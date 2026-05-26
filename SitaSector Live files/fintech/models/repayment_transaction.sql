CREATE TABLE IF NOT EXISTS repayment_transactions (
  transaction_id VARCHAR PRIMARY KEY,
  account_id VARCHAR NOT NULL REFERENCES loan_accounts(account_id),
  amount_paid DECIMAL(18,2),
  payment_date DATE,
  channel VARCHAR CHECK (channel IN ('mpesa', 'bank', 'ussd'))
);
