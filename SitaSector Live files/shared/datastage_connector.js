// Shared IBM DataStage base connector — mock extract for portable runs
const MOCK = process.env.SITA_MOCK_MODE === '1';

const SAMPLE_LOANS = [
  {
    account_id: 'LA-001',
    customer_id: 'C-001',
    product_type: 'personal',
    principal_amount: '150000.00',
    disbursement_date: '2026-04-15',
    status: 'active',
    total_collected: '25000.00'
  },
  {
    account_id: 'LA-002',
    customer_id: 'C-002',
    product_type: 'business',
    principal_amount: '500000.00',
    disbursement_date: '2026-03-01',
    status: 'defaulted',
    total_collected: '0.00'
  }
];

class DataStageConnector {
  static async extract({ source, query }) {
    if (MOCK) {
      return SAMPLE_LOANS;
    }
    const { Pool } = require('pg');
    const pool = new Pool({ connectionString: source || process.env.CORE_BANKING_DB_URL });
    const result = await pool.query(query);
    await pool.end();
    return result.rows;
  }
}

module.exports = { DataStageConnector };
