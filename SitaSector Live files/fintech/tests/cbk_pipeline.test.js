process.env.SITA_MOCK_MODE = '1';
const path = require('path');
require('dotenv').config({ path: path.join(__dirname, '../../.env.example') });

const { runCBKPipeline } = require('../pipelines/cbk_report_pipeline');

(async () => {
  const reportId = await runCBKPipeline('2026-05');
  if (!reportId) throw new Error('Expected reportId');
  console.log('[PASS] fintech CBK pipeline:', reportId);
})().catch((e) => {
  console.error('[FAIL] fintech:', e.message);
  process.exit(1);
});
