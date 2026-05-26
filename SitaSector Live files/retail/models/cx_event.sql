CREATE TABLE IF NOT EXISTS cx_events (
  event_id VARCHAR PRIMARY KEY,
  profile_id UUID REFERENCES customer_profiles(profile_id),
  event_type VARCHAR,
  occurred_at TIMESTAMP,
  channel VARCHAR,
  metadata JSONB
);

CREATE TABLE IF NOT EXISTS raw_customer_events (
  email VARCHAR,
  phone VARCHAR,
  source_system VARCHAR,
  source_customer_id VARCHAR,
  first_name VARCHAR,
  last_name VARCHAR,
  created_at TIMESTAMP,
  golden_profile_id UUID
);
