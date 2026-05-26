CREATE TABLE IF NOT EXISTS telemetry_readings (
  reading_id UUID PRIMARY KEY,
  installation_id UUID REFERENCES installations(installation_id),
  timestamp TIMESTAMP,
  output_kw DECIMAL,
  battery_voltage DECIMAL,
  temperature_celsius DECIMAL,
  irradiance DECIMAL,
  alert_flags JSONB
);
