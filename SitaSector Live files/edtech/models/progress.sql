CREATE TABLE IF NOT EXISTS progress (
  progress_id VARCHAR PRIMARY KEY,
  learner_id VARCHAR REFERENCES learners(learner_id),
  module_id VARCHAR REFERENCES modules(module_id),
  lessons_completed INTEGER,
  last_active TIMESTAMP,
  score DECIMAL(5,2),
  status VARCHAR
);
