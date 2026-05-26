import uuid
from django.db import models


class ExportShipment(models.Model):
    shipment_id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    batch_ids = models.JSONField(default=list)
    buyer_id = models.CharField(max_length=50)
    destination_country = models.CharField(max_length=5)
    departure_date = models.DateField()
    certificate_ids = models.JSONField(default=list, blank=True)
    customs_status = models.CharField(max_length=20, default="pending")
    hold_reason = models.TextField(blank=True)

    class Meta:
        app_label = "models"
