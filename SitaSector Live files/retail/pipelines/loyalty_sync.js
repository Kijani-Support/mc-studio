const db = require('../db');

async function syncLoyaltyTiers(tiers) {
  let updated = 0;
  for (const t of tiers) {
    await db.query(
      `UPDATE customer_profiles SET loyalty_tier=$1 WHERE email=$2`,
      [t.tier, t.email]
    );
    updated++;
  }
  return { updated };
}

module.exports = { syncLoyaltyTiers };
