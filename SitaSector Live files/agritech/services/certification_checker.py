# agritech/services/certification_checker.py
# Rules engine: validate farm certifications per export destination market
# Sita Sector Sprint · MC Studio IBM Silver Partner

import os
import sys
import django
from datetime import date

ROOT = os.path.join(os.path.dirname(__file__), '..', '..')
AG = os.path.join(ROOT, 'agritech')
sys.path.insert(0, ROOT)
sys.path.insert(0, AG)
os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'agritech.settings')
django.setup()

from models.farm import Farm
from models.harvest_batch import HarvestBatch
from models.export_shipment import ExportShipment

# Certification requirements per destination market
MARKET_RULES = {
    'DE': ['organic', 'fairtrade'],          # Germany: organic + fairtrade required
    'JP': ['organic', 'rainforest_alliance'], # Japan: organic + RA required
    'GB': ['fairtrade'],                      # UK: fairtrade minimum
    'US': ['organic'],                        # US: organic minimum
    'KE': [],                                 # Domestic: no export cert required
}

def get_required_certs(destination_country: str) -> list:
    return MARKET_RULES.get(destination_country.upper(), [])

def check_batch_certifications(batch_ids: list, destination_country: str) -> dict:
    """
    Validate that all farms contributing to a shipment hold
    the required certifications for the destination market.
    Returns: { passed: bool, issues: list }
    """
    required = get_required_certs(destination_country)
    issues = []
    today = date.today()

    for batch_id in batch_ids:
        batch = HarvestBatch.objects.select_related('farm').get(batch_id=batch_id)
        farm = batch.farm

        # Check each required certification
        for cert in required:
            if farm.certification_status != cert and cert not in (farm.additional_certs or []):
                issues.append({
                    'batch_id': batch_id,
                    'farm_id': str(farm.farm_id),
                    'issue': f"Missing required certification: {cert}",
                    'severity': 'BLOCK'
                })
            elif farm.certification_expiry and farm.certification_expiry < today:
                issues.append({
                    'batch_id': batch_id,
                    'farm_id': str(farm.farm_id),
                    'issue': f"Certification {cert} expired on {farm.certification_expiry}",
                    'severity': 'BLOCK'
                })

    return {
        'destination': destination_country,
        'required_certs': required,
        'batches_checked': len(batch_ids),
        'passed': len(issues) == 0,
        'issues': issues
    }

def pre_shipment_check(shipment_id: str) -> dict:
    """Run full compliance check before shipment approval."""
    shipment = ExportShipment.objects.get(shipment_id=shipment_id)
    result = check_batch_certifications(
        batch_ids=shipment.batch_ids,
        destination_country=shipment.destination_country
    )
    if result['passed']:
        shipment.customs_status = 'pending'
    else:
        shipment.customs_status = 'held'
        shipment.hold_reason = str(result['issues'])
    shipment.save()
    return result
