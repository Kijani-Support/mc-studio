// In-memory DB mock for portable sector tests (no PostgreSQL required)
let seq = 1;

const SAMPLE_PROGRESS = [
  {
    county: 'Nairobi',
    school_name: 'Alliance High',
    learning_mode: 'blended',
    cohort_id: 'COH-1',
    subject: 'Math',
    grade_level: 10,
    status: 'completed',
    score: '78.5',
    lessons_completed: 12,
    last_active: '2026-05-01'
  },
  {
    county: 'Kisumu',
    school_name: 'Kisumu Academy',
    learning_mode: 'online',
    cohort_id: 'COH-2',
    subject: 'English',
    grade_level: 9,
    status: 'at_risk',
    score: '45.0',
    lessons_completed: 4,
    last_active: '2026-05-10'
  }
];

const SAMPLE_RAW_CUSTOMERS = [
  {
    email: 'a@example.com',
    phone: '+254700000001',
    source_system: 'pos',
    source_customer_id: 'POS-1',
    first_name: 'Ada',
    last_name: 'M',
    created_at: new Date()
  }
];

async function query(sql, params = []) {
  const s = sql.replace(/\s+/g, ' ').trim();

  if (/INSERT INTO regulatory_reports/i.test(s)) {
    return { rows: [{ report_id: `RPT-${seq++}` }] };
  }
  if (/UPDATE regulatory_reports/i.test(s)) {
    return { rows: [] };
  }
  if (/INSERT INTO donor_reports/i.test(s)) {
    return { rows: [{ report_id: `DR-${seq++}` }] };
  }
  if (/FROM progress p/i.test(s)) {
    return { rows: SAMPLE_PROGRESS };
  }
  if (/FROM raw_customer_events/i.test(s)) {
    return { rows: SAMPLE_RAW_CUSTOMERS };
  }
  if (/INSERT INTO customer_profiles/i.test(s) || /UPDATE raw_customer_events/i.test(s)) {
    return { rows: [] };
  }

  return { rows: [] };
}

module.exports = { query };
