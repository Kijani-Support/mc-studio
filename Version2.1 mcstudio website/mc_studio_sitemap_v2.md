# MC Studio x OW Advocates
## Website Sitemap & Information Architecture
### Version 2.0 | January 2026

---

## EXECUTIVE SUMMARY

This sitemap proposes a comprehensive platform architecture for **studiomoduschora.com** that:
1. **Collects startup health data** via Legal Health Checks, QA assessments, and compliance tracking
2. **Labels and scores startups** using multi-dimensional health metrics
3. **Showcases the ecosystem** including startups, partners, products, and success stories
4. **Promotes IBM authorized services and resale** through dedicated product pages

---

## PRIMARY NAVIGATION STRUCTURE

```
studiomoduschora.com
│
├── 🏠 HOME (/)
├── 🚀 STARTUPS (/startups)
├── 📊 HEALTH CHECK (/legalhealthcheck)
├── 🤝 PARTNERS (/partners)
├── 💼 SERVICES (/services)
├── 🔷 IBM PRODUCTS (/ibm-products)
├── 📁 PROJECTS (/projects)
├── 📰 MEDIA (/media)
└── 👥 CAREERS (/jobplacements)
```

---

## 1. HOME PAGE (/)

### Purpose
Primary landing page showcasing MC Studio's value proposition and ecosystem overview

### Content Sections
```
/
├── Hero Section
│   ├── Tagline: "Law in Harmony with Growth"
│   ├── CTA: "Get Your Legal Health Score"
│   └── Partner badges (OW Advocates, IBM Business Partner)
│
├── Startup Showcase Carousel
│   └── Featured portfolio startups by sector
│
├── Health Score Snapshot
│   ├── Aggregate ecosystem health metrics
│   └── CTA: "Check Your Startup's Health"
│
├── Sector Overview
│   ├── FinTech │ HealthTech │ EdTech
│   └── AgriTech │ Retail │ Energy
│
├── IBM Partner Highlight
│   ├── Authorized IBM Business Partner badge
│   ├── Featured IBM solutions
│   └── CTA: "Explore IBM Products"
│
├── Partnership Benefits
│   └── Why join MC Studio ecosystem
│
├── Latest Updates
│   ├── Recent case studies
│   ├── News/Media mentions
│   └── Upcoming events
│
└── Footer
    ├── Quick links
    ├── Contact information
    └── Social media
```

---

## 2. STARTUPS SECTION (/startups)

### Purpose
Showcase portfolio startups with health labels and searchable directory

### Page Structure
```
/startups
├── /startups (Directory Landing)
│   ├── Search & Filter Bar
│   │   ├── By Sector (FTX, HTX, ETX, ATX, REC, ENM)
│   │   ├── By Tier (Hustle, Grow, Lead)
│   │   ├── By Health Score (Excellent, Good, Developing)
│   │   └── By Investment Stage (Pre-seed, Seed, Series A+)
│   │
│   ├── Startup Grid/Cards
│   │   └── Each card shows:
│   │       ├── Logo & Name
│   │       ├── Sector badge
│   │       ├── Health Score indicator (🟢🟡🔴)
│   │       ├── Tier badge
│   │       └── Brief description
│   │
│   └── Ecosystem Stats
│       ├── Total startups
│       ├── Average health score
│       ├── Investment raised
│       └── Jobs created
│
├── /startups/:slug (Individual Profile)
│   ├── Header
│   │   ├── Logo, Name, Tagline
│   │   ├── Sector & Tier badges
│   │   └── Website/Contact links
│   │
│   ├── Health Dashboard (Public View)
│   │   ├── Overall Health Score (0-100%)
│   │   ├── Category Breakdown
│   │   │   ├── Legal Compliance
│   │   │   ├── IP Protection
│   │   │   ├── Data Protection
│   │   │   ├── Corporate Governance
│   │   │   └── Tax Compliance
│   │   └── Last Assessment Date
│   │
│   ├── Company Overview
│   │   ├── Mission & Vision
│   │   ├── Problem/Solution
│   │   ├── Target Market
│   │   └── Business Model
│   │
│   ├── Milestones & Achievements
│   │   └── Timeline of key events
│   │
│   ├── Team (Optional)
│   │   └── Founders & Key Members
│   │
│   ├── Investment Profile (if applicable)
│   │   ├── Current round
│   │   ├── Seeking amount
│   │   └── "Request Intro" CTA
│   │
│   └── Related Case Studies
│
├── /startups/apply
│   └── Application form to join ecosystem
│
└── /startups/success-stories
    └── Redirect to /casestudies
```

