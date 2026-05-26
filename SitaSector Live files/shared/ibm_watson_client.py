"""Shared IBM Watson Machine Learning client — mock mode for portable runs."""
import os
import requests

MOCK = os.environ.get("SITA_MOCK_MODE", "1") == "1"


class WatsonClient:
    def __init__(self, model_id_env: str = "WATSON_ANOMALY_MODEL_ID"):
        self.endpoint = os.environ.get("WATSON_ML_ENDPOINT", "")
        self.api_key = os.environ.get("WATSON_API_KEY", "")
        self.model_id = os.environ.get(model_id_env, "mock-model")

    def predict(self, fields, values):
        if MOCK or not self.api_key:
            return {"predictions": [{"values": [[0.82, 48.0]]}]}
        url = f"{self.endpoint.rstrip('/')}/v4/deployments/{self.model_id}/predictions"
        payload = {"model_id": self.model_id, "input": {"fields": fields, "values": values}}
        resp = requests.post(
            url,
            json=payload,
            headers={"Authorization": f"Bearer {self.api_key}"},
            timeout=60,
        )
        resp.raise_for_status()
        return resp.json()
