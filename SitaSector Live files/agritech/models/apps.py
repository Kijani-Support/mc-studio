from django.apps import AppConfig


class ModelsConfig(AppConfig):
    default_auto_field = "django.db.models.BigAutoField"
    name = "models"

    def ready(self):
        from . import farm, harvest_batch, processing_log, export_shipment  # noqa: F401
