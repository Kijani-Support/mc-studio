# Sita Sector Sprint — Complete Runnable Monorepo

**MC Studio · IBM Silver Partner**  
*IBM Data Workshop Series — Data Mapping, Automation & AI Integration*

> **This folder (`SitaSector Live files`)** is the full runnable implementation duplicate of `sita-sector-sprint` (reference stubs only). It includes shared IBM clients, sector models, APIs, pipelines, tests, and portable mock mode for local runs or IBM Watson / MDM / DataStage when credentials are configured.

---

## Quick Start (Portable / Mock Mode)

**Prerequisites:** Node.js 18+, Python 3.10+, pip

```bash
cd "SitaSector Live files"
copy .env.example .env          # Windows — or: cp .env.example .env
npm install
pip install -r requirements.txt
npm test                        # runs all 6 sector tests
```

`SITA_MOCK_MODE=1` (default in `.env.example`) uses in-memory DB mocks and simulated IBM responses — no PostgreSQL or cloud keys required.

### Sector test matrix (verified)

| Sector | Test command | What it validates |
|---|---|---|
| Fintech | `npm run test:fintech` | CBK DataStage pipeline → MDM → report artifact |
| Retail | `npm run test:retail` | MDM golden profile unification + WooCommerce connector |
| Edtech | `npm run test:edtech` | Donor schema transforms + Watson at-risk classifier |
| Energy | `node energy/tests/test_epra_report_builder.js` | EPRA report export |
| Energy | `python energy/tests/test_anomaly_scorer.py` | Watson anomaly → predictive maintenance job |
| Healthtech | `python healthtech/tests/test_mdm_sync.py` | IBM MDM nightly patient sync |
| Agritech | `python agritech/tests/test_certification_checker.py` | Export market certification rules |

Run everything: `npm test` (includes `python scripts/setup_django.py` for SQLite ORM sectors).

---

## IBM Watson / TechZone / CP4D Deployment

1. Copy `.env.example` → `.env` and set `SITA_MOCK_MODE=0`
2. Provide credentials:

| Variable | Purpose |
|---|---|
| `IBM_MDM_URL`, `IBM_MDM_API_KEY` | Master data resolve (fintech, retail, healthtech) |
| `WATSON_ML_ENDPOINT`, `WATSON_API_KEY` | Watson Machine Learning scoring |
| `WATSON_ANOMALY_MODEL_ID` | Energy telemetry anomaly deployment |
| `WATSON_AT_RISK_MODEL_ID` | Edtech learner risk deployment |
| `WATSON_NBA_MODEL_ID` | Retail next-best-action deployment |
| `CORE_BANKING_DB_URL` / `DATABASE_URL` | Live PostgreSQL (replaces `shared/db_mock.js`) |

Shared clients live in `shared/` (`ibm_mdm_client.js`, `ibm_watson_client.py`, `datastage_connector.js`, `report_utils.js`).

---

## Repository Layout (implemented)

```
SitaSector Live files/
├── .env.example
├── package.json / requirements.txt
├── scripts/
│   ├── test-all-sectors.js      # full test runner
│   ├── setup_django.py          # SQLite migrate: healthtech, agritech, energy
│   └── django_bootstrap.py      # per-test DB bootstrap
├── shared/                      # IBM integration layer (mock + live)
├── fintech/ retail/ edtech/     # Node pipelines + SQL models + API stubs
├── healthtech/ agritech/ energy/ # Django ORM sectors + services + tests
└── output/                      # generated report artifacts (mock PDF → JSON)
```

---

## Case Studies & Data Model Reference

The sections below document sector scenarios, entities, and artifact naming. **All referenced files are now present in this monorepo.**

---

## How to Use This Document

Each sector below contains:
- A **case study** grounding the data challenge in a real operational scenario
- A **data model** (entities, relationships, key fields)
- A **data flow** (source → transform → output)
- A **build reference** (IBM tool + implementation approach)
- A **project artifact file reference** (naming convention for code assets)

All code references follow the `SitaSector Live files/` monorepo structure defined at the end of this document.

---

## Sector 1 — Fintech

### Case Study: Automated Regulatory Reporting for a Kenyan Digital Lender

**Scenario:** A licensed digital lender submits monthly reports to CBK (Central Bank of Kenya) and quarterly summaries to CMA. Currently, a finance analyst exports raw loan ledger data from their core banking system, reformats it manually in Excel for each regulator's template, and emails PDFs. The process takes three days per cycle and has produced two compliance errors in the past year.

