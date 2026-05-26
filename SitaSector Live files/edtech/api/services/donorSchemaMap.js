const fs = require('fs');
const path = require('path');

const SCHEMA_DIR = path.join(__dirname, '../../config/donor_schemas');

function listDonorSchemas() {
  return fs.readdirSync(SCHEMA_DIR)
    .filter((f) => f.endsWith('_schema.json'))
    .map((f) => f.replace('_schema.json', ''));
}

function getDonorSchema(donorId) {
  const p = path.join(SCHEMA_DIR, `${donorId}_schema.json`);
  return JSON.parse(fs.readFileSync(p, 'utf8'));
}

module.exports = { listDonorSchemas, getDonorSchema };
