async function handleWebhook(payload) {
  const order = payload?.order || payload;
  return {
    orderId: order?.id,
    email: order?.billing?.email,
    total: order?.total,
    channel: 'woocommerce',
    status: 'ingested'
  };
}

module.exports = { handleWebhook };
