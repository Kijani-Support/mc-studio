// Schema mapping: internal loan ledger → CMA quarterly format
const { DataStageConnector } = require('../../shared/datastage_connector');

const CMA_FIELD_MAP = {
  account_id: 'loan_reference',
  principal_amount: 'outstanding_principal',
  status: 'asset_quality',
  product_type: 'product_category'
};

async function transformToCMA(rows) {
  return rows.map((row) => {
    const out = {};
    for (const [src, dest] of Object.entries(CMA_FIELD_MAP)) {
      out[dest] = row[src];
    }
    out.reporting_period = row.period || 'Q1-2026';
    return out;
  });
}

async function extractForCMA() {
  return DataStageConnector.extract({
    source: process.env.CORE_BANKING_DB_URL,
    query: 'SELECT account_id, product_type, principal_amount, status FROM loan_accounts'
  });
}

module.exports = { transformToCMA, extractForCMA };
