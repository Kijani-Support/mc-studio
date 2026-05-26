"""Watson ML at-risk learner classification job."""
import os
import sys

sys.path.insert(0, os.path.join(os.path.dirname(__file__), '..', '..'))
from shared.ibm_watson_client import WatsonClient

THRESHOLD = 0.65


def classify_learner(features: dict) -> dict:
    client = WatsonClient(model_id_env="WATSON_AT_RISK_MODEL_ID")
    fields = ["lessons_completed", "days_inactive", "score"]
    values = [[
        features.get("lessons_completed", 0),
        features.get("days_inactive", 0),
        features.get("score", 0),
    ]]
    result = client.predict(fields, values)
    risk_score = result["predictions"][0]["values"][0][0]
    return {
        "learner_id": features.get("learner_id"),
        "risk_score": risk_score,
        "at_risk": risk_score >= THRESHOLD,
    }


if __name__ == "__main__":
    sample = {"learner_id": "L-1", "lessons_completed": 2, "days_inactive": 10, "score": 40}
    print(classify_learner(sample))
