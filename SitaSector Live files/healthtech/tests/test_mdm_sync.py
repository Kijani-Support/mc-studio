import os
import sys
from datetime import date

ROOT = os.path.join(os.path.dirname(__file__), "..", "..")
sys.path.insert(0, ROOT)
os.environ["SITA_MOCK_MODE"] = "1"

from scripts.django_bootstrap import bootstrap

bootstrap("healthtech", "healthtech.settings")

from models.patient import Patient
from services.mdm_sync import run

Patient.objects.create(
    national_id="12345678",
    name="Jane Doe",
    dob=date(1990, 1, 1),
    gender="F",
    county="Nairobi",
    registered_facility_id="FAC-1",
)
run()
print("[PASS] healthtech MDM sync")
