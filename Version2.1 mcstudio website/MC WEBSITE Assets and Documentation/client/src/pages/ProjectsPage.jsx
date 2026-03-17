import React, { useState } from 'react'; 
import { ComposableMap, Geographies, Geography, ZoomableGroup, Marker } from "react-simple-maps";
import { Search, MapPin, ZoomIn, ZoomOut } from 'lucide-react';
import { useTheme } from '../components/Context/ThemeContext';
import NavBar from '../components/NavBar';

const geoUrl = "https://unpkg.com/world-atlas@2.0.2/countries-110m.json";

const PROJECTS = [
  {
    id: 1, title: "Global AI Integration Initiative", category: "Technology", region: "North America",
    partners: ["IBM", "Microsoft"], description: "A groundbreaking project to integrate advanced AI solutions across various industries, focusing on automation.",
    image: "https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&q=80&w=800",
    lat: 40.7128, lng: -74.0060, color: "#4f46e5"
  },
  {
    id: 2, title: "Sustainable Energy Grid Deployment", category: "Energy", region: "Europe",
    partners: ["Siemens", "EDF"], description: "Developing and deploying sustainable energy solutions across European cities, promoting green power.",
    image: "https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&q=80&w=800",
    lat: 48.8566, lng: 2.3522, color: "#10b981"
  },
  {
    id: 3, title: "Digital Healthcare Platform", category: "Healthcare", region: "Asia",
    partners: ["Philips", "Telemed Asia"], description: "Creating an accessible digital healthcare platform to connect patients with medical professionals remotely.",
    image: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&q=80&w=800",
    lat: 35.6762, lng: 139.6503, color: "#8b5cf6"
  },
  {
    id: 4, title: "Blockchain Supply Chain Optimization", category: "Logistics", region: "South America",
    partners: ["AgriChain", "LogiTech"], description: "Implementing blockchain technology to optimize supply chain transparency and security.",
    image: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800",
    lat: -23.5505, lng: -46.6333, color: "#ec4899"
  },
  {
    id: 5, title: "Smart City Infrastructure Project", category: "Infrastructure", region: "Africa",
    partners: ["World Bank", "CityNet Africa"], description: "Developing intelligent urban infrastructure to improve quality of life and resource management.",
    image: "https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?auto=format&fit=crop&q=80&w=800",
    lat: -1.2921, lng: 36.8219, color: "#f59e0b"
  }
];

const FilterSection = ({ title, options, activeFilter, onFilterChange, isDarkMode }) => (
  <div className="mb-6">
    <h3 className={`font-bold text-sm mb-3 transition-colors ${isDarkMode ? 'text-gray-200' : 'text-gray-900'}`}>
      {title}
    </h3>
    <div className="flex flex-wrap gap-2">
      {options.map((opt, idx) => {
        const isActive = activeFilter === opt;
        return (
          <button 
            key={idx} 
            onClick={() => onFilterChange(opt)}
            className={`px-4 py-1.5 border rounded-full text-xs font-medium transition-all duration-200 ${
              isActive 
                ? (isDarkMode ? 'text-white border-blue-500 bg-blue-600 shadow-sm' : 'text-white border-blue-600 bg-blue-600 shadow-sm')
                : (isDarkMode ? 'text-gray-400 bg-gray-900 border-gray-800 hover:bg-gray-800 hover:text-white' : 'text-gray-600 bg-white border-gray-200 hover:bg-gray-50 hover:border-gray-300')
            }`}
          >
            {opt}
          </button>
        );
      })}
    </div>
  </div>
);

