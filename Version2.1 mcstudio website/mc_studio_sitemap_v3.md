# modus chora studio
## Website Sitemap & Information Architecture
### Version 3.0 | January 2026

---

## EXECUTIVE SUMMARY

This sitemap documents the actual website architecture for **studiomoduschora.com** based on the Visily wireframe designs. The platform features:

1. **Dual Navigation Structure** - Two distinct navigation patterns for different user contexts
2. **Legal Health Check System** - 7-step assessment with scoring and tier recommendations
3. **Partner Ecosystem** - OW Advocates, IBM, and strategic partners
4. **Startup Portfolio** - Directory with profiles and project showcase
5. **Aikya Legal Services** - Tiered legal subscription services

---

## DUAL NAVIGATION STRUCTURE

The website uses two distinct navigation patterns:

### Navigation A: Platform Navigation
**Used on:** Home, Startups, Projects, Case Studies, Services, Media pages

```
| modus chora studio | Home | Startups | Projects | Case Studies | Services | Media | [Contact Us] |
```

**Footer Structure:**
- Company: About Us, Careers, Partners, Blog
- Services: Strategy, Design, Development, Consulting
- Resources: Case Studies, Projects, Startups, IBM Products
- Legal: Privacy Policy, Terms of Service, Cookie Policy, Admin Portal, Dashboard

---

### Navigation B: Legal/Partners Navigation
**Used on:** Legal Health Check, Partners, IBM, Dashboard, Aikya Pricing pages

```
| modus chora studio | Legal Health Check | Partners | Services | FAQ | [Start Assessment / Activate Your Account] |
```

**Footer Structure:**
- Company: About Us, Contact, Careers
- Legal & Services: Legal Health Check, Partners, Services, Privacy Policy, Terms of Service

---

## 1. HOME PAGE (/)

**Navigation:** Platform Navigation

### Page Layout
```
/
├── Header
│   └── Navigation: Home | Startups | Projects | Case Studies | Services | Media | [Contact Us]
│
├── Hero Section
│   ├── Headline: "Innovate, Create, Impact."
│   ├── Subtext: "We empower visionary founders with bespoke web templates..."
│   ├── CTA Button: "Explore Our Work"
│   └── Hero Image: Team collaboration photo
│
├── Latest Reports & Media
│   └── 3 Article Cards
│       ├── "The Future of Web Design: Trends for 2024"
│       ├── "Building Scalable Startups: A Comprehensive Guide"
│       └── "Leveraging AI in Project Management"
│
├── Explore Our Startups Portfolio
│   └── 4 Startup Logo Cards
│       ├── CloudForge
│       ├── BrightSpark
│       ├── NexusHub
│       └── RocketReach
│
├── Global Reach, Local Impact
│   ├── Section Headline
│   └── Interactive World Map with project location markers
│
├── Trusted by Industry Leaders
│   └── Partner logo carousel
│
├── Stay Ahead. Join Our Newsletter
│   ├── Email input field
│   └── Subscribe button
│
└── Footer (Platform Footer)
```

---

## 2. STARTUPS SECTION (/startups)

**Navigation:** Platform Navigation

### Directory Page (/startups)
```
/startups
├── Header with Platform Navigation
│
├── Hero Banner (Gradient background)
│   ├── Headline: "Join Our Network of Innovators"
│   ├── Subtext: "Are you a groundbreaking startup looking for strategic partnerships..."
│   └── CTA: "Apply Now"
│
├── Search & Filter Bar
│   ├── Search input: "Search by name or keywords..."
│   ├── Industry filter dropdown
│   ├── Stage filter dropdown
│   └── View toggle: Grid | List
│
├── Featured Startups
│   └── 4 Featured Cards
│       ├── QuantumLeap AI (Artificial Intelligence)
│       ├── EcoHarvest Farms (Sustainable Agriculture)
│       ├── MediConnect Global (Health Tech)
│       └── AeroDynamics X (Aerospace)
│
├── Our Startups
│   └── Startup Grid (8 per page)
│       ├── Card includes: Logo, Name, Tags, Description, Services Used
│       └── Examples: FinFlow Insights, ArtisanCraft Market, NeuroSense VR, GigaLogistics
│
├── Pagination
│   └── 1 | 2 | > | >>
│
└── Footer (Platform Footer)
```

### Individual Startup Profile (/startups/:slug)
```
/startups/quantumleap
├── Header with Platform Navigation
│
├── Hero Section
│   ├── Startup Name: "QuantumLeap Innovations"
│   ├── Tagline: "Pioneering the Future of AI-Driven Solutions"
│   ├── Description paragraph
│   ├── CTAs: "Apply Now" | "Contact Us"
│   └── Hero Image
│
├── Key Metrics & Achievements
│   ├── $75M Funding Raised
│   ├── 120+ Employee Count
│   ├── 150% Annual Archive (YoY revenue)
│   └── 5 Countries Global Presence
│
├── Services Utilized
│   └── Service Cards
│       ├── Custom Software Development
│       ├── UI/UX Design & Prototyping
│       ├── Cybersecurity Consulting
│       ├── Strategic Market Entry
│       ├── Brand & Marketing Strategy
│       └── Innovation Workshops
│
├── Impactful Case Studies
│   └── Case Study Cards
│       ├── "Enhancing Customer Engagement for E-commerce Giant"
│       ├── "Streamlining Financial Operations for a Fintech Startup"
│       └── "Revolutionizing Agricultural Yield Prediction"
│
├── Our Valued Partners
│   └── Partner logos: IBM, Power Learn Project, Skye, Okutta & Wairi Advocates, Silkroad AI
│
└── Footer (Platform Footer with Newsletter)
```

