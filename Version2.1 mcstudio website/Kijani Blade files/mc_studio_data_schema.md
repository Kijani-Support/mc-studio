# MC Studio Data Schema
## Comprehensive Data Model for Vector Database Management

**Version:** 1.0  
**Date:** February 4, 2026  
**Organization:** MC Studio x Okutta & Wairi Advocates  
**Hub Partners:** IBM Research Centre, Power Learn Project, Baraza Media Lab  
**Purpose:** Standardized data schema for startup ecosystem, legal services, and venture operations

---

## ABOUT MC STUDIO & HUB PARTNERS

MC Studio is a venture studio based in Nairobi, Kenya, licensed as a silver status IBM Business Partner. The studio focuses on startup support, legal compliance, and product QA testing. Okutta and Wairi Advocates (OW) is the affiliated law firm handling portfolio files within the Kenyan jurisdiction and acting as representative when engaging across borders within the EMEA region.

### Hub Partners

MC Studio collaborates with three strategic hub partners who provide ecosystem access, training, and media support:

1. **IBM Research Centre** - Technology research, innovation programs, and enterprise partnerships
2. **Power Learn Project** - Technical skills training, developer bootcamps, and capacity building
3. **Baraza Media Lab** - Media production, content creation, and startup storytelling

These hub partners target startups within 6 key sectors:
- **Fintech** - Financial technology and payment solutions
- **HealthTech** - Healthcare technology and telemedicine
- **EdTech** - Educational technology and e-learning
- **AgriTech** - Agricultural technology and farm management
- **Retail/Ecommerce** - Online retail and marketplace platforms
- **Energy/Manufacturing** - Clean energy and manufacturing innovation

Each sector has unique compliance requirements, regulatory considerations, and IP handling protocols that are tracked throughout the startup lifecycle.

---

## TABLE OF CONTENTS