const ProjectCard = ({ project, isDarkMode, isHovered, onMouseEnter, onMouseLeave }) => (
  <div 
    onMouseEnter={onMouseEnter}
    onMouseLeave={onMouseLeave}
    className={`border rounded-xl overflow-hidden transition-all duration-300 mb-6 group flex flex-col cursor-pointer ${
      isDarkMode 
        ? `bg-gray-900 ${isHovered ? 'border-blue-500 shadow-[0_0_15px_rgba(59,130,246,0.3)] -translate-y-1' : 'border-gray-800 hover:border-gray-700 shadow-sm'}` 
        : `bg-white ${isHovered ? 'border-blue-500 shadow-lg shadow-blue-500/20 -translate-y-1' : 'border-gray-200 hover:border-blue-200 shadow-sm'}`
    }`}
  >
    <div className="h-40 w-full overflow-hidden relative">
      <img src={project.image} alt={project.title} className={`w-full h-full object-cover transform transition-transform duration-500 ${isHovered ? 'scale-105' : 'group-hover:scale-105'}`} />
    </div>
    <div className="p-5 flex flex-col flex-grow">
      <h3 className={`font-bold text-lg mb-3 leading-tight transition-colors ${isDarkMode ? 'text-white' : 'text-gray-900'} ${isHovered ? (isDarkMode ? 'text-blue-400' : 'text-blue-700') : 'group-hover:text-blue-600'}`}>
        {project.title}
      </h3>
      <div className="flex flex-wrap gap-2 mb-3">
        <span className="bg-[#1e3a8a] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wide">
          {project.region}
        </span>
        {project.partners.map((partner, i) => (
          <span key={i} className={`text-[10px] font-medium px-3 py-1 rounded-full border transition-colors ${isDarkMode ? 'bg-gray-800 text-gray-300 border-gray-700' : 'bg-white text-gray-600 border-gray-200'}`}>
            {partner}
          </span>
        ))}
      </div>
      <p className={`text-xs leading-relaxed mt-1 transition-colors ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
        {project.description}
      </p>
    </div>
  </div>
);

export default function ProjectsPage() {
  const { isDarkMode } = useTheme(); 

  const [searchQuery, setSearchQuery] = useState("");
  const [hoveredProject, setHoveredProject] = useState(null); 
  const [position, setPosition] = useState({ coordinates: [0, 20], zoom: 1 }); 

  const [regionFilter, setRegionFilter] = useState("All");
  const [partnerFilter, setPartnerFilter] = useState("All");
  const [categoryFilter, setCategoryFilter] = useState("All");

  const handleZoomIn = () => {
    if (position.zoom >= 8) return;
    setPosition((pos) => ({ ...pos, zoom: pos.zoom * 1.2 }));
  };

  const handleZoomOut = () => {
    if (position.zoom <= 1) return;
    setPosition((pos) => ({ ...pos, zoom: Math.max(1, pos.zoom / 1.2) }));
  };

  const filteredProjects = PROJECTS.filter((project) => {
    if (searchQuery) {
      const lowerQuery = searchQuery.toLowerCase();
      return (
        project.title.toLowerCase().includes(lowerQuery) ||
        project.description.toLowerCase().includes(lowerQuery) ||
        project.region.toLowerCase().includes(lowerQuery) ||
        project.partners.some(partner => partner.toLowerCase().includes(lowerQuery))
      );
    }

    const matchRegion = regionFilter === "All" || project.region === regionFilter;
    const matchPartner = partnerFilter === "All" || project.partners.includes(partnerFilter);
    const matchCategory = categoryFilter === "All" || project.category === categoryFilter;

    return matchRegion && matchPartner && matchCategory;
  });

  return (
    <div className={`flex flex-col h-screen font-sans overflow-hidden transition-colors duration-300 ${
      isDarkMode ? 'bg-black text-white' : 'bg-white text-gray-900'
    }`}>
      <header className={`flex-none relative top-0 z-50 w-full border-b shadow-sm transition-colors duration-300 ${
        isDarkMode ? 'bg-black border-gray-800' : 'bg-white border-gray-100'
      }`}>
        <NavBar />
      </header>

      <main className="flex flex-1 overflow-hidden relative transition-all duration-300 ease-in-out"> 
        <div className={`flex-1 relative overflow-hidden flex items-center justify-center transition-colors duration-300 ${
          isDarkMode ? 'bg-[#0f172a]' : 'bg-[#e0e7ff]' 
        }`}>
          <ComposableMap 
            projection="geoMercator"
            projectionConfig={{ scale: 130 }} 
            width={800} 
            height={600}
            className="w-full h-full outline-none"
            style={{ width: "100%", height: "100%" }}
          >
            <ZoomableGroup 
              zoom={position.zoom} 
              center={position.coordinates} 
              onMoveEnd={setPosition}
              minZoom={1} 
              maxZoom={8}
              translateExtent={[[0, 0], [800, 600]]}
            >
              <Geographies geography={geoUrl}>
                {({ geographies }) =>
                  geographies.map((geo) => (
                    <Geography
                      key={geo.rsmKey}
                      geography={geo}
                      fill={isDarkMode ? "#1f2937" : "#ffffff"} 
                      stroke={isDarkMode ? "#374151" : "#cbd5e1"} 
                      strokeWidth={0.5}
                      style={{
                        default: { outline: "none" },
                        hover: { fill: isDarkMode ? "#4b5563" : "#f1f5f9", outline: "none", cursor: "pointer" },
                        pressed: { outline: "none" },
                      }}
                    />
                  ))
                }
              </Geographies>

              {filteredProjects.map((project) => {
                const isHovered = hoveredProject === project.id;
                const scale = 1 / position.zoom;
                const activeScale = isHovered ? scale * 1.4 : scale; 

                return (
                  <Marker 
                    key={project.id} 
                    coordinates={[project.lng, project.lat]}
                    onMouseEnter={() => setHoveredProject(project.id)}
                    onMouseLeave={() => setHoveredProject(null)}
                    style={{ cursor: "pointer" }}
                  >
                    <circle 
                      r={14 * activeScale} 
                      fill={project.color} 
                      opacity={isHovered ? 0.6 : 0.3} 
                      style={{ transition: "all 0.3s cubic-bezier(0.4, 0, 0.2, 1)" }}
                    />
                    <circle 
                      r={5 * activeScale} 
                      fill={project.color} 
                      stroke={isDarkMode ? "#0f172a" : "#e0e7ff"} 
                      strokeWidth={2 * scale} 
                      style={{ transition: "all 0.3s cubic-bezier(0.4, 0, 0.2, 1)" }}
                    />
                  </Marker>
                );
              })}
            </ZoomableGroup>
          </ComposableMap>
          
          <div className={`absolute bottom-8 left-8 z-10 backdrop-blur-md px-5 py-3 rounded-xl border shadow-lg transition-colors ${
            isDarkMode ? 'bg-black/40 border-white/10' : 'bg-white/70 border-gray-200'
          }`}>
             <div className={`flex items-center space-x-3 text-xs font-medium ${isDarkMode ? 'text-white' : 'text-gray-700'}`}>
                <MapPin size={16} className="text-blue-500" />
                <span>Pan & scroll to explore global projects</span>
             </div>
          </div>

          <div className={`absolute right-8 top-8 z-10 flex flex-col gap-2 rounded-lg border shadow-sm overflow-hidden backdrop-blur-md transition-colors ${
            isDarkMode ? 'bg-black/40 border-gray-700' : 'bg-white/80 border-gray-200'
          }`}>
            <button onClick={handleZoomIn} className={`p-2 transition-colors ${isDarkMode ? 'hover:bg-gray-700 text-gray-300' : 'hover:bg-gray-100 text-gray-700'}`}>
              <ZoomIn size={18} />
            </button>
            <div className={`h-px w-full ${isDarkMode ? 'bg-gray-700' : 'bg-gray-200'}`} />
            <button 
              onClick={handleZoomOut} disabled={position.zoom <= 1}
              className={`p-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed ${isDarkMode ? 'hover:bg-gray-700 text-gray-300' : 'hover:bg-gray-100 text-gray-700'}`}
            >
              <ZoomOut size={18} />
            </button>
          </div>
        </div>

        <div className={`w-full lg:w-[480px] flex-shrink-0 border-l overflow-y-auto custom-scrollbar transition-colors duration-300 ${
            isDarkMode ? 'bg-gray-900/50 border-gray-800' : 'bg-gray-50/50 border-gray-200'
          }`}
        >
          <div className="p-8">
            <h2 className={`text-2xl font-bold mb-5 transition-colors ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
              Find Projects
            </h2>
            
            <div className="relative mb-8">
              <Search className={`absolute left-3.5 top-3 ${isDarkMode ? 'text-gray-500' : 'text-gray-400'}`} size={16} />
              <input 
                type="text" 
                placeholder="Search projects by title, region, or partner..." 
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className={`w-full pl-10 pr-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-1 transition-all ${
                  isDarkMode ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500' : 'bg-white border-gray-200 text-gray-900 focus:border-blue-600 focus:ring-blue-600'
                }`}
              />
            </div>

            {!searchQuery && (
              <>
                <FilterSection 
                  title="Region" 
                  options={["All", "North America", "Europe", "Asia", "South America", "Africa"]} 
                  activeFilter={regionFilter}
                  onFilterChange={setRegionFilter}
                  isDarkMode={isDarkMode} 
                />
                <FilterSection 
                  title="Partners" 
                  options={["All", "IBM", "Microsoft", "Siemens", "EDF", "Philips", "Telemed Asia", "AgriChain", "LogiTech", "World Bank", "CityNet Africa"]} 
                  activeFilter={partnerFilter}
                  onFilterChange={setPartnerFilter}
                  isDarkMode={isDarkMode} 
                />
                <FilterSection 
                  title="Category" 
                  options={["All", "Technology", "Energy", "Healthcare", "Logistics", "Infrastructure"]} 
                  activeFilter={categoryFilter}
                  onFilterChange={setCategoryFilter}
                  isDarkMode={isDarkMode} 
                />
                <div className={`my-8 h-px transition-colors ${isDarkMode ? 'bg-gray-800' : 'bg-gray-200'}`} />
              </>
            )}

            <div className="flex justify-between items-center mb-6">
              <h2 className={`text-lg font-bold transition-colors ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                Filtered Results ({filteredProjects.length})
              </h2>
            </div>

            <div className="space-y-6">
              {filteredProjects.length > 0 ? (
                filteredProjects.map(project => (
                  <ProjectCard 
                    key={project.id} 
                    project={project} 
                    isDarkMode={isDarkMode} 
                    isHovered={hoveredProject === project.id}
                    onMouseEnter={() => setHoveredProject(project.id)}
                    onMouseLeave={() => setHoveredProject(null)}
                  />
                ))
              ) : (
                <div className={`text-sm text-center py-10 ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
                  No projects match your search criteria. Try adjusting your filters!
                </div>
              )}
            </div>
          </div>
        </div>
      </main>
    </div>
  );
}