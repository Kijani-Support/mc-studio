# healthtech/services/mdm_sync.py
# IBM MDM nightly sync: deduplicate patients across all branch systems
# Sita Sector Sprint · MC Studio IBM Silver Partner

import os
import sys
import requests
import django
from datetime import datetime, timedelta

ROOT = os.path.join(os.path.dirname(__file__), '..', '..')
HT = os.path.join(ROOT, 'healthtech')
sys.path.insert(0, ROOT)
sys.path.insert(0, HT)

os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'healthtech.settings')
django.setup()

from models.patient import Patient

MOCK = os.environ.get('SITA_MOCK_MODE', '1') == '1'
IBM_MDM_BASE = os.environ.get('IBM_MDM_URL', '')
IBM_MDM_KEY  = os.environ.get('IBM_MDM_API_KEY', '')

def get_candidate_duplicates(since_hours=24):
    """Fetch patients created or updated in the last N hours."""
    cutoff = datetime.utcnow() - timedelta(hours=since_hours)
    return Patient.objects.filter(updated_at__gte=cutoff).values(
        'patient_id', 'national_id', 'name', 'dob', 'registered_facility_id'
    )

def resolve_via_mdm(candidates):
    """
    Send candidate records to IBM MDM for probabilistic matching.
    Returns list of {patient_id, golden_id, match_confidence}.
    """
    if MOCK:
        return [
            {
                'sourceId': str(p['patient_id']),
                'goldenId': f"GOLDEN-{p['national_id']}",
                'confidence': 0.91
            }
            for p in candidates
        ]
    payload = {
        "entityType": "Patient",
        "records": [
            {
                "sourceId": str(p['patient_id']),
                "attributes": {
                    "nationalId": p['national_id'],
                    "fullName": p['name'],
                    "dateOfBirth": str(p['dob'])
                }
            } for p in candidates
        ]
    }
    resp = requests.post(
        f"{IBM_MDM_BASE}/mdm/v1/resolve",
        json=payload,
        headers={"Authorization": f"Bearer {IBM_MDM_KEY}"}
    )
    resp.raise_for_status()
    return resp.json().get('matches', [])

def apply_golden_ids(matches):
    """Write IBM MDM golden_id back to local Patient records."""
    updated = 0
    for match in matches:
        if match['confidence'] >= 0.85:
            Patient.objects.filter(patient_id=match['sourceId']).update(
                golden_id=match['goldenId'],
                mdm_confidence=match['confidence'],
                mdm_synced_at=datetime.utcnow()
            )
            updated += 1
    return updated

def run():
    print(f"[MDM Sync] Starting at {datetime.utcnow().isoformat()}")
    candidates = list(get_candidate_duplicates())
    print(f"[MDM Sync] {len(candidates)} candidate records")
    if not candidates:
        return
    matches = resolve_via_mdm(candidates)
    updated = apply_golden_ids(matches)
    print(f"[MDM Sync] {updated} records updated with golden IDs")

if __name__ == '__main__':
    run()