---

## 3. PROJECTS SECTION (/projects)

**Navigation:** Platform Navigation

### Projects Map Page (/projects)
```
/projects
├── Header with Platform Navigation
│
├── Full-Page Interactive Map
│   └── World map with project location markers (pins)
│
├── Sidebar (Right Panel)
│   ├── "Find Projects" header
│   ├── Search input: "Search projects..."
│   │
│   ├── Region Filter
│   │   └── All | North America | Europe | Asia | South America | Africa
│   │
│   ├── Partners Filter
│   │   └── All | IBM | Microsoft | Siemens | EDF | Philips | Telemed Asia | AgriChain Solutions | World Bank | CityNet Africa
│   │
│   ├── Case Studies Filter
│   │   └── Tags: AI Transformation at Scale, Green Energy for Smart Cities, Healthcare Access in Rural Asia, Transparent Food Supply, Smart Cities for a Brighter Future, Urban Innovation
│   │
│   └── Filtered Results (5)
│       ├── Global AI Integration Initiative (North America - IBM, Microsoft)
│       ├── Sustainable Energy Grid Deployment (Europe - Siemens, EDF)
│       ├── Digital Healthcare Platform (Asia - Philips, Telemed Asia)
│       ├── Blockchain Supply Chain Optimization (South America - AgriChain Solutions)
│       └── Smart City Infrastructure Project (Africa - World Bank, CityNet Africa)
│
└── Footer (Platform Footer)
```

---

## 4. CASE STUDIES SECTION (/casestudies)

**Navigation:** Platform Navigation

### Case Studies Gallery (/casestudies)
```
/casestudies
├── Header with Platform Navigation
│
├── Featured Case Study Hero
│   ├── Image: Healthcare professional with technology
│   ├── Title: "Klinik: Digital Transformation for a Global Healthcare Leader"
│   ├── Description: "Our strategic partnership helped a major healthcare provider..."
│   ├── Key Metrics
│   │   ├── +30% Patient Satisfaction
│   │   ├── +20% Operational Efficiency
│   │   └── +15% Market Reach
│   └── CTA: "Review Dossier"
│
├── Explore Our Success Stories
│   ├── Search: "Search case studies..."
│   │
│   ├── Category Filters
│   │   └── All | Technology | Healthcare | Finance | Education | Automotive | Energy
│   │
│   └── Case Study Grid (6 cards)
│       ├── "Optimizing Supply Chain for E-commerce Retail"
│       │   └── Tags: E-commerce, Logistics, Efficiency
│       ├── "Enhanced User Experience for Fintech Platform"
│       │   └── Tags: Fintech, UI/UX, Engagement
│       ├── "Driving Innovation with AI for Automotive Manufacturer"
│       │   └── Tags: Automotive, AI, Manufacturing
│       ├── "Digital Marketing Strategy for Education Tech Startup"
│       │   └── Tags: Education, Marketing, Growth
│       ├── "Cloud Infrastructure Migration for SaaS Provider"
│       │   └── Tags: Cloud, SaaS, Infrastructure
│       └── "Brand Identity & Web Development for a New Energy Venture"
│           └── Tags: Energy, Branding, Web Dev
│
└── Footer (Platform Footer)
```

---

## 5. SERVICES SECTION (/services) - Platform

**Navigation:** Platform Navigation

