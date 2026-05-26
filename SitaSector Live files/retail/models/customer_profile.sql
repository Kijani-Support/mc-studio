CREATE TABLE IF NOT EXISTS customer_profiles (
  profile_id UUID PRIMARY KEY,
  email VARCHAR UNIQUE NOT NULL,
  phone VARCHAR,
  loyalty_tier VARCHAR CHECK (loyalty_tier IN ('bronze', 'silver', 'gold')),
  total_lifetime_value DECIMAL(18,2) DEFAULT 0,
  last_purchase_date DATE,
  preferred_channel VARCHAR,
  mdm_confidence DECIMAL(5,4),
  golden_resolved_at TIMESTAMP
);
