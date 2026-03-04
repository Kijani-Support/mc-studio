import React, { useState } from 'react';
import { Search, Facebook, Twitter, Instagram, Linkedin, Youtube, ArrowRight, ExternalLink } from 'lucide-react';
import { useTheme } from '../components/context/ThemeContext'; // <-- Import the custom hook
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';

// --- Mock Data ---

const HERO_CASE_STUDY = {
  title: "Klinik: Digital Transformation for a Global Healthcare Leader",
  description: "Our strategic partnership helped a major healthcare provider modernize its patient engagement platforms, resulting in improved patient satisfaction by 30% and operational efficiency gains of 20%.",
  image: "https://images.unsplash.com/photo-1576091160550-217358c7db81?auto=format&fit=crop&q=80&w=1600",
  stats: [
    { value: "+30%", label: "Patient Satisfaction" },
    { value: "+20%", label: "Operational Efficiency" },
    { value: "+15%", label: "Market Reach" }
  ]
};

const SUCCESS_STORIES = [
  {
    id: 1,
    title: "Optimizing Supply Chain for E-commerce Retail",
    description: "Developed a custom logistics platform that streamlined inventory delivery times and optimized warehouse management for a rapidly growing online retailer.",
    image: "https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&q=80&w=800",
    tags: ["E-commerce", "Logistics", "Efficiency"],
    partners: "UrbanLogistics",
    projects: "IntelliLogistics",
  },
  {
    id: 2,
    title: "Enhanced User Experience for Fintech Platform",
    description: "Revamped the UI/UX of a leading fintech application, leading to a 25% increase in user retention and simplified financial transactions.",
    image: "https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&q=80&w=800",
    tags: ["Fintech", "UI/UX", "Engagement"],
    partners: "PayView Solutions",
    projects: "FinView Redesign",
  },
  {
    id: 3,
    title: "Driving Innovation with AI for Automotive Manufacturer",
    description: "Integrated AI-powered predictive maintenance systems into manufacturing lines, boosting production uptime and reducing unexpected equipment failures.",
    image: "https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=800",
    tags: ["Automotive", "AI", "Manufacturing"],
    partners: "AutoTech Innovations",
    projects: "Predictive Assembly",
  },
  {
    id: 4,
    title: "Digital Marketing Strategy for Education Tech Startup",
    description: "Crafted and executed a comprehensive digital marketing strategy that expanded outreach and increased student enrollment by 35% for an EdTech startup.",
    image: "https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=800",
    tags: ["Education", "Marketing", "Growth"],
    partners: "LearnFlow Academy",
    projects: "EduLaunch Campaign",
  },
  {
    id: 5,
    title: "Cloud Infrastructure Migration for SaaS Provider",
    description: "Successfully migrated an enterprise SaaS platform to a scalable cloud infrastructure, improving reliability and reducing hosting costs by 15%.",
    image: "https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=800",
    tags: ["Cloud", "SaaS", "Infrastructure"],
    partners: "Aether Cloud",
    projects: "Horizon Cloud Mig",
  },
  {
    id: 6,
    title: "Brand Identity & Web Development for a New Energy Venture",
    description: "Developed a compelling brand identity and a responsive website for an innovative renewable energy startup, launching their market presence.",
    image: "https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&q=80&w=800",
    tags: ["Energy", "Branding", "Web Dev"],
    partners: "TerraVolt Solutions",
    projects: "EcoConnect Platform",
  }
];

const FILTER_CATEGORIES = ["All", "E-commerce", "Fintech", "Automotive", "Education", "Cloud", "Energy"];

// --- Components ---

