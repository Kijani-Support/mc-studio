from models.harvest_batch import HarvestBatch
from models.farm import Farm


def record_intake(farm_id: str, payload: dict) -> HarvestBatch:
    farm = Farm.objects.get(farm_id=farm_id)
    return HarvestBatch.objects.create(
        farm=farm,
        harvest_date=payload["harvest_date"],
        weight_kg=payload["weight_kg"],
        processing_method=payload.get("processing_method", "washed"),
        quality_grade=payload.get("quality_grade", "AA"),
        intake_agent_id=payload.get("intake_agent_id", "AGENT-1"),
    )
