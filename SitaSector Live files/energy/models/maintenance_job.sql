CREATE TABLE IF NOT EXISTS maintenance_jobs (
  job_id UUID PRIMARY KEY,
  installation_id UUID REFERENCES installations(installation_id),
  trigger_type VARCHAR,
  scheduled_date DATE,
  completed_date DATE,
  technician_id VARCHAR,
  outcome VARCHAR,
  anomaly_score FLOAT,
  notes TEXT
);
