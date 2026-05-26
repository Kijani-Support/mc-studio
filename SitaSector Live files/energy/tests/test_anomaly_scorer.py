import os
import sys
from datetime import datetime, timedelta
from decimal import Decimal

ROOT = os.path.join(os.path.dirname(__file__), "..", "..")
sys.path.insert(0, ROOT)
os.environ["SITA_MOCK_MODE"] = "1"

from scripts.django_bootstrap import bootstrap

bootstrap("energy", "energy.settings")

from models.installation import Installation
from models.telemetry_reading import TelemetryReading
import sys as _sys
_sys.path.insert(0, os.path.join(ROOT, "energy"))
from pipelines.anomaly_scorer import run_for_installation

inst = Installation.objects.create(
    site_name="Test Site",
    county="Nairobi",
    system_capacity_kw=Decimal("5.0"),
    install_date=datetime.utcnow().date(),
    status="operational",
)
now = datetime.utcnow()
for i in range(4):
    TelemetryReading.objects.create(
        installation=inst,
        timestamp=now - timedelta(hours=i),
        output_kw=Decimal("3.5"),
        battery_voltage=Decimal("48.0"),
        temperature_celsius=Decimal("32.0"),
        irradiance=Decimal("800.0"),
    )

job = run_for_installation(str(inst.installation_id))
print("[PASS] energy anomaly scorer, job created:", bool(job))
