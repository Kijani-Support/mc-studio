CREATE TABLE IF NOT EXISTS regulatory_reports (
  report_id VARCHAR PRIMARY KEY,
  regulator VARCHAR CHECK (regulator IN ('CBK', 'CMA', 'SASRA')),
  period VARCHAR NOT NULL,
  generated_at TIMESTAMP DEFAULT NOW(),
  status VARCHAR CHECK (status IN ('draft', 'submitted', 'accepted')),
  file_path VARCHAR
);
