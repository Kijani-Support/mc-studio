"""Convert Watson predictions into MaintenanceJob records."""
import os
import django
from datetime import datetime, timedelta

os.environ.setdefault("DJANGO_SETTINGS_MODULE", "energy.settings")
django.setup()

from models.maintenance_job import MaintenanceJob


def schedule_from_prediction(installation, score_result):
    scheduled = datetime.utcnow() + timedelta(hours=score_result["predicted_failure_hours"] * 0.7)
    return MaintenanceJob.objects.create(
        installation=installation,
        trigger_type="predictive",
        scheduled_date=scheduled.date(),
        anomaly_score=score_result["anomaly_score"],
        notes=f"Scheduled from Watson score {score_result['anomaly_score']:.2f}",
    )
