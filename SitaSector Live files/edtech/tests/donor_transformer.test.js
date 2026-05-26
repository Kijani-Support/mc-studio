process.env.SITA_MOCK_MODE = '1';
const { generateDonorReport } = require('../pipelines/donor_report_transformer');

(async () => {
  const a = await generateDonorReport('donor_a', '2026-05', '2026-05-01', '2026-05-31');
  const b = await generateDonorReport('donor_b', '2026-05', '2026-05-01', '2026-05-31');
  if (!a.reportId || !b.reportId) throw new Error('Expected reportIds');
  console.log('[PASS] edtech donor reports:', a.reportId, b.reportId);
})().catch((e) => {
  console.error('[FAIL] edtech:', e.message);
  process.exit(1);
});
