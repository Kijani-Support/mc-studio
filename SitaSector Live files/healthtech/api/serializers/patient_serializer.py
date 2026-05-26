def serialize_patient(patient) -> dict:
    return {
        "patient_id": str(patient.patient_id),
        "national_id": patient.national_id,
        "name": patient.name,
        "county": patient.county,
        "golden_id": patient.golden_id,
    }
