from models.farm import Farm


def get_farm_certifications(farm_id: str) -> dict:
    farm = Farm.objects.get(farm_id=farm_id)
    return {
        "farm_id": str(farm.farm_id),
        "certification_status": farm.certification_status,
        "certification_expiry": str(farm.certification_expiry) if farm.certification_expiry else None,
        "additional_certs": farm.additional_certs,
    }
