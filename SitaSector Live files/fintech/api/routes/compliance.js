async function submitCompliance(req, res) {
  const { reportId, regulator } = req.body || {};
  res.json({
    reportId,
    regulator: regulator || 'CBK',
    status: 'submitted',
    submittedAt: new Date().toISOString()
  });
}

module.exports = { submitCompliance };
