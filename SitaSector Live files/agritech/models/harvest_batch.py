import uuid
from django.db import models
from .farm import Farm


class HarvestBatch(models.Model):
    batch_id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    farm = models.ForeignKey(Farm, on_delete=models.CASCADE, related_name="harvest_batches")
    harvest_date = models.DateField()
    weight_kg = models.DecimalField(max_digits=10, decimal_places=2)
    processing_method = models.CharField(max_length=20)
    quality_grade = models.CharField(max_length=5)
    intake_agent_id = models.CharField(max_length=50)

    class Meta:
        app_label = "models"
