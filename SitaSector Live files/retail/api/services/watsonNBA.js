const MOCK = process.env.SITA_MOCK_MODE === '1';

async function getNextBestAction(profileId) {
  if (MOCK) {
    return { profileId, action: 'send_winback_offer', confidence: 0.81 };
  }
  const endpoint = process.env.WATSON_ML_ENDPOINT;
  const key = process.env.WATSON_API_KEY;
  const modelId = process.env.WATSON_NBA_MODEL_ID;
  const resp = await fetch(`${endpoint}/v4/deployments/${modelId}/predictions`, {
    method: 'POST',
    headers: { Authorization: `Bearer ${key}`, 'Content-Type': 'application/json' },
    body: JSON.stringify({ input: { profileId } })
  });
  return resp.json();
}

module.exports = { getNextBestAction };
