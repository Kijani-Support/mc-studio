async function listLearners(req, res) {
  res.json({ learners: [] });
}

async function getLearnerProgress(req, res) {
  res.json({ learnerId: req.params.id, progress: [] });
}

module.exports = { listLearners, getLearnerProgress };
