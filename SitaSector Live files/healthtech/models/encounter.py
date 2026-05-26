import uuid
from django.db import models
from .patient import Patient


class Encounter(models.Model):
    encounter_id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    patient = models.ForeignKey(Patient, on_delete=models.CASCADE, related_name="encounters")
    facility_id = models.CharField(max_length=50)
    clinician_id = models.CharField(max_length=50)
    encounter_date = models.DateTimeField()
    encounter_type = models.CharField(max_length=30)
    diagnosis_codes = models.JSONField(default=list)
    notes = models.TextField(blank=True)

    class Meta:
        app_label = "models"
