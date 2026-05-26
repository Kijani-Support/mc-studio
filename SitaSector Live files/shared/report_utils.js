// Shared PDF / export utilities — writes JSON artifact in mock mode
const fs = require('fs');
const path = require('path');

const OUT_DIR = path.join(__dirname, '..', 'output');

async function generatePDF({ schema, data, period }) {
  if (!fs.existsSync(OUT_DIR)) fs.mkdirSync(OUT_DIR, { recursive: true });
  const safeName = (schema.reportName || 'report').replace(/\s+/g, '_');
  const filePath = path.join(OUT_DIR, `${safeName}_${period}_${Date.now()}.json`);
  fs.writeFileSync(filePath, JSON.stringify({ schema, period, rowCount: data.length, data }, null, 2));
  return filePath;
}

module.exports = { generatePDF };
