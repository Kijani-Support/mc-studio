const { buildEPRAReport } = require('../../pipelines/epra_report_builder');

async function getEPRAReports(req, res) {
  res.json({ reports: [] });
}

async function submitEPRA(req, res) {
  const built = await buildEPRAReport(req.body.period, req.body.metrics || {});
  res.json({ ...built, status: 'submitted' });
}

module.exports = { getEPRAReports, submitEPRA };
