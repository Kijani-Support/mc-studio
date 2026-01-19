import React, { useState } from 'react';

const SitemapVisualization = () => {
  const [expandedSections, setExpandedSections] = useState(['home', 'startups', 'legalhealthcheck', 'partners']);
  const [activeNav, setActiveNav] = useState('platform');

  const toggleSection = (section) => {
    setExpandedSections(prev => 
      prev.includes(section) 
        ? prev.filter(s => s !== section)
        : [...prev, section]
    );
  };

  // Two distinct navigation structures based on screenshots
  const navigationStructures = {
    platform: {
      name: 'Platform Navigation',
      description: 'Used on: Home, Startups, Projects, Case Studies, Services, Media pages',
      items: ['Home', 'Startups', 'Projects', 'Case Studies', 'Services', 'Media'],
      cta: 'Contact Us'
    },
    legal: {
      name: 'Legal/Partners Navigation',
      description: 'Used on: Legal Health Check, Partners, IBM, Dashboard, Aikya Pricing pages',
      items: ['Legal Health Check', 'Partners', 'Services', 'FAQ'],
      cta: 'Start Assessment / Activate Your Account'
    }
  };

  // Platform Navigation Pages
  const platformSitemap = {
    home: {
      name: 'Home',
      path: '/',
      icon: '🏠',
      description: 'Main landing page - "Innovate, Create, Impact."',
      navType: 'platform',
      sections: [
        'Hero with CTA "Explore Our Work"',
        'Latest Reports & Media (3 article cards)',
        'Explore Our Startups Portfolio (CloudForge, BrightSpark, NexusHub, RocketReach)',
        'Global Reach, Local Impact (Interactive world map)',
        'Trusted by Industry Leaders (Partner logos)',
        'Stay Ahead. Join Our Newsletter'
      ],
      children: []
    },
    startups: {
      name: 'Startups',
      path: '/startups',
      icon: '🚀',
      description: 'Startup directory with searchable grid',
      navType: 'platform',
      dataCollection: true,
      sections: [
        'Hero: "Join Our Network of Innovators" with Apply Now CTA',
        'Search bar with Industry & Stage filters',
        'Featured Startups section (4 cards)',
        'Our Startups grid with pagination'
      ],
      children: [
        { name: 'Directory', path: '/startups', description: 'Searchable startup grid with filters' },
        { name: 'Startup Profile', path: '/startups/:slug', description: 'Individual startup page (e.g., QuantumLeap Innovations)' },
        { name: 'Apply Now', path: '/startups/apply', description: 'Application to join ecosystem', dataCollection: true },
      ]
    },
    projects: {
      name: 'Projects',
      path: '/projects',
      icon: '🗺️',
      description: 'Interactive project map with filtering',
      navType: 'platform',
      sections: [
        'Full-page interactive world map with project markers',
        'Find Projects search bar',
        'Region filter (All, North America, Europe, Asia, South America, Africa)',
        'Partners filter (IBM, Microsoft, Siemens, EDF, Philips, etc.)',
        'Case Studies filter tags',
        'Filtered Results sidebar with project cards'
      ],
      children: [
        { name: 'Map View', path: '/projects', description: 'Interactive map with project locations' },
        { name: 'Project Detail', path: '/projects/:slug', description: 'Individual project page' },
      ]
    },
    casestudies: {
      name: 'Case Studies',
      path: '/casestudies',
      icon: '📈',
      description: 'Success stories with category filtering',
      navType: 'platform',
      sections: [
        'Featured Case Study hero (Klinik: Digital Transformation)',
        'Key metrics: +30% Patient Satisfaction, +20% Efficiency, +15% Market Reach',
        'Explore Our Success Stories section',
        'Category filters: All, Technology, Healthcare, Finance, Education, Automotive, Energy',
        'Case study cards grid (6 cards shown)'
      ],
      children: [
        { name: 'Gallery', path: '/casestudies', description: 'Filterable case study collection' },
        { name: 'Case Study Detail', path: '/casestudies/:slug', description: 'In-depth success story' },
      ]
    },
    services: {
      name: 'Services',
      path: '/services',
      icon: '💼',
      description: 'Platform services - Strategy, Design, Development',
      navType: 'platform',
      sections: [
        'Hero: "Innovate, Design, Develop: Our Integrated Services"',
        'Our Core Competencies (Strategic Consultation, UX Design, Full-Stack Development, Digital Transformation)',
        'Tailored Solutions: Kijani.co Plans pricing',
        'Basic Support ($99/month), Premium Partnership ($299/month), Enterprise Solutions (Custom)',
        'Building for a Customised Dataroom section',
        'FAQ accordion section'
      ],
      children: [
        { name: 'Strategy', path: '/services/strategy', description: 'Strategic consultation services' },
        { name: 'Design', path: '/services/design', description: 'UX/UI design services' },
        { name: 'Development', path: '/services/development', description: 'Full-stack development' },
        { name: 'Consulting', path: '/services/consulting', description: 'Digital transformation consulting' },
      ]
    },
    media: {
      name: 'Media',
      path: '/media',
      icon: '📰',
      description: 'Articles, news, and insights',
      navType: 'platform',
      sections: [
        'Article listing with featured image',
        'Recent Articles sidebar',
        'Stay Updated newsletter signup'
      ],
      children: [
        { name: 'Articles', path: '/media', description: 'Blog and article listing' },
        { name: 'Article Detail', path: '/media/:slug', description: 'Individual article page (dark theme)' },
      ]
    },
  };

  // Legal/Partners Navigation Pages
  const legalSitemap = {
    legalhealthcheck: {
      name: 'Legal Health Check',
      path: '/legalhealthcheck',
      icon: '📊',
      description: 'Legal health assessment system',
      navType: 'legal',
      highlight: true,
      dataCollection: true,
      children: [
        { name: 'Landing', path: '/legalhealthcheck', description: 'Overview: "What is a Legal Health Check?"' },
        { name: 'Assessment', path: '/legalhealthcheck/assess', description: '7-step assessment form', dataCollection: true, highlight: true },
        { name: 'Results', path: '/legalhealthcheck/results/:id', description: 'Health Score & recommendations' },
        { name: 'Dashboard', path: '/legalhealthcheck/dashboard', description: 'Private dashboard (Auth required)', auth: true },
        { name: 'FAQ', path: '/legalhealthcheck/faq', description: 'Frequently Asked Questions' },
      ]
    },
    partners: {
      name: 'Partners',
      path: '/partners',
      icon: '🤝',
      description: 'Partner ecosystem and IBM services',
      navType: 'legal',
      children: [
        { name: 'Partner Ecosystem', path: '/partners', description: 'Featured partners & categories' },
        { name: 'OW Advocates', path: '/partners/ow-advocates', description: 'Legal partner profile' },
        { name: 'IBM Partnership', path: '/partners/ibm', description: 'IBM partnership overview' },
        { name: 'IBM Services', path: '/partners/ibm/services', description: 'IBM service offerings' },
        { name: 'Become a Partner', path: '/partners/become-partner', description: 'Partnership application form', dataCollection: true },
      ]
    },
    aikyaServices: {
      name: 'Services (Aikya)',
      path: '/services/aikya',
      icon: '⚖️',
      description: 'Aikya Legal service tiers',
      navType: 'legal',
      children: [
        { name: 'Aikya Hustle', path: '/services/aikya/hustle', description: 'Founder Tier - KSh 25,000/month', highlight: true },
        { name: 'Growth Tier', path: '/services/aikya/growth', description: 'Scaling startups - KSh 50,000/month' },
        { name: 'Lead Enterprise', path: '/services/aikya/lead', description: 'Enterprise - KSh 150,000/month' },
      ]
    },
    faq: {
      name: 'FAQ',
      path: '/faq',
      icon: '❓',
      description: 'Frequently Asked Questions',
      navType: 'legal',
      children: []
    },
  };

  // Assessment Steps (from Health_Check_Assessment.png)
  const assessmentSteps = [
    { step: 1, name: 'Company Information', fields: ['Company Name', 'Industry', 'Country of Operation', 'Number of Employees', 'Company Registration Number'] },
    { step: 2, name: 'Corporate Structure', fields: ['Registration status', 'Shareholders agreement', 'Board governance'] },
    { step: 3, name: 'Employment & HR', fields: ['Employment contracts', 'Policies', 'ESOP status'] },
    { step: 4, name: 'Data Protection', fields: ['Privacy policies', 'Data handling', 'Compliance'] },
    { step: 5, name: 'Intellectual Property', fields: ['Trademarks', 'Patents', 'IP assignments'] },
    { step: 6, name: 'Tax & Compliance', fields: ['Tax registration', 'Regulatory licenses', 'Compliance status'] },
    { step: 7, name: 'Review & Submit', fields: ['Summary review', 'Submission'] },
  ];

  // Health Results Categories (from Health_Check_Results.png)
  const healthCategories = [
    { name: 'Corporate Structure', status: 'Good', color: 'green' },
    { name: 'Employment & HR', status: 'Moderate Risk', color: 'yellow' },
    { name: 'Data Protection', status: 'Good', color: 'green' },
    { name: 'Intellectual Property', status: 'Moderate Risk', color: 'yellow' },
    { name: 'Contracts & Agreements', status: 'Good', color: 'green' },
    { name: 'Regulatory Compliance', status: 'High Risk', color: 'red' },
  ];

  // Featured Partners (from Partner_Ecosystem.png)
  const featuredPartners = [
    { name: 'OW Advocates', type: 'Legal Services' },
    { name: 'IBM Business Partner', type: 'Technology' },
    { name: 'JHUB', type: 'Startup Ecosystem' },
    { name: 'Power Learn Project', type: 'Education' },
    { name: 'JuaFlow by Phindor', type: 'Cybersecurity' },
    { name: 'Watu Wa Gaming', type: 'FinTech' },
  ];

  // Partner Categories (from Partner_Ecosystem.png)
  const partnerCategories = [
    'Legal Services',
    'Technology Providers',
    'Consulting & Advisory',
    'Startup Ecosystem',
    'Cybersecurity & Data',
    'Integrations',
  ];

  // IBM Services (from IBM_Services_Overview.png)
  const ibmServices = [
    { name: 'Cloud Solutions', description: 'Scalable, secure, and flexible cloud infrastructure powered by IBM' },
    { name: 'AI & Machine Learning', description: 'Leverage IBM Watson for advanced AI capabilities and intelligent insights' },
    { name: 'Security Services', description: 'Comprehensive cybersecurity solutions and advanced threat detection' },
    { name: 'Automation & Integration', description: 'Streamline operations with intelligent automation tools' },
    { name: 'Industry Solutions', description: 'Tailored IBM solutions for specific industry challenges' },
    { name: 'Licensing & Compliance', description: 'Expert guidance on IBM software licensing and compliance' },
    { name: 'Implementation & Support', description: 'End-to-end implementation and ongoing technical support' },
    { name: 'Data & Analytics', description: 'Transform raw data into actionable insights with IBM analytics' },
  ];

  // Aikya Pricing Tiers (from Aikya_Hustle_Plan.png)
  const aikyaTiers = [
    {
      name: 'Aikya Hustle',
      price: 'KSh 25,000',
      period: '/month',
      description: 'Ideal for early-stage founders seeking foundational legal support',
      features: [
        'Legal strategy & roadmap',
        'Contract drafting (up to 5/month)',
        'IP protection guidance',
        'Regulatory compliance check',
        'Access to legal templates',
        'Monthly founder check-in (1 hr)',
        'Dedicated legal advisor (email support)',
        'Startup specific legal advice'
      ],
      recommended: false
    },
    {
      name: 'Growth Tier',
      price: 'KSh 50,000',
      period: '/month',
      description: 'Designed for scaling startups needing comprehensive legal coverage',
      features: [
        'All Founder Tier benefits',
        'Advanced contract negotiation (up to 10/month)',
        'Data privacy policy drafting',
        'HR & employment legal support',
        'Investor legal support',
        'Quarterly strategic review (2 hrs)',
        'Priority email & phone support',
        'M&A preparation guidance'
      ],
      recommended: true
    },
    {
      name: 'Lead Enterprise Tier',
      price: 'KSh 150,000',
      period: '/month',
      description: 'For established businesses requiring extensive legal services',
      features: [
        'All Growth Tier benefits',
        'Unlimited contract drafting & review',
        'M&A legal advisory',
        'Complex litigation support',
        'Global compliance management',
        'Dedicated legal team',
        '24/7 priority support',
        'On-site legal workshops'
      ],
      recommended: false
    },
  ];

  const authPages = [
    { name: 'Private Dashboard', path: '/legalhealthcheck/dashboard', icon: '📊', description: 'Startup legal health dashboard with score tracking' },
    { name: 'Admin Portal', path: '/admin', icon: '⚙️', description: 'MC Studio admin management' },
  ];

  const utilityPages = [
    { name: 'About Us', path: '/about', icon: '📖' },
    { name: 'Contact', path: '/contact', icon: '✉️', dataCollection: true },
    { name: 'Careers', path: '/careers', icon: '👥' },
    { name: 'Privacy Policy', path: '/legal/privacy', icon: '🔒' },
    { name: 'Terms of Service', path: '/legal/terms', icon: '📜' },
    { name: 'Cookie Policy', path: '/legal/cookies', icon: '🍪' },
  ];

  const footerStructure = {
    platform: {
      columns: [
        { title: 'Company', links: ['About Us', 'Careers', 'Partners', 'Blog'] },
        { title: 'Services', links: ['Strategy', 'Design', 'Development', 'Consulting'] },
        { title: 'Resources', links: ['Case Studies', 'Projects', 'Startups', 'IBM Products'] },
        { title: 'Legal', links: ['Privacy Policy', 'Terms of Service', 'Cookie Policy', 'Admin Portal', 'Dashboard'] },
      ]
    },
    legal: {
      columns: [
        { title: 'Company', links: ['About Us', 'Contact', 'Careers'] },
        { title: 'Legal & Services', links: ['Legal Health Check', 'Partners', 'Services', 'Privacy Policy', 'Terms of Service'] },
      ]
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 p-6">
      <div className="max-w-7xl mx-auto">
        {/* Header */}
        <div className="text-center mb-8">
          <h1 className="text-4xl font-bold text-white mb-2">
            modus chora studio
          </h1>
          <p className="text-xl text-blue-200">Website Sitemap & Information Architecture v3.0</p>
          <div className="mt-4 flex justify-center gap-4 flex-wrap">
            <span className="bg-blue-600 text-white px-4 py-1 rounded-full text-sm">
              studiomoduschora.com
            </span>
            <span className="bg-blue-500 text-white px-4 py-1 rounded-full text-sm flex items-center gap-1">
              🔷 IBM Business Partner
            </span>
            <span className="bg-emerald-600 text-white px-4 py-1 rounded-full text-sm flex items-center gap-1">
              ⚖️ OW Advocates Partner
            </span>
          </div>
        </div>

        {/* Navigation Structures */}
        <div className="bg-white/10 backdrop-blur rounded-xl p-6 mb-6">
          <h2 className="text-xl font-bold text-white mb-4">🧭 Dual Navigation Structure</h2>
          <div className="grid md:grid-cols-2 gap-6">
            {Object.entries(navigationStructures).map(([key, nav]) => (
              <div 
                key={key}
                onClick={() => setActiveNav(key)}
                className={`p-4 rounded-lg cursor-pointer transition-all ${
                  activeNav === key 
                    ? 'bg-blue-600 ring-2 ring-blue-300' 
                    : 'bg-white/10 hover:bg-white/20'
                }`}
              >
                <h3 className="text-lg font-bold text-white mb-2">{nav.name}</h3>
                <p className="text-blue-200 text-sm mb-3">{nav.description}</p>
                <div className="flex flex-wrap gap-2 mb-2">
                  {nav.items.map((item, idx) => (
                    <span key={idx} className="bg-white/20 px-3 py-1 rounded text-white text-sm">
                      {item}
                    </span>
                  ))}
                </div>
                <div className="text-xs text-blue-300 mt-2">CTA Button: {nav.cta}</div>
              </div>
            ))}
          </div>
        </div>

        {/* Platform Pages */}
        <div className="bg-white rounded-xl shadow-2xl p-6 mb-6">
          <h2 className="text-2xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            🌐 Platform Navigation Pages
          </h2>
          <p className="text-gray-600 mb-6">Main website with Home, Startups, Projects, Case Studies, Services, Media</p>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {Object.entries(platformSitemap).map(([key, section]) => (
              <div 
                key={key}
                className="border-2 border-gray-200 rounded-xl overflow-hidden hover:border-blue-300 transition-all"
              >
                <button
                  onClick={() => toggleSection(key)}
                  className="w-full p-4 text-left flex items-center justify-between bg-gray-50"
                >
                  <div className="flex items-center gap-3">
                    <span className="text-2xl">{section.icon}</span>
                    <div>
                      <div className="font-bold text-gray-800">{section.name}</div>
                      <div className="text-sm text-gray-500">{section.path}</div>
                    </div>
                  </div>
                  <span className="text-gray-400">
                    {expandedSections.includes(key) ? '▼' : '▶'}
                  </span>
                </button>
                
                {expandedSections.includes(key) && (
                  <div className="p-4 bg-white border-t">
                    <p className="text-sm text-gray-600 mb-3">{section.description}</p>
                    {section.sections && (
                      <div className="mb-3">
                        <div className="text-xs font-semibold text-gray-500 mb-2">PAGE SECTIONS:</div>
                        <ul className="text-xs text-gray-600 space-y-1">
                          {section.sections.map((s, idx) => (
                            <li key={idx} className="flex items-start gap-1">
                              <span className="text-blue-500">•</span> {s}
                            </li>
                          ))}
                        </ul>
                      </div>
                    )}
                    {section.children.length > 0 && (
                      <div className="space-y-2">
                        <div className="text-xs font-semibold text-gray-500">CHILD PAGES:</div>
                        {section.children.map((child, idx) => (
                          <div 
                            key={idx}
                            className="flex items-center justify-between p-2 rounded text-sm bg-gray-50"
                          >
                            <div>
                              <span className="font-medium text-gray-700">{child.name}</span>
                              <span className="text-gray-400 ml-2 text-xs">{child.path}</span>
                            </div>
                            {child.dataCollection && (
                              <span className="w-2 h-2 bg-green-500 rounded-full" title="Collects Data"></span>
                            )}
                          </div>
                        ))}
                      </div>
                    )}
                  </div>
                )}
              </div>
            ))}
          </div>
        </div>

        {/* Legal/Partners Pages */}
        <div className="bg-white rounded-xl shadow-2xl p-6 mb-6">
          <h2 className="text-2xl font-bold text-gray-800 mb-2 flex items-center gap-2">
            ⚖️ Legal & Partners Navigation Pages
          </h2>
          <p className="text-gray-600 mb-6">Legal Health Check, Partners, Aikya Services, FAQ</p>
          
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            {Object.entries(legalSitemap).map(([key, section]) => (
              <div 
                key={key}
                className={`border-2 rounded-xl overflow-hidden transition-all ${
                  section.highlight 
                    ? 'border-blue-500 bg-blue-50' 
                    : 'border-gray-200 hover:border-blue-300'
                }`}
              >
                <button
                  onClick={() => toggleSection(key)}
                  className={`w-full p-4 text-left flex items-center justify-between ${
                    section.highlight ? 'bg-blue-100' : 'bg-gray-50'
                  }`}
                >
                  <div className="flex items-center gap-3">
                    <span className="text-2xl">{section.icon}</span>
                    <div>
                      <div className="font-bold text-gray-800">{section.name}</div>
                      <div className="text-sm text-gray-500">{section.path}</div>
                    </div>
                  </div>
                  <div className="flex items-center gap-2">
                    {section.dataCollection && (
                      <span className="w-3 h-3 bg-green-500 rounded-full" title="Data Collection"></span>
                    )}
                    <span className="text-gray-400">
                      {expandedSections.includes(key) ? '▼' : '▶'}
                    </span>
                  </div>
                </button>
                
                {expandedSections.includes(key) && (
                  <div className="p-4 bg-white border-t">
                    <p className="text-sm text-gray-600 mb-3">{section.description}</p>
                    {section.children.length > 0 && (
                      <div className="space-y-2">
                        {section.children.map((child, idx) => (
                          <div 
                            key={idx}
                            className={`flex items-center justify-between p-2 rounded text-sm ${
                              child.highlight ? 'bg-blue-100' : 'bg-gray-50'
                            }`}
                          >
                            <div>
                              <span className="font-medium text-gray-700">{child.name}</span>
                              <span className="text-gray-400 ml-2 text-xs">{child.path}</span>
                            </div>
                            <div className="flex items-center gap-2">
                              {child.auth && (
                                <span className="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded">Auth</span>
                              )}
                              {child.dataCollection && (
                                <span className="w-2 h-2 bg-green-500 rounded-full" title="Collects Data"></span>
                              )}
                            </div>
                          </div>
                        ))}
                      </div>
                    )}
                  </div>
                )}
              </div>
            ))}
          </div>
        </div>

        {/* Assessment Flow */}
        <div className="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-6 mb-6 shadow-xl">
          <h2 className="text-2xl font-bold text-white mb-4">📋 Legal Health Check Assessment Flow</h2>
          <div className="flex flex-wrap gap-2 items-center justify-center mb-4">
            {assessmentSteps.map((step, idx) => (
              <React.Fragment key={step.step}>
                <div className={`px-4 py-2 rounded-lg text-sm ${
                  step.step === 1 ? 'bg-white text-blue-800 font-bold' : 'bg-white/20 text-white'
                }`}>
                  <span className="font-bold">{step.step}.</span> {step.name}
                </div>
                {idx < assessmentSteps.length - 1 && (
                  <span className="text-white/50">→</span>
                )}
              </React.Fragment>
            ))}
          </div>
        </div>

        {/* Health Results */}
        <div className="bg-white rounded-xl shadow-lg p-6 mb-6">
          <h3 className="text-xl font-bold text-gray-800 mb-4">📊 Health Check Results Page Structure</h3>
          <div className="grid md:grid-cols-2 gap-6">
            <div>
              <div className="text-6xl font-bold text-blue-600 mb-2">82</div>
              <div className="text-gray-600 mb-4">Legal Health Score (Example)</div>
              <div className="space-y-2">
                {healthCategories.map((cat, idx) => (
                  <div key={idx} className="flex items-center justify-between p-2 bg-gray-50 rounded">
                    <span className="text-sm font-medium">{cat.name}</span>
                    <span className={`text-xs px-2 py-1 rounded ${
                      cat.color === 'green' ? 'bg-green-100 text-green-800' :
                      cat.color === 'yellow' ? 'bg-yellow-100 text-yellow-800' :
                      'bg-red-100 text-red-800'
                    }`}>
                      {cat.status}
                    </span>
                  </div>
                ))}
              </div>
            </div>
            <div>
              <h4 className="font-semibold text-gray-800 mb-3">Priority Actions for Improvement</h4>
              <ul className="space-y-2 text-sm">
                <li className="p-2 bg-gray-50 rounded flex justify-between">
                  <span>Update Employment Contracts</span>
                  <span className="text-blue-600 text-xs">Review Templates →</span>
                </li>
                <li className="p-2 bg-gray-50 rounded flex justify-between">
                  <span>Conduct IP Audit for Global Markets</span>
                  <span className="text-blue-600 text-xs">Start Audit →</span>
                </li>
                <li className="p-2 bg-gray-50 rounded flex justify-between">
                  <span>Consult on Regulatory Changes</span>
                  <span className="text-blue-600 text-xs">Book Consultation →</span>
                </li>
              </ul>
              <div className="mt-4 p-4 bg-blue-50 rounded-lg">
                <div className="text-sm text-gray-600">Recommended Tier:</div>
                <div className="text-xl font-bold text-blue-800">Aikya Growth Tier</div>
              </div>
            </div>
          </div>
        </div>

        {/* Aikya Pricing Tiers */}
        <div className="bg-white rounded-xl shadow-lg p-6 mb-6">
          <h3 className="text-xl font-bold text-gray-800 mb-4">💰 Aikya Legal Service Tiers</h3>
          <div className="grid md:grid-cols-3 gap-4">
            {aikyaTiers.map((tier, idx) => (
              <div key={idx} className={`border-2 rounded-xl p-4 ${
                tier.recommended ? 'border-blue-500 bg-blue-50' : 'border-gray-200'
              }`}>
                {tier.recommended && (
                  <span className="bg-blue-600 text-white text-xs px-2 py-1 rounded mb-2 inline-block">Recommended</span>
                )}
                <h4 className="text-lg font-bold text-gray-800">{tier.name}</h4>
                <div className="text-2xl font-bold text-blue-600 my-2">
                  {tier.price}<span className="text-sm text-gray-500">{tier.period}</span>
                </div>
                <p className="text-sm text-gray-600 mb-3">{tier.description}</p>
                <ul className="text-xs space-y-1">
                  {tier.features.slice(0, 5).map((f, i) => (
                    <li key={i} className="flex items-center gap-1">
                      <span className="text-blue-500">✓</span> {f}
                    </li>
                  ))}
                </ul>
              </div>
            ))}
          </div>
        </div>

        {/* IBM Services */}
        <div className="bg-gradient-to-r from-slate-800 to-slate-900 rounded-xl p-6 mb-6">
          <h3 className="text-xl font-bold text-white mb-4 flex items-center gap-2">
            🔷 IBM Services Overview (/partners/ibm/services)
          </h3>
          <div className="grid md:grid-cols-4 gap-4">
            {ibmServices.map((service, idx) => (
              <div key={idx} className="bg-white/10 backdrop-blur rounded-lg p-4">
                <div className="text-white font-semibold mb-2">{service.name}</div>
                <div className="text-blue-200 text-xs">{service.description}</div>
              </div>
            ))}
          </div>
        </div>

        {/* Partner Ecosystem */}
        <div className="bg-white rounded-xl shadow-lg p-6 mb-6">
          <h3 className="text-xl font-bold text-gray-800 mb-4">🤝 Partner Ecosystem Page Structure</h3>
          <div className="grid md:grid-cols-2 gap-6">
            <div>
              <h4 className="font-semibold text-gray-700 mb-3">Featured Partners</h4>
              <div className="grid grid-cols-3 gap-2">
                {featuredPartners.map((p, idx) => (
                  <div key={idx} className="p-2 bg-gray-50 rounded text-center">
                    <div className="font-medium text-sm">{p.name}</div>
                    <div className="text-xs text-gray-500">{p.type}</div>
                  </div>
                ))}
              </div>
            </div>
            <div>
              <h4 className="font-semibold text-gray-700 mb-3">Partner Categories</h4>
              <div className="flex flex-wrap gap-2">
                {partnerCategories.map((cat, idx) => (
                  <span key={idx} className="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg text-sm">
                    {cat}
                  </span>
                ))}
              </div>
            </div>
          </div>
        </div>

        {/* Dashboard Structure */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div className="bg-white rounded-xl shadow-lg p-6">
            <h3 className="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
              🔐 Private Dashboard (/legalhealthcheck/dashboard)
            </h3>
            <div className="space-y-3">
              <div className="p-3 bg-blue-50 rounded-lg">
                <div className="font-medium">Current Legal Health Score</div>
                <div className="text-xs text-gray-500">Score with "Excellent" badge</div>
              </div>
              <div className="p-3 bg-gray-50 rounded-lg">
                <div className="font-medium">Historical Assessments</div>
                <div className="text-xs text-gray-500">Line chart tracking score over time</div>
              </div>
              <div className="p-3 bg-gray-50 rounded-lg">
                <div className="font-medium">Action Item Checklist</div>
                <div className="text-xs text-gray-500">Pending legal tasks with checkboxes</div>
              </div>
              <div className="p-3 bg-gray-50 rounded-lg">
                <div className="font-medium">Progress Tracking</div>
                <div className="text-xs text-gray-500">Timeline of completed milestones</div>
              </div>
              <div className="p-3 bg-gray-50 rounded-lg">
                <div className="font-medium">Document Vault</div>
                <div className="text-xs text-gray-500">Secure document storage with download</div>
              </div>
            </div>
          </div>

          <div className="bg-white rounded-xl shadow-lg p-6">
            <h3 className="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
              🔧 Utility & Footer Pages
            </h3>
            <div className="grid grid-cols-2 gap-3">
              {utilityPages.map((page, idx) => (
                <div key={idx} className="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                  <span>{page.icon}</span>
                  <div>
                    <div className="font-medium text-gray-700 text-sm">{page.name}</div>
                    <div className="text-xs text-gray-400">{page.path}</div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>

        {/* User Journeys */}
        <div className="bg-white rounded-xl shadow-lg p-6 mb-6">
          <h3 className="text-xl font-bold text-gray-800 mb-4">🔄 Primary User Journeys</h3>
          <div className="space-y-4">
            <div className="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg">
              <div className="font-semibold text-blue-800 mb-2">Journey 1: Startup Legal Health Check</div>
              <div className="flex flex-wrap items-center gap-2 text-sm">
                <span className="bg-white px-3 py-1 rounded shadow">Home/Partners</span>
                <span className="text-blue-400">→</span>
                <span className="bg-blue-100 px-3 py-1 rounded shadow">Legal Health Check</span>
                <span className="text-blue-400">→</span>
                <span className="bg-blue-200 px-3 py-1 rounded shadow font-semibold">7-Step Assessment</span>
                <span className="text-blue-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Results Page</span>
                <span className="text-blue-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Aikya Tier Selection</span>
                <span className="text-blue-400">→</span>
                <span className="bg-blue-100 px-3 py-1 rounded shadow">Private Dashboard</span>
              </div>
            </div>
            
            <div className="p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg">
              <div className="font-semibold text-emerald-800 mb-2">Journey 2: Partner Exploration</div>
              <div className="flex flex-wrap items-center gap-2 text-sm">
                <span className="bg-white px-3 py-1 rounded shadow">Partners</span>
                <span className="text-emerald-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Partner Ecosystem</span>
                <span className="text-emerald-400">→</span>
                <span className="bg-emerald-100 px-3 py-1 rounded shadow">OW Advocates / IBM</span>
                <span className="text-emerald-400">→</span>
                <span className="bg-emerald-200 px-3 py-1 rounded shadow font-semibold">Become a Partner Form</span>
              </div>
            </div>

            <div className="p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg">
              <div className="font-semibold text-purple-800 mb-2">Journey 3: Startup Discovery</div>
              <div className="flex flex-wrap items-center gap-2 text-sm">
                <span className="bg-white px-3 py-1 rounded shadow">Home</span>
                <span className="text-purple-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Startups Directory</span>
                <span className="text-purple-400">→</span>
                <span className="bg-purple-100 px-3 py-1 rounded shadow">Filter/Search</span>
                <span className="text-purple-400">→</span>
                <span className="bg-purple-200 px-3 py-1 rounded shadow font-semibold">Startup Profile</span>
                <span className="text-purple-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Case Studies</span>
              </div>
            </div>

            <div className="p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg">
              <div className="font-semibold text-amber-800 mb-2">Journey 4: Project Exploration</div>
              <div className="flex flex-wrap items-center gap-2 text-sm">
                <span className="bg-white px-3 py-1 rounded shadow">Home</span>
                <span className="text-amber-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Projects Map</span>
                <span className="text-amber-400">→</span>
                <span className="bg-amber-100 px-3 py-1 rounded shadow">Filter by Region/Partner</span>
                <span className="text-amber-400">→</span>
                <span className="bg-amber-200 px-3 py-1 rounded shadow font-semibold">Project Detail</span>
                <span className="text-amber-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Contact Us</span>
              </div>
            </div>
          </div>
        </div>

        {/* Implementation Priority */}
        <div className="bg-white rounded-xl shadow-lg p-6">
          <h3 className="text-xl font-bold text-gray-800 mb-4">📅 Implementation Priority</h3>
          <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div className="p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
              <div className="font-bold text-red-800">Phase 1</div>
              <div className="text-sm text-red-600 mb-2">Month 1</div>
              <ul className="text-sm text-gray-700 space-y-1">
                <li>• Home page</li>
                <li>• Legal Health Check flow</li>
                <li>• Results page</li>
                <li>• Aikya pricing page</li>
              </ul>
            </div>
            <div className="p-4 bg-amber-50 rounded-lg border-l-4 border-amber-500">
              <div className="font-bold text-amber-800">Phase 2</div>
              <div className="text-sm text-amber-600 mb-2">Month 2</div>
              <ul className="text-sm text-gray-700 space-y-1">
                <li>• Partner ecosystem</li>
                <li>• OW Advocates profile</li>
                <li>• IBM partnership pages</li>
                <li>• Become a Partner form</li>
              </ul>
            </div>
            <div className="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
              <div className="font-bold text-blue-800">Phase 3</div>
              <div className="text-sm text-blue-600 mb-2">Month 3</div>
              <ul className="text-sm text-gray-700 space-y-1">
                <li>• Startups directory</li>
                <li>• Startup profiles</li>
                <li>• Projects map</li>
                <li>• Case studies</li>
              </ul>
            </div>
            <div className="p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
              <div className="font-bold text-green-800">Phase 4</div>
              <div className="text-sm text-green-600 mb-2">Month 4+</div>
              <ul className="text-sm text-gray-700 space-y-1">
                <li>• Private dashboard</li>
                <li>• Media/Articles</li>
                <li>• Platform services</li>
                <li>• Admin portal</li>
              </ul>
            </div>
          </div>
        </div>

        {/* Footer */}
        <div className="text-center mt-8 text-blue-200">
          <p className="font-semibold">modus chora studio</p>
          <p className="text-sm opacity-75">Sitemap v3.0 | January 2026 | Based on Visily Wireframes</p>
          <p className="text-xs opacity-50 mt-1">© 2026 Modus Chora Studio x OW Advocates. All rights reserved.</p>
        </div>
      </div>
    </div>
  );
};

export default SitemapVisualization;