### Startup Health Labels (Computed from Assessment Data)
| Score Range | Label | Badge |
|-------------|-------|-------|
| 85-100% | Investor Ready | 🟢 Excellent |
| 70-84% | Growth Ready | 🟡 Good |
| 50-69% | Developing | 🟠 Developing |
| 0-49% | Foundation Stage | 🔴 Needs Attention |

---

## 3. HEALTH CHECK SECTION (/legalhealthcheck)

### Purpose
Primary data collection tool for assessing and labeling startup health

### Page Structure
```
/legalhealthcheck
├── /legalhealthcheck (Landing)
│   ├── What is a Legal Health Check?
│   │   └── Explanation + benefits
│   ├── The Assessment Process
│   │   └── Step-by-step visual
│   ├── What You'll Get
│   │   ├── Health Score
│   │   ├── Risk Assessment
│   │   ├── Priority Actions
│   │   └── Tier Recommendation
│   └── CTA: "Start Your Free Assessment"
│
├── /legalhealthcheck/assess
│   └── Legal Health Onboarding Form
│       ├── Step 1: Company Information
│       │   ├── Company name
│       │   ├── Contact details
│       │   ├── Sector selection
│       │   └── Employee count & revenue
│       │
│       ├── Step 2: Corporate Structure
│       │   ├── Registration status
│       │   ├── Shareholders agreement
│       │   └── Board/governance
│       │
│       ├── Step 3: Employment & HR
│       │   ├── Employment contracts
│       │   ├── Policies in place
│       │   └── ESOP status
│       │
│       ├── Step 4: Data Protection
│       │   ├── ODPC registration
│       │   ├── Privacy policy
│       │   └── DPIA status
│       │
│       ├── Step 5: Intellectual Property
│       │   ├── Trademark registration
│       │   ├── IP assignments
│       │   └── NDAs in place
│       │
│       ├── Step 6: Tax & Compliance
│       │   ├── KRA compliance
│       │   ├── Sector licenses
│       │   └── Regulatory status
│       │
│       └── Step 7: Review & Submit
│
├── /legalhealthcheck/results/:id
│   └── Personalized Results Page
│       ├── Health Score Display
│       ├── Risk Level Badge
│       ├── Category-by-Category Analysis
│       ├── Priority Actions List
│       ├── Recommended Aikya Tier
│       ├── Download PDF Report
│       └── CTA: "Book Consultation"
│
├── /legalhealthcheck/dashboard (Authenticated)
│   └── Startup's Private Dashboard
│       ├── Current health score
│       ├── Historical assessments
│       ├── Progress tracking
│       ├── Action item checklist
│       └── Document vault
│
└── /legalhealthcheck/faq
    └── Common questions about assessment
```

---

## 4. PARTNERS SECTION (/partners)

### Purpose
Showcase strategic partners and collaboration opportunities

