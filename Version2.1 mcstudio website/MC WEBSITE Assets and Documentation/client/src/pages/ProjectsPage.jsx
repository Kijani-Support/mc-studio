import React, { useState, useEffect, useRef } from 'react';
import Globe from 'react-globe.gl';
import { Search, MapPin } from 'lucide-react';
import globeImg from '../assets/images/earth-dark.jpg';
import skyImg from '../assets/images/Globe_Background.jpg';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';

// --- Mock Data ---
const PROJECTS = [
  {
    id: 1,
    title: "Global AI Integration Initiative",
    category: "Technology",
    region: "North America",
    partners: ["IBM", "Microsoft"],
    description: "A groundbreaking project to integrate advanced AI solutions across various industries, focusing on automation.",
    image: "https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&q=80&w=800",
    lat: 40.7128,
    lng: -74.0060, // NYC
    color: "#4f46e5"
  },
  {
    id: 2,
    title: "Sustainable Energy Grid Deployment",
    category: "Energy",
    region: "Europe",
    partners: ["Siemens", "EDF"],
    description: "Developing and deploying sustainable energy solutions across European cities, promoting green power.",
    image: "https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&q=80&w=800",
    lat: 48.8566,
    lng: 2.3522, // Paris
    color: "#10b981"
  },
  {
    id: 3,
    title: "Digital Healthcare Platform",
    category: "Healthcare",
    region: "Asia",
    partners: ["Philips", "Telemed Asia"],
    description: "Creating an accessible digital healthcare platform to connect patients with medical professionals remotely.",
    image: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&q=80&w=800",
    lat: 35.6762,
    lng: 139.6503, // Tokyo
    color: "#8b5cf6"
  },
  {
    id: 4,
    title: "Blockchain Supply Chain Optimization",
    category: "Logistics",
    region: "South America",
    partners: ["AgriChain", "LogiTech"],
    description: "Implementing blockchain technology to optimize supply chain transparency and security.",
    image: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800",
    lat: -23.5505,
    lng: -46.6333, // Sao Paulo
    color: "#ec4899"
  },
  {
    id: 5,
    title: "Smart City Infrastructure Project",
    category: "Infrastructure",
    region: "Africa",
    partners: ["World Bank", "CityNet Africa"],
    description: "Developing intelligent urban infrastructure to improve quality of life and resource management.",
    image: "https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?auto=format&fit=crop&q=80&w=800",
    lat: -1.2921,
    lng: 36.8219, // Nairobi
    color: "#f59e0b"
  }
];

// --- Components ---

const FilterSection = ({ title, options }) => (
  <div className="mb-6">
    <h3 className="font-bold text-gray-900 text-sm mb-3">{title}</h3>
    <div className="flex flex-wrap gap-2">
      {options.map((opt, idx) => (
        <button 
          key={idx} 
          className={`px-4 py-1.5 border border-gray-200 rounded-full text-xs font-medium transition-all duration-200 ${
            idx === 0 
              ? 'text-gray-900 border-gray-300 bg-gray-50' 
              : 'text-gray-600 bg-white hover:bg-gray-50 hover:border-gray-300'
          }`}
        >
          {opt}
        </button>
      ))}
    </div>
  </div>
);

const ProjectCard = ({ project }) => (
  <div className="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 mb-6 group flex flex-col">
    <div className="h-40 w-full overflow-hidden relative">
      <img 
        src={project.image} 
        alt={project.title} 
        className="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
      />
    </div>
    <div className="p-5 flex flex-col flex-grow">
      <h3 className="font-bold text-gray-900 text-lg mb-3 leading-tight group-hover:text-blue-700 transition-colors">
        {project.title}
      </h3>
      
      <div className="flex flex-wrap gap-2 mb-3">
        <span className="bg-[#1e3a8a] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wide">
          {project.region}
        </span>
        {project.partners.map((partner, i) => (
          <span key={i} className="bg-white text-gray-600 text-[10px] font-medium px-3 py-1 rounded-full border border-gray-200">
            {partner}
          </span>
        ))}
      </div>
      
      <p className="text-gray-500 text-xs leading-relaxed mt-1">
        {project.description}
      </p>
    </div>
  </div>
);

// --- Main App ---

