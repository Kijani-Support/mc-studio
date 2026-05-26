const { handleWebhook } = require('../pipelines/woocommerce_connector');

(async () => {
  const r = await handleWebhook({ order: { id: 101, billing: { email: 'x@y.com' }, total: '99.00' } });
  if (r.channel !== 'woocommerce') throw new Error('Expected woocommerce channel');
  console.log('[PASS] retail woocommerce connector');
})().catch((e) => {
  console.error('[FAIL] retail woocommerce:', e.message);
  process.exit(1);
});
