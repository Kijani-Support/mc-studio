const { generateDonorReport } = require('../../pipelines/donor_report_transformer');

async function generateReport(req, res) {
  const donorId = req.params.donorId;
  const result = await generateDonorReport(donorId, '2026-05', '2026-05-01', '2026-05-31');
  res.json(result);
}

module.exports = { generateReport };
