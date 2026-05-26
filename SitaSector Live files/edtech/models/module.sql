CREATE TABLE IF NOT EXISTS modules (
  module_id VARCHAR PRIMARY KEY,
  subject VARCHAR,
  grade_level INTEGER,
  total_lessons INTEGER,
  pass_threshold DECIMAL(5,2)
);
