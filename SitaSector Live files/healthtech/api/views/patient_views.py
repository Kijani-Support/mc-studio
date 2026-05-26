from api.serializers.patient_serializer import serialize_patient
from models.patient import Patient


def get_patient(patient_id: str) -> dict:
    return serialize_patient(Patient.objects.get(patient_id=patient_id))
