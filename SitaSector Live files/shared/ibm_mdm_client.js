// Shared IBM MDM API wrapper — mock mode for local / TechZone portability
const MOCK = process.env.SITA_MOCK_MODE === '1' || !process.env.IBM_MDM_API_KEY;

class MDMClient {
  static async resolveEntities(records, options = {}) {
    if (MOCK) {
      return records.map((r, i) => ({
        goldenId: `golden-${options.entity || 'Entity'}-${i}`,
        sourceId: r.customer_id || r.account_id || r.email || String(i),
        email: r.email,
        phone: r.phone,
        confidence: 0.92,
        ...r
      }));
    }
    const base = process.env.IBM_MDM_URL;
    const key = process.env.IBM_MDM_API_KEY;
    const resp = await fetch(`${base}/mdm/v1/resolve`, {
      method: 'POST',
      headers: {
        Authorization: `Bearer ${key}`,
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ entityType: options.entity, records })
    });
    if (!resp.ok) throw new Error(`MDM resolve failed: ${resp.status}`);
    const data = await resp.json();
    return data.matches || data.records || [];
  }
}

module.exports = { MDMClient };
