"""Push referral summary to destination branch."""
from models.referral import Referral


def dispatch_referral(referral_id: str) -> dict:
    referral = Referral.objects.select_related("origin_encounter__patient").get(referral_id=referral_id)
    patient = referral.origin_encounter.patient
    referral.status = "accepted"
    referral.save(update_fields=["status"])
    summary = {
        "patient_id": str(patient.patient_id),
        "name": patient.name,
        "destination_facility_id": referral.destination_facility_id,
        "status": referral.status,
    }
    print(f"[Referral] Dispatched summary to {referral.destination_facility_id}", summary)
    return summary
