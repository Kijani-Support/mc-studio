const { runCBKPipeline } = require('../../pipelines/cbk_report_pipeline');

async function listReports(req, res) {
  res.json({ reports: [], message: 'Connect DATABASE_URL for live listing' });
}

async function generateReport(req, res) {
  const period = req.body?.period || '2026-05';
  const reportId = await runCBKPipeline(period);
  res.json({ reportId, regulator: 'CBK' });
}

module.exports = { listReports, generateReport };
