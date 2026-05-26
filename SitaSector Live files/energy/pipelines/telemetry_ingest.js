async function ingestTelemetryBatch(readings) {
  return { ingested: readings.length, channel: 'mqtt-mock' };
}

module.exports = { ingestTelemetryBatch };
