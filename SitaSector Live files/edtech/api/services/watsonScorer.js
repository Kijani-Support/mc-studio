const MOCK = process.env.SITA_MOCK_MODE === '1';

async function scoreLearnerRisk(features) {
  if (MOCK) {
    const atRisk = (features.daysInactive || 0) > 7 || (features.score || 100) < 50;
    return { atRisk, riskScore: atRisk ? 0.78 : 0.22 };
  }
  const endpoint = process.env.WATSON_ML_ENDPOINT;
  const key = process.env.WATSON_API_KEY;
  const modelId = process.env.WATSON_AT_RISK_MODEL_ID;
  const resp = await fetch(`${endpoint}/v4/deployments/${modelId}/predictions`, {
    method: 'POST',
    headers: { Authorization: `Bearer ${key}`, 'Content-Type': 'application/json' },
    body: JSON.stringify({ input: features })
  });
  return resp.json();
}

module.exports = { scoreLearnerRisk };
