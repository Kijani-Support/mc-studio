CREATE TABLE IF NOT EXISTS learners (
  learner_id VARCHAR PRIMARY KEY,
  name VARCHAR,
  county VARCHAR,
  school_name VARCHAR,
  cohort_id VARCHAR,
  enrollment_date DATE,
  learning_mode VARCHAR
);
