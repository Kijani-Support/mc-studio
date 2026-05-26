// edtech/pipelines/donor_report_transformer.js
// Transform learner Progress records into donor-specific report schemas
// Sita Sector Sprint · MC Studio IBM Silver Partner

const db = require('../db');
const fs = require('fs');
const path = require('path');

/**
 * Load donor schema definition from config
 * Each schema defines: groupBy, metrics, filters, outputFormat
 */
function loadDonorSchema(donorId) {
  const schemaPath = path.join(__dirname, `../config/donor_schemas/${donorId}_schema.json`);
  if (!fs.existsSync(schemaPath)) throw new Error(`No schema found for donor: ${donorId}`);
  return JSON.parse(fs.readFileSync(schemaPath, 'utf8'));
}

/**
 * Fetch progress data for a given period
 */
async function fetchProgressData(periodStart, periodEnd) {
  const result = await db.query(`
    SELECT
      l.county, l.school_name, l.learning_mode, l.cohort_id,
      m.subject, m.grade_level,
      p.status, p.score, p.lessons_completed,
      p.last_active
    FROM progress p
    JOIN learners l ON l.learner_id = p.learner_id
    JOIN modules m ON m.module_id = p.module_id
    WHERE p.last_active BETWEEN $1 AND $2
  `, [periodStart, periodEnd]);
  return result.rows;
}

/**
 * Apply donor schema transformation rules to raw progress rows
 */
function applySchema(rows, schema) {
  // Apply filters
  let filtered = rows;
  if (schema.filters) {
    for (const [field, value] of Object.entries(schema.filters)) {
      filtered = filtered.filter(r => r[field] === value);
    }
  }

  // Group and aggregate
  const groups = {};
  for (const row of filtered) {
    const key = schema.groupBy.map(f => row[f]).join('||');
    if (!groups[key]) {
      groups[key] = { _key: key, _rows: [], _meta: {} };
      for (const f of schema.groupBy) groups[key]._meta[f] = row[f];
    }
    groups[key]._rows.push(row);
  }

  // Compute metrics per group
  return Object.values(groups).map(group => {
    const out = { ...group._meta };
    for (const [metric, fn] of Object.entries(schema.metrics)) {
      if (fn === 'COUNT') out[metric] = group._rows.length;
      if (fn === 'COUNT_COMPLETED') out[metric] = group._rows.filter(r => r.status === 'completed').length;
      if (fn === 'AVG_SCORE') {
        const scores = group._rows.map(r => parseFloat(r.score)).filter(Boolean);
        out[metric] = scores.length ? (scores.reduce((a,b) => a+b,0) / scores.length).toFixed(2) : null;
      }
      if (fn === 'COMPLETION_RATE') {
        const total = group._rows.length;
        const done = group._rows.filter(r => r.status === 'completed').length;
        out[metric] = total ? ((done / total) * 100).toFixed(1) + '%' : '0%';
      }
    }
    return out;
  });
}

async function generateDonorReport(donorId, periodLabel, periodStart, periodEnd) {
  const schema = loadDonorSchema(donorId);
  const raw = await fetchProgressData(periodStart, periodEnd);
  const transformed = applySchema(raw, schema);

  // Persist to donor_reports table
  const result = await db.query(`
    INSERT INTO donor_reports (donor_id, period, schema_version, generated_at, payload)
    VALUES ($1, $2, $3, NOW(), $4) RETURNING report_id
  `, [donorId, periodLabel, schema.version, JSON.stringify(transformed)]);

  console.log(`[Donor Report] ${donorId} / ${periodLabel}: ${transformed.length} rows → report ${result.rows[0].report_id}`);
  return { reportId: result.rows[0].report_id, rows: transformed.length };
}

module.exports = { generateDonorReport };
