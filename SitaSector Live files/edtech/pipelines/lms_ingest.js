const db = require('../db');

async function ingestLMSActivity(events) {
  let count = 0;
  for (const e of events) {
    await db.query(
      `INSERT INTO progress (learner_id, module_id, lessons_completed, last_active, score, status)
       VALUES ($1,$2,$3,$4,$5,$6)`,
      [e.learnerId, e.moduleId, e.lessonsCompleted, e.lastActive, e.score, e.status]
    );
    count++;
  }
  return { ingested: count };
}

module.exports = { ingestLMSActivity };