### Page Structure
```
/partners
├── /partners (Landing)
│   ├── Our Partner Ecosystem
│   │   └── Visual partner map
│   │
│   ├── Featured Partners
│   │   ├── OW Advocates (Legal Partner)
│   │   ├── IBM Business Partner
│   │   └── Other strategic partners
│   │
│   └── Become a Partner CTA
│
├── /partners/okutta-wairi (or /partners/ow)
│   └── OW Advocates Partnership Page
│       ├── About OW Advocates
│       ├── Legal services offered
│       ├── Aikya Legal framework
│       └── Contact/Booking
│
├── /partners/ibmbp (IBM Business Partner)
│   └── IBM Partnership Overview
│       ├── IBM Business Partner status
│       ├── Partnership benefits
│       ├── CTA: "View IBM Products" → /ibm-products
│       └── QA Dashboard preview
│
├── /partners/investors
│   └── For Investors
│       ├── Investment opportunities
│       ├── Portfolio overview
│       ├── Due diligence support
│       ├── Finder fee structure (5%)
│       └── Request portfolio access
│
└── /partners/become-partner
    └── Partnership application form
```

---

## 5. SERVICES SECTION (/services)

### Purpose
Detail service offerings across legal, QA, and advisory services

### Page Structure
```
/services
├── /services (Landing)
│   ├── Service Categories Overview
│   │   ├── Legal Services (Aikya Legal)
│   │   ├── QA & Compliance
│   │   ├── IBM Technology Solutions
│   │   ├── Advisory & Consulting
│   │   └── Investment Support
│   │
│   └── "Find Your Tier" CTA → /legalhealthcheck
│
├── /services/legal
│   └── Aikya Legal Services
│       ├── Overview
│       │
│       ├── /services/legal/hustle
│       │   └── AIKYA HUSTLE - Founder Tier
│       │       ├── KSh 25,000/month
│       │       ├── Deliverables list
│       │       ├── Ideal for (criteria)
│       │       └── Sign up CTA
│       │
│       ├── /services/legal/grow
│       │   └── AIKYA GROW - Scale Tier
│       │       ├── KSh 50,000/month
│       │       ├── Deliverables list
│       │       ├── Ideal for (criteria)
│       │       └── Sign up CTA
│       │
│       ├── /services/legal/lead
│       │   └── AIKYA LEAD - Market Leader
│       │       ├── KSh 150,000/month
│       │       ├── Deliverables list
│       │       ├── Ideal for (criteria)
│       │       └── Sign up CTA
│       │
│       └── /services/legal/compare
│           └── Side-by-side tier comparison
│
├── /services/qa
│   └── QA & Compliance Services
│       ├── IBM Standards Compliance
│       ├── Code Quality Assurance
│       ├── Security Audits
│       ├── Documentation Review
│       └── Sector-specific compliance
│
├── /services/advisory
│   └── Strategic Advisory
│       ├── Fundraising support
│       ├── Due diligence prep
│       ├── M&A advisory
│       └── Regional expansion (EMEA)
│
├── /services/sectors
│   └── Sector-Specific Services
│       ├── /services/sectors/fintech
│       ├── /services/sectors/healthtech
│       ├── /services/sectors/edtech
│       ├── /services/sectors/agritech
│       ├── /services/sectors/retail
│       └── /services/sectors/energy
│
└── /services/pricing
    └── Complete pricing overview
```

---

## 6. IBM PRODUCTS SECTION (/ibm-products) - NEW

### Purpose
Showcase authorized IBM products and services available for resale and implementation

