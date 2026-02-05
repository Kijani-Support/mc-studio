# MC Studio Website to Database Schema Mapping

**Version:** 1.0  
**Date:** February 5, 2026  
**Purpose:** Map website screens to database entities and operations

---

## SCREEN-TO-ENTITY MAPPING

### 1. HOME PAGE
**URL:** `/`  
**Navigation:** Platform Navigation

**Database Interactions:**
- **Reads:** `startups` (featured startups portfolio)
- **Reads:** `partners` (partner logo carousel)
- **Reads:** `articles/media` (latest reports section)

**Key Features:**
- Display 4 featured startup logos (CloudForge, BrightSpark, NexusHub, RocketReach)
- Show partner logos in carousel
- Interactive world map with project markers
- Newsletter signup form

---

### 2. STARTUPS DIRECTORY
**URL:** `/startups`  
**Navigation:** Platform Navigation

**Database Interactions:**
- **Reads:** `startups` (filtered and paginated)
- **Filters:** sector, stage, search query
- **Pagination:** 8 startups per page

**SQL Query Example:**
```sql
SELECT * FROM startups 
WHERE status = 'active' 
  AND sector = :selected_sector
  AND stage = :selected_stage
  AND company_name ILIKE :search_query
ORDER BY created_at DESC
LIMIT 8 OFFSET :page_offset;
```

---

### 3. STARTUP PROFILE
**URL:** `/startups/:slug`  
**Navigation:** Platform Navigation

**Database Interactions:**
- **Reads:** `startups` (single record by slug)
- **Reads:** `service_engagements` (services utilized)
- **Reads:** `partners` (valued partners)
- **Reads:** Case studies (if any)

**Data Displayed:**
- Company name, tagline, description
- Key metrics (funding raised, employees, revenue growth, countries)
- Services utilized cards
- Case studies
- Partner logos (IBM, Power Learn Project, OW Advocates, etc.)

---

### 4. LEGAL HEALTH CHECK - LANDING
**URL:** `/legalhealthcheck`  
**Navigation:** Legal/Partners Navigation

**Database Interactions:**
- No direct database interaction
- Static informational content

**Purpose:**
- Explain Legal Health Check process
- Show 4-step process
- Display benefits (Health Score, Risk Analysis, Priority Actions, Tier Recommendation)
- CTA: "Start Your Free Assessment Now"

---

### 5. LEGAL HEALTH CHECK - ASSESSMENT
**URL:** `/legalhealthcheck/assess`  
**Navigation:** Legal/Partners Navigation

**Database Interactions:**
- **Creates:** `legal_health_checks` (progressive save)
- **Updates:** `legal_health_checks` (as user progresses)
- **Creates/Updates:** `startups` (if new company)

**7-Step Form Structure:**
1. Company Information
2. Corporate Structure (9 questions)
3. Employment & HR (7 questions)
4. Data Protection (8 questions)
5. Intellectual Property (14 questions)
6. Tax & Compliance
7. Review & Submit

**Save Logic:**
```javascript
// Progressive save on each section completion
onSectionComplete(sectionNumber, data) {
  await api.put(`/legal-health-checks/${lhcId}`, {
    [`section_${sectionNumber}`]: data,
    completion_percentage: calculatePercentage(sectionNumber)
  });
}
```

---

### 6. LEGAL HEALTH CHECK - RESULTS
**URL:** `/legalhealthcheck/results/:id`  
**Navigation:** Legal/Partners Navigation

**Database Interactions:**
- **Reads:** `legal_health_checks` (by ID)
- **Reads:** `startups` (associated startup)
- **Displays:** Overall score, category breakdown, recommendations

**Data Displayed:**
- Overall Score (0-100)
- Risk Level badge (Low/Moderate/High/Critical)
- 6 Category Cards with scores:
  - Corporate Structure
  - Employment & HR
  - Data Protection
  - Intellectual Property
  - Contracts & Agreements
  - Regulatory Compliance
- Priority Actions for Improvement
- Recommended Tier (HUSTLE/GROW/LEAD)
- CTA: "Book Consultation"

