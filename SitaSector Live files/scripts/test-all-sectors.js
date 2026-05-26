const { spawnSync } = require('child_process');
const path = require('path');

const ROOT = path.join(__dirname, '..');
process.env.SITA_MOCK_MODE = '1';

const steps = [
  { name: 'django setup', cmd: 'python', args: ['scripts/setup_django.py'], cwd: ROOT },
  { name: 'fintech', cmd: 'node', args: ['fintech/tests/cbk_pipeline.test.js'], cwd: ROOT },
  { name: 'retail mdm', cmd: 'node', args: ['retail/tests/mdm_unification.test.js'], cwd: ROOT },
  { name: 'retail woo', cmd: 'node', args: ['retail/tests/woocommerce_connector.test.js'], cwd: ROOT },
  { name: 'edtech donor', cmd: 'node', args: ['edtech/tests/donor_transformer.test.js'], cwd: ROOT },
  { name: 'edtech at-risk', cmd: 'python', args: ['edtech/tests/at_risk_classifier.test.py'], cwd: ROOT },
  { name: 'energy epra', cmd: 'node', args: ['energy/tests/test_epra_report_builder.js'], cwd: ROOT },
  { name: 'energy anomaly', cmd: 'python', args: ['energy/tests/test_anomaly_scorer.py'], cwd: ROOT },
  { name: 'healthtech mdm', cmd: 'python', args: ['healthtech/tests/test_mdm_sync.py'], cwd: ROOT },
  { name: 'healthtech referral', cmd: 'python', args: ['healthtech/tests/test_referral_dispatcher.py'], cwd: ROOT },
  { name: 'agritech cert', cmd: 'python', args: ['agritech/tests/test_certification_checker.py'], cwd: ROOT },
  { name: 'agritech shipment', cmd: 'python', args: ['agritech/tests/test_shipment_builder.py'], cwd: ROOT },
];

let failed = 0;
for (const step of steps) {
  const r = spawnSync(step.cmd, step.args, { cwd: step.cwd, encoding: 'utf8', env: { ...process.env, SITA_MOCK_MODE: '1' } });
  if (r.stdout) process.stdout.write(r.stdout);
  if (r.stderr) process.stderr.write(r.stderr);
  if (r.status !== 0) {
    console.error(`[FAIL] ${step.name} (exit ${r.status})`);
    failed++;
  }
}

if (failed) {
  console.error(`\n${failed} sector test(s) failed`);
  process.exit(1);
}
console.log('\n[OK] All sector tests passed');