### Services Page (/services)
```
/services
├── Header with Platform Navigation
│
├── Hero Section
│   ├── Headline: "Innovate, Design, Develop: Our Integrated Services"
│   ├── Description: "At modus chora studio, we transform ideas into impactful digital realities..."
│   ├── CTA: "Explore Our Solutions"
│   └── Hero Image
│
├── Our Core Competencies
│   └── 4 Service Cards
│       ├── Strategic Consultation
│       │   └── "Guiding your vision from concept to market with expert insights..."
│       │   └── CTA: "Discover Strategy"
│       ├── User Experience Design
│       │   └── "Crafting intuitive, engaging, and beautiful digital experiences..."
│       │   └── CTA: "View Design Portfolio"
│       ├── Full-Stack Development
│       │   └── "Building robust, scalable, and secure web applications..."
│       │   └── CTA: "Explore Development"
│       └── Digital Transformation
│           └── "Empowering businesses to adapt and thrive in the digital age..."
│           └── CTA: "Learn About Transformation"
│
├── Tailored Solutions: Kijani.co Plans
│   └── Pricing Cards
│       ├── Basic Support - $99/month
│       │   ├── Standard Email Support
│       │   ├── Knowledge Base Access
│       │   ├── Basic Bug Fixes
│       │   ├── Weekly Performance Reports
│       │   └── 1 User Account
│       │   └── CTA: "Select Basic"
│       │
│       ├── Premium Partnership - $299/month [Highlighted]
│       │   ├── Dedicated Account Manager
│       │   ├── Priority Phone Support
│       │   ├── Proactive Monitoring
│       │   ├── Monthly Strategic Reviews
│       │   ├── Up to 5 User Accounts
│       │   └── Custom Integration Assistance
│       │   └── CTA: "Choose Premium"
│       │
│       └── Enterprise Solutions - Custom Quote
│           ├── 24/7 Enterprise Support
│           ├── On-site Consultations
│           ├── Custom Development Sprints
│           ├── Tailored SLA Agreements
│           ├── Unlimited User Accounts
│           └── Advanced Security Audits
│           └── CTA: "Contact For Quote"
│
├── Building for a Customised Dataroom?
│   └── CTA: "Get a Custom Quote"
│
├── Frequently Asked Questions
│   └── Accordion FAQ
│       ├── "What is Studiomoduschora?"
│       ├── "How does your strategic consultation process work?"
│       ├── "Do you offer custom software development?"
│       ├── "What technologies do you specialize in?"
│       └── "Can you help with UI/UX design for existing products?"
│
└── Footer (Platform Footer)
```

---

## 6. MEDIA SECTION (/media)

**Navigation:** Platform Navigation

### Article Detail Page (/media/:slug)
```
/media/the-future-of-digital-transformation
├── Header with Platform Navigation (Dark Theme)
│
├── Main Content Area
│   ├── Featured Image (Gradient abstract)
│   │
│   ├── Article Title: "The Future of Digital Transformation: Trends & Insights"
│   ├── Byline: "By Charity Mwangi on October 26, 2026"
│   │
│   └── Article Body
│       ├── Introduction paragraph
│       ├── **Integration of AI and Machine Learning** section
│       ├── **Hyper-personalization** section
│       ├── **Cybersecurity and data privacy** section
│       ├── **Sustainable technology and green IT initiatives** section
│       └── Conclusion paragraph
│
├── Sidebar
│   ├── Recent Articles
│   │   ├── "Building Resilient Startup Ecosystems"
│   │   ├── "Global Projects: Bridging Continents"
│   │   ├── "Design Thinking for Modern Applications"
│   │   └── "Innovation in Action: Case Study Spotlight"
│   │
│   └── Stay Updated
│       ├── Newsletter signup description
│       ├── Email input
│       └── "Subscribe Now" button
│
└── Footer (Platform Footer - Dark)
```

---

## 7. LEGAL HEALTH CHECK SECTION (/legalhealthcheck)

**Navigation:** Legal/Partners Navigation

### Landing Page (/legalhealthcheck)
```
/legalhealthcheck
├── Header with Legal Navigation + "Start Assessment" CTA
│
├── Hero Section
│   ├── Headline: "What is a Legal Health Check?"
│   ├── Subheadline: "Proactive Legal Clarity for Your Business Growth"
│   ├── Description: "A Legal Health Check is a comprehensive assessment..."
│   ├── CTA: "Start Your Free Assessment"
│   └── Hero Image: Terms and Conditions document
│
├── Why Your Business Needs a Legal Health Check
│   └── Explanation paragraph about importance
│
├── The Legal Health Check Process
│   └── 4 Steps
│       ├── Step 1: Company Information
│       │   └── "Provide essential details about your business..."
│       ├── Step 2: Comprehensive Assessment
│       │   └── "Answer targeted questions across various legal domains..."
│       ├── Step 3: Expert Review
│       │   └── "Our legal specialists analyze your responses..."
│       └── Step 4: Personalized Report
│           └── "Receive a detailed report with your health score..."
│
├── What You'll Gain From the Assessment
│   └── 4 Benefits
│       ├── Health Score - Overall legal resilience indicator
│       ├── Risk Analysis - Detailed identification of potential legal risks
│       ├── Priority Actions - Recommended steps to address issues
│       └── Tier Recommendation - Guidance on optimal Aikya service tier
│
├── Ready to Secure Your Business Future?
│   ├── Description paragraph
│   └── CTA: "Start Your Free Assessment Now"
│
└── Footer (Legal Footer)
```