**The Fix:** A master data pipeline that reads directly from the loan ledger, applies transformation rules per regulator schema, and auto-generates submission-ready reports — triggered on schedule.

### Data Model

```
LoanAccount
  - account_id (PK)
  - customer_id (FK → Customer)
  - product_type: [personal, business, asset]
  - principal_amount: DECIMAL
  - interest_rate: DECIMAL
  - disbursement_date: DATE
  - maturity_date: DATE
  - status: [active, defaulted, closed]

Customer
  - customer_id (PK)
  - id_number: VARCHAR
  - kyc_tier: [basic, enhanced]
  - risk_score: INTEGER
  - created_at: TIMESTAMP

RepaymentTransaction
  - transaction_id (PK)
  - account_id (FK → LoanAccount)
  - amount_paid: DECIMAL
  - payment_date: DATE
  - channel: [mpesa, bank, ussd]

RegulatoryReport
  - report_id (PK)
  - regulator: [CBK, CMA, SASRA]
  - period: VARCHAR
  - generated_at: TIMESTAMP
  - status: [draft, submitted, accepted]
  - file_path: VARCHAR
```

### Data Flow

```
[Core Banking DB] 
    → IBM DataStage (extract + validate)
    → IBM MDM (master loan + customer registry)
    → Transformation Engine (apply CBK/CMA schema rules)
    → [RegulatoryReport table]
    → Auto-PDF generation + email dispatch
    → Audit log entry
```

### Build Reference

| Layer | IBM Tool | Notes |
|---|---|---|
| Ingestion | IBM DataStage | CDC from core banking DB |
| Mastering | IBM MDM | Deduplicate customer records across products |
| Rules | IBM OpenPages | Regulatory rule library per regulator |
| Output | IBM Watson Studio | Schedule + generate report artifacts |

### Project Artifact File References

```
sita-sector-sprint/
  fintech/
    models/
      loan_account.sql
      customer.sql
      repayment_transaction.sql
      regulatory_report.sql
    pipelines/
      cbk_report_pipeline.js          # DataStage pipeline config
      cma_transform.js                # Schema mapping: internal → CMA format
      report_scheduler.js             # Cron trigger for monthly/quarterly runs
    api/
      routes/
        reports.js                    # GET /reports, POST /reports/generate
        compliance.js                 # POST /compliance/submit
      services/
        regulatoryEngine.js           # Core transformation logic
        mdmClient.js                  # IBM MDM API wrapper
    tests/
      cbk_pipeline.test.js
```

---

## Sector 2 — Healthtech

### Case Study: Unified Patient Record for a Multi-Site Clinic Network

**Scenario:** A private clinic group operates four branches across Nairobi. Patient records exist in three systems: a legacy HMIS at the oldest branch, a newer EHR at two branches, and a lab portal used across all four. When a patient is referred internally, the receiving branch requests patient history by WhatsApp. Lab results sometimes arrive after the consultation. Regulators (MOH) require quarterly aggregate health metrics the group cannot currently produce without hiring a data contractor.

**The Fix:** A unified patient data master that syncs across all branch systems, enabling real-time referral access and automated MOH reporting.

### Data Model

```
Patient
  - patient_id (PK, UUID)
  - national_id: VARCHAR
  - name: VARCHAR
  - dob: DATE
  - gender: ENUM
  - county: VARCHAR
  - registered_facility_id (FK → Facility)

Encounter
  - encounter_id (PK)
  - patient_id (FK → Patient)
  - facility_id (FK → Facility)
  - clinician_id (FK → Clinician)
  - encounter_date: DATETIME
  - encounter_type: [outpatient, inpatient, referral, emergency]
  - diagnosis_codes: JSONB        -- ICD-10 array
  - notes: TEXT

LabResult
  - result_id (PK)
  - encounter_id (FK → Encounter)
  - test_type: VARCHAR
  - result_value: VARCHAR
  - normal_range: VARCHAR
  - received_at: DATETIME
  - source_lab: VARCHAR

Referral
  - referral_id (PK)
  - origin_encounter_id (FK → Encounter)
  - destination_facility_id (FK → Facility)
  - status: [pending, accepted, completed]
  - created_at: TIMESTAMP

Facility
  - facility_id (PK)
  - name: VARCHAR
  - branch_code: VARCHAR
  - system_type: [HMIS, EHR, hybrid]
```

### Data Flow

