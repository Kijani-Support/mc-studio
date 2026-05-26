import os
import sys
from datetime import date, timedelta
from decimal import Decimal

ROOT = os.path.join(os.path.dirname(__file__), "..", "..")
sys.path.insert(0, ROOT)

from scripts.django_bootstrap import bootstrap

bootstrap("agritech", "agritech.settings")

from models.farm import Farm
from models.harvest_batch import HarvestBatch
from models.export_shipment import ExportShipment
from services.certification_checker import check_batch_certifications, pre_shipment_check

farm = Farm.objects.create(
    farmer_id="F-1",
    location_lat=Decimal("-0.5"),
    location_lng=Decimal("37.0"),
    acreage=Decimal("2.5"),
    certification_status="organic",
    certification_expiry=date.today() + timedelta(days=90),
    additional_certs=["fairtrade"],
)
batch = HarvestBatch.objects.create(
    farm=farm,
    harvest_date=date.today(),
    weight_kg=Decimal("500"),
    processing_method="washed",
    quality_grade="AA",
    intake_agent_id="A-1",
)
result = check_batch_certifications([str(batch.batch_id)], "DE")
assert result["passed"] is True
shipment = ExportShipment.objects.create(
    batch_ids=[str(batch.batch_id)],
    buyer_id="B-1",
    destination_country="DE",
    departure_date=date.today(),
)
pre_shipment_check(str(shipment.shipment_id))
print("[PASS] agritech certification checker")
