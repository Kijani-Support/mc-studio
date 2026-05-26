CREATE TABLE IF NOT EXISTS epra_reports (
  report_id VARCHAR PRIMARY KEY,
  period VARCHAR,
  generated_at TIMESTAMP,
  status VARCHAR,
  incident_count INTEGER,
  total_output_kwh DECIMAL
);
