CREATE TABLE IF NOT EXISTS customers (
  customer_id VARCHAR PRIMARY KEY,
  id_number VARCHAR,
  kyc_tier VARCHAR CHECK (kyc_tier IN ('basic', 'enhanced')),
  risk_score INTEGER,
  created_at TIMESTAMP DEFAULT NOW()
);
