async function listInstallations(req, res) {
  res.json({ installations: [] });
}

async function getTelemetry(req, res) {
  res.json({ installationId: req.params.id, readings: [] });
}

module.exports = { listInstallations, getTelemetry };
