async function listOrders(req, res) {
  res.json({ orders: [] });
}

async function processReturn(req, res) {
  res.json({ orderId: req.body?.orderId, status: 'returned', channelsUpdated: ['pos', 'woocommerce'] });
}

module.exports = { listOrders, processReturn };
