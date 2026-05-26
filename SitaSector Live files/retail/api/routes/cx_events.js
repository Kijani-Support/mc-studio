async function ingestCXEvent(req, res) {
  res.json({ eventId: `EVT-${Date.now()}`, status: 'accepted' });
}

module.exports = { ingestCXEvent };