export default function App() {
  const globeRef = useRef();
  const [dimensions, setDimensions] = useState({ width: 0, height: 0 });
  const [showFooter, setShowFooter] = useState(true);
  const containerRef = useRef(null);
  const sidebarRef = useRef(null);
  const scrollTimeoutRef = useRef(null);

  // Handle globe resizing
  useEffect(() => {
    function handleResize() {
      if (containerRef.current) {
        setDimensions({
          width: containerRef.current.offsetWidth,
          height: containerRef.current.offsetHeight
        });
      }
    }
    window.addEventListener('resize', handleResize);
    handleResize(); // Initial size
    
    // Auto-rotate globe
    if (globeRef.current) {
      globeRef.current.controls().autoRotate = true;
      globeRef.current.controls().autoRotateSpeed = 0.5;
    }

    return () => window.removeEventListener('resize', handleResize);
  }, []);

  // Handle scroll to auto-hide/show footer
  useEffect(() => {
    const sidebar = sidebarRef.current;
    if (!sidebar) return;

    function handleScroll() {
      setShowFooter(false);
      if (scrollTimeoutRef.current) {
        clearTimeout(scrollTimeoutRef.current);
      }
      scrollTimeoutRef.current = setTimeout(() => {
        setShowFooter(true);
      }, 1500);
    }

    sidebar.addEventListener('scroll', handleScroll);
    return () => {
      sidebar.removeEventListener('scroll', handleScroll);
      if (scrollTimeoutRef.current) {
        clearTimeout(scrollTimeoutRef.current);
      }
    };
  }, []);

  return (
    <div className="flex flex-col h-screen bg-white font-sans text-gray-900">
      <header className="relative top-0 z-50 w-full bg-white border-b border-gray-100 shadow-sm">
        <NavBar />
      </header>

      <main className="flex flex-1 overflow-hidden relative transition-all duration-300 ease-in-out"> 
        
        {/* LEFT COLUMN: INTERACTIVE GLOBE */}
        <div ref={containerRef} className="flex-1 bg-slate-900 relative overflow-hidden">
          {dimensions.width > 0 && (
            <Globe
              ref={globeRef}
              width={dimensions.width}
              height={dimensions.height}
              globeImageUrl={globeImg}
              backgroundImageUrl={skyImg}
              pointsData={PROJECTS}
              pointLat="lat"
              pointLng="lng"
              pointColor="color"
              pointAltitude={0.1}
              pointRadius={0.5}
              atmosphereColor="#3b82f6"
              atmosphereAltitude={0.25}
            />
          )}
          
          {/* Map pins description overlay */}
          <div className="absolute bottom-8 left-8 z-10 bg-black/40 backdrop-blur-md px-5 py-3 rounded-xl border border-white/10 shadow-lg">
             <div className="flex items-center space-x-3 text-white text-xs font-medium">
                <MapPin size={16} className="text-blue-400" />
                <span>Interact to explore global project locations</span>
             </div>
          </div>
        </div>

        {/* RIGHT COLUMN: SIDEBAR */}
        <div ref={sidebarRef} className="w-full lg:w-[480px] flex-shrink-0 border-l border-gray-200 overflow-y-auto bg-gray-50/50 custom-scrollbar">
          <div className="p-8">
            
            <h2 className="text-2xl font-bold text-gray-900 mb-5">Find Projects</h2>
            <div className="relative mb-8">
              <Search className="absolute left-3.5 top-3 text-gray-400" size={16} />
              <input 
                type="text" 
                placeholder="Search projects..." 
                className="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 shadow-sm transition-all"
              />
            </div>

            <FilterSection 
              title="Region" 
              options={["All", "North America", "Europe", "Asia", "South America", "Africa"]} 
            />
            
            <FilterSection 
              title="Partners" 
              options={["All", "IBM", "Microsoft", "Siemens", "EDF", "Philips", "Telemed Asia", "AgriChain Solutions", "World Bank", "CityNet Africa"]} 
            />

            <FilterSection 
              title="Case Studies" 
              options={["All", "AI Transformation at Scale", "Green Energy for Smart Cities", "Healthcare Access in Rural Asia", "Transparent Food Supply", "Smart Cities for a Brighter Future", "Urban Innovation"]} 
            />

            <div className="my-8 h-px bg-gray-200" />

            <div className="flex justify-between items-center mb-6">
              <h2 className="text-lg font-bold text-gray-900">Filtered Results ({PROJECTS.length})</h2>
            </div>

            <div className="space-y-6">
              {PROJECTS.map(project => (
                <ProjectCard key={project.id} project={project} />
              ))}
            </div>
          </div>
        </div>
      </main>

      {/* FULL WIDTH FOOTER (Auto-Hiding based on scroll) */}
      <div className={`bg-gray-50 transition-all duration-500 ease-in-out overflow-hidden border-t border-gray-200 ${showFooter ? 'opacity-100 max-h-[500px]' : 'opacity-0 max-h-0 border-t-0'}`}>
        <Footer />
      </div>
    </div>
  );
}