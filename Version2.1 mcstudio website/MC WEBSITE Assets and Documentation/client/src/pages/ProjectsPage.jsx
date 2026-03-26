import React, { useState, useEffect, useRef } from 'react';
import createGlobe from 'cobe';
import { useSpring } from '@react-spring/web';
import { Search, MapPin } from 'lucide-react';
import { useTheme } from '../components/Context/ThemeContext';
import NavBar from '../components/NavBar';

// ─── HELPER FUNCTION ───────────────────────────────────────────────────────
const hexToRgb = (hex) => {
  const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  return result ? [
    parseInt(result[1], 16) / 255,
    parseInt(result[2], 16) / 255,
    parseInt(result[3], 16) / 255
  ] : [1, 1, 1];
};

// ─── MOCK DATA ─────────────────────────────────────────────────────────────
const PROJECTS = [
  { id: 1, title: "Global AI Integration Initiative", category: "Technology", region: "North America", partners: ["IBM", "Microsoft"], description: "A groundbreaking project to integrate advanced AI solutions across various industries, focusing on automation.", image: "https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&q=80&w=800", lat: 40.7128, lng: -74.0060, color: "#4f46e5" },
  { id: 2, title: "Sustainable Energy Grid Deployment", category: "Energy", region: "Europe", partners: ["Siemens", "EDF"], description: "Developing and deploying sustainable energy solutions across European cities, promoting green power.", image: "https://images.unsplash.com/photo-1466611653911-95081537e5b7?auto=format&fit=crop&q=80&w=800", lat: 48.8566, lng: 2.3522, color: "#10b981" },
  { id: 3, title: "Digital Healthcare Platform", category: "Healthcare", region: "Asia", partners: ["Philips", "Telemed Asia"], description: "Creating an accessible digital healthcare platform to connect patients with medical professionals remotely.", image: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&q=80&w=800", lat: 35.6762, lng: 139.6503, color: "#8b5cf6" },
  { id: 4, title: "Blockchain Supply Chain Optimization", category: "Logistics", region: "South America", partners: ["AgriChain", "LogiTech"], description: "Implementing blockchain technology to optimize supply chain transparency and security.", image: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800", lat: -23.5505, lng: -46.6333, color: "#ec4899" },
  { id: 5, title: "Smart City Infrastructure Project", category: "Infrastructure", region: "Africa", partners: ["World Bank", "CityNet Africa"], description: "Developing intelligent urban infrastructure to improve quality of life and resource management.", image: "https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?auto=format&fit=crop&q=80&w=800", lat: -1.2921, lng: 36.8219, color: "#f59e0b" }
];

// ─── ISOLATED GLOBE COMPONENT ──────────────────────────────────────────────
const Globe = ({ filteredProjects, hoveredProject, isDarkMode }) => {
  const canvasRef = useRef();
  const containerRef = useRef(); 
  
  const pointerRef = useRef(null);
  const [{ r }, api] = useSpring(() => ({ 
    r: 0, 
    config: { mass: 1, tension: 280, friction: 60 } 
  }));

  const basePhiRef = useRef(0);
  const thetaRef = useRef(0.2);
  
  const markersRef = useRef([]);
  const hoveredRef = useRef(null);

  // Sync React state into refs so the animation loop doesn't trigger re-renders
  useEffect(() => {
    hoveredRef.current = hoveredProject;
    markersRef.current = filteredProjects.map(p => ({
      location: [p.lat, p.lng],
      size: hoveredProject === p.id ? 0.08 : 0.04,
      color: hexToRgb(p.color), 
      id: `project-${p.id}` 
    }));
  }, [filteredProjects, hoveredProject]);

  // Main WebGL Engine
  useEffect(() => {
    if (!canvasRef.current || !containerRef.current) return;

    let globe = null;
    let animationFrameId;
    let currentWidth = 0;
    
    // Fallback to 2 for crispness on standard monitors
    const dpr = window.devicePixelRatio || 2; 

    // Function to build the globe once we have a valid width
    const initGlobe = () => {
      if (globe) globe.destroy();
      
      globe = createGlobe(canvasRef.current, {
        devicePixelRatio: dpr,
        width: currentWidth * dpr, // CRITICAL FIX: Multiply by DPR
        height: currentWidth * dpr, // CRITICAL FIX: Multiply by DPR
        phi: basePhiRef.current,
        theta: thetaRef.current,
        dark: isDarkMode ? 1 : 0,
        diffuse: 1.2,
        scale: 1,
        mapSamples: 16000,
        mapBrightness: 6,
        baseColor: isDarkMode ? [0.15, 0.15, 0.15] : [1, 1, 1], 
        markerColor: [0.1, 0.6, 1], 
        glowColor: isDarkMode ? [0.1, 0.1, 0.1] : [1, 1, 1],
        offset: [0, 0],
        markers: markersRef.current, 
      });
    };

    const animate = () => {
      if (!globe) return;

      if (hoveredRef.current !== null) {
        const project = PROJECTS.find(p => p.id === hoveredRef.current);
        if (project) {
          const targetPhi = -project.lng * (Math.PI / 180);
          const targetTheta = project.lat * (Math.PI / 180) * 0.45;
          
          // Shortest path rotation logic
          let phiDiff = targetPhi - basePhiRef.current;
          phiDiff = Math.atan2(Math.sin(phiDiff), Math.cos(phiDiff));
          basePhiRef.current += phiDiff * 0.08;
          
          let thetaDiff = targetTheta - thetaRef.current;
          thetaRef.current += thetaDiff * 0.08;
        }
      } else {
        if (pointerRef.current === null) {
          basePhiRef.current += 0.003; 
        }
        thetaRef.current += (0.2 - thetaRef.current) * 0.08; 
      }

      globe.update({
        phi: basePhiRef.current + r.get(),
        theta: thetaRef.current,
        width: currentWidth * dpr, // CRITICAL FIX: Keep sizing accurate per frame
        height: currentWidth * dpr,
        markers: markersRef.current
      });

      animationFrameId = requestAnimationFrame(animate);
    };

    // CRITICAL FIX: ResizeObserver guarantees the globe never renders at 0x0 pixels
    const resizeObserver = new ResizeObserver((entries) => {
      for (let entry of entries) {
        const newWidth = entry.contentRect.width;
        if (newWidth > 0 && newWidth !== currentWidth) {
          currentWidth = newWidth;
          if (!globe) {
            initGlobe();
            animate();
          }
        }
      }
    });

    resizeObserver.observe(containerRef.current);

    // Cleanup
    return () => {
      resizeObserver.disconnect();
      cancelAnimationFrame(animationFrameId);
      if (globe) globe.destroy();
    };
  }, [isDarkMode, r]); // Only re-run if theme changes

  return (
    <div ref={containerRef} className="flex justify-center items-center w-full max-w-[600px] aspect-square relative z-10">
      
      <style>{`
        .marker-label {
          position: absolute;
          bottom: anchor(top);
          left: anchor(center);
          translate: -50% 0;
        }
        
        @supports not ((position-anchor: --test) or (anchor-name: --test)) {
          .marker-label {
            bottom: auto;
            left: auto;
            right: 24px;
            top: var(--fallback-top);
            translate: 0 0;
            opacity: 1 !important; 
          }
        }
      `}</style>

      <canvas
        ref={canvasRef}
        style={{ 
          width: "100%", 
          height: "100%", 
          cursor: "grab", 
          contain: "layout paint size",
          opacity: 0.95
        }}
        onPointerDown={(e) => {
          pointerRef.current = e.clientX;
          basePhiRef.current += r.get();
          api.start({ r: 0, immediate: true });
          if (canvasRef.current) canvasRef.current.style.cursor = 'grabbing';
        }}
        onPointerUp={() => {
          pointerRef.current = null;
          if (canvasRef.current) canvasRef.current.style.cursor = 'grab';
        }}
        onPointerOut={() => {
          pointerRef.current = null;
          if (canvasRef.current) canvasRef.current.style.cursor = 'grab';
        }}
        onPointerMove={(e) => {
          if (pointerRef.current !== null) {
            const delta = e.clientX - pointerRef.current;
            api.start({ r: delta / 200 });
          }
        }}
      />

      {filteredProjects.map((p, index) => {
        const isHovered = hoveredProject === p.id;
        return (
          <div
            key={p.id}
            className={`marker-label pointer-events-none whitespace-nowrap px-2 py-1 mb-2 rounded font-bold text-[10px] uppercase tracking-wider transition-all duration-300 ${
              isDarkMode 
                ? 'bg-[#1a1a1a] text-white border border-white/10' 
                : 'bg-white text-gray-900 border border-black/10 shadow-sm'
            } ${isHovered ? 'scale-110 z-50 ring-2 ring-blue-500' : 'scale-100 z-10'}`}
            style={{
              positionAnchor: `--cobe-project-${p.id}`,
              opacity: `var(--cobe-visible-project-${p.id}, 0)`,
              zIndex: isHovered ? 50 : 10,
              '--fallback-top': `${(index * 32) + 24}px`
            }}
          >
            {p.region}
          </div>
        );
      })}

    </div>
  );
};

// ─── UI COMPONENTS ─────────────────────────────────────────────────────────
const FilterSection = ({ title, options, activeFilter, onFilterChange, isDarkMode }) => (
  <div className="mb-6">
    <h3 className={`font-bold text-sm mb-3 transition-colors ${isDarkMode ? 'text-gray-200' : 'text-gray-900'}`}>{title}</h3>
    <div className="flex flex-wrap gap-2">
      {options.map((opt, idx) => (
        <button key={idx} onClick={() => onFilterChange(opt)} className={`px-4 py-1.5 border rounded-full text-xs font-medium transition-all duration-200 ${activeFilter === opt ? (isDarkMode ? 'text-white border-blue-500 bg-blue-600 shadow-sm' : 'text-white border-blue-600 bg-blue-600 shadow-sm') : (isDarkMode ? 'text-gray-400 bg-gray-900 border-gray-800 hover:bg-gray-800 hover:text-white' : 'text-gray-600 bg-white border-gray-200 hover:bg-gray-50 hover:border-gray-300')}`}>
          {opt}
        </button>
      ))}
    </div>
  </div>
);

const ProjectCard = ({ project, isDarkMode, isHovered, onMouseEnter, onMouseLeave }) => (
  <div onMouseEnter={onMouseEnter} onMouseLeave={onMouseLeave} className={`border rounded-xl overflow-hidden transition-all duration-300 mb-6 group flex flex-col cursor-pointer ${isDarkMode ? `bg-gray-900 ${isHovered ? 'border-blue-500 shadow-[0_0_15px_rgba(59,130,246,0.3)] -translate-y-1' : 'border-gray-800 hover:border-gray-700 shadow-sm'}` : `bg-white ${isHovered ? 'border-blue-500 shadow-lg shadow-blue-500/20 -translate-y-1' : 'border-gray-200 hover:border-blue-200 shadow-sm'}`}`}>
    <div className="h-40 w-full overflow-hidden relative">
      <img src={project.image} alt={project.title} className={`w-full h-full object-cover transform transition-transform duration-500 ${isHovered ? 'scale-105' : 'group-hover:scale-105'}`} />
    </div>
    <div className="p-5 flex flex-col flex-grow">
      <h3 className={`font-bold text-lg mb-3 leading-tight transition-colors ${isDarkMode ? 'text-white' : 'text-gray-900'} ${isHovered ? (isDarkMode ? 'text-blue-400' : 'text-blue-700') : 'group-hover:text-blue-600'}`}>{project.title}</h3>
      <div className="flex flex-wrap gap-2 mb-3">
        <span className="bg-[#1e3a8a] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wide">{project.region}</span>
        {project.partners.map((partner, i) => <span key={i} className={`text-[10px] font-medium px-3 py-1 rounded-full border transition-colors ${isDarkMode ? 'bg-gray-800 text-gray-300 border-gray-700' : 'bg-white text-gray-600 border-gray-200'}`}>{partner}</span>)}
      </div>
      <p className={`text-xs leading-relaxed mt-1 transition-colors ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>{project.description}</p>
    </div>
  </div>
);

// ─── MAIN PAGE ─────────────────────────────────────────────────────────────
export default function ProjectsPage() {
  const { isDarkMode } = useTheme();

  const [hoveredProject, setHoveredProject] = useState(null);
  const [searchQuery, setSearchQuery] = useState('');
  const [regionFilter, setRegionFilter] = useState('All');
  const [partnerFilter, setPartnerFilter] = useState('All');
  const [categoryFilter, setCategoryFilter] = useState('All');

  const filteredProjects = PROJECTS.filter((project) => {
    if (searchQuery) {
      const q = searchQuery.toLowerCase();
      return project.title.toLowerCase().includes(q) || project.description.toLowerCase().includes(q) || project.region.toLowerCase().includes(q) || project.partners.some(p => p.toLowerCase().includes(q));
    }
    return (regionFilter === 'All' || project.region === regionFilter) && (partnerFilter === 'All' || project.partners.includes(partnerFilter)) && (categoryFilter === 'All' || project.category === categoryFilter);
  });

  return (
    <div className={`flex flex-col h-screen font-sans overflow-hidden transition-colors duration-300 ${isDarkMode ? 'bg-[#050505] text-white' : 'bg-[#f4f7fc] text-gray-900'}`}>
      <header className={`flex-none relative top-0 z-50 w-full border-b shadow-sm transition-colors duration-300 ${isDarkMode ? 'bg-[#050505] border-gray-800' : 'bg-white border-gray-100'}`}>
        <NavBar />
      </header>

      <main className="flex flex-1 overflow-hidden relative transition-all duration-300 ease-in-out">
        
        {/* GLOBE AREA */}
        <div className={`flex-1 relative overflow-hidden flex items-center justify-center transition-colors duration-300 ${isDarkMode ? 'bg-[#050505]' : 'bg-[#eef2fa]'}`}>
          
          <div className="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div className={`w-[500px] h-[500px] rounded-full blur-[100px] opacity-30 ${isDarkMode ? 'bg-blue-600' : 'bg-blue-300'}`} />
          </div>

          <Globe filteredProjects={filteredProjects} hoveredProject={hoveredProject} isDarkMode={isDarkMode} />

          <div className={`absolute bottom-8 left-8 z-20 backdrop-blur-md px-5 py-3 rounded-xl border shadow-lg transition-colors pointer-events-none ${isDarkMode ? 'bg-black/40 border-white/10' : 'bg-white/80 border-gray-200'}`}>
            <div className={`flex items-center space-x-3 text-xs font-medium ${isDarkMode ? 'text-white' : 'text-gray-700'}`}>
              <MapPin size={16} className="text-blue-500" />
              <span>Drag to rotate · Hover a card to focus</span>
            </div>
          </div>
        </div>

        {/* SIDEBAR AREA */}
        <div className={`w-full lg:w-[480px] flex-shrink-0 border-l overflow-y-auto custom-scrollbar transition-colors duration-300 ${isDarkMode ? 'bg-[#0a0a0a] border-gray-800' : 'bg-white border-gray-200 shadow-xl'}`}>
          <div className="p-8">
            <h2 className={`text-2xl font-bold mb-5 transition-colors ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>Find Projects</h2>
            
            <div className="relative mb-8">
              <Search className={`absolute left-3.5 top-3 ${isDarkMode ? 'text-gray-500' : 'text-gray-400'}`} size={16} />
              <input type="text" placeholder="Search projects by title, region, or partner..." value={searchQuery} onChange={(e) => setSearchQuery(e.target.value)} className={`w-full pl-10 pr-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-1 transition-all ${isDarkMode ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500' : 'bg-gray-50 border-gray-200 text-gray-900 focus:border-blue-600 focus:ring-blue-600'}`} />
            </div>

            {!searchQuery && (
              <>
                <FilterSection title="Region" options={['All', 'North America', 'Europe', 'Asia', 'South America', 'Africa']} activeFilter={regionFilter} onFilterChange={setRegionFilter} isDarkMode={isDarkMode} />
                <FilterSection title="Partners" options={['All', 'IBM', 'Microsoft', 'Siemens', 'EDF', 'Philips', 'Telemed Asia', 'AgriChain', 'LogiTech', 'World Bank', 'CityNet Africa']} activeFilter={partnerFilter} onFilterChange={setPartnerFilter} isDarkMode={isDarkMode} />
                <FilterSection title="Category" options={['All', 'Technology', 'Energy', 'Healthcare', 'Logistics', 'Infrastructure']} activeFilter={categoryFilter} onFilterChange={setCategoryFilter} isDarkMode={isDarkMode} />
                <div className={`my-8 h-px transition-colors ${isDarkMode ? 'bg-gray-800' : 'bg-gray-200'}`} />
              </>
            )}

            <div className="flex justify-between items-center mb-6">
              <h2 className={`text-lg font-bold transition-colors ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>Filtered Results ({filteredProjects.length})</h2>
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
                <div className={`text-sm text-center py-10 ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>No projects match your search criteria. Try adjusting your filters!</div>
              )}
            </div>
          </div>
        </div>
      </main>
    </div>
  );
}