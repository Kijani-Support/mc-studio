import uuid
from django.db import models
from .encounter import Encounter


class Referral(models.Model):
    referral_id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    origin_encounter = models.ForeignKey(Encounter, on_delete=models.CASCADE, related_name="referrals")
    destination_facility_id = models.CharField(max_length=50)
    status = models.CharField(max_length=20, default="pending")
    created_at = models.DateTimeField(auto_now_add=True)

    class Meta:
        app_label = "models"
