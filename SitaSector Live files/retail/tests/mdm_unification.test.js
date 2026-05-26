process.env.SITA_MOCK_MODE = '1';
const { runUnification } = require('../pipelines/mdm_unification');

(async () => {
  await runUnification();
  console.log('[PASS] retail MDM unification');
})().catch((e) => {
  console.error('[FAIL] retail:', e.message);
  process.exit(1);
});
