const { getNextBestAction } = require('../services/watsonNBA');

async function getCustomer(req, res) {
  res.json({ profileId: req.params.id, email: 'demo@example.com' });
}

async function getCustomerHistory(req, res) {
  res.json({ profileId: req.params.id, orders: [], cxEvents: [] });
}

async function getNBA(req, res) {
  const nba = await getNextBestAction(req.params.id);
  res.json(nba);
}

module.exports = { getCustomer, getCustomerHistory, getNBA };
