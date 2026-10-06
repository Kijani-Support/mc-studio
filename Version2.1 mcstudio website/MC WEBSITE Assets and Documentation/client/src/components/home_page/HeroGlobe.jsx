import React, { useEffect, useRef } from "react";
import createGlobe from 'cobe';

// ─── THEME CONFIGURATION ──────────────────────────────────────────────────
// A consistent vibrant blue for all dots and arcs (matches Tailwind blue-500)
const BLUE_COLOR = [59 / 255, 130 / 255, 246 / 255]; 

// Core project coordinates
const PROJECTS = [
  { region: "North America", lat: 40.7128, lng: -74.0060 },
  { region: "Europe", lat: 48.8566, lng: 2.3522 },
  { region: "Asia", lat: 35.6762, lng: 139.6503 },
  { region: "South America", lat: -23.5505, lng: -46.6333 },
  { region: "Africa", lat: -1.2921, lng: 36.8219 }
];

const AFRICA_COORDS = [-1.2921, 36.8219];

// Network connections: All regions converging onto Africa
const ARCS = [
  { from: [40.7128, -74.0060], to: AFRICA_COORDS },  // NA to Africa
  { from: [48.8566, 2.3522], to: AFRICA_COORDS },    // Europe to Africa
  { from: [35.6762, 139.6503], to: AFRICA_COORDS },  // Asia to Africa
  { from: [-23.5505, -46.6333], to: AFRICA_COORDS }, // South America to Africa
];

// ─── COMPONENT ────────────────────────────────────────────────────────────
const HeroGlobe = ({ isDarkMode }) => {
  const canvasRef = useRef();
  const containerRef = useRef(); 

  const basePhiRef = useRef(0);
  // NEGATIVE THETA: Tilts the globe forward to show the Southern Hemisphere prominently
  const thetaRef = useRef(-0.5); 
  const markersRef = useRef([]);

  useEffect(() => {
    // Generate uniform blue markers (Size halved from 0.05 to 0.025)
    markersRef.current = PROJECTS.map(p => ({
      location: [p.lat, p.lng],
      size: 0.025, 
      color: BLUE_COLOR, 
    }));
  }, []);

  useEffect(() => {
    if (!canvasRef.current || !containerRef.current) return;

    let globe = null;
    let animationFrameId;
    let currentWidth = 0;
    const dpr = window.devicePixelRatio || 2; 

    const initGlobe = () => {
      if (globe) globe.destroy();
      
      globe = createGlobe(canvasRef.current, {
        devicePixelRatio: dpr,
        width: currentWidth * dpr, 
        height: currentWidth * dpr,
        phi: basePhiRef.current,
        theta: thetaRef.current, 
        dark: isDarkMode ? 1 : 0,
        diffuse: 1.2,
        scale: 1.0, // Makes the globe fill the viewport beautifully
        mapSamples: 10000,
        mapBrightness: 7,
        baseColor: isDarkMode ? [0.15, 0.15, 0.15] : [1, 1, 1], 
        glowColor: isDarkMode ? [0.1, 0.1, 0.1] : [1, 1, 1],
        
        // Offset reset to 0,0 since we are now using pure Absolute Centering in CSS
        offset: [0, 400], 
        
        // Data injected here
        markers: markersRef.current, 
        markerColor: BLUE_COLOR,
        arcs: ARCS,
        arcColor: BLUE_COLOR,
        arcWidth: 0.25,   
        arcHeight: 0.25,  
      });
    };

    const animate = () => {
      if (!globe) return;

      // Constant smooth auto-rotation
      basePhiRef.current += 0.003; 

      globe.update({
        phi: basePhiRef.current,
        theta: thetaRef.current, 
        width: currentWidth * dpr, 
        height: currentWidth * dpr,
        markers: markersRef.current
      });

      animationFrameId = requestAnimationFrame(animate);
    };

    const resizeObserver = new ResizeObserver(() => {
      if (canvasRef.current) {
        const newWidth = canvasRef.current.offsetWidth;
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

    return () => {
      resizeObserver.disconnect();
      cancelAnimationFrame(animationFrameId);
      if (globe) globe.destroy();
    };
  }, [isDarkMode]); 

  return (
    <div ref={containerRef} className="w-full h-full relative z-10">
      <canvas
        ref={canvasRef}
        // CRITICAL FIX: Absolute positioning forces the exact center of the square canvas 
        // to lock to the exact center of the parent div, regardless of their height differences.
        className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none" 
        style={{ 
          width: "100%", 
          maxWidth: "1000px",     
          aspectRatio: "1 / 1",   
          contain: "layout paint size",
          opacity: 0.95
        }}
      />
    </div>
  );
};

export default HeroGlobe;