### Page Structure
```
/ibm-products
├── /ibm-products (Landing Page)
│   ├── Hero Section
│   │   ├── "Authorized IBM Business Partner"
│   │   ├── IBM Partner badge/certification
│   │   └── Value proposition
│   │
│   ├── Product Categories Grid
│   │   ├── Cloud & Infrastructure
│   │   ├── AI & Data Analytics
│   │   ├── Security Solutions
│   │   ├── Automation & Integration
│   │   └── Industry Solutions
│   │
│   ├── Why Choose MC Studio for IBM
│   │   ├── Authorized reseller benefits
│   │   ├── Local implementation support
│   │   ├── Integration with legal compliance
│   │   └── Startup-friendly pricing
│   │
│   └── CTA: "Request IBM Consultation"
│
├── /ibm-products/cloud
│   └── IBM Cloud Solutions
│       ├── IBM Cloud Platform
│       │   ├── Features & benefits
│       │   ├── Pricing tiers
│       │   └── Request quote
│       │
│       ├── IBM Cloud Pak Solutions
│       │   ├── Cloud Pak for Data
│       │   ├── Cloud Pak for Business Automation
│       │   ├── Cloud Pak for Integration
│       │   └── Cloud Pak for Security
│       │
│       ├── Red Hat OpenShift
│       │   ├── Container platform
│       │   ├── Kubernetes management
│       │   └── Hybrid cloud deployment
│       │
│       └── Cloud Migration Services
│           ├── Assessment
│           ├── Migration planning
│           └── Implementation support
│
├── /ibm-products/ai
│   └── AI & Data Solutions
│       ├── IBM watsonx
│       │   ├── watsonx.ai (AI Studio)
│       │   ├── watsonx.data (Data Lakehouse)
│       │   ├── watsonx.governance (AI Governance)
│       │   └── Enterprise AI use cases
│       │
│       ├── IBM Watson Services
│       │   ├── Watson Assistant (Chatbots)
│       │   ├── Watson Discovery (Search & Analytics)
│       │   ├── Watson Natural Language
│       │   └── Watson Speech to Text / Text to Speech
│       │
│       ├── IBM Cognos Analytics
│       │   ├── Business intelligence
│       │   ├── Reporting & dashboards
│       │   └── Self-service analytics
│       │
│       └── IBM SPSS Statistics
│           ├── Statistical analysis
│           ├── Predictive analytics
│           └── Data mining
│
├── /ibm-products/security
│   └── Security Solutions
│       ├── IBM Security QRadar
│       │   ├── SIEM platform
│       │   ├── Threat detection
│       │   └── Incident response
│       │
│       ├── IBM Guardium
│       │   ├── Data protection
│       │   ├── Database security
│       │   └── Compliance monitoring
│       │
│       ├── IBM Verify
│       │   ├── Identity & access management
│       │   ├── Single sign-on (SSO)
│       │   └── Multi-factor authentication
│       │
│       └── IBM Security Services
│           ├── Security assessments
│           ├── Penetration testing
│           └── Managed security services
│
├── /ibm-products/automation
│   └── Automation & Integration
│       ├── IBM Robotic Process Automation (RPA)
│       │   ├── Process automation
│       │   ├── Bot deployment
│       │   └── Workflow optimization
│       │
│       ├── IBM App Connect
│       │   ├── API management
│       │   ├── Integration platform
│       │   └── Hybrid integration
│       │
│       ├── IBM Business Automation Workflow
│       │   ├── Process orchestration
│       │   ├── Case management
│       │   └── Decision automation
│       │
│       └── IBM MQ
│           ├── Messaging middleware
│           ├── Enterprise messaging
│           └── Hybrid cloud messaging
│
├── /ibm-products/industry
│   └── Industry-Specific Solutions
│       ├── Financial Services
│       │   ├── IBM Financial Crimes Insight
│       │   ├── Regulatory compliance tools
│       │   └── Risk management
│       │
│       ├── Healthcare
│       │   ├── IBM Health Insights
│       │   ├── Clinical data management
│       │   └── Healthcare analytics
│       │
│       ├── Retail & Commerce
│       │   ├── IBM Sterling Order Management
│       │   ├── Supply chain solutions
│       │   └── Commerce platforms
│       │
│       └── Manufacturing & IoT
│           ├── IBM Maximo (Asset Management)
│           ├── IoT Platform
│           └── Predictive maintenance
│
├── /ibm-products/licensing
│   └── Software Licensing
│       ├── Licensing Models
│       │   ├── Subscription licensing
│       │   ├── Perpetual licenses
│       │   ├── Usage-based pricing
│       │   └── Enterprise agreements
│       │
│       ├── Volume Licensing
│       │   ├── SMB packages
│       │   ├── Enterprise packages
│       │   └── Startup programs
│       │
│       └── License Management Services
│           ├── License optimization
│           ├── Compliance audits
│           └── Renewal management
│
├── /ibm-products/services
│   └── Implementation & Support Services
│       ├── Consulting Services
│       │   ├── Solution architecture
│       │   ├── Technical consulting
│       │   └── Business process consulting
│       │
│       ├── Implementation Services
│       │   ├── Deployment & configuration
│       │   ├── Data migration
│       │   ├── Integration services
│       │   └── Custom development
│       │
│       ├── Training & Enablement
│       │   ├── Product training
│       │   ├── Certification programs
│       │   └── Workshop facilitation
│       │
│       └── Managed Services
│           ├── Infrastructure management
│           ├── Application support
│           └── 24/7 monitoring
│
├── /ibm-products/startup-program
│   └── IBM for Startups
│       ├── Program Overview
│       │   ├── Eligibility criteria
│       │   ├── Benefits package
│       │   └── Application process
│       │
│       ├── Startup Credits & Discounts
│       │   ├── Cloud credits
│       │   ├── Software discounts
│       │   └── Support packages
│       │
│       └── Success Stories
│           └── Portfolio companies using IBM
│
├── /ibm-products/quote
│   └── Request a Quote
│       ├── Product selection form
│       ├── Requirements gathering
│       ├── Contact information
│       └── Consultation booking
│
└── /ibm-products/resources
    └── IBM Resources
        ├── Product documentation
        ├── Case studies
        ├── Whitepapers
        ├── Webinar recordings
        └── IBM PartnerWorld resources
```

