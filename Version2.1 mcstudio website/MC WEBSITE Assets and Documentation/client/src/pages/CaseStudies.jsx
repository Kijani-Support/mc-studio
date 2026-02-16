import React, { useState } from 'react';
import { Search, Facebook, Twitter, Instagram, Linkedin, Youtube, ArrowRight, ExternalLink } from 'lucide-react';
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

const FILTER_CATEGORIES = ["All", "Technology", "Healthcare", "Finance", "Education", "Automotive", "Energy"];

// --- Components ---

const HeroSection = () => (
  <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div className="bg-white rounded-2xl p-6 md:p-8 flex flex-col md:flex-row gap-8 items-center shadow-sm border border-gray-100">
      
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
        <h1 className="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">
          {HERO_CASE_STUDY.title}
        </h1>
        <p className="text-gray-600 leading-relaxed text-lg">
          {HERO_CASE_STUDY.description}
        </p>
        
        {/* Stats Grid */}
        <div className="grid grid-cols-3 gap-4 border-t border-b border-gray-100 py-6">
          {HERO_CASE_STUDY.stats.map((stat, idx) => (
            <div key={idx}>
              <div className="text-2xl md:text-3xl font-bold text-blue-700">{stat.value}</div>
              <div className="text-xs text-gray-500 uppercase tracking-wide mt-1">{stat.label}</div>
            </div>
          ))}
        </div>

        <button className="bg-blue-700 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-800 transition-colors inline-flex items-center space-x-2">
          <span>Review Dossier</span>
          <ArrowRight size={16} />
        </button>
      </div>
    </div>
  </section>
);

const StoryCard = ({ story }) => (
  <div className="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full group">
    <div className="h-48 overflow-hidden relative">
      <img 
        src={story.image} 
        alt={story.title} 
        className="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
      />
      <div className="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors" />
    </div>
    
    <div className="p-6 flex flex-col flex-grow">
      <h3 className="font-bold text-gray-900 text-xl mb-3 leading-snug">{story.title}</h3>
      <p className="text-gray-500 text-sm leading-relaxed mb-4 flex-grow">
        {story.description}
      </p>

      {/* Tags */}
      <div className="flex flex-wrap gap-2 mb-6">
        {story.tags.map((tag, i) => (
          <span 
            key={i} 
            className={`text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide ${
              i === 0 ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-800'
            }`}
          >
            {tag}
          </span>
        ))}
      </div>

      {/* Meta Data */}
      <div className="space-y-1 mb-4 text-xs text-gray-500 border-t border-gray-100 pt-4">
        <div className="flex">
          <span className="w-16 font-semibold text-gray-400">Partners:</span>
          <span className="text-blue-600 font-medium">{story.partners}</span>
        </div>
        <div className="flex">
          <span className="w-16 font-semibold text-gray-400">Projects:</span>
          <span className="text-blue-600 font-medium">{story.projects}</span>
        </div>
      </div>

      <a href="#" className="text-sm font-semibold text-gray-900 hover:text-blue-700 flex items-center mt-auto group-hover:translate-x-1 transition-transform">
        Learn More <ArrowRight size={14} className="ml-1" />
      </a>
    </div>
  </div>
);

// --- Main App ---

export default function CaseStudiesPage() {
  const [activeFilter, setActiveFilter] = useState("All");

  return (
    <div className="min-h-screen bg-gray-50 font-sans text-gray-900">
      <NavBar />
      
      <main>
        {/* Featured Case Study */}
        <HeroSection />

        {/* Main Content Area */}
        <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
          
          <h2 className="text-2xl font-bold text-gray-900 mb-6">Explore Our Success Stories</h2>
          
          {/* Filter Bar */}
          <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div className="relative w-full md:w-64">
              <Search className="absolute left-3 top-2.5 text-gray-400" size={16} />
              <input 
                type="text" 
                placeholder="Search case studies..." 
                className="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm"
              />
            </div>

            <div className="flex flex-wrap gap-2">
              <span className="text-xs font-semibold text-gray-500 self-center mr-2">Category:</span>
              {FILTER_CATEGORIES.map((cat) => (
                <button
                  key={cat}
                  onClick={() => setActiveFilter(cat)}
                  className={`px-4 py-1.5 rounded-full text-xs font-medium transition-all ${
                    activeFilter === cat
                      ? "bg-blue-700 text-white shadow-md"
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
            {SUCCESS_STORIES.map(story => (
              <StoryCard key={story.id} story={story} />
            ))}
          </div>

        </section>
      </main>

      <Footer />
    </div>
  );
}