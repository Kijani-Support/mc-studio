import json
import os
from pathlib import Path


def generate_export_certificate(shipment_id: str, traceability: dict) -> str:
    out_dir = Path(__file__).resolve().parents[2] / "output"
    out_dir.mkdir(parents=True, exist_ok=True)
    file_path = out_dir / f"export_cert_{shipment_id}.json"
    file_path.write_text(json.dumps(traceability, indent=2), encoding="utf-8")
    return str(file_path)