---

## 7. PROJECTS SECTION (/projects)

### Purpose
Showcase active and completed projects across sectors

### Page Structure
```
/projects
├── /projects (Portfolio Landing)
│   ├── Filter by:
│   │   ├── Sector
│   │   ├── Project type
│   │   ├── Status (Active/Completed)
│   │   └── Year
│   │
│   ├── Featured Projects Grid
│   │   └── Project cards with:
│   │       ├── Project name
│   │       ├── Client/Startup
│   │       ├── Sector badge
│   │       ├── Status indicator
│   │       └── Brief outcome
│   │
│   └── Metrics Dashboard
│       ├── Projects completed
│       ├── Success rate
│       ├── Client satisfaction
│       └── Investment facilitated
│
├── /projects/:slug
│   └── Individual Project Page
│       ├── Project overview
│       ├── Challenge & Solution
│       ├── Approach & Methodology
│       ├── Results & Impact
│       ├── Technologies used (including IBM products)
│       └── Related case study link
│
├── /projects/by-sector/:sector
│   └── Sector-filtered project listing
│
└── /projects/submit
    └── Project request form
```

---

## 8. CASE STUDIES SECTION (/casestudies)

### Purpose
In-depth success stories demonstrating value delivered

### Page Structure
```
/casestudies
├── /casestudies (Landing)
│   ├── Featured Case Study
│   │   └── Hero case study with video/imagery
│   │
│   ├── Case Study Grid
│   │   └── Filter by:
│   │       ├── Sector
│   │       ├── Service type
│   │       ├── IBM products used
│   │       └── Challenge type
│   │
│   └── Impact Statistics
│       ├── Startups served
│       ├── Investment raised
│       ├── Compliance rate improvement
│       └── Time saved
│
└── /casestudies/:slug
    └── Individual Case Study
        ├── Executive Summary
        ├── Client Profile
        │   └── Link to startup profile
        ├── The Challenge
        ├── Our Approach
        │   ├── Services deployed
        │   ├── IBM products utilized
        │   ├── Team involved
        │   └── Timeline
        ├── The Solution
        ├── Results & Metrics
        │   ├── Before/After comparison
        │   ├── ROI achieved
        │   └── Health score improvement
        ├── Client Testimonial
        ├── Key Learnings
        └── Related Services CTA
```

---

## 9. MEDIA SECTION (/media)

### Purpose
News, events, resources, and thought leadership

