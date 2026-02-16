import React, { useState, useEffect, useRef } from 'react';
import Globe from 'react-globe.gl';
import { Search, MapPin } from 'lucide-react';
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
    <h3 className="font-bold text-gray-800 mb-3">{title}</h3>
    <div className="flex flex-wrap gap-2">
      {options.map((opt, idx) => (
        <button 
          key={idx} 
          className="px-3 py-1 border border-gray-300 rounded-full text-xs text-gray-600 hover:bg-gray-100 hover:border-gray-400 transition-all"
        >
          {opt}
        </button>
      ))}
    </div>
  </div>
);

const ProjectCard = ({ project }) => (
  <div className="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow mb-6">
    <div className="h-32 w-full overflow-hidden relative">
      <img 
        src={project.image} 
        alt={project.title} 
        className="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500"
      />
      <div className="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent" />
    </div>
    <div className="p-4">
      <h3 className="font-bold text-gray-900 text-lg mb-2 leading-tight">{project.title}</h3>
      
      <div className="flex flex-wrap gap-2 mb-3">
        <span className="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">
          {project.region}
        </span>
        {project.partners.map((partner, i) => (
          <span key={i} className="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded border border-gray-200">
            {partner}
          </span>
        ))}
      </div>
      
      <p className="text-gray-500 text-xs leading-relaxed mb-3">
        {project.description}
      </p>
    </div>
  </div>
);

// --- Main App ---

export default function App() {
  const globeRef = useRef();
  const [dimensions, setDimensions] = useState({ width: 0, height: 0 });
  const containerRef = useRef(null);

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

  return (
    <div className="flex flex-col h-screen bg-white font-sans overflow-hidden">
      <NavBar />

      <main className="flex flex-1 overflow-hidden relative">
        
        {/* LEFT COLUMN: INTERACTIVE GLOBE */}
        <div ref={containerRef} className="flex-1 bg-slate-900 relative overflow-hidden">
          {/* Decorative Overlay for Map Look */}
          <div className="absolute top-0 left-0 p-8 z-10 pointer-events-none">
             <div className="text-white/80 text-6xl font-bold opacity-10 tracking-widest">AFRICA</div>
          </div>

          {dimensions.width > 0 && (
            <Globe
              ref={globeRef}
              width={dimensions.width}
              height={dimensions.height}
              globeImageUrl="//unpkg.com/three-globe/example/img/earth-night.jpg"
              backgroundImageUrl="//unpkg.com/three-globe/example/img/night-sky.png"
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
          <div className="absolute bottom-8 left-8 z-10 bg-white/10 backdrop-blur-md p-4 rounded-lg border border-white/20">
             <div className="flex items-center space-x-2 text-white text-xs">
                <MapPin size={14} className="text-blue-400" />
                <span>Interact to explore global project locations</span>
             </div>
          </div>
        </div>

        {/* RIGHT COLUMN: SIDEBAR */}
        <div className="w-full md:w-[480px] flex-shrink-0 border-l border-gray-200 overflow-y-auto bg-white custom-scrollbar">
          <div className="p-8">
            
            <h2 className="text-xl font-bold text-gray-900 mb-4">Find Projects</h2>
            <div className="relative mb-8">
              <Search className="absolute left-3 top-2.5 text-gray-400" size={18} />
              <input 
                type="text" 
                placeholder="Search projects..." 
                className="w-full pl-10 pr-4 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
              />
            </div>

            <FilterSection 
              title="Region" 
              options={["All", "North America", "Europe", "Asia", "South America", "Africa"]} 
            />
            
            <FilterSection 
              title="Partners" 
              options={["All", "IBM", "Microsoft", "Siemens", "EDF", "Philips", "World Bank"]} 
            />

            <FilterSection 
              title="Case Studies" 
              options={["All", "AI Transformation", "Green Energy", "Healthcare Access", "Smart Cities"]} 
            />

            <div className="my-8 h-px bg-gray-200" />

            <div className="flex justify-between items-center mb-6">
              <h2 className="text-lg font-bold text-gray-900">Filtered Results ({PROJECTS.length})</h2>
            </div>

            <div className="space-y-4">
              {PROJECTS.map(project => (
                <ProjectCard key={project.id} project={project} />
              ))}
            </div>

          </div>
          
          <Footer />
        </div>
      </main>
    </div>
  );
}