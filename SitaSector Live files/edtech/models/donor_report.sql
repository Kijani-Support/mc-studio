CREATE TABLE IF NOT EXISTS donor_reports (
  report_id VARCHAR PRIMARY KEY,
  donor_id VARCHAR,
  period VARCHAR,
  schema_version VARCHAR,
  generated_at TIMESTAMP,
  payload JSONB
);