### Page Structure
```
/media
├── /media (Hub Landing)
│   ├── Latest News
│   ├── Upcoming Events
│   └── Featured Resources
│
├── /media/news
│   └── News & Press
│       ├── Press releases
│       ├── Media mentions
│       ├── Awards & recognition
│       └── Company announcements
│
├── /media/events
│   └── Events Calendar
│       ├── Upcoming workshops
│       ├── Webinars
│       ├── IBM partner events
│       └── Industry conferences
│       └── /media/events/:slug (Event details)
│
├── /media/blog
│   └── Blog/Insights
│       ├── Thought leadership articles
│       ├── Sector updates
│       ├── Regulatory news
│       ├── IBM technology insights
│       └── How-to guides
│       └── /media/blog/:slug (Article page)
│
├── /media/resources
│   └── Resource Library
│       ├── Whitepapers
│       ├── Templates
│       ├── Compliance guides
│       ├── IBM product guides
│       ├── Checklists
│       └── Toolkits
│       └── /media/resources/:slug (Resource page)
│
└── /media/press-kit
    └── Brand assets and media kit
```

---

## 10. GAMES SECTION (/games)

### Purpose
Interactive educational tools and gamified experiences

### Page Structure
```
/games
├── /games (Landing)
│   ├── Introduction
│   │   └── Why gamified learning?
│   │
│   └── Available Games/Tools
│       ├── Compliance Quiz
│       ├── Startup Health Simulator
│       ├── Legal Term Challenge
│       └── Sector Knowledge Tests
│
├── /games/compliance-quiz
│   └── Interactive compliance assessment
│
├── /games/startup-simulator
│   └── Build-a-startup simulation
│
└── /games/leaderboard
    └── Community rankings
```

---

## 11. CAREERS/JOB PLACEMENTS (/jobplacements)

### Purpose
Job board for MC Studio ecosystem and portfolio companies

### Page Structure
```
/jobplacements
├── /jobplacements (Job Board Landing)
│   ├── Search & Filter
│   │   ├── By company (MC Studio / Portfolio)
│   │   ├── By sector
│   │   ├── By role type
│   │   ├── By experience level
│   │   └── By location
│   │
│   ├── Featured Positions
│   │   └── Highlighted urgent/senior roles
│   │
│   └── Job Listings Grid
│       └── Each listing shows:
│           ├── Company logo
│           ├── Job title
│           ├── Location
│           ├── Type (Full-time/Part-time/Contract)
│           └── Posted date
│
├── /jobplacements/:id
│   └── Job Detail Page
│       ├── Job overview
│       ├── Responsibilities
│       ├── Requirements
│       ├── Benefits
│       ├── Company profile snippet
│       └── Apply CTA
│
├── /jobplacements/post
│   └── Post a Job (for portfolio companies)
│
├── /jobplacements/mc-studio
│   └── MC Studio internal positions
│
└── /jobplacements/talent-pool
    └── Submit CV for future opportunities
```

---

## 12. AUTHENTICATED DASHBOARD AREAS

### For Startups (Login Required)
```
/dashboard
├── /dashboard (Overview)
│   ├── Health Score Widget
│   ├── Action Items
│   ├── Upcoming deadlines
│   └── Quick links
│
├── /dashboard/health
│   └── Detailed health metrics
│       ├── Current assessment
│       ├── Historical trend
│       ├── Category breakdown
│       └── Improvement roadmap
│
├── /dashboard/documents
│   └── Document vault
│       ├── Contracts
│       ├── Compliance docs
│       ├── Reports
│       └── Templates
│
├── /dashboard/compliance
│   └── Compliance tracker
│       ├── License renewals
│       ├── Filing deadlines
│       └── Regulatory updates
│
├── /dashboard/ibm
│   └── IBM product licenses & subscriptions
│
├── /dashboard/team
│   └── Team management
│
└── /dashboard/settings
    └── Account settings
```

