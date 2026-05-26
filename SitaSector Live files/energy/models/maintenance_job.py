import uuid
from django.db import models
from .installation import Installation


class MaintenanceJob(models.Model):
    job_id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    installation = models.ForeignKey(Installation, on_delete=models.CASCADE, related_name="jobs")
    trigger_type = models.CharField(max_length=20)
    scheduled_date = models.DateField()
    completed_date = models.DateField(null=True, blank=True)
    technician_id = models.CharField(max_length=50, null=True, blank=True)
    outcome = models.CharField(max_length=20, null=True, blank=True)
    anomaly_score = models.FloatField(null=True, blank=True)
    notes = models.TextField(blank=True)

    class Meta:
        app_label = "models"
