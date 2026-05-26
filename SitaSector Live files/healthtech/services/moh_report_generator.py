"""Quarterly MOH aggregate report builder."""
from django.db.models import Count
from models.encounter import Encounter


def build_quarterly_moh_report(quarter_label: str) -> dict:
    aggregates = (
        Encounter.objects.values("facility_id")
        .annotate(encounter_count=Count("encounter_id"))
        .order_by("facility_id")
    )
    return {
        "period": quarter_label,
        "regulator": "MOH",
        "facilities": list(aggregates),
        "generated_at": quarter_label,
    }
