from services.intake_pipeline import record_intake


def intake_batch(farm_id: str, payload: dict) -> dict:
    batch = record_intake(farm_id, payload)
    return {"batch_id": str(batch.batch_id)}