### Assessment Form (/legalhealthcheck/assess)
```
/legalhealthcheck/assess
├── Header with Legal Navigation
│
├── Assessment Progress (Left Panel)
│   └── Step Tracker (Vertical Timeline)
│       ├── 1. Company Information [Active]
│       ├── 2. Corporate Structure
│       ├── 3. Employment & HR
│       ├── 4. Data Protection
│       ├── 5. Intellectual Property
│       ├── 6. Tax & Compliance
│       └── 7. Review & Submit
│
├── Form Panel (Right)
│   └── Step 1: Company Information
│       ├── Company Name (input)
│       ├── Industry (dropdown: Select industry)
│       ├── What is your estimated annual revenue? (input: e.g., Kes 3,000,000)
│       ├── Number of Employees (dropdown: Select range)
│       ├── Is your Company registered? (dropdown: yes, no)
│       └── CTA: Yes "Save & Continue →" or No "Not Registered →"
|── Form Panel (Right- Screen 2B)
|   └── Step 2: Corporate Structure
|       ├── What is your Country HQ? (dropdown: African countries alphabetically)
|       ├── What is your Company's registration number? (input: e.g., PXXXXXXXXXX)
|       ├── Confirm your Tax ID (input: e.g., PVT-XXXXXXXX)
|       ├── Do you have a board of directors/ advisors in place? (dropdown: yes, need guidance)
|       ├── Do you have a Shareholders agreement in place? (dropdown: yes, no)
|       ├── Are you currently fundraising? (dropdown: yes, no)
|       ├── Share your company/product website or Linkedin page. (input: e.g., http://example.com)
|       └── CTA: "Save & Continue →" 
|── Form Panel (Right- Screen 3)
|    └── Step 3: Employment & HR
|       ├── How many employees? (dropdown: 2-14, 15-59, 60-499)
|       ├── Select what category describes your employee matrix. (dropdown: full-time, part-time, contract)
|       ├── What system automates your HRM? (input: e.g., Zoho, Odoo, SAP)
|       ├── What percentage of revenue goes to your Payroll? (input: e.g., 10%)
|       ├── Select your current HR department? (dropdown: internal HR, Dedicated HR consultant, Outsourced to HR firm)
|       └── CTA: "Save & Continue →"   
│── Form Panel (Right- Screen 4)
|    └── Step 4: Data Protection
|       ├── Are you a registered Data Processor or Data Controller? (dropdown: yes, no)
|       ├── Do you rely on 3rd party data processing apps? If yes, list them. (input: e.g., Google workspace)
|       └── CTA: "Save & Continue →"
│── Form Panel (Right- Screen 5)
|    └── Step 5: Intellectual Property 
|       ├── Do you own your startup content/media/mechanism? (dropdown: yes, no)
|       ├── Do you have an established Research&Development liaison? (dropdown: yes, no)
|       ├── Have you registered a Trademark or Copyright associated with your company? (dropdown: yes, no)
|       └── CTA: "Save & Continue →"
|── Form Panel (Right- Screen 6)
|    └── Step 6: Tax & Compliance
|       ├── What sector do you fall in? (dropdown: fintech, agritech, edtech, healthtech, retail&commerce, energy&manufacturing)
|       ├── What taxes are you currently paying? (checkbox: PAYE, VAT, Excise duty)
|       ├── Which tax resources would you give priority in need? (checkbox: legal services, accounting services, fundraising services)
|       ├── What other compliance fees are you paying? (input: e.g., business license,housing levy)
|       └── CTA: "Finish & Review →"
└── Footer (Legal Footer)
```

### Results Page (/legalhealthcheck/results/:id)
```
/legalhealthcheck/results/abc123
├── Header with Legal Navigation + "Activate Your Account" CTA
│
├── Score Header
│   ├── Large Score Display: "82" Legal Health Score
│   ├── Risk Level Badge: "Low"
│   ├── CTA: "Book Consultation"
│   └── Secondary: "Download PDF Report"
│
├── Your Legal Health Breakdown
│   └── 6 Category Cards (Grid)
│       ├── Corporate Structure [Good]
│       │   └── "Your company's foundational legal documents are robust..."
│       ├── Employment & HR [Moderate Risk]
│       │   └── "Some gaps exist in employee contract templates..."
│       ├── Data Protection [Good]
│       │   └── "Strong data privacy policies and robust cybersecurity..."
│       ├── Intellectual Property [Moderate Risk]
│       │   └── "Your trademarks and patents require a strategic review..."
│       ├── Contracts & Agreements [Good]
│       │   └── "Standard operating agreements are legally sound..."
│       └── Regulatory Compliance [High Risk]
│           └── "Significant updates are needed to align with new regulations..."
│
├── Priority Actions for Improvement
│   └── Action Items (3 rows)
│       ├── "Update Employment Contracts" → [Review Templates]
│       ├── "Conduct IP Audit for Global Markets" → [Start Audit]
│       └── "Consult on Regulatory Changes" → [Book Consultation]
│
├── Your Recommended Path Forward
│   └── Recommended Tier Card
│       ├── "Recommended Tier:"
│       ├── "Aikya Growth Tier"
│       ├── Description: "Designed for scaling businesses, this tier provides..."
│       ├── Benefits list:
│       │   ├── Quarterly legal health check-ins
│       │   ├── Dedicated legal advisor access
│       │   ├── Discounted contract drafting and review
│       │   └── Priority support for new market entries
│       └── CTA: "Book Consultation"
│
└── Footer (Legal Footer)
```

