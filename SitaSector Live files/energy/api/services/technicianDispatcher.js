async function dispatchTechnician(jobId, technicianId) {
  console.log(`[Orchestrate] Dispatch job ${jobId} → tech ${technicianId}`);
  return { jobId, technicianId, status: 'dispatched' };
}

module.exports = { dispatchTechnician };
