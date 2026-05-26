import os
import sys
from datetime import date
from decimal import Decimal

ROOT = os.path.join(os.path.dirname(__file__), "..", "..")
sys.path.insert(0, ROOT)

from scripts.django_bootstrap import bootstrap

bootstrap("agritech", "agritech.settings")

from models.farm import Farm
from models.harvest_batch import HarvestBatch
from services.shipment_builder import build_shipment

farm = Farm.objects.create(
    farmer_id="F-2",
    location_lat=Decimal("0"),
    location_lng=Decimal("37"),
    acreage=Decimal("1"),
    certification_status="organic",
)
batch = HarvestBatch.objects.create(
    farm=farm,
    harvest_date=date.today(),
    weight_kg=Decimal("100"),
    processing_method="natural",
    quality_grade="AB",
    intake_agent_id="A-2",
)
shipment = build_shipment([str(batch.batch_id)], "BUY-9", "KE", date.today())
print("[PASS] agritech shipment builder:", shipment.shipment_id)
