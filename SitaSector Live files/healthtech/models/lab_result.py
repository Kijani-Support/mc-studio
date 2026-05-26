import uuid
from django.db import models
from .encounter import Encounter


class LabResult(models.Model):
    result_id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    encounter = models.ForeignKey(Encounter, on_delete=models.CASCADE, related_name="lab_results")
    test_type = models.CharField(max_length=100)
    result_value = models.CharField(max_length=100)
    normal_range = models.CharField(max_length=100)
    received_at = models.DateTimeField()
    source_lab = models.CharField(max_length=100)

    class Meta:
        app_label = "models"
