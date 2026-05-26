const db = require('../db');

async function ingestPOSBatch(rows) {
  for (const row of rows) {
    await db.query(
      `INSERT INTO raw_customer_events (email, phone, source_system, source_customer_id, first_name, last_name, created_at)
       VALUES ($1,$2,'pos',$3,$4,$5,NOW())`,
      [row.email, row.phone, row.id, row.first_name, row.last_name]
    );
  }
  return { ingested: rows.length };
}

module.exports = { ingestPOSBatch };
