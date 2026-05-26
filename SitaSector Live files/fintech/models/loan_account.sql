CREATE TABLE IF NOT EXISTS loan_accounts (
  account_id VARCHAR PRIMARY KEY,
  customer_id VARCHAR NOT NULL REFERENCES customers(customer_id),
  product_type VARCHAR CHECK (product_type IN ('personal', 'business', 'asset')),
  principal_amount DECIMAL(18,2) NOT NULL,
  interest_rate DECIMAL(8,4),
  disbursement_date DATE,
  maturity_date DATE,
  status VARCHAR CHECK (status IN ('active', 'defaulted', 'closed'))
);
