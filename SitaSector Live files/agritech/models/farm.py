import uuid
from django.db import models


class Farm(models.Model):
    farm_id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    farmer_id = models.CharField(max_length=50)
    location_lat = models.DecimalField(max_digits=10, decimal_places=6)
    location_lng = models.DecimalField(max_digits=10, decimal_places=6)
    acreage = models.DecimalField(max_digits=8, decimal_places=2)
    certification_status = models.CharField(max_length=50, default="organic")
    certification_expiry = models.DateField(null=True, blank=True)
    additional_certs = models.JSONField(default=list, blank=True)

    class Meta:
        app_label = "models"
