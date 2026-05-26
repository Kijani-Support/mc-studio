// Cron-style scheduler for regulatory report pipelines
const { runCBKPipeline } = require('./cbk_report_pipeline');

const SCHEDULES = {
  CBK: { cron: '0 6 1 * *', handler: runCBKPipeline, label: () => {
    const d = new Date();
    return `${d.getFullYear()}-${String(d.getMonth()).padStart(2, '0')}`;
  }}
};

async function runDueJobs() {
  const results = [];
  for (const [name, job] of Object.entries(SCHEDULES)) {
    const period = job.label();
    console.log(`[Scheduler] Running ${name} for period ${period}`);
    results.push({ name, reportId: await job.handler(period) });
  }
  return results;
}

if (require.main === module) {
  runDueJobs().then((r) => console.log('[Scheduler] Done', r)).catch(console.error);
}

module.exports = { runDueJobs, SCHEDULES };
