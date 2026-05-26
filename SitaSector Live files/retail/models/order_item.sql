CREATE TABLE IF NOT EXISTS order_items (
  item_id VARCHAR PRIMARY KEY,
  order_id VARCHAR REFERENCES orders(order_id),
  sku VARCHAR,
  quantity INTEGER,
  unit_price DECIMAL(18,2),
  category VARCHAR
);