### FAQ Page (/legalhealthcheck/faq)
```
/legalhealthcheck/faq
├── Header with Legal Navigation + "Start Assessment" CTA
│
├── Page Title: "Frequently Asked Questions"
│   └── Subtitle: "Find answers to common questions about the Legal Health Check..."
│
├── General Questions
│   └── Accordion Items
│       ├── "What is the Legal Health Check?" [Expanded]
│       │   └── "The Legal Health Check is a comprehensive online assessment..."
│       ├── "Who can benefit from a Legal Health Check?"
│       ├── "How long does the assessment take?"
│       └── "Is my data secure and confidential?"
│
├── Assessment Process
│   └── Accordion Items
│       ├── "What legal areas does the assessment cover?" [Expanded]
│       │   └── "Our assessment covers key legal domains including Company Information..."
│       ├── "What information do I need to provide?"
│       ├── "Can I save my progress?"
│       └── "What if I don't know an answer?"
│
├── Results & Recommendations
│   └── Accordion Items
│       ├── "What do the results include?" [Expanded]
│       │   └── "Your personalized results will include a Legal Health Score..."
│       ├── "How accurate are the recommendations?"
│       ├── "Can I download my report?"
│       └── "What are the next steps after receiving my results?"
│
├── CTAs
│   ├── "Start Your Free Assessment" [Primary]
│   └── "Contact Support" [Secondary]
│
└── Footer (Legal Footer)
```

### Private Dashboard (/legalhealthcheck/dashboard)
```
/legalhealthcheck/dashboard [Authenticated]
├── Header with Legal Navigation + "Activate Your Account" CTA
│
├── Welcome Message
│   └── "Welcome, Jane!" + "Your personalized legal health dashboard."
│
├── Dashboard Grid
│   │
│   ├── Current Legal Health Score (Card)
│   │   ├── Score: "82"
│   │   ├── Badge: "Excellent"
│   │   ├── Status: "Your company is in great legal health. Keep up the good work!"
│   │   └── CTA: "View Detailed Report"
│   │
│   ├── Historical Assessments (Card)
│   │   ├── Title: "Track your legal health progress over time."
│   │   └── Line Chart (Jan-Jun showing score trend 65→82)
│   │
│   ├── Action Item Checklist (Card)
│   │   ├── Title: "Your pending legal tasks."
│   │   └── Checklist Items
│   │       ├── ☐ Review new Privacy Policy draft with team
│   │       ├── ☑ Schedule legal consultation for trademark application
│   │       ├── ☐ Update employee handbook with latest HR regulations
│   │       ├── ☐ Organize Q3 legal expenses for tax filing
│   │       └── ☑ Finalize contractor agreements for new hires
│   │   └── "+ Add New Action"
│   │
│   ├── Progress Tracking (Card)
│   │   ├── Title: "Key milestones in your legal journey."
│   │   └── Timeline
│   │       ├── Oct 2023 - Initial Legal Health Check Completed
│   │       ├── Nov 2023 - Corporate Structure Review
│   │       ├── Jan 2024 - Data Protection Policy Implemented
│   │       └── Mar 2024 - Trademark Registration
│   │
│   └── Document Vault (Card)
│       ├── Title: "Secure access to your legal documents."
│       └── Document List
│           ├── Service Agreement - Acme Inc. [Download]
│           ├── Employee Handbook V2.1 [Download]
│           ├── Privacy Policy (GDPR Compliant) [Download]
│           └── Trademark Application Filing [Download]
│       └── CTAs: "Upload Document" | "View All"
│
└── Footer (Legal Footer)
```

---

## 8. PARTNERS SECTION (/partners)

**Navigation:** Legal/Partners Navigation

### Partner Ecosystem Landing (/partners)
```
/partners
├── Header with Legal Navigation + "Start Assessment" CTA
│
├── Hero Section
│   ├── Headline: "Empowering Growth Through Strategic Alliances"
│   ├── Description: "Explore our ecosystem of trusted partners..."
│   ├── CTA: "Become a Partner →"
│   └── Hero Image: Entrepreneurs group photo
│
├── Our Featured Partners
│   └── Partner Cards (6)
│       ├── OW Advocates (Legal counsel - corporate law)
│       ├── IBM Business Partner (Technology solutions)
│       ├── JHUB (Software development, digital transformation)
│       ├── Power Learn Project (Market entry, operational efficiency)
│       ├── JuaFlow by Phindor (Cybersecurity, data protection)
│       └── Watu Wa Gaming (FinTech, blockchain, payments)
│
├── Explore Partner Categories
│   └── Category Cards (6)
│       ├── Legal Services - "Specialized legal expertise..."
│       ├── Technology Providers - "Cutting-edge software and hardware..."
│       ├── Consulting & Advisory - "Strategic guidance to navigate..."
│       ├── Startup Ecosystem - "Support for new ventures..."
│       ├── Cybersecurity & Data - "Robust solutions to protect..."
│       └── Integrations - "Seamlessly connect and automate..."
│
├── Unlock Potential with IBM Solutions
│   ├── Description: "Leverage the power of IBM's cutting-edge technology..."
│   └── CTA: "View IBM Products & Services →"
│
├── Ready to Amplify Your Impact?
│   ├── Description: "Join the Modus Chora partner network..."
│   └── CTA: "Apply to Become a Partner →"
│
└── Footer (Legal Footer)
```

