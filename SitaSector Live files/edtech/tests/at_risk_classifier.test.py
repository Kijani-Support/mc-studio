import os
import sys

os.environ["SITA_MOCK_MODE"] = "1"
sys.path.insert(0, os.path.join(os.path.dirname(__file__), "..", ".."))

from edtech.pipelines.at_risk_classifier import classify_learner

result = classify_learner({"learner_id": "L-1", "lessons_completed": 1, "days_inactive": 14, "score": 35})
assert "at_risk" in result
print("[PASS] edtech at-risk classifier:", result)
