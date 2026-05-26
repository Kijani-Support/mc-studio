const { scoreLearnerRisk } = require('../services/watsonScorer');

async function getAtRiskAlerts(req, res) {
  const demo = await scoreLearnerRisk({ learnerId: 'L-1', daysInactive: 10, score: 42 });
  res.json({ alerts: [demo] });
}

module.exports = { getAtRiskAlerts };