### OW Advocates Profile (/partners/ow-advocates)
```
/partners/ow-advocates
├── Header with Legal Navigation + "Start Assessment" CTA
│
├── Partner Logo & Header
│   └── OW OKUTTA WAIRI & CO. ADVOCATES logo
│
├── Hero Section
│   ├── Headline: "OW Advocates: Your Trusted Legal Partner"
│   └── Subtitle: "Partnering with Modus Chora to deliver exceptional legal services..."
│
├── About OW Advocates
│   └── Description paragraphs about the firm's expertise and partnership
│   └── CTA: "Book Legal Consult"
│
├── Our Legal Services
│   └── 3 Service Cards
│       ├── Corporate Law & Governance
│       │   └── "Expert guidance on company formation, compliance, M&A..."
│       ├── Litigation & Dispute Resolution
│       │   └── "Vigorous representation in court and ADR strategies..."
│       └── Employment & Labor Law
│           └── "Comprehensive advice on employment contracts, policies..."
│
├── Understanding the Aikya Legal Framework
│   ├── Headline: "Holistic & Integrated Legal Strategy"
│   ├── Description: "The Aikya Legal Framework is a comprehensive approach..."
│   └── Key Features:
│       ├── Proactive Risk Assessment
│       ├── Customized Legal Roadmaps
│       └── Seamless Compliance Integration
│
├── Case Studies & Success Stories
│   └── 2 Case Study Cards
│       ├── "Navigating Complex M&A for Tech Startup" [Successful Acquisition]
│       └── "Securing Intellectual Property for Innovators" [IP Protection]
│
├── Ready to Partner with OW Advocates?
│   └── CTA: "Book a Consultation"
│
└── Footer (Legal Footer)
```

### IBM Partnership Overview (/partners/ibm)
```
/partners/ibm
├── Header with Legal Navigation
│
├── Hero Section
│   ├── Headline: "Modus Chora Studio & IBM: Innovating Legal Tech Together"
│   ├── Description: "Leveraging IBM's cutting-edge technology..."
│   ├── IBM Logo
│   └── CTA: "View IBM Products"
│
├── Unlock Advanced Legal Capabilities with IBM
│   └── 3 Feature Cards
│       ├── AI-Powered Insights
│       │   └── "Gain deeper understanding from complex legal documents..."
│       ├── Enhanced Security & Compliance
│       │   └── "Protect your sensitive legal data and ensure regulatory..."
│       └── Scalable & Reliable Solutions
│           └── "Leverage flexible, enterprise-grade cloud infrastructure..."
│
├── Integrated IBM Services for Your Business
│   └── 4 Service Cards
│       ├── IBM Watson Legal AI
│       ├── IBM Security & Compliance
│       ├── IBM Cloud Solutions
│       └── IBM Automation & Workflow
│
├── Advanced QA & Analytics Driven by IBM
│   └── Dashboard preview with description
│
├── Our IBM Badges
│   └── Badge gallery (4 badges)
│
├── Explore the Full Spectrum of IBM Products
│   └── CTA: "View IBM Products"
│
└── Footer (Legal Footer)
```

### IBM Services Overview (/partners/ibm/services)
```
/partners/ibm/services
├── Header with Legal Navigation + "Start Assessment" CTA
│
├── Hero Section (Blue gradient background)
│   ├── Headline: "Empowering Innovation with IBM Technology Solutions"
│   └── Description: "modus chora studio proudly partners with IBM..."
│
├── Our IBM Service Offerings
│   └── 8 Service Cards (3x3 Grid)
│       ├── Cloud Solutions
│       │   └── "Scalable, secure, and flexible cloud infrastructure..."
│       ├── AI & Machine Learning
│       │   └── "Leverage IBM Watson for advanced AI capabilities..."
│       ├── Security Services
│       │   └── "Comprehensive cybersecurity solutions..."
│       ├── Automation & Integration
│       │   └── "Streamline operations with IBM's intelligent automation..."
│       ├── Industry Solutions
│       │   └── "Tailored IBM solutions designed to meet specific industry..."
│       ├── Licensing & Compliance
│       │   └── "Expert guidance on IBM software licensing..."
│       ├── Implementation & Support
│       │   └── "End-to-end implementation and ongoing technical support..."
│       └── Data & Analytics
│           └── "Transform raw data into actionable insights..."
│
├── Ready to Transform Your Business with IBM?
│   └── CTAs: "Request Quote" | "Resources"
│
├── Unsure Which Of Prerequisites Needed?
│   ├── Description: "Take our free Legal Health Check..."
│   └── CTA: "Find Your Tier"
│
└── Footer (Legal Footer)
```

