import React, { useState } from 'react';

const SitemapVisualization = () => {
  const [expandedSections, setExpandedSections] = useState(['home', 'startups', 'legalhealthcheck', 'ibmProducts']);

  const toggleSection = (section) => {
    setExpandedSections(prev => 
      prev.includes(section) 
        ? prev.filter(s => s !== section)
        : [...prev, section]
    );
  };

  const sitemap = {
    home: {
      name: 'Home',
      path: '/',
      icon: '🏠',
      description: 'Primary landing page with ecosystem overview',
      dataCollection: false,
      children: []
    },
    startups: {
      name: 'Startups',
      path: '/startups',
      icon: '🚀',
      description: 'Portfolio directory with health labels',
      dataCollection: true,
      children: [
        { name: 'Directory', path: '/startups', description: 'Searchable startup grid with health scores' },
        { name: 'Profile', path: '/startups/:slug', description: 'Individual startup with health dashboard' },
        { name: 'Apply', path: '/startups/apply', description: 'Join ecosystem application', dataCollection: true },
      ]
    },
    legalhealthcheck: {
      name: 'Health Check',
      path: '/legalhealthcheck',
      icon: '📊',
      description: 'Legal health assessment & scoring system',
      dataCollection: true,
      highlight: true,
      children: [
        { name: 'Landing', path: '/legalhealthcheck', description: 'Overview and benefits' },
        { name: 'Assessment', path: '/legalhealthcheck/assess', description: 'Multi-step health questionnaire', dataCollection: true, highlight: true },
        { name: 'Results', path: '/legalhealthcheck/results/:id', description: 'Personalized score & recommendations' },
        { name: 'Dashboard', path: '/legalhealthcheck/dashboard', description: 'Startup private dashboard (Auth)', auth: true },
      ]
    },
    partners: {
      name: 'Partners',
      path: '/partners',
      icon: '🤝',
      description: 'Strategic partner ecosystem',
      dataCollection: false,
      children: [
        { name: 'OW Advocates', path: '/partners/okutta-wairi', description: 'Legal partner profile' },
        { name: 'IBM BP Overview', path: '/partners/ibmbp', description: 'IBM partnership overview' },
        { name: 'Investors', path: '/partners/investors', description: 'Investment opportunities' },
        { name: 'Become Partner', path: '/partners/become-partner', description: 'Partnership application', dataCollection: true },
      ]
    },
    services: {
      name: 'Services',
      path: '/services',
      icon: '💼',
      description: 'Aikya Legal & QA services',
      dataCollection: false,
      children: [
        { name: 'Legal Overview', path: '/services/legal', description: 'Aikya Legal framework' },
        { name: 'Hustle Tier', path: '/services/legal/hustle', description: 'KSh 25,000/mo - Founders' },
        { name: 'Grow Tier', path: '/services/legal/grow', description: 'KSh 50,000/mo - Scaling' },
        { name: 'Lead Tier', path: '/services/legal/lead', description: 'KSh 150,000/mo - Leaders' },
        { name: 'QA Services', path: '/services/qa', description: 'IBM-standard QA' },
        { name: 'Sectors', path: '/services/sectors', description: 'FTX, HTX, ETX, ATX, REC, ENM' },
      ]
    },
    ibmProducts: {
      name: 'IBM Products',
      path: '/ibm-products',
      icon: '🔷',
      description: 'Authorized IBM products & resale',
      dataCollection: true,
      highlight: true,
      isNew: true,
      children: [
        { name: 'Cloud Solutions', path: '/ibm-products/cloud', description: 'IBM Cloud, Cloud Pak, OpenShift' },
        { name: 'AI & Data', path: '/ibm-products/ai', description: 'watsonx, Watson Services, Cognos, SPSS' },
        { name: 'Security', path: '/ibm-products/security', description: 'QRadar, Guardium, Verify' },
        { name: 'Automation', path: '/ibm-products/automation', description: 'RPA, App Connect, MQ' },
        { name: 'Industry Solutions', path: '/ibm-products/industry', description: 'FinServ, Healthcare, Retail, IoT' },
        { name: 'Licensing', path: '/ibm-products/licensing', description: 'Software licensing options' },
        { name: 'Services', path: '/ibm-products/services', description: 'Implementation & support' },
        { name: 'Startup Program', path: '/ibm-products/startup-program', description: 'IBM for Startups benefits' },
        { name: 'Request Quote', path: '/ibm-products/quote', description: 'Get pricing', dataCollection: true, highlight: true },
      ]
    },
    projects: {
      name: 'Projects',
      path: '/projects',
      icon: '📁',
      description: 'Portfolio of work across sectors',
      dataCollection: false,
      children: [
        { name: 'Portfolio', path: '/projects', description: 'Filterable project grid' },
        { name: 'Project Detail', path: '/projects/:slug', description: 'Individual project page' },
      ]
    },
    casestudies: {
      name: 'Case Studies',
      path: '/casestudies',
      icon: '📈',
      description: 'Success stories & impact',
      dataCollection: false,
      children: [
        { name: 'Gallery', path: '/casestudies', description: 'Case study collection' },
        { name: 'Detail', path: '/casestudies/:slug', description: 'In-depth success story' },
      ]
    },
    media: {
      name: 'Media',
      path: '/media',
      icon: '📰',
      description: 'News, events & resources',
      dataCollection: false,
      children: [
        { name: 'News', path: '/media/news', description: 'Press & announcements' },
        { name: 'Events', path: '/media/events', description: 'Calendar & registration', dataCollection: true },
        { name: 'Blog', path: '/media/blog', description: 'Thought leadership' },
        { name: 'Resources', path: '/media/resources', description: 'Templates & guides' },
      ]
    },
    games: {
      name: 'Games',
      path: '/games',
      icon: '🎮',
      description: 'Interactive learning tools',
      dataCollection: false,
      children: [
        { name: 'Compliance Quiz', path: '/games/compliance-quiz', description: 'Test your knowledge' },
        { name: 'Simulator', path: '/games/startup-simulator', description: 'Build a startup game' },
      ]
    },
    jobplacements: {
      name: 'Careers',
      path: '/jobplacements',
      icon: '👥',
      description: 'Job board & talent pool',
      dataCollection: true,
      children: [
        { name: 'Job Board', path: '/jobplacements', description: 'Search opportunities' },
        { name: 'Job Detail', path: '/jobplacements/:id', description: 'Apply to position' },
        { name: 'Post Job', path: '/jobplacements/post', description: 'For portfolio companies', dataCollection: true },
        { name: 'Talent Pool', path: '/jobplacements/talent-pool', description: 'Submit CV', dataCollection: true },
      ]
    }
  };

  const authPages = [
    { name: 'Startup Dashboard', path: '/dashboard', icon: '📊', description: 'Authenticated startup portal' },
    { name: 'Partner Portal', path: '/portal', icon: '🔐', description: 'Investor/partner access' },
    { name: 'Admin Panel', path: '/admin', icon: '⚙️', description: 'MC Studio management' },
  ];

  const utilityPages = [
    { name: 'About', path: '/about', icon: '📖' },
    { name: 'Contact', path: '/contact', icon: '✉️', dataCollection: true },
    { name: 'FAQ', path: '/faq', icon: '❓' },
    { name: 'Support', path: '/support', icon: '🆘' },
    { name: 'Terms', path: '/legal/terms', icon: '📜' },
    { name: 'Privacy', path: '/legal/privacy', icon: '🔒' },
  ];

  const healthScoreLabels = [
    { range: '85-100%', label: 'Investor Ready', color: '#10b981', badge: '🟢 Excellent' },
    { range: '70-84%', label: 'Growth Ready', color: '#f59e0b', badge: '🟡 Good' },
    { range: '50-69%', label: 'Developing', color: '#f97316', badge: '🟠 Developing' },
    { range: '0-49%', label: 'Foundation', color: '#ef4444', badge: '🔴 Needs Attention' },
  ];

  const ibmProductCategories = [
    { name: 'Cloud', icon: '☁️', products: ['IBM Cloud', 'Cloud Pak', 'Red Hat OpenShift'] },
    { name: 'AI & Data', icon: '🤖', products: ['watsonx', 'Watson Services', 'Cognos', 'SPSS'] },
    { name: 'Security', icon: '🛡️', products: ['QRadar', 'Guardium', 'Verify'] },
    { name: 'Automation', icon: '⚡', products: ['RPA', 'App Connect', 'MQ'] },
  ];

  return (
    <div className="min-h-screen bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 p-6">
      <div className="max-w-7xl mx-auto">
        {/* Header */}
        <div className="text-center mb-8">
          <h1 className="text-4xl font-bold text-white mb-2">
            MC Studio x OW Advocates
          </h1>
          <p className="text-xl text-purple-200">Website Sitemap & Information Architecture</p>
          <div className="mt-4 flex justify-center gap-4 flex-wrap">
            <span className="bg-purple-600 text-white px-4 py-1 rounded-full text-sm">
              studiomoduschora.com
            </span>
            <span className="bg-blue-600 text-white px-4 py-1 rounded-full text-sm flex items-center gap-1">
              🔷 IBM Business Partner
            </span>
            <span className="bg-green-600 text-white px-4 py-1 rounded-full text-sm flex items-center gap-1">
              <span className="w-2 h-2 bg-white rounded-full animate-pulse"></span>
              Data Collection Points
            </span>
          </div>
        </div>

        {/* IBM Products Highlight - NEW */}
        <div className="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-6 mb-6 shadow-xl">
          <div className="flex items-center gap-3 mb-4">
            <span className="text-3xl">🔷</span>
            <div>
              <h2 className="text-2xl font-bold text-white">IBM Products & Services</h2>
              <p className="text-blue-200">Authorized Reseller & Implementation Partner</p>
            </div>
            <span className="ml-auto bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-sm font-bold">NEW</span>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
            {ibmProductCategories.map((cat, idx) => (
              <div key={idx} className="bg-white/10 backdrop-blur rounded-lg p-4">
                <div className="text-2xl mb-2">{cat.icon}</div>
                <div className="text-white font-semibold mb-2">{cat.name}</div>
                <div className="text-blue-200 text-xs">
                  {cat.products.join(' • ')}
                </div>
              </div>
            ))}
          </div>
          <div className="mt-4 text-center">
            <span className="bg-white text-blue-800 px-6 py-2 rounded-full font-semibold text-sm">
              /ibm-products → Full product catalog with licensing & implementation services
            </span>
          </div>
        </div>

        {/* Health Score Labels */}
        <div className="bg-white/10 backdrop-blur rounded-xl p-6 mb-6">
          <h2 className="text-xl font-bold text-white mb-4">📊 Startup Health Labels</h2>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
            {healthScoreLabels.map((item, idx) => (
              <div key={idx} className="bg-white/10 rounded-lg p-4 text-center">
                <div className="text-2xl mb-2">{item.badge.split(' ')[0]}</div>
                <div className="text-white font-semibold">{item.label}</div>
                <div className="text-purple-200 text-sm">{item.range}</div>
              </div>
            ))}
          </div>
        </div>

        {/* Main Sitemap */}
        <div className="bg-white rounded-xl shadow-2xl p-6 mb-6">
          <h2 className="text-2xl font-bold text-gray-800 mb-6 pb-4 border-b-2 border-purple-500">
            📂 Primary Navigation Structure
          </h2>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {Object.entries(sitemap).map(([key, section]) => (
              <div 
                key={key}
                className={`border-2 rounded-xl overflow-hidden transition-all ${
                  section.highlight 
                    ? key === 'ibmProducts' 
                      ? 'border-blue-500 bg-blue-50' 
                      : 'border-purple-500 bg-purple-50'
                    : 'border-gray-200 hover:border-purple-300'
                }`}
              >
                <button
                  onClick={() => toggleSection(key)}
                  className={`w-full p-4 text-left flex items-center justify-between ${
                    section.highlight 
                      ? key === 'ibmProducts' 
                        ? 'bg-blue-100' 
                        : 'bg-purple-100'
                      : 'bg-gray-50'
                  }`}
                >
                  <div className="flex items-center gap-3">
                    <span className="text-2xl">{section.icon}</span>
                    <div>
                      <div className="font-bold text-gray-800 flex items-center gap-2">
                        {section.name}
                        {section.isNew && (
                          <span className="bg-yellow-400 text-yellow-900 px-2 py-0.5 rounded text-xs font-bold">NEW</span>
                        )}
                      </div>
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
                  <div className="p-4 bg-white">
                    <p className="text-sm text-gray-600 mb-3">{section.description}</p>
                    {section.children.length > 0 && (
                      <div className="space-y-2">
                        {section.children.map((child, idx) => (
                          <div 
                            key={idx}
                            className={`flex items-center justify-between p-2 rounded text-sm ${
                              child.highlight 
                                ? key === 'ibmProducts' 
                                  ? 'bg-blue-100' 
                                  : 'bg-purple-100'
                                : 'bg-gray-50'
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

        {/* Authenticated Areas */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div className="bg-white rounded-xl shadow-lg p-6">
            <h3 className="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
              🔐 Authenticated Dashboards
            </h3>
            <div className="space-y-3">
              {authPages.map((page, idx) => (
                <div key={idx} className="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                  <div className="flex items-center gap-3">
                    <span className="text-xl">{page.icon}</span>
                    <div>
                      <div className="font-semibold text-gray-800">{page.name}</div>
                      <div className="text-sm text-gray-500">{page.path}</div>
                    </div>
                  </div>
                  <span className="text-xs bg-blue-200 text-blue-800 px-2 py-1 rounded">Login Required</span>
                </div>
              ))}
            </div>
          </div>

          <div className="bg-white rounded-xl shadow-lg p-6">
            <h3 className="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
              🔧 Utility Pages
            </h3>
            <div className="grid grid-cols-2 gap-3">
              {utilityPages.map((page, idx) => (
                <div key={idx} className="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                  <span>{page.icon}</span>
                  <div>
                    <div className="font-medium text-gray-700 text-sm">{page.name}</div>
                    <div className="text-xs text-gray-400">{page.path}</div>
                  </div>
                  {page.dataCollection && (
                    <span className="w-2 h-2 bg-green-500 rounded-full ml-auto"></span>
                  )}
                </div>
              ))}
            </div>
          </div>
        </div>

        {/* Data Flow */}
        <div className="bg-white rounded-xl shadow-lg p-6 mb-6">
          <h3 className="text-xl font-bold text-gray-800 mb-4">🔄 Primary User Journeys</h3>
          <div className="space-y-4">
            <div className="p-4 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg">
              <div className="font-semibold text-purple-800 mb-2">Journey 1: New Startup Discovery</div>
              <div className="flex flex-wrap items-center gap-2 text-sm">
                <span className="bg-white px-3 py-1 rounded shadow">Home</span>
                <span className="text-purple-400">→</span>
                <span className="bg-purple-100 px-3 py-1 rounded shadow">Health Check</span>
                <span className="text-purple-400">→</span>
                <span className="bg-purple-200 px-3 py-1 rounded shadow font-semibold">Assessment</span>
                <span className="text-purple-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Results</span>
                <span className="text-purple-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Tier Selection</span>
                <span className="text-purple-400">→</span>
                <span className="bg-blue-100 px-3 py-1 rounded shadow">Dashboard</span>
              </div>
            </div>
            
            <div className="p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg">
              <div className="font-semibold text-blue-800 mb-2">Journey 2: IBM Product Purchase</div>
              <div className="flex flex-wrap items-center gap-2 text-sm">
                <span className="bg-white px-3 py-1 rounded shadow">Home</span>
                <span className="text-blue-400">→</span>
                <span className="bg-blue-100 px-3 py-1 rounded shadow">IBM Products</span>
                <span className="text-blue-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Product Category</span>
                <span className="text-blue-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Product Detail</span>
                <span className="text-blue-400">→</span>
                <span className="bg-blue-200 px-3 py-1 rounded shadow font-semibold">Request Quote</span>
                <span className="text-blue-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Purchase</span>
              </div>
            </div>

            <div className="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg">
              <div className="font-semibold text-green-800 mb-2">Journey 3: Investor Due Diligence</div>
              <div className="flex flex-wrap items-center gap-2 text-sm">
                <span className="bg-white px-3 py-1 rounded shadow">Home</span>
                <span className="text-green-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Partners/Investors</span>
                <span className="text-green-400">→</span>
                <span className="bg-blue-100 px-3 py-1 rounded shadow">Portal Login</span>
                <span className="text-green-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Browse Startups</span>
                <span className="text-green-400">→</span>
                <span className="bg-green-100 px-3 py-1 rounded shadow font-semibold">View Health Scores</span>
                <span className="text-green-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Request Intro</span>
              </div>
            </div>

            <div className="p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg">
              <div className="font-semibold text-amber-800 mb-2">Journey 4: Job Seeker</div>
              <div className="flex flex-wrap items-center gap-2 text-sm">
                <span className="bg-white px-3 py-1 rounded shadow">Home</span>
                <span className="text-amber-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Job Placements</span>
                <span className="text-amber-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Search/Filter</span>
                <span className="text-amber-400">→</span>
                <span className="bg-white px-3 py-1 rounded shadow">Job Detail</span>
                <span className="text-amber-400">→</span>
                <span className="bg-amber-100 px-3 py-1 rounded shadow font-semibold">Apply</span>
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
                <li>• Health Check flow</li>
                <li>• Basic startup directory</li>
                <li>• Services overview</li>
              </ul>
            </div>
            <div className="p-4 bg-amber-50 rounded-lg border-l-4 border-amber-500">
              <div className="font-bold text-amber-800">Phase 2</div>
              <div className="text-sm text-amber-600 mb-2">Month 2</div>
              <ul className="text-sm text-gray-700 space-y-1">
                <li>• Startup profiles</li>
                <li>• Partner pages (OW, IBM)</li>
                <li>• Case studies</li>
                <li>• Job placements</li>
              </ul>
            </div>
            <div className="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
              <div className="font-bold text-blue-800">Phase 3</div>
              <div className="text-sm text-blue-600 mb-2">Month 3</div>
              <ul className="text-sm text-gray-700 space-y-1">
                <li>• <strong>IBM Products pages</strong></li>
                <li>• Quote request system</li>
                <li>• Startup dashboard</li>
                <li>• Admin QA panel</li>
              </ul>
            </div>
            <div className="p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
              <div className="font-bold text-green-800">Phase 4</div>
              <div className="text-sm text-green-600 mb-2">Month 4+</div>
              <ul className="text-sm text-gray-700 space-y-1">
                <li>• Full IBM catalog</li>
                <li>• Partner portal</li>
                <li>• Games section</li>
                <li>• Advanced analytics</li>
              </ul>
            </div>
          </div>
        </div>

        {/* Footer */}
        <div className="text-center mt-8 text-purple-200">
          <p>modus chora studio</p>
          <p className="text-sm opacity-75">Sitemap v2.0 | January 2026 | IBM Business Partner</p>
        </div>
      </div>
    </div>
  );
};

export default SitemapVisualization;
