const { dispatchTechnician } = require('../services/technicianDispatcher');

async function listJobs(req, res) {
  res.json({ jobs: [] });
}

async function dispatchJob(req, res) {
  const result = await dispatchTechnician(req.body.jobId, req.body.technicianId);
  res.json(result);
}

module.exports = { listJobs, dispatchJob };
