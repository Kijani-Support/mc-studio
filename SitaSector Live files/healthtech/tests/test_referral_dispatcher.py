import os
import sys
from datetime import date, datetime

ROOT = os.path.join(os.path.dirname(__file__), "..", "..")
sys.path.insert(0, ROOT)

from scripts.django_bootstrap import bootstrap

bootstrap("healthtech", "healthtech.settings")

from models.patient import Patient
from models.encounter import Encounter
from models.referral import Referral
from services.referral_dispatcher import dispatch_referral

p = Patient.objects.create(
    national_id="99",
    name="Test Patient",
    dob=date(1985, 5, 5),
    gender="M",
    county="Kiambu",
    registered_facility_id="FAC-A",
)
enc = Encounter.objects.create(
    patient=p,
    facility_id="FAC-A",
    clinician_id="CL-1",
    encounter_date=datetime.utcnow(),
    encounter_type="referral",
)
ref = Referral.objects.create(origin_encounter=enc, destination_facility_id="FAC-B")
summary = dispatch_referral(str(ref.referral_id))
assert summary["status"] == "accepted"
print("[PASS] healthtech referral dispatcher")