1. [Core Entities](#core-entities)
2. [File Naming Conventions](#file-naming-conventions)
3. [Vector Database Schema](#vector-database-schema)
4. [Relationship Mappings](#relationship-mappings)
5. [Metadata Standards](#metadata-standards)
6. [Data Collection Touchpoints](#data-collection-touchpoints)
7. [Implementation Guidelines](#implementation-guidelines)

---

## 1. CORE ENTITIES

### 1.1 Startup Entity
**Collection:** `startups`  
**File Prefix:** `STARTUP_`

```json
{
  "id": "string (UUID)",
  "slug": "string (URL-safe)",
  "company_name": "string",
  "legal_entity_name": "string",
  "registration_number": "string",
  "business_structure": "enum (Ltd, LLP, Sole Proprietor, Unregistered)",
  
  "contact_info": {
    "email": "string",
    "phone": "string",
    "website": "string",
    "physical_address": "string",
    "postal_address": "string"
  },
  
  "classification": {
    "sector": "enum (Fintech, HealthTech, EdTech, AgriTech, Retail/Ecommerce, Energy/Manufacturing)",
    "industry_tags": "array[string]",
    "stage": "enum (Idea, Pre-Seed, Seed, Series A, Series B, Series C+, Growth, Mature)",
    "employee_count": "integer",
    "founding_date": "date",
    "incorporation_date": "date"
  },
  
  "financial_data": {
    "annual_revenue_kes": "decimal",
    "revenue_range": "enum (<5M, 5M-20M, 20M-200M, 200M-500M, 500M+)",
    "funding_raised_kes": "decimal",
    "funding_rounds": "array[FundingRound]",
    "monthly_burn_rate": "decimal",
    "runway_months": "integer"
  },
  
  "legal_tier": {
    "current_tier": "enum (HUSTLE, GROW, LEAD, None)",
    "tier_start_date": "date",
    "monthly_retainer_kes": "decimal",
    "contract_status": "enum (Active, Paused, Churned, Prospect)",
    "contract_duration_months": "integer",
    "auto_renewal": "boolean"
  },
  
  "legal_health": {
    "health_check_id": "string (FK to LegalHealthCheck)",
    "overall_score": "integer (0-100)",
    "last_assessment_date": "date",
    "risk_level": "enum (Low, Moderate, High, Critical)",
    "category_scores": {
      "corporate_structure": "integer (0-100)",
      "employment_hr": "integer (0-100)",
      "data_protection": "integer (0-100)",
      "intellectual_property": "integer (0-100)",
      "contracts_agreements": "integer (0-100)",
      "regulatory_compliance": "integer (0-100)"
    }
  },
  
  "compliance_status": {
    "kra_pin": "string",
    "kra_compliance": "boolean",
    "data_protection_registered": "boolean",
    "odpc_number": "string",
    "licenses": "array[License]",
    "regulatory_bodies": "array[string]"
  },
  
  "intellectual_property": {
    "trademarks": "array[Trademark]",
    "patents": "array[Patent]",
    "copyrights": "array[Copyright]",
    "domain_names": "array[string]",
    "ip_strategy_documented": "boolean"
  },
  
  "team_info": {
    "founders": "array[Founder]",
    "key_personnel": "array[Person]",
    "total_employees": "integer",
    "employment_contracts_count": "integer",
    "esop_implemented": "boolean"
  },
  
  "hub_program_program": {
    "participant": "boolean",
    "cohort": "string",
    "enrollment_date": "date",
    "program_status": "enum (Active, Graduated, Inactive)"
  },
  
  "ibm_partnership": {
    "qa_projects_completed": "integer",
    "qa_projects_active": "integer",
    "total_qa_revenue_kes": "decimal",
    "ibm_status": "enum (None, Bronze, Silver, Gold)"
  },
  
  "investor_readiness": {
    "finder_fee_eligible": "boolean",
    "investment_sought_kes": "decimal",
    "due_diligence_completed": "boolean",
    "dossier_prepared": "boolean",
    "investor_connections": "array[Investor]"
  },
  
  "documents": {
    "shareholders_agreement": "boolean",
    "founders_agreement": "boolean",
    "employment_contracts": "boolean",
    "ndas": "boolean",
    "commercial_contracts": "array[string]",
    "policies": "array[string]"
  },
  
  "engagement_history": {
    "first_contact_date": "date",
    "acquisition_source": "enum (IBM Research Centre, Power Learn Project, Baraza Media Lab, Referral, Inbound, Outbound, Event, Partnership)",
    "legal_health_checks_completed": "integer",
    "consultations_completed": "integer",
    "services_purchased": "array[Service]",
    "ltv_kes": "decimal",
    "last_interaction_date": "date"
  },
  
  "metadata": {
    "created_at": "timestamp",
    "updated_at": "timestamp",
    "created_by": "string (user_id)",
    "assigned_bd_rep": "string (user_id)",
    "assigned_trail_guide": "string (user_id)",
    "status": "enum (Active, Inactive, Archived)",
    "tags": "array[string]",
    "notes": "text"
  },
  
  "vector_embeddings": {
    "business_description_vector": "array[float] (1536 dimensions)",
    "services_needed_vector": "array[float] (1536 dimensions)",
    "sector_embedding": "array[float] (1536 dimensions)"
  }
}
```

**File Naming Convention:**
- Format: `STARTUP_{COMPANY_NAME_SLUG}_{CATEGORY}_{DATE}.{ext}`
- Examples:
  - `STARTUP_QuantumLeap_Profile_2026-02-04.json`
  - `STARTUP_QuantumLeap_LegalHealthCheck_2026-02-04.pdf`
  - `STARTUP_QuantumLeap_ShareholdersAgreement_2026-01-15.docx`
  - `STARTUP_QuantumLeap_QAReport_IBM_2026-02-01.pdf`

---

### 1.2 Legal Health Check Entity
**Collection:** `legal_health_checks`  
**File Prefix:** `LHC_`

```json
{
  "id": "string (UUID)",
  "startup_id": "string (FK to Startup)",
  "assessment_date": "timestamp",
  "completed": "boolean",
  "completion_percentage": "integer (0-100)",
  
  "respondent_info": {
    "name": "string",
    "title": "string",
    "email": "string",
    "phone": "string"
  },
  
  "section_1_business_structure": {
    "business_registered": "boolean",
    "considered_incorporation": "boolean",
    "scaling_outside_kenya": "boolean",
    "formal_structure": "boolean",
    "founders_agreement": "boolean",
    "shareholders_agreement": "boolean",
    "financing_considered": "enum (Equity, Debt, Grant, None)",
    "licenses_permits": "boolean",
    "governance_structure": "boolean",
    "score": "integer (0-100)",
    "risk_level": "enum (Good, Moderate Risk, High Risk)"
  },
  
  "section_2_employment": {
    "employee_count": "integer",
    "employees_aware_rights": "boolean",
    "employment_agreements": "boolean",
    "esop_planned": "boolean",
    "policies_in_place": "boolean",
    "employer_obligations_known": "boolean",
    "ip_agreements_employees": "boolean",
    "score": "integer (0-100)",
    "risk_level": "enum (Good, Moderate Risk, High Risk)"
  },
  
  "section_3_commercial_operations": {
    "commercial_contracts": "boolean",
    "contract_review_regular": "boolean",
    "sop_exists": "boolean",
    "sla_exists": "boolean",
    "performance_review": "boolean",
    "score": "integer (0-100)",
    "risk_level": "enum (Good, Moderate Risk, High Risk)"
  },
  
  "section_4_data_protection": {
    "data_compliance_checklist_used": "boolean",
    "data_protection_policy": "boolean",
    "registered_as_controller_processor": "boolean",
    "obligations_known": "boolean",
    "data_officer_considered": "boolean",
    "gap_assessment_done": "boolean",
    "dpia_conducted": "boolean",
    "training_needed": "boolean",
    "score": "integer (0-100)",
    "risk_level": "enum (Good, Moderate Risk, High Risk)"
  },
  
  "section_5_intellectual_property": {
    "ip_identification_processes": "boolean",
    "ip_registered": "boolean",
    "trademarks_patents_registered": "boolean",
    "domain_secured": "boolean",
    "website_copyright_protected": "boolean",
    "logos_registered": "boolean",
    "business_name_registered": "boolean",
    "creative_material_agreements": "boolean",
    "clearance_searches_done": "boolean",
    "ip_protection_policy": "boolean",
    "ip_rights_obligations_known": "boolean",
    "disclosure_prevention_processes": "boolean",
    "competitor_infringement_identification": "boolean",
    "ip_training_needed": "boolean",
    "score": "integer (0-100)",
    "risk_level": "enum (Good, Moderate Risk, High Risk)"
  },
  
  "section_6_regulatory_compliance": {
    "sector_specific_licenses": "array[string]",
    "compliance_status": "array[ComplianceItem]",
    "regulatory_bodies": "array[string]",
    "score": "integer (0-100)",
    "risk_level": "enum (Good, Moderate Risk, High Risk)"
  },
  
  "section_7_additional_info": {
    "company_description": "text",
    "specific_legal_concerns": "text",
    "immediate_needs": "array[string]",
    "timeline": "string"
  },
  
  "scoring": {
    "overall_score": "integer (0-100)",
    "weighted_score": "decimal",
    "category_weights": {
      "corporate_structure": 0.20,
      "employment_hr": 0.15,
      "data_protection": 0.20,
      "intellectual_property": 0.15,
      "contracts_agreements": 0.15,
      "regulatory_compliance": 0.15
    }
  },
  
  "recommendations": {
    "recommended_tier": "enum (HUSTLE, GROW, LEAD)",
    "priority_actions": "array[Action]",
    "estimated_setup_cost_kes": "decimal",
    "critical_gaps": "array[string]",
    "quick_wins": "array[string]"
  },
  
  "follow_up": {
    "consultation_scheduled": "boolean",
    "consultation_date": "timestamp",
    "assigned_trail_guide": "string (user_id)",
    "quote_sent": "boolean",
    "converted_to_client": "boolean",
    "conversion_date": "timestamp"
  },
  
  "metadata": {
    "created_at": "timestamp",
    "updated_at": "timestamp",
    "completed_at": "timestamp",
    "source": "enum (Website, In-Person, Email, Event)",
    "version": "string (assessment version)",
    "time_to_complete_minutes": "integer"
  },
  
  "vector_embeddings": {
    "concerns_vector": "array[float] (1536 dimensions)",
    "needs_vector": "array[float] (1536 dimensions)"
  }
}
```

**File Naming Convention:**
- Format: `LHC_{STARTUP_SLUG}_{DATE}_{STATUS}.{ext}`
- Examples:
  - `LHC_QuantumLeap_2026-02-04_COMPLETED.pdf`
  - `LHC_QuantumLeap_2026-02-04_Recommendations.docx`
  - `LHC_QuantumLeap_2026-02-04_ScoreCard.json`

---

### 1.3 Service Engagement Entity
**Collection:** `service_engagements`  
**File Prefix:** `ENG_`

```json
{
  "id": "string (UUID)",
  "startup_id": "string (FK to Startup)",
  "service_type": "enum (Legal Retainer, Legal Health Check, QA Testing, Due Diligence, Add-On Service)",
  
  "retainer_details": {
    "tier": "enum (HUSTLE, GROW, LEAD)",
    "monthly_fee_kes": "decimal",
    "start_date": "date",
    "end_date": "date",
    "contract_months": "integer",
    "auto_renewal": "boolean",
    "status": "enum (Active, Paused, Cancelled, Expired)"
  },
  
  "scope_of_work": {
    "services_included": "array[string]",
    "monthly_hours_budgeted": "integer",
    "hours_used": "integer",
    "documents_included": "array[string]",
    "consultations_included": "integer",
    "consultations_used": "integer"
  },
  
  "team_assignment": {
    "lead_partner": "string (user_id)",
    "trail_guide": "string (user_id)",
    "assigned_associates": "array[string]",
    "bd_rep": "string (user_id)"
  },
  
  "billing": {
    "billing_cycle": "enum (Monthly, Quarterly, Annual, One-Time)",
    "payment_method": "enum (M-Pesa, Bank Transfer, Card)",
    "last_invoice_date": "date",
    "next_invoice_date": "date",
    "payment_status": "enum (Current, Overdue, Defaulted)",
    "days_overdue": "integer",
    "total_invoiced_kes": "decimal",
    "total_paid_kes": "decimal",
    "outstanding_balance_kes": "decimal"
  },
  
  "deliverables": {
    "documents_delivered": "array[Document]",
    "milestones_completed": "array[Milestone]",
    "upcoming_deliverables": "array[string]"
  },
  
  "client_satisfaction": {
    "harmony_pulse_scores": "array[HarmonyPulse]",
    "nps_score": "integer (-100 to 100)",
    "testimonials": "array[Testimonial]",
    "issues_raised": "array[Issue]"
  },
  
  "add_on_services": {
    "services_purchased": "array[AddOnService]",
    "total_add_on_revenue_kes": "decimal"
  },
  
  "metadata": {
    "created_at": "timestamp",
    "updated_at": "timestamp",
    "created_by": "string (user_id)",
    "tags": "array[string]",
    "notes": "text"
  }
}
```

**File Naming Convention:**
- Format: `ENG_{STARTUP_SLUG}_{TIER}_{CATEGORY}_{DATE}.{ext}`
- Examples:
  - `ENG_QuantumLeap_GROW_Contract_2026-01-15.pdf`
  - `ENG_QuantumLeap_GROW_MonthlyReport_2026-02-01.pdf`
  - `ENG_QuantumLeap_GROW_Invoice_INV2026-02-001.pdf`

---

### 1.4 IBM QA Project Entity
**Collection:** `qa_projects`  
**File Prefix:** `QA_`

```json
{
  "id": "string (UUID)",
  "startup_id": "string (FK to Startup)",
  "project_name": "string",
  "project_code": "string",
  
  "project_details": {
    "start_date": "date",
    "end_date": "date",
    "status": "enum (Scoping, In Progress, Testing, Review, Completed, On Hold)",
    "project_type": "enum (Manual Testing, Automation, Performance, Security, Accessibility)",
    "testing_scope": "text"
  },
  
  "team_assignment": {
    "qa_lead": "string (user_id)",
    "qa_analysts": "array[string]",
    "hours_budgeted": "integer",
    "hours_used": "integer"
  },
  
  "financials": {
    "project_fee_kes": "decimal (typically 30,000)",
    "payment_status": "enum (Pending, Paid, Overdue)",
    "invoiced": "boolean",
    "invoice_date": "date",
    "payment_date": "date"
  },
  
  "deliverables": {
    "test_plan": "boolean",
    "test_cases_count": "integer",
    "bugs_found": "integer",
    "bugs_severity_critical": "integer",
    "bugs_severity_high": "integer",
    "bugs_severity_medium": "integer",
    "bugs_severity_low": "integer",
    "test_report": "boolean",
    "recommendations": "boolean"
  },
  
  "quality_metrics": {
    "test_coverage_percentage": "decimal",
    "pass_rate_percentage": "decimal",
    "defect_density": "decimal",
    "client_satisfaction": "integer (1-5)"
  },
  
  "ibm_integration": {
    "ibm_tools_used": "array[string]",
    "ibm_certification_relevant": "boolean",
    "reported_to_ibm": "boolean"
  },
  
  "metadata": {
    "created_at": "timestamp",
    "updated_at": "timestamp",
    "completed_at": "timestamp",
    "created_by": "string (user_id)",
    "tags": "array[string]",
    "notes": "text"
  }
}
```

**File Naming Convention:**
- Format: `QA_{STARTUP_SLUG}_{PROJECT_CODE}_{CATEGORY}_{DATE}.{ext}`
- Examples:
  - `QA_QuantumLeap_QA2026-001_TestPlan_2026-01-20.pdf`
  - `QA_QuantumLeap_QA2026-001_TestReport_2026-02-03.pdf`
  - `QA_QuantumLeap_QA2026-001_BugLog_2026-02-03.xlsx`

---

### 1.5 Investment Deal Entity
**Collection:** `investment_deals`  
**File Prefix:** `INV_`

```json
{
  "id": "string (UUID)",
  "startup_id": "string (FK to Startup)",
  "deal_name": "string",
  
  "deal_details": {
    "deal_type": "enum (Seed, Series A, Series B, Series C+, Debt, Grant, Convertible Note, SAFE)",
    "target_amount_kes": "decimal",
    "actual_amount_kes": "decimal",
    "valuation_pre_money_kes": "decimal",
    "valuation_post_money_kes": "decimal",
    "close_date": "date",
    "status": "enum (Prospecting, Due Diligence, Term Sheet, Negotiation, Closed, Failed)"
  },
  
  "investors": {
    "lead_investor": "Investor",
    "co_investors": "array[Investor]",
    "total_investors": "integer"
  },
  
  "mc_studio_role": {
    "finder_fee_applicable": "boolean",
    "finder_fee_percentage": "decimal (typically 0.05)",
    "finder_fee_amount_kes": "decimal",
    "finder_fee_paid": "boolean",
    "finder_fee_payment_date": "date",
    
    "due_diligence_by_ow": "boolean",
    "dd_fee_kes": "decimal",
    "dd_completed_date": "date",
    "dd_report_delivered": "boolean",
    
    "dossier_prepared": "boolean",
    "pitch_support_provided": "boolean"
  },
  
  "documents": {
    "term_sheet": "boolean",
    "shareholders_agreement": "boolean",
    "subscription_agreement": "boolean",
    "disclosure_letter": "boolean",
    "board_resolutions": "boolean",
    "dd_report": "boolean"
  },
  
  "timeline": {
    "introduction_date": "date",
    "first_meeting_date": "date",
    "term_sheet_date": "date",
    "dd_start_date": "date",
    "dd_completion_date": "date",
    "closing_date": "date"
  },
  
  "metadata": {
    "created_at": "timestamp",
    "updated_at": "timestamp",
    "created_by": "string (user_id)",
    "assigned_partner": "string (user_id)",
    "tags": "array[string]",
    "notes": "text"
  }
}
```

**File Naming Convention:**
- Format: `INV_{STARTUP_SLUG}_{ROUND}_{CATEGORY}_{DATE}.{ext}`
- Examples:
  - `INV_QuantumLeap_SeriesA_TermSheet_2026-01-30.pdf`
  - `INV_QuantumLeap_SeriesA_DueDiligence_2026-02-01.pdf`
  - `INV_QuantumLeap_SeriesA_Dossier_2026-01-25.pdf`

---

### 1.6 Document Entity
**Collection:** `documents`  
**File Prefix:** `DOC_`

```json
{
  "id": "string (UUID)",
  "startup_id": "string (FK to Startup)",
  "engagement_id": "string (FK to ServiceEngagement, nullable)",
  
  "document_info": {
    "document_name": "string",
    "document_type": "enum (Contract, Agreement, Policy, Template, Report, Certificate, License, Registration, Correspondence, Other)",
    "document_category": "string",
    "version": "string",
    "language": "enum (English, Swahili)"
  },
  
  "file_details": {
    "filename": "string",
    "file_path": "string",
    "file_size_bytes": "integer",
    "file_format": "enum (PDF, DOCX, XLSX, PPTX, TXT, JPG, PNG)",
    "checksum_sha256": "string"
  },
  
  "classification": {
    "confidentiality": "enum (Public, Internal, Confidential, Highly Confidential)",
    "retention_years": "integer",
    "legal_privilege": "boolean",
    "client_facing": "boolean"
  },
  
  "parties": {
    "prepared_by": "string (user_id)",
    "reviewed_by": "string (user_id)",
    "approved_by": "string (user_id)",
    "signed_by_startup": "boolean",
    "signed_by_mc_studio": "boolean",
    "signed_by_ow": "boolean",
    "other_signatories": "array[string]"
  },
  
  "dates": {
    "creation_date": "date",
    "execution_date": "date",
    "effective_date": "date",
    "expiration_date": "date",
    "last_review_date": "date",
    "next_review_date": "date"
  },
  
  "status": {
    "status": "enum (Draft, Under Review, Approved, Executed, Expired, Superseded, Archived)",
    "execution_status": "enum (Not Applicable, Pending Signature, Partially Signed, Fully Executed)",
    "validity": "enum (Valid, Expired, Terminated, Void)"
  },
  
  "related_entities": {
    "related_documents": "array[string] (document_ids)",
    "supersedes": "string (document_id)",
    "superseded_by": "string (document_id)",
    "amendments": "array[string] (document_ids)"
  },
  
  "compliance": {
    "requires_registration": "boolean",
    "registered_with": "string",
    "registration_number": "string",
    "registration_date": "date",
    "stamp_duty_paid": "boolean",
    "stamp_duty_amount_kes": "decimal"
  },
  
  "metadata": {
    "created_at": "timestamp",
    "updated_at": "timestamp",
    "uploaded_by": "string (user_id)",
    "tags": "array[string]",
    "notes": "text",
    "access_log": "array[AccessLog]"
  },
  
  "vector_embeddings": {
    "content_vector": "array[float] (1536 dimensions)",
    "summary_vector": "array[float] (1536 dimensions)"
  }
}
```

**File Naming Convention:**
- Format: `DOC_{STARTUP_SLUG}_{DOCTYPE}_{VERSION}_{DATE}.{ext}`
- Examples:
  - `DOC_QuantumLeap_ShareholdersAgreement_v2.1_2026-01-15.pdf`
  - `DOC_QuantumLeap_EmploymentContract_CEO_2025-06-01.docx`
  - `DOC_QuantumLeap_DataProtectionPolicy_v1.0_2026-01-20.pdf`

---

### 1.7 Contact/Person Entity
**Collection:** `contacts`  
**File Prefix:** `CONTACT_`

```json
{
  "id": "string (UUID)",
  "person_type": "enum (Founder, Employee, Investor, Partner, Stakeholder, Lead)",
  
  "personal_info": {
    "first_name": "string",
    "last_name": "string",
    "full_name": "string",
    "title": "string",
    "email": "string",
    "phone": "string",
    "linkedin_url": "string",
    "nationality": "string",
    "id_number": "string (hashed)"
  },
  
  "startup_relationship": {
    "startup_id": "string (FK to Startup)",
    "relationship_type": "enum (Founder, Co-Founder, CEO, CTO, CFO, Employee, Advisor, Investor, Board Member)",
    "equity_percentage": "decimal",
    "start_date": "date",
    "end_date": "date",
    "is_active": "boolean"
  },
  
  "employment_details": {
    "job_title": "string",
    "department": "string",
    "employment_type": "enum (Full-Time, Part-Time, Contract, Consultant)",
    "salary_kes": "decimal",
    "contract_signed": "boolean",
    "nda_signed": "boolean",
    "ip_agreement_signed": "boolean",
    "esop_granted": "boolean",
    "esop_shares": "integer"
  },
  
  "investor_details": {
    "investor_type": "enum (Angel, VC, PE, Corporate, Family Office)",
    "firm_name": "string",
    "aum_usd": "decimal",
    "focus_sectors": "array[string]",
    "focus_stages": "array[string]",
    "investments_count": "integer"
  },
  
  "metadata": {
    "created_at": "timestamp",
    "updated_at": "timestamp",
    "source": "enum (Website, Referral, Event, LinkedIn, Direct)",
    "tags": "array[string]",
    "notes": "text"
  }
}
```

**File Naming Convention:**
- Format: `CONTACT_{LASTNAME}_{FIRSTNAME}_{STARTUP_SLUG}_{DATE}.{ext}`
- Examples:
  - `CONTACT_Smith_John_QuantumLeap_2026-02-04.vcf`
  - `CONTACT_Smith_John_EmploymentContract_2025-06-01.pdf`

---

### 1.8 Team Member Entity (MC Studio/OW Staff)
**Collection:** `team_members`  
**File Prefix:** `TEAM_`

```json
{
  "id": "string (UUID)",
  "employee_id": "string",
  
  "personal_info": {
    "first_name": "string",
    "last_name": "string",
    "email": "string",
    "phone": "string",
    "id_number": "string (hashed)"
  },
  
  "employment": {
    "department": "enum (Business Development, QA Testing, Venture Operations, Marketing, Legal - OW)",
    "role": "string",
    "employment_type": "enum (Full-Time, Part-Time, Contract)",
    "start_date": "date",
    "end_date": "date",
    "is_active": "boolean"
  },
  
  "compensation": {
    "base_salary_kes": "decimal",
    "allowance_kes": "decimal",
    "commission_rate": "decimal",
    "bonus_eligibility": "boolean"
  },
  
  "specialization": {
    "sectors_covered": "array[string]",
    "services_offered": "array[string]",
    "certifications": "array[string]",
    "languages": "array[string]"
  },
  
  "performance": {
    "clients_assigned": "array[string] (startup_ids)",
    "revenue_generated_ytd_kes": "decimal",
    "qa_projects_completed": "integer",
    "client_satisfaction_avg": "decimal (1-5)",
    "target_achievement_percentage": "decimal"
  },
  
  "metadata": {
    "created_at": "timestamp",
    "updated_at": "timestamp",
    "tags": "array[string]",
    "notes": "text"
  }
}
```

**File Naming Convention:**
- Format: `TEAM_{LASTNAME}_{ROLE}_{CATEGORY}_{DATE}.{ext}`
- Examples:
  - `TEAM_Kimani_BDLead_Performance_Q1-2026.xlsx`
  - `TEAM_Kimani_BDLead_Contract_2025-11-01.pdf`

---

### 1.9 Partner Entity
**Collection:** `partners`  
**File Prefix:** `PARTNER_`

```json
{
  "id": "string (UUID)",
  "partner_type": "enum (Legal Firm, Technology Partner, Investor Network, Service Provider, Strategic Partner)",
  
  "organization_info": {
    "name": "string",
    "legal_name": "string",
    "website": "string",
    "email": "string",
    "phone": "string",
    "address": "string",
    "country": "string"
  },
  
  "partnership_details": {
    "partnership_type": "enum (OW Advocates, IBM, IBM Research Centre, Power Learn Project, and Baraza Media Lab, Referral Partner, Service Provider)",
    "start_date": "date",
    "status": "enum (Active, Inactive, Prospective)",
    "agreement_signed": "boolean",
    "revenue_share_model": "text"
  },
  
  "ow_specific": {
    "is_ow_advocates": "boolean",
    "cases_referred": "integer",
    "dd_projects_completed": "integer",
    "total_legal_fees_kes": "decimal"
  },
  
  "ibm_specific": {
    "is_ibm_partner": "boolean",
    "partnership_level": "enum (None, Bronze, Silver, Gold)",
    "qa_projects_referred": "integer",
    "certification_status": "string",
    "tools_access": "array[string]"
  },
  
  "ibm_research_centre": {
    "is_partner": "boolean",
    "cohorts_managed": "array[string]",
    "startups_referred": "integer",
    "events_hosted": "integer"
  },
  
  "power_learn_project": {
    "is_partner": "boolean",
    "cohorts_managed": "array[string]",
    "startups_referred": "integer",
    "training_programs": "integer"
  },
  
  "baraza_media_lab": {
    "is_partner": "boolean",
    "cohorts_managed": "array[string]",
    "startups_referred": "integer",
    "media_campaigns": "integer"
  },
  
  "engagement_metrics": {
    "startups_referred": "integer",
    "deals_facilitated": "integer",
    "total_revenue_generated_kes": "decimal",
    "last_interaction_date": "date"
  },
  
  "metadata": {
    "created_at": "timestamp",
    "updated_at": "timestamp",
    "tags": "array[string]",
    "notes": "text"
  }
}
```

**File Naming Convention:**
- Format: `PARTNER_{PARTNER_NAME}_{CATEGORY}_{DATE}.{ext}`
- Examples:
  - `PARTNER_OWAdvocates_Agreement_2025-11-01.pdf`
  - `PARTNER_IBM_Certification_2025-12-15.pdf`
  - `PARTNER_IBMResearchCentre_MOU_2025-10-01.pdf`
  - `PARTNER_PowerLearnProject_Agreement_2025-10-01.pdf`
  - `PARTNER_BarazaMediaLab_Partnership_2025-10-01.pdf`

---

### 1.10 Communication Log Entity
**Collection:** `communications`  
**File Prefix:** `COMM_`

```json
{
  "id": "string (UUID)",
  "startup_id": "string (FK to Startup)",
  "contact_id": "string (FK to Contact)",
  
  "communication_details": {
    "type": "enum (Email, Call, Meeting, WhatsApp, SMS, Video Call, Event)",
    "direction": "enum (Inbound, Outbound)",
    "subject": "string",
    "summary": "text",
    "outcome": "string"
  },
  
  "participants": {
    "from_mc_studio": "array[string] (user_ids)",
    "from_startup": "array[string] (contact_ids)",
    "cc": "array[string]",
    "attendees": "array[string]"
  },
  
  "scheduling": {
    "scheduled_date": "timestamp",
    "actual_date": "timestamp",
    "duration_minutes": "integer",
    "location": "string"
  },
  
  "follow_up": {
    "action_items": "array[ActionItem]",
    "next_steps": "string",
    "follow_up_date": "date",
    "follow_up_completed": "boolean"
  },
  
  "categorization": {
    "purpose": "enum (Sales, Support, Consultation, Reporting, Update, Issue Resolution)",
    "tags": "array[string]",
    "priority": "enum (Low, Medium, High, Urgent)"
  },
  
  "attachments": {
    "files": "array[string] (document_ids)",
    "links": "array[string]"
  },
  
  "metadata": {
    "created_at": "timestamp",
    "created_by": "string (user_id)",
    "tags": "array[string]",
    "notes": "text"
  },
  
  "vector_embeddings": {
    "summary_vector": "array[float] (1536 dimensions)"
  }
}
```

**File Naming Convention:**
- Format: `COMM_{STARTUP_SLUG}_{TYPE}_{DATE}.{ext}`
- Examples:
  - `COMM_QuantumLeap_Meeting_2026-02-04.pdf`
  - `COMM_QuantumLeap_Email_2026-02-03.eml`

---

## 2. FILE NAMING CONVENTIONS

### 2.1 Standardized Prefix System

| Entity Type | Prefix | Example |
|------------|--------|---------|
| Startup Profile | `STARTUP_` | `STARTUP_QuantumLeap_Profile_2026-02-04.json` |
| Legal Health Check | `LHC_` | `LHC_QuantumLeap_2026-02-04_COMPLETED.pdf` |
| Service Engagement | `ENG_` | `ENG_QuantumLeap_GROW_Contract_2026-01-15.pdf` |
| QA Project | `QA_` | `QA_QuantumLeap_QA2026-001_TestReport_2026-02-03.pdf` |
| Investment Deal | `INV_` | `INV_QuantumLeap_SeriesA_TermSheet_2026-01-30.pdf` |
| Document | `DOC_` | `DOC_QuantumLeap_ShareholdersAgreement_v2.1_2026-01-15.pdf` |
| Contact | `CONTACT_` | `CONTACT_Smith_John_QuantumLeap_2026-02-04.vcf` |
| Team Member | `TEAM_` | `TEAM_Kimani_BDLead_Performance_Q1-2026.xlsx` |
| Partner | `PARTNER_` | `PARTNER_OWAdvocates_Agreement_2025-11-01.pdf` |
| Communication | `COMM_` | `COMM_QuantumLeap_Meeting_2026-02-04.pdf` |
| Invoice | `INV_` | `INV_QuantumLeap_INV2026-02-001_2026-02-01.pdf` |
| Report | `RPT_` | `RPT_Monthly_Revenue_2026-02.xlsx` |

### 2.2 Date Formatting Standards

- **Date Format:** `YYYY-MM-DD` (ISO 8601)
- **Month Only:** `YYYY-MM`
- **Quarter:** `Q#-YYYY` (e.g., `Q1-2026`)
- **Year:** `YYYY`

### 2.3 Version Control

- **Format:** `v{MAJOR}.{MINOR}`
- **Examples:**
  - `v1.0` - Initial version
  - `v1.1` - Minor revision
  - `v2.0` - Major revision
  - `v2.1_DRAFT` - Draft of minor revision

### 2.4 Status Indicators

- `_DRAFT` - Document in draft
- `_REVIEW` - Under review
- `_APPROVED` - Approved but not executed
- `_EXECUTED` - Fully executed
- `_FINAL` - Final version
- `_SUPERSEDED` - No longer active

### 2.5 Sector-Specific Tags

For sector-specific documents:
- `_FINTECH_` 
- `_HEALTHTECH_`
- `_EDTECH_`
- `_AGRITECH_`
- `_RETAIL_`
- `_ENERGY_`

**Example:** `DOC_QuantumLeap_DataProtectionPolicy_FINTECH_v1.0_2026-01-20.pdf`

---

## 3. VECTOR DATABASE SCHEMA

### 3.1 Collection Structure for Pinecone/Weaviate/Qdrant

```python
# Collection: startups_embeddings
{
  "id": "startup_uuid",
  "vector": [float × 1536],  # OpenAI ada-002 or equivalent
  "metadata": {
    "startup_id": "string",
    "company_name": "string",
    "slug": "string",
    "sector": "string",
    "stage": "string",
    "tier": "string",
    "health_score": "integer",
    "employee_count": "integer",
    "revenue_range": "string",
    "location": "string",
    "tags": ["tag1", "tag2"],
    "embedding_type": "business_description",
    "created_at": "timestamp",
    "updated_at": "timestamp"
  }
}

# Collection: documents_embeddings
{
  "id": "document_uuid",
  "vector": [float × 1536],
  "metadata": {
    "document_id": "string",
    "startup_id": "string",
    "startup_name": "string",
    "document_type": "string",
    "document_name": "string",
    "file_path": "string",
    "confidentiality": "string",
    "embedding_type": "document_content",
    "chunk_index": "integer",  # For chunked documents
    "total_chunks": "integer",
    "created_at": "timestamp",
    "updated_at": "timestamp"
  }
}

# Collection: communications_embeddings
{
  "id": "communication_uuid",
  "vector": [float × 1536],
  "metadata": {
    "communication_id": "string",
    "startup_id": "string",
    "startup_name": "string",
    "type": "string",
    "date": "timestamp",
    "participants": ["person1", "person2"],
    "embedding_type": "communication_summary",
    "created_at": "timestamp"
  }
}

# Collection: legal_health_checks_embeddings
{
  "id": "lhc_uuid",
  "vector": [float × 1536],
  "metadata": {
    "lhc_id": "string",
    "startup_id": "string",
    "startup_name": "string",
    "overall_score": "integer",
    "risk_level": "string",
    "assessment_date": "timestamp",
    "recommended_tier": "string",
    "embedding_type": "lhc_concerns",
    "created_at": "timestamp"
  }
}
```

### 3.2 Index Configuration

**Recommended Settings:**
- **Dimensions:** 1536 (OpenAI ada-002) or 3072 (OpenAI ada-003)
- **Metric:** Cosine similarity
- **Pods:** Start with 1, scale based on data size
- **Replicas:** 1 for dev, 2+ for production

### 3.3 Metadata Filters

Common filter patterns:
```python
# Find startups in Fintech sector with GROW tier
filter = {
  "sector": {"$eq": "Fintech"},
  "tier": {"$eq": "GROW"}
}

# Find high-risk startups needing attention
filter = {
  "risk_level": {"$eq": "High"},
  "health_score": {"$lt": 50}
}

# Find documents by type and date range
filter = {
  "document_type": {"$eq": "Shareholders Agreement"},
  "created_at": {"$gte": "2026-01-01", "$lte": "2026-02-04"}
}
```

### 3.4 Embedding Strategy

**Text to Embed:**
1. **Startups:**
   - Business description + sector + services needed
   - Problem statement + solution
   - Target market + customer profiles

2. **Documents:**
   - Full text content (chunked if >8000 tokens)
   - Summary + key clauses
   - Document metadata concatenated

3. **Communications:**
   - Subject + summary + outcome
   - Action items + next steps

4. **Legal Health Checks:**
   - Specific concerns + immediate needs
   - Critical gaps + quick wins
   - Additional info section

**Chunking Strategy for Long Documents:**
- **Chunk Size:** 1000 tokens
- **Overlap:** 200 tokens
- **Method:** Semantic chunking (respect paragraphs/sections)

---

## 4. RELATIONSHIP MAPPINGS

### 4.1 Entity Relationship Diagram

```
Startup (1) ─────── (M) LegalHealthCheck
   │
   ├────── (M) ServiceEngagement
   │          │
   │          └────── (M) Document
   │
   ├────── (M) QAProject
   │
   ├────── (M) InvestmentDeal
   │          │
   │          └────── (M) Investor
   │
   ├────── (M) Contact
   │          │
   │          └────── (1) Founder
   │
   ├────── (M) Communication
   │
   └────── (M) Document

TeamMember (1) ───── (M) Startup (assigned clients)
   │
   └────── (M) Communication

Partner (1) ─────── (M) Startup (referrals)
   │
   └────── (M) ServiceEngagement
```

### 4.2 Lookup Tables

**Sector to Compliance Requirements:**
```json
{
  "Fintech": {
    "regulatory_bodies": ["CBK", "KRA", "ODPC"],
    "key_licenses": ["Money Remittance License", "Payment Service Provider"],
    "compliance_focus": ["AML/CFT", "Data Protection", "Consumer Protection"]
  },
  "HealthTech": {
    "regulatory_bodies": ["PPB", "KMPDB", "ODPC"],
    "key_licenses": ["Pharmacy License", "Telemedicine License"],
    "compliance_focus": ["Patient Privacy", "Medical Data", "Professional Standards"]
  },
  "EdTech": {
    "regulatory_bodies": ["ODPC", "KRA"],
    "key_licenses": ["Education Provider License"],
    "compliance_focus": ["Child Protection", "Data Privacy", "Content Standards"]
  },
  "AgriTech": {
    "regulatory_bodies": ["KEPHIS", "PCPB", "ODPC"],
    "key_licenses": ["Agrochemical License", "Seed Certification"],
    "compliance_focus": ["Environmental Standards", "Product Safety"]
  },
  "Retail/Ecommerce": {
    "regulatory_bodies": ["ODPC", "KRA", "CAK"],
    "key_licenses": ["Business Permit", "VAT Registration"],
    "compliance_focus": ["Consumer Protection", "Data Privacy", "Tax Compliance"]
  },
  "Energy/Manufacturing": {
    "regulatory_bodies": ["EPRA", "NEMA", "ODPC"],
    "key_licenses": ["Energy License", "Environmental Impact Assessment"],
    "compliance_focus": ["Environmental Compliance", "Safety Standards"]
  }
}
```

**Tier to Services Mapping:**
```json
{
  "HUSTLE": {
    "monthly_fee_kes": 25000,
    "services_included": [
      "Company/LLP registration",
      "Founders' Agreement",
      "Simple employment contracts",
      "NDAs",
      "IP assignment basics",
      "KRA & Data Protection compliance",
      "3-hour monthly consultation"
    ],
    "typical_profile": {
      "employees": "1-10",
      "revenue_kes": "<5M",
      "stage": ["Idea", "Pre-Seed", "Seed"]
    }
  },
  "GROW": {
    "monthly_fee_kes": 50000,
    "services_included": [
      "Corporate governance",
      "Commercial contracts",
      "ESOP setup",
      "Regulatory compliance",
      "Quarterly strategy sessions",
      "Data Protection Impact Assessment",
      "Board secretarial support"
    ],
    "typical_profile": {
      "employees": "10-50",
      "revenue_kes": "20M-200M",
      "stage": ["Series A", "Series B"]
    }
  },
  "LEAD": {
    "monthly_fee_kes": 150000,
    "services_included": [
      "M&A advisory",
      "Regulatory representation",
      "Corporate restructuring",
      "Board governance audits",
      "Dedicated legal team",
      "Strategic opinions",
      "Unlimited consultations"
    ],
    "typical_profile": {
      "employees": "50+",
      "revenue_kes": "500M+",
      "stage": ["Series B+", "Growth", "PE-backed", "IPO-ready"]
    }
  }
}
```

---

## 5. METADATA STANDARDS

### 5.1 Timestamps
All timestamps must be in ISO 8601 format with timezone:
```
2026-02-04T14:30:00.000Z
```

### 5.2 Currency
All monetary values in Kenyan Shillings (KES) as decimal:
```json
{
  "monthly_retainer_kes": 25000.00,
  "total_invoiced_kes": 75000.00
}
```

### 5.3 Enumerations
Standard enums across all entities:

**Business Stage:**
- Idea
- Pre-Seed
- Seed
- Series A
- Series B
- Series C+
- Growth
- Mature

**Sector:**
- Fintech
- HealthTech
- EdTech
- AgriTech
- Retail/Ecommerce
- Energy/Manufacturing

**Risk Level:**
- Low
- Moderate
- High
- Critical

**Status (Generic):**
- Active
- Inactive
- Pending
- Completed
- Cancelled
- Archived

### 5.4 Tags
Tags should be:
- Lowercase
- Hyphen-separated
- Descriptive
- Consistent

Examples:
- `high-priority`
- `needs-follow-up`
- `hub_program-cohort-2`
- `fintech-regulatory`
- `esop-setup`

---

## 6. DATA COLLECTION TOUCHPOINTS

### 6.1 Website Forms

**Legal Health Check Form (`/legalhealthcheck/assess`):**
- Collects: 7-section questionnaire
- Creates: LegalHealthCheck entity
- Triggers: Email to startup, notification to BD team
- File Output: `LHC_{STARTUP_SLUG}_{DATE}_SUBMITTED.json`

**Startup Application (`/startups/apply`):**
- Collects: Company info, sector, stage, contact details
- Creates: Startup entity (status: Prospect) + Contact entity
- Triggers: Qualification workflow
- File Output: `STARTUP_{SLUG}_Application_2026-02-04.pdf`

**Partner Application (`/partners/become-partner`):**
- Collects: Organization info, partnership interest
- Creates: Partner entity (status: Prospective)
- Triggers: Partnership review process
- File Output: `PARTNER_{NAME}_Application_2026-02-04.pdf`

**Contact Form (`/contact`):**
- Collects: Name, email, inquiry
- Creates: Communication entity
- Triggers: Routing to appropriate team
- File Output: `COMM_Inquiry_2026-02-04.txt`

### 6.2 CRM Integration Points

**Data Flow:**
```
Website Form → API → Vector DB (embeddings) → PostgreSQL (structured) → CRM (Salesforce/HubSpot)
```

**Sync Schedule:**
- Real-time: Legal Health Checks, Applications
- Hourly: Communications, Documents
- Daily: Analytics, Reporting

### 6.3 Email Integration

**Email to Entity Mapping:**
```
inquiries@studiomoduschora.com → Communication (type: Inbound)
legal@studiomoduschora.com → Document + Communication
hello@studiomoduschora.com → Communication (Sales)
```

**Automated File Naming:**
- Incoming: `COMM_{SENDER_DOMAIN}_{SUBJECT_SLUG}_{DATE}.eml`
- Attachments: Extracted and renamed per document standards

---

## 7. IMPLEMENTATION GUIDELINES

### 7.1 Database Selection

**Primary Storage:** PostgreSQL 15+
- Relational integrity
- JSONB for flexible fields
- Full-text search
- Mature ecosystem

**Vector Storage:** Pinecone / Weaviate / Qdrant
- Semantic search
- Similarity matching
- Fast retrieval

**File Storage:** AWS S3 / Google Cloud Storage
- Versioning enabled
- Encryption at rest
- Access logging

**Cache Layer:** Redis
- Session management
- Real-time analytics
- Rate limiting

### 7.2 Data Pipeline

```
1. Data Ingestion
   ↓
2. Validation & Sanitization
   ↓
3. Embedding Generation (OpenAI API)
   ↓
4. Parallel Write:
   ├→ PostgreSQL (structured data)
   ├→ Vector DB (embeddings)
   └→ S3 (file storage)
   ↓
5. Trigger Events:
   ├→ Email notifications
   ├→ CRM sync
   ├→ Analytics update
   └→ Search index update
```

### 7.3 File Storage Structure

```
s3://mc-studio-files/
├── startups/
│   ├── {startup_slug}/
│   │   ├── profiles/
│   │   │   └── STARTUP_{slug}_Profile_{date}.json
│   │   ├── legal-health-checks/
│   │   │   └── LHC_{slug}_{date}_COMPLETED.pdf
│   │   ├── contracts/
│   │   │   ├── DOC_{slug}_ShareholdersAgreement_v1.0_{date}.pdf
│   │   │   └── DOC_{slug}_EmploymentContract_CEO_{date}.pdf
│   │   ├── qa-projects/
│   │   │   └── QA_{slug}_{project_code}_TestReport_{date}.pdf
│   │   ├── investments/
│   │   │   └── INV_{slug}_SeriesA_TermSheet_{date}.pdf
│   │   └── communications/
│   │       └── COMM_{slug}_Meeting_{date}.pdf
│
├── team/
│   └── TEAM_{lastname}_{role}_{category}_{date}.pdf
│
├── partners/
│   └── PARTNER_{name}_{category}_{date}.pdf
│
├── reports/
│   ├── monthly/
│   │   └── RPT_Monthly_Revenue_2026-02.xlsx
│   └── quarterly/
│       └── RPT_Quarterly_Performance_Q1-2026.pdf
│
└── templates/
    ├── DOC_TEMPLATE_ShareholdersAgreement_v3.0.docx
    └── DOC_TEMPLATE_EmploymentContract_v2.1.docx
```

### 7.4 Access Control

**Role-Based Access Control (RBAC):**

| Role | Startups | Documents | Financials | Admin |
|------|----------|-----------|------------|-------|
| BD Rep | Read/Write (assigned) | Read | Read (summary) | No |
| Trail Guide | Read (assigned) | Read/Write (assigned) | No | No |
| QA Analyst | Read (assigned) | Read (QA docs) | No | No |
| Partner (OW) | Read (assigned) | Read/Write (legal) | Read (invoices) | No |
| Operations Manager | Read (all) | Read (all) | Read (all) | Limited |
| Director | Read/Write (all) | Read/Write (all) | Read/Write (all) | Full |

**Document Classification Access:**
- **Public:** All staff
- **Internal:** Staff only
- **Confidential:** Assigned team + management
- **Highly Confidential:** Partner/Director only

### 7.5 Data Retention

**Retention Periods:**
- **Active Clients:** Indefinite (while engaged)
- **Churned Clients:** 7 years (legal requirement)
- **Prospects (not converted):** 3 years
- **Legal Documents:** 10 years minimum
- **Financial Records:** 7 years (KRA requirement)
- **Communication Logs:** 2 years
- **Analytics Data:** 5 years

**Archival Process:**
- Year 0-2: Hot storage (frequent access)
- Year 3-5: Warm storage (occasional access)
- Year 6+: Cold storage (archival)

### 7.6 Backup & Disaster Recovery

**Backup Schedule:**
- **PostgreSQL:** Daily full backup, hourly incremental
- **Vector DB:** Daily snapshot
- **S3 Files:** Versioning enabled, cross-region replication

**Recovery Time Objective (RTO):** 4 hours  
**Recovery Point Objective (RPO):** 1 hour

### 7.7 Data Quality Checks

**Automated Validation:**
- Email format validation
- Phone number format (Kenya: +254...)
- Date range checks (no future incorporation dates)
- Required field validation
- Duplicate detection (by email, phone, registration number)

**Data Cleaning Rules:**
- Normalize company names (remove "Ltd", "LLP", etc. for matching)
- Standardize phone numbers to E.164 format
- Convert all monetary values to KES
- Trim whitespace from all text fields

### 7.8 Privacy & GDPR/DPA Compliance

**Personal Data Handling:**
- Explicit consent for data collection
- Right to access (provide data export)
- Right to rectification (allow updates)
- Right to erasure (anonymize on request)
- Data portability (JSON/CSV export)

**Anonymization for Analytics:**
- Hash all PII in analytics databases
- Aggregate before sharing
- No individual-level data in reports

### 7.9 API Standards

**RESTful API Endpoints:**
```
POST   /api/v1/startups
GET    /api/v1/startups/{id}
PUT    /api/v1/startups/{id}
DELETE /api/v1/startups/{id}

POST   /api/v1/legal-health-checks
GET    /api/v1/legal-health-checks/{id}

POST   /api/v1/documents
GET    /api/v1/documents/{id}

GET    /api/v1/search?q={query}&sector={sector}&tier={tier}
```

**Authentication:** JWT tokens  
**Rate Limiting:** 100 requests/minute per API key  
**Versioning:** URL-based (`/api/v1/`)

### 7.10 Search & Retrieval

**Full-Text Search (PostgreSQL):**
```sql
SELECT * FROM startups
WHERE to_tsvector('english', company_name || ' ' || description) 
      @@ to_tsquery('fintech & payment');
```

**Semantic Search (Vector DB):**
```python
# Find similar startups by description
results = index.query(
    vector=embedding_of_query,
    filter={"sector": "Fintech", "tier": "GROW"},
    top_k=10,
    include_metadata=True
)
```

**Hybrid Search (Combine both):**
1. Full-text search for exact matches
2. Vector search for semantic similarity
3. Merge and re-rank results

---

## 8. SAMPLE QUERIES

### 8.1 Business Intelligence Queries

**Monthly Revenue by Tier:**
```sql
SELECT 
  legal_tier->>'current_tier' AS tier,
  COUNT(*) AS client_count,
  SUM((legal_tier->>'monthly_retainer_kes')::decimal) AS mrr
FROM startups
WHERE legal_tier->>'contract_status' = 'Active'
GROUP BY tier;
```

**High-Risk Startups Needing Attention:**
```sql
SELECT 
  company_name,
  (legal_health->>'overall_score')::int AS health_score,
  legal_health->>'risk_level' AS risk,
  legal_tier->>'current_tier' AS tier
FROM startups
WHERE 
  (legal_health->>'risk_level') IN ('High', 'Critical')
  AND legal_tier->>'contract_status' = 'Active'
ORDER BY (legal_health->>'overall_score')::int ASC;
```

**Conversion Rate from Legal Health Check:**
```sql
SELECT 
  COUNT(DISTINCT lhc.id) AS total_checks,
  COUNT(DISTINCT CASE WHEN s.legal_tier->>'current_tier' IS NOT NULL THEN lhc.id END) AS conversions,
  ROUND(
    100.0 * COUNT(DISTINCT CASE WHEN s.legal_tier->>'current_tier' IS NOT NULL THEN lhc.id END) / 
    NULLIF(COUNT(DISTINCT lhc.id), 0), 
    2
  ) AS conversion_rate_percentage
FROM legal_health_checks lhc
LEFT JOIN startups s ON lhc.startup_id = s.id
WHERE lhc.assessment_date >= '2026-01-01';
```

**QA Revenue by Analyst:**
```sql
SELECT 
  tm.first_name || ' ' || tm.last_name AS analyst_name,
  COUNT(qa.id) AS projects_completed,
  SUM((qa.financials->>'project_fee_kes')::decimal) AS total_revenue
FROM qa_projects qa
JOIN team_members tm ON qa.team_assignment->'qa_lead' ? tm.id::text
WHERE qa.status = 'Completed'
  AND qa.end_date >= '2026-01-01'
GROUP BY analyst_name
ORDER BY total_revenue DESC;
```

### 8.2 Vector Search Examples

**Find Startups Similar to a Given Startup:**
```python
# Get embedding for target startup
target_embedding = get_startup_embedding("QuantumLeap")

# Search for similar startups
similar = index.query(
    vector=target_embedding,
    filter={"sector": {"$eq": "Fintech"}},
    top_k=5,
    include_metadata=True
)

for match in similar.matches:
    print(f"{match.metadata['company_name']}: {match.score}")
```

**Semantic Search for Documents:**
```python
# User query: "Find all shareholder agreements with vesting clauses"
query_embedding = get_embedding("shareholder agreements vesting clauses")

results = index.query(
    namespace="documents",
    vector=query_embedding,
    filter={
        "document_type": {"$eq": "Shareholders Agreement"}
    },
    top_k=20,
    include_metadata=True
)
```

**Find Relevant Past Communications:**
```python
# Find communications related to "data protection compliance"
query_embedding = get_embedding("data protection compliance issues")

comms = index.query(
    namespace="communications",
    vector=query_embedding,
    filter={
        "type": {"$in": ["Meeting", "Call", "Email"]},
        "date": {"$gte": "2025-01-01"}
    },
    top_k=10,
    include_metadata=True
)
```

---

## 9. APPENDICES

### Appendix A: Sector-Specific Compliance Checklists

*[Detailed checklists for each of the 6 sectors covered by hub partners would go here]*

### Appendix B: Document Templates

*[List of standard document templates with file naming]*

### Appendix C: Regulatory Body Contact Information

*[Directory of regulatory bodies relevant to each sector]*

### Appendix D: Glossary of Terms

**MRR:** Monthly Recurring Revenue  
**LTV:** Lifetime Value  
**CAC:** Client Acquisition Cost  
**ESOP:** Employee Share Ownership Plan  
**DPIA:** Data Protection Impact Assessment  
**ODPC:** Office of the Data Protection Commissioner  
**KRA:** Kenya Revenue Authority  
**CBK:** Central Bank of Kenya  
**CAK:** Communications Authority of Kenya  
**EPRA:** Energy and Petroleum Regulatory Authority

---

**END OF SCHEMA DOCUMENT**

*This schema is a living document and should be updated as MC Studio's operations evolve.*
