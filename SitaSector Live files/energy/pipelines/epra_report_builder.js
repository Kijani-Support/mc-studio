const fs = require('fs');
const path = require('path');

async function buildEPRAReport(period, metrics) {
  const outDir = path.join(__dirname, '../../output');
  if (!fs.existsSync(outDir)) fs.mkdirSync(outDir, { recursive: true });
  const filePath = path.join(outDir, `EPRA_${period}_${Date.now()}.json`);
  const payload = { period, ...metrics, generatedAt: new Date().toISOString() };
  fs.writeFileSync(filePath, JSON.stringify(payload, null, 2));
  return { filePath, status: 'draft' };
}

module.exports = { buildEPRAReport };