```
[Branch HMIS] ─┐
[Branch EHR]  ─┼→ IBM DataStage (ETL per source schema)
[Lab Portal]  ─┘
    → IBM MDM (golden patient record — match on national_id)
    → Unified Patient API
    → [Referral service: push summary to destination branch]
    → [MOH Reporting engine: aggregate quarterly metrics]
    → [Clinician dashboard: IBM Watson-powered risk flags]
```

### Build Reference

| Layer | IBM Tool | Notes |
|---|---|---|
| ETL | IBM DataStage | Multi-source connectors per branch system |
| Master Record | IBM MDM | Probabilistic match on name + DOB + ID |
| AI Flags | IBM Watson | Risk stratification model on encounter history |
| Compliance | IBM OpenPages | MOH reporting schema and submission tracking |

### Project Artifact File References

```
sita-sector-sprint/
  healthtech/
    models/
      patient.py                      # Django model: Patient
      encounter.py                    # Django model: Encounter
      lab_result.py                   # Django model: LabResult
      referral.py                     # Django model: Referral
    migrations/
      0001_initial.py
      0002_add_diagnosis_codes.py
    services/
      mdm_sync.py                     # IBM MDM sync job (runs nightly)
      referral_dispatcher.py          # Push referral summary to destination branch
      moh_report_generator.py         # Quarterly MOH aggregate builder
    api/
      views/
        patient_views.py              # GET /patients/:id, POST /patients
        referral_views.py             # POST /referrals
        report_views.py               # GET /reports/moh/quarterly
      serializers/
        patient_serializer.py
        referral_serializer.py
    tests/
      test_mdm_sync.py
      test_referral_dispatcher.py
```

---

## Sector 3 — Edtech

### Case Study: Learner Progress Tracking & Funder Reporting for a Hybrid Learning Platform

**Scenario:** An edtech startup delivers blended learning (online modules + in-person tutoring) to secondary school students in Nairobi, Kisumu, and Mombasa. They receive grant funding from two international donors who each require impact reports in different formats — one wants completion rates by county, the other wants learning outcome scores by subject. The ops team manually pulls data from the LMS each month. Instructors have no real-time view of at-risk learners.

**The Fix:** A unified learner analytics model with automated donor reporting and an instructor alert system for learners falling behind.

### Data Model

```
Learner
  - learner_id (PK)
  - name: VARCHAR
  - county: VARCHAR
  - school_name: VARCHAR
  - cohort_id (FK → Cohort)
  - enrollment_date: DATE
  - learning_mode: [online, blended, in_person]

Module
  - module_id (PK)
  - subject: VARCHAR
  - grade_level: INTEGER
  - total_lessons: INTEGER
  - pass_threshold: DECIMAL

Progress
  - progress_id (PK)
  - learner_id (FK → Learner)
  - module_id (FK → Module)
  - lessons_completed: INTEGER
  - last_active: DATETIME
  - score: DECIMAL
  - status: [on_track, at_risk, completed, dropped]

DonorReport
  - report_id (PK)
  - donor_id (FK → Donor)
  - period: VARCHAR
  - schema_version: VARCHAR
  - generated_at: TIMESTAMP
  - payload: JSONB
```

### Data Flow

```
[LMS Activity Logs]
    → IBM DataStage (daily extract + normalise)
    → [Progress table] (IBM MDM: deduplicate learner across platforms)
    → IBM Watson (at-risk classification model)
    → [Instructor alert: learners with score < threshold or 7-day inactivity]
    → [Donor Report engine: transform Progress → donor-specific schema]
    → Automated email dispatch per donor schedule
```

### Build Reference

| Layer | IBM Tool | Notes |
|---|---|---|
| Ingestion | IBM DataStage | LMS webhook + daily batch |
| Analytics | IBM Watson Studio | At-risk model trained on completion velocity |
| Mastering | IBM MDM | Learner deduplication across blended touchpoints |
| Reporting | IBM Cognos / custom | Donor schema transformer |

### Project Artifact File References

```
sita-sector-sprint/
  edtech/
    models/
      learner.sql
      module.sql
      progress.sql
      donor_report.sql
    pipelines/
      lms_ingest.js                   # DataStage: LMS → Progress table
      at_risk_classifier.py           # Watson ML scoring job
      donor_report_transformer.js     # Progress → donor schema (per donor config)
    api/
      routes/
        learners.js                   # GET /learners, GET /learners/:id/progress
        alerts.js                     # GET /alerts/at-risk
        reports.js                    # POST /reports/generate/:donor_id
      services/
        watsonScorer.js               # IBM Watson API client
        donorSchemaMap.js             # Donor schema registry
    config/
      donor_schemas/
        donor_a_schema.json
        donor_b_schema.json
    tests/
      at_risk_classifier.test.py
      donor_transformer.test.js
```