### For Partners/Investors (Login Required)
```
/portal
├── /portal (Partner Dashboard)
│   ├── Portfolio overview
│   ├── Aggregate health metrics
│   └── Investment pipeline
│
├── /portal/startups
│   └── Startup detailed access
│
├── /portal/due-diligence
│   └── DD report access
│
└── /portal/reports
    └── Custom reports
```

### For MC Studio Admin (Login Required)
```
/admin
├── /admin (Admin Dashboard)
│   ├── QA Dashboard
│   ├── Cash forecast
│   ├── IBM sales pipeline
│   └── Team performance
│
├── /admin/startups
│   └── Manage startup profiles
│
├── /admin/assessments
│   └── Review health checks
│
├── /admin/ibm
│   └── IBM product management
│       ├── License inventory
│       ├── Resale tracking
│       └── Commission reports
│
├── /admin/compliance
│   └── Compliance matrix manager
│
└── /admin/reports
    └── Generate reports
```

---

## 13. UTILITY PAGES

```
/about
├── About MC Studio
├── Our Story
├── Mission & Vision
├── Leadership Team
└── Contact Information

/contact
├── Contact Form
├── Office Locations
├── Department Contacts
└── Emergency Legal Hotline

/legal
├── /legal/terms - Terms of Service
├── /legal/privacy - Privacy Policy
├── /legal/cookies - Cookie Policy
└── /legal/disclaimer - Legal Disclaimer

/faq
└── Frequently Asked Questions

/support
├── Help Center
├── Knowledge Base
└── Submit Ticket
```

---

## DATA COLLECTION TOUCHPOINTS

### Primary Data Collection Forms
| Page | Data Collected | Purpose |
|------|---------------|---------|
| `/legalhealthcheck/assess` | Full legal health questionnaire | Primary startup scoring |
| `/startups/apply` | Basic company info, sector, stage | Ecosystem onboarding |
| `/partners/become-partner` | Partner org details | Partnership tracking |
| `/ibm-products/quote` | Product requirements, contact | IBM sales pipeline |
| `/jobplacements/post` | Job details | Job board population |
| `/contact` | Inquiry details | Lead generation |
| `/media/events/:slug` | RSVP data | Event management |

### Health Score Computation
```
Overall Health Score = Weighted Average of:
├── Corporate Structure (20%)
├── Employment/HR (15%)
├── Commercial Contracts (15%)
├── Data Protection (20%)
├── Intellectual Property (15%)
└── Tax & Regulatory (15%)
```

---

## NAVIGATION & USER FLOWS

### Primary User Journeys

**Journey 1: New Startup Discovery**
```
Home → Health Check Landing → Assessment → Results → 
→ Recommended Tier → Service Sign-up → Dashboard
```

**Journey 2: Investor Due Diligence**
```
Home → Partners/Investors → Request Access → 
→ Portal Login → Browse Startups → View Health Scores → 
→ Request Intro
```

**Journey 3: Partner Exploration**
```
Home → Services → Sector Page → Case Studies → 
→ Contact/Book Consultation
```

**Journey 4: IBM Product Purchase**
```
Home → IBM Products → Product Category → Product Detail → 
→ Request Quote → Consultation → Purchase
```

**Journey 5: Job Seeker**
```
Home → Job Placements → Search/Filter → 
→ Job Detail → Apply
```

---

## TECHNICAL RECOMMENDATIONS

### SEO Structure
- Clean, keyword-rich URLs
- Proper heading hierarchy
- Schema markup for:
  - Organization
  - LocalBusiness
  - JobPosting
  - Product (for IBM products)
  - Article (for blog)
  - Event (for events)

### Performance
- Lazy loading for startup grid images
- Progressive enhancement for health check form
- Cached dashboard data with background refresh

### Analytics Events to Track
- Health check starts/completions
- Tier recommendations generated
- IBM product inquiries
- Quote requests
- Partnership inquiries
- Job applications
- Document downloads
- Case study views

---

## SITEMAP VISUALIZATION

