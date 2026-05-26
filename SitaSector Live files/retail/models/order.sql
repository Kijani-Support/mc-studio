CREATE TABLE IF NOT EXISTS orders (
  order_id VARCHAR PRIMARY KEY,
  profile_id UUID REFERENCES customer_profiles(profile_id),
  channel VARCHAR CHECK (channel IN ('pos', 'woocommerce', 'social')),
  order_date TIMESTAMP,
  total_amount DECIMAL(18,2),
  status VARCHAR
);