---

## Sector 4 — Agritech

### Case Study: Supply Chain Traceability for a Coffee Export Cooperative

**Scenario:** A cooperative aggregates beans from 400+ smallholder farmers across Mount Kenya. Buyers in Germany and Japan require full traceability — farm origin, harvest date, processing method, certification status. Currently, field agents record data on paper. Certification auditors request documents by email. Export paperwork is assembled manually two days before each shipment and frequently has errors that delay customs clearance.

**The Fix:** A digital traceability ledger from farm intake to export documentation, with automated certification compliance checks.

### Data Model

```
Farm
  - farm_id (PK)
  - farmer_id (FK → Farmer)
  - location_lat: DECIMAL
  - location_lng: DECIMAL
  - acreage: DECIMAL
  - certification_status: [organic, fairtrade, rainforest_alliance, none]
  - certification_expiry: DATE

HarvestBatch
  - batch_id (PK)
  - farm_id (FK → Farm)
  - harvest_date: DATE
  - weight_kg: DECIMAL
  - processing_method: [washed, natural, honey]
  - quality_grade: [AA, AB, C, PB]
  - intake_agent_id (FK → Agent)

ProcessingLog
  - log_id (PK)
  - batch_id (FK → HarvestBatch)
  - stage: [milling, drying, sorting, bagging]
  - completed_at: DATETIME
  - operator_id: VARCHAR
  - output_weight_kg: DECIMAL

ExportShipment
  - shipment_id (PK)
  - batch_ids: JSONB              -- array of batch_ids in this shipment
  - buyer_id (FK → Buyer)
  - destination_country: VARCHAR
  - departure_date: DATE
  - certificate_ids: JSONB        -- linked certification documents
  - customs_status: [pending, cleared, held]
```

### Data Flow

```
[Field Agent Mobile App] → IBM DataStage (intake event stream)
    → [HarvestBatch table]
    → [ProcessingLog events]
    → IBM MDM (farm + farmer master registry)
    → Certification compliance check (rules engine)
    → [ExportShipment builder: auto-assemble traceability document]
    → PDF export certificate → buyer portal + customs submission
```

### Build Reference

| Layer | IBM Tool | Notes |
|---|---|---|
| Field Capture | IBM DataStage | Mobile-to-cloud event pipeline |
| Mastering | IBM MDM | Farm + farmer deduplication, certification registry |
| Rules | IBM OpenPages | Certification compliance check per destination market |
| Documents | IBM Watson | Auto-extract traceability summary for export docs |

### Project Artifact File References

```
sita-sector-sprint/
  agritech/
    models/
      farm.py                         # Django model: Farm
      harvest_batch.py                # Django model: HarvestBatch
      processing_log.py               # Django model: ProcessingLog
      export_shipment.py              # Django model: ExportShipment
    migrations/
      0001_initial.py
    services/
      intake_pipeline.py              # Field agent → HarvestBatch ingestion
      certification_checker.py        # Rules engine: check cert validity per market
      shipment_builder.py             # Assemble traceability doc from batch_ids
      export_pdf_generator.py         # PDF certificate generation
    api/
      views/
        batches.py                    # GET /batches, POST /batches/intake
        shipments.py                  # POST /shipments/build, GET /shipments/:id
        certifications.py             # GET /farms/:id/certifications
    tests/
      test_certification_checker.py
      test_shipment_builder.py
```

---

## Sector 5 — Retail & E-commerce

### Case Study: Unified Customer Profile for an Omnichannel Fashion Retailer

**Scenario:** A Nairobi fashion retailer operates three physical stores and a WooCommerce online shop. Customer data is siloed: in-store purchases are on a POS system, online orders are in WooCommerce, and a loyalty programme runs on a third platform. Marketing sends blanket email blasts because there is no unified purchase history. Returns processed in-store are not reflected online and vice versa.

**The Fix:** A unified customer data platform linking POS, ecommerce, and loyalty — enabling personalised CX automation and consistent return processing.

### Data Model