```
studiomoduschora.com
│
├── / (Home)
│
├── /startups ─────────── Portfolio Directory
│   ├── /:slug ─────────── Individual Profiles
│   ├── /apply ─────────── Join Ecosystem
│   └── /success-stories → /casestudies
│
├── /legalhealthcheck ──── Health Assessment
│   ├── /assess ────────── Assessment Form
│   ├── /results/:id ───── Results Page
│   ├── /dashboard ─────── Startup Dashboard (Auth)
│   └── /faq ───────────── FAQ
│
├── /partners ──────────── Partner Ecosystem
│   ├── /okutta-wairi ──── OW Advocates
│   ├── /ibmbp ─────────── IBM Partnership Overview
│   ├── /investors ─────── Investor Portal
│   └── /become-partner ── Partnership App
│
├── /services ──────────── Service Offerings
│   ├── /legal ─────────── Aikya Legal
│   │   ├── /hustle
│   │   ├── /grow
│   │   ├── /lead
│   │   └── /compare
│   ├── /qa ────────────── QA Services
│   ├── /advisory ──────── Advisory
│   ├── /sectors/:sector ─ Sector-Specific
│   └── /pricing ───────── Pricing
│
├── /ibm-products ──────── IBM Authorized Products (NEW)
│   ├── /cloud ─────────── Cloud & Infrastructure
│   ├── /ai ────────────── AI & Data Solutions
│   ├── /security ──────── Security Solutions
│   ├── /automation ────── Automation & Integration
│   ├── /industry ──────── Industry Solutions
│   ├── /licensing ─────── Software Licensing
│   ├── /services ──────── Implementation & Support
│   ├── /startup-program ─ IBM for Startups
│   ├── /quote ─────────── Request Quote
│   └── /resources ─────── IBM Resources
│
├── /projects ──────────── Project Portfolio
│   └── /:slug ─────────── Project Details
│
├── /casestudies ───────── Success Stories
│   └── /:slug ─────────── Case Study Details
│
├── /media ─────────────── Media Hub
│   ├── /news ──────────── Press & News
│   ├── /events ────────── Events Calendar
│   ├── /blog ──────────── Blog/Insights
│   ├── /resources ─────── Resource Library
│   └── /press-kit ─────── Media Assets
│
├── /games ─────────────── Interactive Tools
│
├── /jobplacements ─────── Career Hub
│   ├── /:id ───────────── Job Details
│   ├── /post ──────────── Post a Job
│   ├── /mc-studio ─────── Internal Jobs
│   └── /talent-pool ───── Submit CV
│
├── /dashboard ─────────── Startup Dashboard (Auth)
├── /portal ────────────── Partner Portal (Auth)
├── /admin ─────────────── Admin Panel (Auth)
│
├── /about ─────────────── About Us
├── /contact ───────────── Contact
├── /faq ───────────────── FAQ
├── /support ───────────── Support Center
│
└── /legal ─────────────── Legal Pages
    ├── /terms
    ├── /privacy
    └── /cookies
```

---

## IMPLEMENTATION PRIORITY

### Phase 1: Foundation (Month 1)
- Home page
- Legal Health Check flow (full assessment)
- Basic startup directory
- Services overview
- Contact page

### Phase 2: Ecosystem (Month 2)
- Individual startup profiles with health scores
- Partner pages (OW, IBM)
- Case studies
- Job placements board

### Phase 3: IBM Products & Dashboards (Month 3)
- IBM Products landing page
- IBM product category pages
- Quote request system
- Startup authenticated dashboard
- Document vault
- Admin QA dashboard

### Phase 4: Enhancement (Month 4+)
- Full IBM product catalog
- Partner/Investor portal
- Games section
- Blog & resources
- Advanced analytics
- IBM sales pipeline integration

---

*Document Version: 2.0*  
*Created: January 2026*  
*Updated: Removed Nafasi references, Added IBM Products section*  
*Author: MC Studio Digital Team*
