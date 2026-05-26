// retail/pipelines/mdm_unification.js
// IBM MDM: build golden CustomerProfile from POS + WooCommerce + Loyalty
// Sita Sector Sprint · MC Studio IBM Silver Partner

const { MDMClient } = require('../../shared/ibm_mdm_client');
const db = require('../db');

/**
 * Fetch unresolved customers from all source systems
 * (those lacking a golden_profile_id)
 */
async function getUnresolvedCustomers() {
  const result = await db.query(`
    SELECT DISTINCT ON (email)
      email, phone, source_system, source_customer_id,
      first_name, last_name, created_at
    FROM raw_customer_events
    WHERE golden_profile_id IS NULL
    ORDER BY email, created_at ASC
  `);
  return result.rows;
}

/**
 * Send to IBM MDM for probabilistic identity resolution
 * Match keys: email (primary), phone (secondary)
 */
async function resolveIdentities(customers) {
  return MDMClient.resolveEntities(customers, {
    entity: 'CustomerProfile',
    matchStrategy: 'probabilistic',
    matchKeys: ['email', 'phone'],
    threshold: 0.80
  });
}

/**
 * Upsert golden CustomerProfile records from MDM results
 */
async function upsertGoldenProfiles(matches) {
  let upserted = 0;
  for (const match of matches) {
    await db.query(`
      INSERT INTO customer_profiles
        (profile_id, email, phone, preferred_channel, mdm_confidence, created_at)
      VALUES ($1, $2, $3, 'unknown', $4, NOW())
      ON CONFLICT (email) DO UPDATE SET
        mdm_confidence = EXCLUDED.mdm_confidence,
        golden_resolved_at = NOW()
    `, [match.goldenId, match.email, match.phone, match.confidence]);

    // Back-fill golden_profile_id on raw events
    await db.query(`
      UPDATE raw_customer_events
      SET golden_profile_id = $1
      WHERE email = $2
    `, [match.goldenId, match.email]);

    upserted++;
  }
  return upserted;
}

async function runUnification() {
  console.log('[MDM Unification] Starting customer identity resolution');
  const customers = await getUnresolvedCustomers();
  console.log(`[MDM Unification] ${customers.length} unresolved customers`);
  if (!customers.length) return;

  const matches = await resolveIdentities(customers);
  const count = await upsertGoldenProfiles(matches);
  console.log(`[MDM Unification] ${count} golden profiles upserted`);
}

module.exports = { runUnification };