### Become a Partner (/partners/become-partner)
```
/partners/become-partner
├── Header with Legal Navigation
│
├── Page Header
│   ├── Title: "Join Our Partner Ecosystem"
│   └── Subtitle: "Partner with Modus Chora and unlock new opportunities..."
│
├── Partnership Application Form
│   ├── Form Description
│   │
│   ├── Section 1: Company Information
│   │   ├── Company Name (input)
│   │   ├── Company Website (input)
│   │   ├── Industry / Sector (input)
│   │   └── Company Size (Number of Employees) (input)
│   │
│   ├── Section 2: Contact Person Details
│   │   ├── Full Name (input)
│   │   ├── Email Address (input)
│   │   ├── Phone Number (input)
│   │   └── Role in Company (input)
│   │
│   ├── Section 3: Partnership Interests
│   │   ├── "What type of partnership are you interested in?"
│   │   │   └── Checkboxes:
│   │   │       ├── Technology Integration Partner
│   │   │       ├── Referral Partner
│   │   │       ├── Content & Thought Leadership
│   │   │       ├── Co-Marketing Partner
│   │   │       └── Other (Please specify)
│   │   │
│   │   └── "What benefits are you looking for?"
│   │       └── Checkboxes:
│   │           ├── Access to legal tech platform & tools
│   │           ├── Co-marketing opportunities
│   │           ├── Revenue share program
│   │           ├── Dedicated partner support & resources
│   │           └── Invitations to exclusive partner events
│   │
│   ├── Section 4: Additional Information
│   │   └── Textarea: "Tell us more about your company..."
│   │
│   └── CTA: "Submit Application"
│
├── Help Link
│   └── "Need assistance or have specific questions? Contact Our Team"
│
└── Footer (Legal Footer)
```

---

## 9. AIKYA LEGAL SERVICES (/services/aikya)

**Navigation:** Legal/Partners Navigation

### Aikya Pricing Page (/services/aikya/hustle)
```
/services/aikya/hustle
├── Header with Legal Navigation + "Activate Your Account" CTA
│
├── Hero Section
│   ├── Headline: "Aikya Hustle: Founder Tier Legal Service"
│   └── Description: "Gain a competitive edge with expert legal guidance..."
│
├── Find Your Perfect Legal Partnership
│   └── 3 Pricing Cards
│       │
│       ├── Aikya Hustle
│       │   ├── Description: "Ideal for early-stage founders..."
│       │   ├── Price: KSh 25,000/month
│       │   ├── Features:
│       │   │   ├── ✓ Legal strategy & roadmap
│       │   │   ├── ✓ Contract drafting (up to 5/month)
│       │   │   ├── ✓ IP protection guidance
│       │   │   ├── ✓ Regulatory compliance check
│       │   │   ├── ✓ Access to legal templates
│       │   │   ├── ✓ Monthly founder check-in (1 hr)
│       │   │   ├── ✓ Dedicated legal advisor (email support)
│       │   │   └── ✓ Startup specific legal advice
│       │   └── CTAs: "Subscribe Now" | "Contact Sales"
│       │
│       ├── Growth Tier [Recommended]
│       │   ├── Description: "Designed for scaling startups..."
│       │   ├── Price: KSh 50,000/month
│       │   ├── Features:
│       │   │   ├── ✓ All Founder Tier benefits
│       │   │   ├── ✓ Advanced contract negotiation (up to 10/month)
│       │   │   ├── ✓ Data privacy policy drafting
│       │   │   ├── ✓ HR & employment legal support
│       │   │   ├── ✓ Investor legal support
│       │   │   ├── ✓ Quarterly strategic review (2 hrs)
│       │   │   ├── ✓ Priority email & phone support
│       │   │   └── ✓ M&A preparation guidance
│       │   └── CTAs: "Subscribe Now" | "Contact Sales"
│       │
│       └── Lead Enterprise Tier
│           ├── Description: "For established businesses..."
│           ├── Price: KSh 150,000/month
│           ├── Features:
│           │   ├── ✓ All Growth Tier benefits
│           │   ├── ✓ Unlimited contract drafting & review
│           │   ├── ✓ M&A legal advisory
│           │   ├── ✓ Complex litigation support
│           │   ├── ✓ Global compliance management
│           │   ├── ✓ Dedicated legal team
│           │   ├── ✓ 24/7 priority support
│           │   └── ✓ On-site legal workshops
│           └── CTAs: "Subscribe Now" | "Contact Sales"
│
├── Ready to Transform Your Legal Operations?
│   └── CTAs: "Get a Custom Quote" | "Explore FAQs"
│
└── Footer (Legal Footer)
```

---

## DATA COLLECTION TOUCHPOINTS

### Primary Data Collection Forms

| Page | Data Collected | Purpose |
|------|---------------|---------|
| `/legalhealthcheck/assess` | Full 7-step legal questionnaire | Primary startup scoring |
| `/startups/apply` | Company info, sector, stage | Ecosystem onboarding |
| `/partners/become-partner` | Company & contact details, interests | Partnership pipeline |
| `/contact` | Name, email, inquiry details | Lead generation |

