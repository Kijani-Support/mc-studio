# energy/pipelines/anomaly_scorer.py
# IBM Watson anomaly detection: telemetry → predictive maintenance trigger
# Sita Sector Sprint · MC Studio IBM Silver Partner

import os
import sys
import django
from datetime import datetime, timedelta

ROOT = os.path.join(os.path.dirname(__file__), '..', '..')
sys.path.insert(0, ROOT)
sys.path.insert(0, os.path.join(ROOT, 'energy'))
os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'energy.settings')
django.setup()

from models.telemetry_reading import TelemetryReading
from models.maintenance_job import MaintenanceJob
from services.watsonAnomalyClient import score_readings

ANOMALY_THRESHOLD = 0.75   # Score above which we create a maintenance job
LOOKBACK_HOURS    = 6      # Window of readings to score

def get_recent_telemetry(installation_id, hours=LOOKBACK_HOURS):
    cutoff = datetime.utcnow() - timedelta(hours=hours)
    return list(TelemetryReading.objects.filter(
        installation_id=installation_id,
        timestamp__gte=cutoff
    ).order_by('timestamp').values(
        'timestamp', 'output_kw', 'battery_voltage', 'temperature_celsius', 'irradiance'
    ))

def score_telemetry(readings: list) -> dict:
    """Send telemetry window to IBM Watson anomaly model."""
    return score_readings(readings)

def create_predictive_job(installation_id, score_result):
    """Create a MaintenanceJob record triggered by anomaly score."""
    scheduled = datetime.utcnow() + timedelta(hours=score_result['predicted_failure_hours'] * 0.7)
    job = MaintenanceJob.objects.create(
        installation_id=installation_id,
        trigger_type='predictive',
        scheduled_date=scheduled.date(),
        anomaly_score=score_result['anomaly_score'],
        notes=f"Watson anomaly score: {score_result['anomaly_score']:.2f}. "
              f"Predicted failure window: {score_result['predicted_failure_hours']:.0f}h"
    )
    print(f"[Anomaly] Job {job.job_id} created for installation {installation_id} "
          f"(score={score_result['anomaly_score']:.2f})")
    return job

def run_for_installation(installation_id):
    readings = get_recent_telemetry(installation_id)
    if len(readings) < 3:
        return None   # Not enough data to score

    score = score_telemetry(readings)

    if score['anomaly_score'] >= ANOMALY_THRESHOLD:
        # Check no open predictive job already exists
        existing = MaintenanceJob.objects.filter(
            installation_id=installation_id,
            trigger_type='predictive',
            outcome__isnull=True
        ).exists()
        if not existing:
            return create_predictive_job(installation_id, score)

    return None

if __name__ == '__main__':
    from models.installation import Installation
    installations = Installation.objects.filter(status__in=['operational', 'degraded'])
    print(f"[Anomaly Scorer] Scoring {installations.count()} installations")
    jobs_created = sum(1 for i in installations if run_for_installation(str(i.installation_id)))
    print(f"[Anomaly Scorer] {jobs_created} predictive jobs created")