const HeroSection = ({ isDarkMode }) => (
  <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div className={`rounded-2xl p-6 md:p-8 flex flex-col md:flex-row gap-8 items-center shadow-sm border transition-colors duration-300 ${
      isDarkMode ? 'bg-gray-900 border-gray-800' : 'bg-white border-gray-100'
    }`}>
      
      {/* Hero Image */}
      <div className="w-full md:w-1/2 rounded-xl overflow-hidden h-64 md:h-96 relative group">
        <img 
          src={HERO_CASE_STUDY.image} 
          alt="Featured Case Study" 
          className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
        />
      </div>

      {/* Hero Content */}
      <div className="w-full md:w-1/2 space-y-6">
        <h1 className={`text-3xl md:text-4xl font-extrabold leading-tight transition-colors duration-300 ${
          isDarkMode ? 'text-white' : 'text-gray-900'
        }`}>
          {HERO_CASE_STUDY.title}
        </h1>
        <p className={`leading-relaxed text-lg transition-colors duration-300 ${
          isDarkMode ? 'text-gray-300' : 'text-gray-600'
        }`}>
          {HERO_CASE_STUDY.description}
        </p>
        
        {/* Stats Grid */}
        <div className={`grid grid-cols-3 gap-4 border-t border-b py-6 transition-colors duration-300 ${
          isDarkMode ? 'border-gray-800' : 'border-gray-100'
        }`}>
          {HERO_CASE_STUDY.stats.map((stat, idx) => (
            <div key={idx}>
              <div className={`text-2xl md:text-3xl font-bold ${
                isDarkMode ? 'text-blue-400' : 'text-blue-700'
              }`}>{stat.value}</div>
              <div className={`text-xs uppercase tracking-wide mt-1 ${
                isDarkMode ? 'text-gray-400' : 'text-gray-500'
              }`}>{stat.label}</div>
            </div>
          ))}
        </div>

        <button className={`px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center space-x-2 ${
          isDarkMode ? 'bg-blue-600 hover:bg-blue-500 text-white' : 'bg-blue-700 hover:bg-blue-800 text-white'
        }`}>
          <span>Review Dossier</span>
          <ArrowRight size={16} />
        </button>
      </div>
    </div>
  </section>
);

const StoryCard = ({ story, isDarkMode }) => (
  <div className={`border rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full group ${
    isDarkMode ? 'bg-gray-900 border-gray-800 hover:shadow-blue-900/20' : 'bg-white border-gray-200'
  }`}>
    <div className="h-48 overflow-hidden relative">
      <img 
        src={story.image} 
        alt={story.title} 
        className="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
      />
      <div className="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors" />
    </div>
    
    <div className="p-6 flex flex-col flex-grow">
      <h3 className={`font-bold text-xl mb-3 leading-snug transition-colors duration-300 ${
        isDarkMode ? 'text-white group-hover:text-blue-400' : 'text-gray-900 group-hover:text-blue-700'
      }`}>{story.title}</h3>
      <p className={`text-sm leading-relaxed mb-4 flex-grow transition-colors duration-300 ${
        isDarkMode ? 'text-gray-400' : 'text-gray-500'
      }`}>
        {story.description}
      </p>

      {/* Tags */}
      <div className="flex flex-wrap gap-2 mb-6">
        {story.tags.map((tag, i) => (
          <span 
            key={i} 
            className={`text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide ${
              i === 0 
                ? (isDarkMode ? 'bg-blue-600 text-white' : 'bg-blue-600 text-white') 
                : (isDarkMode ? 'bg-blue-900/30 text-blue-300 border border-blue-900/50' : 'bg-blue-100 text-blue-800')
            }`}
          >
            {tag}
          </span>
        ))}
      </div>

      {/* Meta Data */}
      <div className={`space-y-1 mb-4 text-xs border-t pt-4 transition-colors duration-300 ${
        isDarkMode ? 'border-gray-800 text-gray-400' : 'border-gray-100 text-gray-500'
      }`}>
        <div className="flex">
          <span className={`w-16 font-semibold ${isDarkMode ? 'text-gray-500' : 'text-gray-400'}`}>Partners:</span>
          <span className={`font-medium ${isDarkMode ? 'text-blue-400' : 'text-blue-600'}`}>{story.partners}</span>
        </div>
        <div className="flex">
          <span className={`w-16 font-semibold ${isDarkMode ? 'text-gray-500' : 'text-gray-400'}`}>Projects:</span>
          <span className={`font-medium ${isDarkMode ? 'text-blue-400' : 'text-blue-600'}`}>{story.projects}</span>
        </div>
      </div>

      <a href="#" className={`text-sm font-semibold flex items-center mt-auto group-hover:translate-x-1 transition-all duration-300 ${
        isDarkMode ? 'text-white hover:text-blue-400' : 'text-gray-900 hover:text-blue-700'
      }`}>
        Learn More <ArrowRight size={14} className="ml-1" />
      </a>
    </div>
  </div>
);