### Health Score Categories (Based on Assessment)

| Category | Weight | Risk Levels |
|----------|--------|-------------|
| Corporate Structure | 20% | Good / Moderate Risk / High Risk |
| Employment & HR | 15% | Good / Moderate Risk / High Risk |
| Data Protection | 20% | Good / Moderate Risk / High Risk |
| Intellectual Property | 15% | Good / Moderate Risk / High Risk |
| Contracts & Agreements | 15% | Good / Moderate Risk / High Risk |
| Regulatory Compliance | 15% | Good / Moderate Risk / High Risk |

---

## FOOTER STRUCTURES

### Platform Footer
```
modus chora studio
"Empowering innovation through strategic design and development."
[Social Icons: LinkedIn, Twitter, Facebook, Instagram, YouTube]

Company         Services        Resources       Legal
─────────       ─────────       ─────────       ─────────
About Us        Strategy        Case Studies    Privacy Policy
Careers         Design          Projects        Terms of Service
Partners        Development     Startups        Cookie Policy
Blog            Consulting      IBM Products    Admin Portal
                                                Dashboard

© 2026 Studiomoduschora. All rights reserved.
```

### Legal/Partners Footer
```
modus chora studio
"Your partner in legal clarity and business growth."
[Social Icons: Facebook, Twitter, LinkedIn, YouTube, Instagram]

Company             Legal & Services
─────────           ─────────────────
About Us            Legal Health Check
Contact             Partners
Careers             Services
                    Privacy Policy
                    Terms of Service

© 2026 Modus Chora Studio x OW Advocates. All rights reserved.
```

---

## SITEMAP VISUALIZATION

```
studiomoduschora.com
│
├── PLATFORM NAVIGATION PAGES
│   │
│   ├── / (Home)
│   │   └── Hero, Latest Reports, Startups Portfolio, Global Map, Newsletter
│   │
│   ├── /startups
│   │   ├── /startups (Directory with search/filter)
│   │   ├── /startups/:slug (Individual profiles)
│   │   └── /startups/apply (Join ecosystem)
│   │
│   ├── /projects
│   │   ├── /projects (Interactive map view)
│   │   └── /projects/:slug (Project detail)
│   │
│   ├── /casestudies
│   │   ├── /casestudies (Gallery with filters)
│   │   └── /casestudies/:slug (Case study detail)
│   │
│   ├── /services (Platform Services)
│   │   ├── /services (Landing with Kijani.co pricing)
│   │   ├── /services/strategy
│   │   ├── /services/design
│   │   ├── /services/development
│   │   └── /services/consulting
│   │
│   └── /media
│       ├── /media (Article listing)
│       └── /media/:slug (Article detail - dark theme)
│
├── LEGAL/PARTNERS NAVIGATION PAGES
│   │
│   ├── /legalhealthcheck
│   │   ├── /legalhealthcheck (Landing)
│   │   ├── /legalhealthcheck/assess (7-step form)
│   │   ├── /legalhealthcheck/results/:id (Score & recommendations)
│   │   ├── /legalhealthcheck/dashboard (Private - Auth)
│   │   └── /legalhealthcheck/faq (FAQ)
│   │
│   ├── /partners
│   │   ├── /partners (Partner ecosystem)
│   │   ├── /partners/ow-advocates (OW profile)
│   │   ├── /partners/ibm (IBM partnership)
│   │   ├── /partners/ibm/services (IBM services)
│   │   └── /partners/become-partner (Application form)
│   │
│   ├── /services/aikya
│   │   ├── /services/aikya/hustle (Pricing page)
│   │   ├── /services/aikya/growth
│   │   └── /services/aikya/lead
│   │
│   └── /faq (General FAQ)
│
├── UTILITY PAGES
│   ├── /about
│   ├── /contact
│   ├── /careers
│   └── /legal
│       ├── /legal/terms
│       ├── /legal/privacy
│       └── /legal/cookies
│
└── AUTHENTICATED PAGES
    ├── /legalhealthcheck/dashboard (Startup dashboard)
    └── /admin (Admin portal)
```

---

## IMPLEMENTATION PRIORITY

### Phase 1: Foundation (Month 1)
- Home page with Platform Navigation
- Legal Health Check landing page
- Assessment form (7 steps)
- Results page with scoring
- Aikya pricing page

### Phase 2: Partners (Month 2)
- Partner ecosystem landing
- OW Advocates profile
- IBM partnership pages
- IBM services overview
- Become a Partner form

### Phase 3: Portfolio (Month 3)
- Startups directory
- Individual startup profiles
- Projects map view
- Case studies gallery

### Phase 4: Enhancement (Month 4+)
- Private dashboard
- Media/Articles section
- Platform services page
- Admin portal

---

*Document Version: 3.0*  
*Created: January 2026*  
*Based on: Visily Wireframe Designs*  
*Author: MC Studio Digital Team*
