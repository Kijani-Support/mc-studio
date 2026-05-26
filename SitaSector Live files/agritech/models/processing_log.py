import uuid
from django.db import models
from .harvest_batch import HarvestBatch


class ProcessingLog(models.Model):
    log_id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    batch = models.ForeignKey(HarvestBatch, on_delete=models.CASCADE, related_name="processing_logs")
    stage = models.CharField(max_length=20)
    completed_at = models.DateTimeField()
    operator_id = models.CharField(max_length=50)
    output_weight_kg = models.DecimalField(max_digits=10, decimal_places=2)

    class Meta:
        app_label = "models"
