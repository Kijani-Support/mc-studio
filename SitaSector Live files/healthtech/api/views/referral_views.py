from services.referral_dispatcher import dispatch_referral


def create_referral(referral_id: str) -> dict:
    return dispatch_referral(referral_id)
