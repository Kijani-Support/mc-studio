def serialize_referral(referral) -> dict:
    return {
        "referral_id": str(referral.referral_id),
        "destination_facility_id": referral.destination_facility_id,
        "status": referral.status,
    }
