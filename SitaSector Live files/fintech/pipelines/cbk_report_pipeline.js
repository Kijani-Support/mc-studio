// fintech/pipelines/cbk_report_pipeline.js
// IBM DataStage pipeline config: Core Banking → CBK Report
// Sita Sector Sprint · MC Studio IBM Silver Partner

const { DataStageConnector } = require('../../shared/datastage_connector');
const { MDMClient } = require('../../shared/ibm_mdm_client');
const { generatePDF } = require('../../shared/report_utils');
const db = require('../db');

const CBK_SCHEMA = {
  reportName: 'CBK Monthly Credit Return',
  fields: ['account_id','disbursement_date','principal','status','npls','collections'],
  groupBy: 'product_type',
  aggregations: { principal: 'SUM', npls: 'COUNT_WHERE_DEFAULTED' }
};

async function runCBKPipeline(periodLabel) {
  // 1. Extract from core banking
  const raw = await DataStageConnector.extract({
    source: process.env.CORE_BANKING_DB_URL,
    query: `
      SELECT la.account_id, la.product_type, la.principal_amount,
             la.disbursement_date, la.status,
             COALESCE(SUM(rt.amount_paid), 0) AS total_collected
      FROM loan_accounts la
      LEFT JOIN repayment_transactions rt ON la.account_id = rt.account_id
      WHERE la.disbursement_date >= date_trunc('month', NOW() - INTERVAL '1 month')
      GROUP BY la.account_id
    `
  });

  // 2. Deduplicate customers via IBM MDM
  const mastered = await MDMClient.resolveEntities(raw, { matchKey: 'customer_id', entity: 'LoanAccount' });

  // 3. Apply CBK transformation rules
  const transformed = mastered.map(row => ({
    account_ref: row.account_id,
    product: row.product_type,
    principal: parseFloat(row.principal_amount).toFixed(2),
    disbursed: row.disbursement_date,
    status: row.status,
    is_npl: row.status === 'defaulted',
    collected: parseFloat(row.total_collected).toFixed(2)
  }));

  // 4. Persist report record
  const report = await db.query(
    `INSERT INTO regulatory_reports (regulator, period, status, generated_at)
     VALUES ('CBK', $1, 'draft', NOW()) RETURNING report_id`,
    [periodLabel]
  );

  // 5. Generate PDF and update record
  const filePath = await generatePDF({ schema: CBK_SCHEMA, data: transformed, period: periodLabel });
  await db.query(`UPDATE regulatory_reports SET file_path=$1, status='draft' WHERE report_id=$2`,
    [filePath, report.rows[0].report_id]);

  console.log(`CBK report ${report.rows[0].report_id} generated: ${filePath}`);
  return report.rows[0].report_id;
}

module.exports = { runCBKPipeline };