**Scoring Algorithm:**
```javascript
calculateOverallScore(lhc) {
  const weights = {
    corporate_structure: 0.20,
    employment_hr: 0.15,
    data_protection: 0.20,
    intellectual_property: 0.15,
    contracts_agreements: 0.15,
    regulatory_compliance: 0.15
  };
  
  return Object.entries(weights).reduce((total, [key, weight]) => {
    return total + (lhc.category_scores[key] * weight);
  }, 0);
}
```

---

### 7. AIKYA HUSTLE PLAN (PRICING)
**URL:** `/services/aikya/hustle`  
**Navigation:** Legal/Partners Navigation

**Database Interactions:**
- **Creates:** `service_engagements` (on subscribe)
- **Updates:** `startups.legal_tier`

**3 Pricing Tiers:**
1. **Aikya Hustle** - KSh 25,000/month
2. **Growth Tier** - KSh 50,000/month (Recommended)
3. **Lead Enterprise Tier** - KSh 150,000/month

**Subscription Flow:**
```javascript
async createSubscription(startupId, tier) {
  // 1. Create service engagement
  const engagement = await ServiceEngagement.create({
    startup_id: startupId,
    tier: tier, // 'HUSTLE', 'GROW', 'LEAD'
    monthly_fee_kes: getTierFee(tier),
    contract_status: 'active',
    start_date: new Date(),
    contract_months: 3, // minimum
    payment_method: 'M-Pesa'
  });
  
  // 2. Update startup tier
  await Startup.update(startupId, {
    legal_tier: {
      current_tier: tier,
      monthly_retainer_kes: getTierFee(tier),
      contract_status: 'Active'
    }
  });
  
  return engagement;
}
```

---

### 8. PRIVATE DASHBOARD
**URL:** `/legalhealthcheck/dashboard`  
**Navigation:** Legal/Partners Navigation (Authenticated)

