-- Reference schema (Django ORM is source of truth in portable runs)
CREATE TABLE IF NOT EXISTS installations (
  installation_id UUID PRIMARY KEY,
  site_name VARCHAR,
  county VARCHAR,
  system_capacity_kw DECIMAL,
  install_date DATE,
  status VARCHAR
);