```
CustomerProfile
  - profile_id (PK, UUID)
  - email: VARCHAR (deduplicated master key)
  - phone: VARCHAR
  - loyalty_tier: [bronze, silver, gold]
  - total_lifetime_value: DECIMAL
  - last_purchase_date: DATE
  - preferred_channel: [in_store, online, both]

Order
  - order_id (PK)
  - profile_id (FK → CustomerProfile)
  - channel: [pos, woocommerce, social]
  - order_date: DATETIME
  - total_amount: DECIMAL
  - status: [pending, fulfilled, returned, cancelled]

OrderItem
  - item_id (PK)
  - order_id (FK → Order)
  - sku: VARCHAR
  - quantity: INTEGER
  - unit_price: DECIMAL
  - category: VARCHAR

CXEvent
  - event_id (PK)
  - profile_id (FK → CustomerProfile)
  - event_type: [browse, wishlist, cart_abandon, purchase, return, complaint]
  - occurred_at: DATETIME
  - channel: VARCHAR
  - metadata: JSONB
```

### Data Flow

```
[POS System] ─┐
[WooCommerce] ─┼→ IBM DataStage (real-time + batch connectors)
[Loyalty App] ─┘
    → IBM MDM (golden CustomerProfile — match on email + phone)
    → [CXEvent stream]
    → IBM Watson (next-best-action model: recommend, retain, win-back)
    → [Personalised email/SMS trigger]
    → [Unified returns handler → update both POS and WooCommerce]
```

### Build Reference

| Layer | IBM Tool | Notes |
|---|---|---|
| Connectors | IBM DataStage | WooCommerce REST API + POS CSV + Loyalty API |
| Unification | IBM MDM | Email + phone probabilistic match |
| Personalisation | IBM Watson | Purchase propensity + churn risk models |
| Automation | IBM Watson Orchestrate | CX workflow: cart abandon → reminder → offer |

### Project Artifact File References

```
sita-sector-sprint/
  retail/
    models/
      customer_profile.sql
      order.sql
      order_item.sql
      cx_event.sql
    pipelines/
      pos_connector.js                # DataStage: POS → Order + CXEvent
      woocommerce_connector.js        # WooCommerce webhook handler
      loyalty_sync.js                 # Loyalty tier sync job
      mdm_unification.js              # IBM MDM golden profile builder
    api/
      routes/
        customers.js                  # GET /customers/:id, GET /customers/:id/history
        orders.js                     # GET /orders, POST /orders/return
        cx_events.js                  # POST /cx-events (ingest from channels)
      services/
        watsonNBA.js                  # Next-best-action API client
        emailTrigger.js               # Personalised comms dispatcher
    tests/
      mdm_unification.test.js
      woocommerce_connector.test.js
```

---

## Sector 6 — Energy & Manufacturing

### Case Study: Predictive Maintenance & Regulatory Compliance for a Solar Manufacturer

**Scenario:** A solar equipment manufacturer and installer operates a fleet of 1,200 installed systems across Kenya. Maintenance is scheduled by calendar (every 6 months) regardless of actual performance data. EPRA requires quarterly performance and incident reports. When systems fail unexpectedly, field technicians are dispatched reactively, driving up costs. Two incidents in the past year were flagged by EPRA for late reporting.

**The Fix:** An IoT-to-analytics pipeline that uses performance telemetry to predict maintenance needs, auto-generates EPRA compliance reports, and dispatches technicians proactively.

### Data Model

```
Installation
  - installation_id (PK)
  - site_name: VARCHAR
  - county: VARCHAR
  - system_capacity_kw: DECIMAL
  - install_date: DATE
  - status: [operational, degraded, offline]

TelemetryReading
  - reading_id (PK)
  - installation_id (FK → Installation)
  - timestamp: DATETIME
  - output_kw: DECIMAL
  - battery_voltage: DECIMAL
  - temperature_celsius: DECIMAL
  - irradiance: DECIMAL
  - alert_flags: JSONB

MaintenanceJob
  - job_id (PK)
  - installation_id (FK → Installation)
  - trigger_type: [scheduled, predictive, reactive]
  - scheduled_date: DATE
  - completed_date: DATE
  - technician_id (FK → Technician)
  - outcome: [resolved, escalated, deferred]

EPRAReport
  - report_id (PK)
  - period: VARCHAR
  - generated_at: TIMESTAMP
  - status: [draft, submitted, acknowledged]
  - incident_count: INTEGER
  - total_output_kwh: DECIMAL
```

### Data Flow

