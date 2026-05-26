import os
import sys

sys.path.insert(0, os.path.join(os.path.dirname(__file__), "..", ".."))
from shared.ibm_watson_client import WatsonClient


def score_readings(readings: list) -> dict:
    client = WatsonClient(model_id_env="WATSON_ANOMALY_MODEL_ID")
    fields = ["timestamp", "output_kw", "battery_voltage", "temperature_celsius", "irradiance"]
    values = [
        [
            str(r["timestamp"]),
            float(r["output_kw"]),
            float(r["battery_voltage"]),
            float(r["temperature_celsius"]),
            float(r["irradiance"]),
        ]
        for r in readings
    ]
    result = client.predict(fields, values)
    return {
        "anomaly_score": result["predictions"][0]["values"][0][0],
        "predicted_failure_hours": result["predictions"][0]["values"][0][1],
    }
