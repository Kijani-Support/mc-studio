process.env.SITA_MOCK_MODE = '1';
const { buildEPRAReport } = require('../pipelines/epra_report_builder');

(async () => {
  const r = await buildEPRAReport('2026-Q1', { incident_count: 0, total_output_kwh: 12000 });
  if (!r.filePath) throw new Error('Expected filePath');
  console.log('[PASS] energy EPRA report:', r.filePath);
})().catch((e) => {
  console.error('[FAIL] energy epra:', e.message);
  process.exit(1);
});