// --- Main App ---

export default function CaseStudiesPage() {
  const [activeFilter, setActiveFilter] = useState("All");
  const [searchQuery, setSearchQuery] = useState(""); 
  
  // Get the global dark mode state from context
  const { isDarkMode } = useTheme();

  // --- FILTER & SEARCH LOGIC ---
  const filteredStories = SUCCESS_STORIES.filter(story => {
    // 1. Check Category match
    const matchesCategory = activeFilter === "All" || story.tags.includes(activeFilter);
    
    // 2. Check Search query match
    const query = searchQuery.toLowerCase();
    const matchesSearch = 
      query === "" || 
      story.title.toLowerCase().includes(query) ||
      story.description.toLowerCase().includes(query) ||
      story.partners.toLowerCase().includes(query) ||
      story.projects.toLowerCase().includes(query) ||
      story.tags.some(tag => tag.toLowerCase().includes(query));

    // Must match BOTH conditions to show up
    return matchesCategory && matchesSearch;
  });

  return (
    <div className={`flex flex-col min-h-screen font-sans transition-colors duration-300 ${
      isDarkMode ? 'bg-black text-white' : 'bg-gray-50 text-gray-900'
    }`}>
      
      {/* FIX: Pinned NavBar Wrapper
        Uses fixed positioning and z-index to stay on top
      */}
      <div className="fixed top-0 left-0 w-full z-50">
        <NavBar />
      </div>
      
      {/* FIX: Added pt-24 sm:pt-32 to push content down 
        so it doesn't overlap with the fixed navbar 
      */}
      <main className="flex-grow pt-24 sm:pt-32">
        {/* Featured Case Study */}
        <HeroSection isDarkMode={isDarkMode} />

        {/* Main Content Area */}
        <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
          
          <h2 className={`text-2xl font-bold mb-6 transition-colors duration-300 ${
            isDarkMode ? 'text-white' : 'text-gray-900'
          }`}>
            Explore Our Success Stories
          </h2>
          
          {/* Filter Bar */}
          <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div className="relative w-full md:w-64">
              <Search className={`absolute left-3 top-2.5 ${isDarkMode ? 'text-gray-500' : 'text-gray-400'}`} size={16} />
              <input 
                type="text" 
                placeholder="Search case studies..." 
                value={searchQuery} 
                onChange={(e) => setSearchQuery(e.target.value)} 
                className={`w-full pl-9 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-sm transition-colors duration-300 ${
                  isDarkMode 
                    ? 'bg-gray-900 border-gray-800 text-white placeholder-gray-500' 
                    : 'bg-white border-gray-200 text-gray-900 placeholder-gray-400'
                }`}
              />
            </div>

            <div className="flex flex-wrap gap-2">
              <span className={`text-xs font-semibold self-center mr-2 ${
                isDarkMode ? 'text-gray-400' : 'text-gray-500'
              }`}>Category:</span>
              
              {FILTER_CATEGORIES.map((cat) => (
                <button
                  key={cat}
                  onClick={() => setActiveFilter(cat)}
                  className={`px-4 py-1.5 rounded-full text-xs font-medium transition-all duration-300 ${
                    activeFilter === cat
                      ? "bg-blue-700 text-white shadow-md"
                      : isDarkMode 
                        ? "bg-gray-900 text-gray-300 border border-gray-800 hover:bg-gray-800 hover:text-white"
                        : "bg-white text-gray-600 border border-gray-200 hover:bg-gray-50"
                  }`}
                >
                  {cat}
                </button>
              ))}
            </div>
          </div>

          {/* Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {filteredStories.map(story => (
              <StoryCard key={story.id} story={story} isDarkMode={isDarkMode} />
            ))}
            
            {/* Empty State UI */}
            {filteredStories.length === 0 && (
              <div className={`col-span-full text-center py-12 ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                No case studies found matching your criteria.
              </div>
            )}
          </div>

        </section>
      </main>

      {/* Footer handles its own theme via Context now */}
      <Footer />
    </div>
  );
}