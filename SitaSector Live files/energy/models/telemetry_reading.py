import uuid
from django.db import models
from .installation import Installation


class TelemetryReading(models.Model):
    reading_id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    installation = models.ForeignKey(Installation, on_delete=models.CASCADE, related_name="readings")
    timestamp = models.DateTimeField()
    output_kw = models.DecimalField(max_digits=10, decimal_places=3)
    battery_voltage = models.DecimalField(max_digits=8, decimal_places=2)
    temperature_celsius = models.DecimalField(max_digits=6, decimal_places=2)
    irradiance = models.DecimalField(max_digits=8, decimal_places=2)
    alert_flags = models.JSONField(default=dict, blank=True)

    class Meta:
        app_label = "models"
