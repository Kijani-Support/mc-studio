import uuid
from django.db import models


class Installation(models.Model):
    installation_id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    site_name = models.CharField(max_length=200)
    county = models.CharField(max_length=100)
    system_capacity_kw = models.DecimalField(max_digits=10, decimal_places=2)
    install_date = models.DateField()
    status = models.CharField(max_length=20, default="operational")

    class Meta:
        app_label = "models"