**Database Interactions:**
- **Reads:** `startups` (current user's startup)
- **Reads:** `legal_health_checks` (historical assessments)
- **Reads:** `documents` (document vault)
- **Reads:** `service_engagements` (subscription status)

**Dashboard Sections:**

#### Current Legal Health Score
```sql
SELECT overall_score, last_assessment_date, risk_level
FROM startups
WHERE id = :startup_id;
```

#### Historical Assessments (Chart)
```sql
SELECT assessment_date, overall_score
FROM legal_health_checks
WHERE startup_id = :startup_id
  AND completed = true
ORDER BY assessment_date ASC;
```

#### Action Item Checklist
```sql
SELECT priority_actions
FROM legal_health_checks
WHERE startup_id = :startup_id
  AND id = (SELECT current_health_check_id FROM startups WHERE id = :startup_id);
```

#### Document Vault
```sql
SELECT document_name, file_path, execution_date, expiration_date
FROM documents
WHERE startup_id = :startup_id
  AND status = 'executed'
ORDER BY execution_date DESC;
```

#### Progress Tracking
Shows milestones from startup journey

---

### 9. PARTNER ECOSYSTEM
**URL:** `/partners`  
**Navigation:** Legal/Partners Navigation

**Database Interactions:**
- **Reads:** `partners` (all active partners)

**Featured Partners:**
- OW Advocates (Legal Services)
- IBM Business Partner (Technology)
- JHUB (Startup Hub)
- Power Learn Project (Training)
- JuaFlow by Pfinder (Solutions)
- Watu Wa Gaming (Gaming)

**Partner Categories:**
- Legal Services
- Technology Providers
- Consulting & Advisory
- Startup Ecosystem
- Cybersecurity & Data
- Integrations

---

### 10. OW ADVOCATES PROFILE
**URL:** `/partners/ow-advocates`  
**Navigation:** Legal/Partners Navigation

**Database Interactions:**
- **Reads:** `partners` (OW Advocates record)
- **Reads:** `service_engagements` (legal services provided)
- **Reads:** Case studies

**Legal Services Displayed:**
- Corporate Law & Governance
- Litigation & Dispute Resolution
- Employment & Labor Law

**Aikya Legal Framework:**
- Proactive Risk Assessment
- Customized Legal Roadmaps
- Seamless Compliance Integration

---

### 11. IBM PARTNERSHIP OVERVIEW
**URL:** `/partners/ibm`  
**Navigation:** Legal/Partners Navigation

**Database Interactions:**
- **Reads:** `partners` (IBM record)
- **Reads:** `qa_projects` (QA metrics)

**Displayed:**
- IBM partnership benefits
- QA & Analytics capabilities
- IBM badges
- Service offerings

---

### 12. IBM SERVICES OVERVIEW
**URL:** `/partners/ibm/services`  
**Navigation:** Legal/Partners Navigation

**Database Interactions:**
- **Reads:** `partners.ibm_specific` data
- **Displays:** IBM service catalog

**IBM Service Offerings:**
- Cloud Solutions
- AI & Machine Learning
- Security Services
- Automation & Integration
- Industry Solutions
- Licensing & Compliance
- Implementation & Support
- Data & Analytics

---

### 13. BECOME A PARTNER
**URL:** `/partners/become-partner`  
**Navigation:** Legal/Partners Navigation

**Database Interactions:**
- **Creates:** `partners` (status: prospective)
- **Creates:** `communications` (partner inquiry)

**Form Sections:**
1. Company Information
2. Contact Person Details
3. Partnership Interests (checkboxes)
4. Additional Information (textarea)

**Create Partner Logic:**
```javascript
async submitPartnerApplication(data) {
  // 1. Create partner record
  const partner = await Partner.create({
    name: data.company_name,
    partner_type: determineType(data.partnership_interests),
    status: 'prospective',
    organization_info: {
      website: data.website,
      industry: data.industry,
      size: data.company_size
    }
  });
  
  // 2. Create contact
  await Contact.create({
    first_name: data.contact_first_name,
    last_name: data.contact_last_name,
    email: data.contact_email,
    phone: data.contact_phone,
    person_type: 'Partner'
  });
  
  // 3. Log communication
  await Communication.create({
    type: 'Inbound',
    direction: 'inbound',
    subject: 'Partner Application',
    summary: data.additional_info,
    purpose: 'partnership'
  });
}
```

---

### 14. PROJECTS MAP
**URL:** `/projects`  
**Navigation:** Platform Navigation

**Database Interactions:**
- **Reads:** `startups` (with location data)
- **Reads:** `partners` (partner involvement)

**Filtered Results Display:**
- Project name
- Partners involved
- Region
- Case study tags

**Map Markers:**
- Location pins based on `startups.contact_info.physical_address`
- Color-coded by region or partner

---

### 15. CASE STUDIES
**URL:** `/casestudies`  
**Navigation:** Platform Navigation

**Database Interactions:**
- **Reads:** Custom case studies table OR
- **Reads:** `startups` + `service_engagements` (to generate case studies)

**Featured Case Study (Klinik):**
- +30% Patient Satisfaction
- +20% Operational Efficiency
- +15% Market Reach

**Category Filters:**
- Technology, Healthcare, Finance, Education, Automotive, Energy

---

### 16. SERVICES PAGE
**URL:** `/services`  
**Navigation:** Platform Navigation

**Database Interactions:**
- None (static content)
- Links to external Kijani.co pricing

**Core Competencies:**
- Strategic Consultation
- User Experience Design
- Full-Stack Development
- Digital Transformation

**Kijani.co Plans:**
- Basic Support: $99/month
- Premium Partnership: $299/month
- Enterprise Solutions: Custom Quote

---

### 17. ARTICLE DETAIL
**URL:** `/media/:slug`  
**Navigation:** Platform Navigation (Dark Theme)

**Database Interactions:**
- **Reads:** Articles/blog posts
- **Increments:** View count
- **Related:** Recent articles sidebar

**Content Structure:**
- Hero image
- Article title
- Author name and date
- Article body (rich text)
- Recent articles sidebar
- Newsletter signup

---

## DATA FLOW DIAGRAMS

### Legal Health Check Workflow

```
User visits /legalhealthcheck
    ↓
Clicks "Start Assessment"
    ↓
/legalhealthcheck/assess
    ↓
[Section 1] Company Info → CREATE startup (if new)
    ↓
[Sections 2-6] Progressive save → UPDATE legal_health_check
    ↓
[Section 7] Review & Submit → Mark completed=true
    ↓
Calculate scores → UPDATE startup.overall_health_score
    ↓
Redirect to /legalhealthcheck/results/:id
    ↓
Display score, recommendations, suggested tier
    ↓
User clicks "Book Consultation" → CREATE communication
```

### Subscription Workflow

```
User on /services/aikya/hustle
    ↓
Reviews tier options
    ↓
Clicks "Subscribe Now" on chosen tier
    ↓
CREATE service_engagement
    ↓
UPDATE startup.legal_tier
    ↓
Send welcome email → Log in communications
    ↓
Assign trail guide → UPDATE startup.assigned_trail_guide_id
    ↓
User gets access to /legalhealthcheck/dashboard
```

---

## KEY QUERIES BY SCREEN

### Startups Directory (with filters)
```sql
-- Count for pagination
SELECT COUNT(*) FROM startups 
WHERE status = 'active'
  AND sector = ANY(:sectors)
  AND stage = ANY(:stages);

-- Get paginated results
SELECT id, slug, company_name, sector, stage, 
       industry_tags, employee_count,
       (SELECT COUNT(*) FROM service_engagements 
        WHERE startup_id = startups.id) as services_count
FROM startups
WHERE status = 'active'
  AND sector = ANY(:sectors)
  AND stage = ANY(:stages)
  AND company_name ILIKE :search
ORDER BY created_at DESC
LIMIT 8 OFFSET :offset;
```

### Dashboard Health Score Chart
```sql
SELECT 
  DATE_TRUNC('month', assessment_date) as month,
  AVG(overall_score) as avg_score
FROM legal_health_checks
WHERE startup_id = :startup_id
  AND completed = true
  AND assessment_date >= NOW() - INTERVAL '6 months'
GROUP BY month
ORDER BY month ASC;
```

### Partner Projects Count
```sql
SELECT 
  p.name as partner_name,
  COUNT(DISTINCT s.id) as startups_referred,
  COUNT(DISTINCT qa.id) as qa_projects
FROM partners p
LEFT JOIN startups s ON s.acquisition_source = p.name
LEFT JOIN qa_projects qa ON qa.startup_id = s.id
WHERE p.status = 'active'
GROUP BY p.id, p.name;
```

---

## REAL-TIME UPDATES

### Dashboard Score Update (WebSocket)
```javascript
// Server-side event on LHC completion
socket.emit('health-score-updated', {
  startup_id: startup.id,
  new_score: lhc.overall_score,
  risk_level: calculateRiskLevel(lhc.overall_score)
});

// Client-side listener
socket.on('health-score-updated', (data) => {
  updateDashboardScore(data.new_score);
  updateRiskBadge(data.risk_level);
});
```

---

## CACHING STRATEGY

**Redis Cache Keys:**
```
startups:directory:{sector}:{stage}:{page} → TTL: 5 minutes
startup:profile:{slug} → TTL: 10 minutes
partners:all → TTL: 1 hour
lhc:results:{id} → TTL: 1 day
dashboard:score:{startup_id} → TTL: 1 hour
```

---

## API ENDPOINTS SUMMARY

| Screen | Endpoint | Method | Entity |
|--------|----------|--------|--------|
| Startups Directory | `/api/startups` | GET | startups |
| Startup Profile | `/api/startups/:slug` | GET | startups |
| Start LHC | `/api/legal-health-checks` | POST | legal_health_checks |
| Save LHC Progress | `/api/legal-health-checks/:id` | PUT | legal_health_checks |
| Get LHC Results | `/api/legal-health-checks/:id` | GET | legal_health_checks |
| Subscribe to Tier | `/api/service-engagements` | POST | service_engagements |
| Get Dashboard | `/api/dashboard` | GET | Multiple |
| Partner Application | `/api/partners` | POST | partners |
| Get Partners | `/api/partners` | GET | partners |

---

**End of Mapping Document**