```
[IoT Sensors / SCADA] → IBM DataStage (streaming telemetry pipeline)
    → [TelemetryReading table]
    → IBM Watson (anomaly detection + degradation prediction model)
    → [MaintenanceJob creation: predictive trigger]
    → [Technician dispatch API]
    → EPRA compliance engine: aggregate quarterly metrics
    → [EPRAReport generation + submission]
```

### Build Reference

| Layer | IBM Tool | Notes |
|---|---|---|
| Streaming | IBM DataStage | MQTT/IoT connector → telemetry pipeline |
| AI | IBM Watson Studio | Anomaly + remaining-useful-life models |
| Compliance | IBM OpenPages | EPRA schema, incident tracking, submission log |
| Dispatch | IBM Watson Orchestrate | Maintenance job → technician assignment workflow |

### Project Artifact File References

```
sita-sector-sprint/
  energy/
    models/
      installation.sql
      telemetry_reading.sql
      maintenance_job.sql
      epra_report.sql
    pipelines/
      telemetry_ingest.js             # DataStage: IoT stream → TelemetryReading
      anomaly_scorer.py               # Watson anomaly detection job
      predictive_scheduler.py         # Convert predictions → MaintenanceJob records
      epra_report_builder.js          # Quarterly EPRA aggregation + export
    api/
      routes/
        installations.js              # GET /installations, GET /installations/:id/telemetry
        maintenance.js                # GET /jobs, POST /jobs/dispatch
        compliance.js                 # GET /reports/epra, POST /reports/epra/submit
      services/
        watsonAnomalyClient.py        # Watson API wrapper for scoring
        technicianDispatcher.js       # Orchestrate workflow trigger
    tests/
      test_anomaly_scorer.py
      test_epra_report_builder.js
```

---

## Monorepo File System Structure

```
SitaSector Live files/
├── README.md                         ← this file (includes Quick Start)
├── .env.example                      ← IBM API keys, DB connection strings
├── package.json                      ← JS/Node shared deps + npm test
├── requirements.txt                  ← Python/Django shared deps
├── scripts/                          ← test-all-sectors.js, setup_django.py
│
├── fintech/
│   ├── models/                       ← SQL schema files
│   ├── pipelines/                    ← DataStage + transformer scripts (.js)
│   ├── api/routes/ + services/       ← Node/Express API layer
│   └── tests/
│
├── healthtech/
│   ├── models/                       ← Django models (.py)
│   ├── migrations/
│   ├── services/                     ← Python service layer
│   ├── api/views/ + serializers/     ← Django REST Framework
│   └── tests/
│
├── edtech/
│   ├── models/                       ← SQL + config
│   ├── pipelines/                    ← JS + Python pipeline mix
│   ├── api/routes/ + services/
│   ├── config/donor_schemas/         ← JSON schema per donor
│   └── tests/
│
├── agritech/
│   ├── models/                       ← Django models (.py)
│   ├── migrations/
│   ├── services/
│   ├── api/views/
│   └── tests/
│
├── retail/
│   ├── models/                       ← SQL schema files
│   ├── pipelines/                    ← JS connectors
│   ├── api/routes/ + services/
│   └── tests/
│
├── energy/
│   ├── models/                       ← SQL schema files
│   ├── pipelines/                    ← JS + Python mix
│   ├── api/routes/ + services/
│   └── tests/
│
└── shared/
    ├── ibm_mdm_client.js             ← Shared IBM MDM API wrapper
    ├── ibm_watson_client.py          ← Shared Watson API wrapper
    ├── datastage_connector.js        ← Shared DataStage base connector
    └── report_utils.js               ← Shared PDF / export utilities
```

---

## IBM Tool Reference Summary

| Tool | Role across sectors |
|---|---|
| IBM DataStage | Ingestion and ETL for all 6 sectors |
| IBM MDM | Master data unification: customers, patients, farmers, learners |
| IBM Watson Studio | ML models: risk scoring, anomaly detection, next-best-action |
| IBM OpenPages | Regulatory rules engine and compliance tracking |
| IBM Watson Orchestrate | Workflow automation: dispatch, alerts, comms triggers |
| IBM TechZone | Developer sandbox for prototyping and deployment |

---

*Sita Sector Sprint · MC Studio · IBM Silver Partner · Nairobi, Kenya*  
*Register: [moduschorastudio.mydmportal.com/SitaSectorMay26](https://moduschorastudio.mydmportal.com/SitaSectorMay26)*
