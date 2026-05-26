import uuid
from django.db import models


class Patient(models.Model):
    patient_id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    national_id = models.CharField(max_length=50)
    name = models.CharField(max_length=200)
    dob = models.DateField()
    gender = models.CharField(max_length=20)
    county = models.CharField(max_length=100)
    registered_facility_id = models.CharField(max_length=50)
    golden_id = models.CharField(max_length=100, null=True, blank=True)
    mdm_confidence = models.FloatField(null=True, blank=True)
    mdm_synced_at = models.DateTimeField(null=True, blank=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        app_label = "models"
