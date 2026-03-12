import React, { useRef } from "react";
import { useTheme } from "../components/Context/ThemeContext"; // <-- Import the custom hook
import NavBar from "../components/NavBar";
import Footer from "../components/Footer";
import Capture from "../assets/images/algo2.jpg";
import OurStartUpComponent from "../components/directory_page/OurStartUpComponent"
import FeaturedStartUpsComponent from "../components/directory_page/FeaturedStartUpsComponent"

// Import icons for the services and filter section
import { 
  Search, LayoutGrid, List, BrainCircuit, Cloud, Database, 
  Palette, Map, LineChart, Code, PenTool, ShieldCheck, 
  Cpu, Rocket, Network, ShoppingCart, Users, Glasses, Truck 
} from 'lucide-react';

// A helper component to render service tags beautifully
const ServiceItem = ({ Icon, text, isDarkMode }) => (
  <span className={`inline-flex items-center gap-1.5 mr-3 mb-2 px-2.5 py-1 rounded-md text-xs font-medium transition-colors ${
    isDarkMode ? 'bg-gray-800 text-gray-300 border border-gray-700' : 'bg-blue-50 text-blue-800 border border-blue-100'
  }`}>
    <Icon size={14} className={isDarkMode ? 'text-blue-400' : 'text-blue-600'} />
    {text}
  </span>
);

const StartUpDirectoryPage = () => {
  // Get the global dark mode state
  const { isDarkMode } = useTheme();

  // Our StartUps component side scrolling feature
  const scrollRef = useRef(null);

  const scrollLeft = () => {
    if (scrollRef.current) {
      scrollRef.current.scrollBy({ left: -300, behavior: "smooth" });
    }
  };

  const scrollRight = () => {
    if (scrollRef.current) {
      scrollRef.current.scrollBy({ left: 300, behavior: "smooth" });
    }
  };

  return (
    <div className={`flex flex-col min-h-screen font-sans w-full overflow-x-hidden transition-colors duration-300 ${
      isDarkMode ? 'bg-black text-white' : 'bg-white text-gray-900'
    }`}>
      {/* NavBar handles its own theme via Context */}
      <NavBar />

      <main className="flex-grow">
        {/* Innovators section */}
        <section className={`w-full pt-32 sm:pt-40 py-20 flex flex-col items-center justify-center px-4 sm:px-12 gap-6 text-center transition-all duration-300 ${
          isDarkMode 
            ? 'bg-gradient-to-tl from-cyan-900/40 via-blue-900/40 to-black text-white' 
            : 'bg-gradient-to-tl from-cyan-400 via-cyan-400 to-blue-500 text-gray-900'
        }`}>
          <h1 className="font-extrabold text-3xl sm:text-4xl">
            Join Our Network of Innovators
          </h1>
          <p className="text-sm md:text-base w-full sm:w-[60%] max-w-2xl font-medium opacity-90">
            Are you a groundbreaking startup looking for strategic partnership and
            growth opportunities? Apply to become part of the StudioModusChora
            ecosystem and accelerate our journey.
          </p>
          <button className={`py-2.5 px-6 rounded-lg font-bold text-sm transition-all shadow-lg hover:-translate-y-0.5 ${
            isDarkMode ? 'bg-blue-600 text-white hover:bg-blue-500' : 'bg-blue-900 text-white hover:bg-blue-800'
          }`}>
            Apply Now
          </button>
        </section>

        {/* Filter section */}
        <section className={`w-full py-12 px-4 transition-colors duration-300 ${isDarkMode ? 'bg-black' : 'bg-white'}`}>
          <div className={`mx-auto flex flex-col sm:flex-row justify-between items-center border rounded-lg shadow-sm p-4 w-full gap-4 max-w-5xl transition-colors duration-300 ${
            isDarkMode ? 'border-gray-800 bg-gray-900/50' : 'border-gray-200 bg-white'
          }`}>
            
            {/* Search Input */}
            <div className="relative w-full sm:w-1/2 md:w-1/3">
              <Search className={`absolute left-3 top-2.5 ${isDarkMode ? 'text-gray-500' : 'text-gray-400'}`} size={16} />
              <input
                type="text"
                placeholder="Search by name or keyword..."
                className={`w-full pl-9 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 transition-colors ${
                  isDarkMode 
                    ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500' 
                    : 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-400'
                }`}
              />
            </div>

            {/* Filter Buttons */}
            <div className="flex flex-wrap gap-3 justify-center items-center w-full sm:w-auto">
              <button className={`border rounded-md text-sm px-4 py-2 transition-colors ${
                isDarkMode ? 'border-gray-700 bg-gray-800 hover:bg-gray-700 text-gray-300' : 'border-gray-300 bg-white hover:bg-gray-50'
              }`}>
                Industry
              </button>
              <button className={`border rounded-md text-sm px-4 py-2 transition-colors ${
                isDarkMode ? 'border-gray-700 bg-gray-800 hover:bg-gray-700 text-gray-300' : 'border-gray-300 bg-white hover:bg-gray-50'
              }`}>
                Stage
              </button>

              {/* View Toggles (Replaced ||| and = with actual icons) */}
              <div className={`flex border rounded-md overflow-hidden transition-colors ${isDarkMode ? 'border-gray-700' : 'border-gray-300'}`}>
                <button className={`p-2 transition-colors ${isDarkMode ? 'bg-gray-700 text-white' : 'bg-gray-200 text-gray-900'}`}>
                  <LayoutGrid size={16} />
                </button>
                <button className={`p-2 transition-colors ${isDarkMode ? 'bg-gray-900 hover:bg-gray-800 text-gray-500' : 'bg-white hover:bg-gray-50 text-gray-500'}`}>
                  <List size={16} />
                </button>
              </div>
            </div>
          </div>
        </section>

        {/* Featured startups section */}
        <section className={`py-16 px-4 sm:px-12 lg:px-20 transition-colors duration-300 ${isDarkMode ? 'bg-gray-900/30' : 'bg-gray-50'}`}>
          <h2 className="font-extrabold text-2xl sm:text-3xl mb-10 max-w-7xl mx-auto">Featured StartUps</h2>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
            <FeaturedStartUpsComponent
              isDarkMode={isDarkMode}
              pic={Capture}
              title="QuantumLeap AI"
              field="Artificial Intelligence"
              stage="Series B"
              description="Developing cutting-edge AI solutions for predictive analytics and automation."
              services={
                <div className="flex flex-wrap mt-3">
                  <ServiceItem isDarkMode={isDarkMode} Icon={BrainCircuit} text="AI Development" />
                  <ServiceItem isDarkMode={isDarkMode} Icon={Cloud} text="Cloud Infra" />
                  <ServiceItem isDarkMode={isDarkMode} Icon={Database} text="Data Science" />
                </div>
              }
            />
            
            <FeaturedStartUpsComponent
              isDarkMode={isDarkMode}
              pic={Capture}
              title="EcoHarvest Farms"
              field="Sustainable Agriculture"
              stage="Seed"
              description="Innovating hydroponic systems for urban farming and sustainable food."
              services={
                <div className="flex flex-wrap mt-3">
                  <ServiceItem isDarkMode={isDarkMode} Icon={Palette} text="Product Design" />
                  <ServiceItem isDarkMode={isDarkMode} Icon={Map} text="Supply Chain" />
                  <ServiceItem isDarkMode={isDarkMode} Icon={LineChart} text="Market Research" />
                </div>
              }
            />
            
            <FeaturedStartUpsComponent
              isDarkMode={isDarkMode}
              pic={Capture}
              title="MediConnect Global"
              field="Health Tech"
              stage="Series A"
              description="A platform connecting patients with specialist doctors globally through telemedicine."
              services={
                <div className="flex flex-wrap mt-3">
                  <ServiceItem isDarkMode={isDarkMode} Icon={Code} text="Platform Dev" />
                  <ServiceItem isDarkMode={isDarkMode} Icon={PenTool} text="UI/UX Design" />
                  <ServiceItem isDarkMode={isDarkMode} Icon={ShieldCheck} text="Compliance" />
                </div>
              }
            />
            
            <FeaturedStartUpsComponent
              isDarkMode={isDarkMode}
              pic={Capture}
              title="AeroDynamics"
              field="Aerospace"
              stage="Series C"
              description="Pioneering drone technology for logistics and environmental monitoring."
              services={
                <div className="flex flex-wrap mt-3">
                  <ServiceItem isDarkMode={isDarkMode} Icon={Cpu} text="Hardware Proto" />
                  <ServiceItem isDarkMode={isDarkMode} Icon={Code} text="Software Eng" />
                  <ServiceItem isDarkMode={isDarkMode} Icon={Rocket} text="Aero Testing" />
                </div>
              }
            />
          </div>
        </section>

        {/* Our startup section */}
        <section className={`py-16 px-4 sm:px-12 lg:px-20 transition-colors duration-300 ${isDarkMode ? 'bg-black' : 'bg-gray-100'}`}>
          <h2 className="font-extrabold text-2xl sm:text-3xl mb-10 max-w-7xl mx-auto">Our StartUps</h2>

          <div className="relative w-full max-w-7xl mx-auto">
            {/* Left Scroll Button */}
            <button
              onClick={scrollLeft}
              className={`absolute -left-4 top-1/2 -translate-y-1/2 p-3 rounded-full shadow-lg z-10 transition-colors duration-300 hidden md:flex ${
                isDarkMode ? 'bg-gray-800 text-blue-400 hover:bg-gray-700' : 'bg-white text-blue-800 hover:bg-blue-50'
              }`}
            >
              {"<<"}
            </button>

            <div 
              ref={scrollRef} 
              className="flex gap-6 flex-nowrap overflow-x-auto scroll-smooth pb-8 pt-2 scrollbar-hide px-2"
            >
              <OurStartUpComponent 
                isDarkMode={isDarkMode}
                pic={Capture}
                title="QuantumLeap AI"
                subTitle="Artificial Intelligence"
                stage="Series B"
                solution="Developing Cutting-edge AI solutions for predictive analytics and automation."
                services={
                  <div className="flex flex-wrap mt-2">
                    <ServiceItem isDarkMode={isDarkMode} Icon={BrainCircuit} text="AI Dev" />
                    <ServiceItem isDarkMode={isDarkMode} Icon={Cloud} text="Cloud Infra" />
                  </div>
                }
              />

              <OurStartUpComponent 
                isDarkMode={isDarkMode}
                pic={Capture}
                title="EcoHarvest Farms"
                subTitle="Sustainable Agriculture"
                stage="Seed"
                solution="Innovating hydroponic systems for urban farming and sustainable food"
                services={
                  <div className="flex flex-wrap mt-2">
                    <ServiceItem isDarkMode={isDarkMode} Icon={Map} text="Optimization" />
                    <ServiceItem isDarkMode={isDarkMode} Icon={LineChart} text="Research" />
                  </div>
                }
              />

              <OurStartUpComponent 
                isDarkMode={isDarkMode}
                pic={Capture}
                title="MediConnect Global"
                subTitle="Health Tech"
                stage="Series B"
                solution="A platform connecting patients with specialist doctors globally through telemedicine"
                services={
                  <div className="flex flex-wrap mt-2">
                    <ServiceItem isDarkMode={isDarkMode} Icon={Code} text="Platform Dev" />
                    <ServiceItem isDarkMode={isDarkMode} Icon={ShieldCheck} text="Compliance" />
                  </div>
                }
              />

              <OurStartUpComponent 
                isDarkMode={isDarkMode}
                pic={Capture}
                title="FinFlow Insights"
                subTitle="Fintech"
                stage="Growth"
                solution="Advanced financial analytics tools for retail investors to track assets."
                services={
                  <div className="flex flex-wrap mt-2">
                    <ServiceItem isDarkMode={isDarkMode} Icon={LineChart} text="Data Viz" />
                    <ServiceItem isDarkMode={isDarkMode} Icon={Network} text="API Int" />
                  </div>
                }
              />

              <OurStartUpComponent 
                isDarkMode={isDarkMode}
                pic={Capture}
                title="ArtisanCraft Market"
                subTitle="E-commerce"
                stage="Seed"
                solution="An online marketplace for independent artisans to sell crafted goods."
                services={
                  <div className="flex flex-wrap mt-2">
                    <ServiceItem isDarkMode={isDarkMode} Icon={ShoppingCart} text="E-commerce" />
                    <ServiceItem isDarkMode={isDarkMode} Icon={Users} text="Community" />
                  </div>
                }
              />

              <OurStartUpComponent 
                isDarkMode={isDarkMode}
                pic={Capture}
                title="NeuroSense VR"
                subTitle="Virtual Reality"
                stage="Series A"
                solution="Immersive VR experience for therapy and cognitive training solutions."
                services={
                  <div className="flex flex-wrap mt-2">
                    <ServiceItem isDarkMode={isDarkMode} Icon={Glasses} text="VR Content" />
                    <ServiceItem isDarkMode={isDarkMode} Icon={Code} text="Dev" />
                  </div>
                }
              />

              <OurStartUpComponent 
                isDarkMode={isDarkMode}
                pic={Capture}
                title="GigaLogistics"
                subTitle="Logistics"
                stage="Series B"
                solution="Optimizing global supply chains with AI-driven route planning models."
                services={
                  <div className="flex flex-wrap mt-2">
                    <ServiceItem isDarkMode={isDarkMode} Icon={Truck} text="Logistics" />
                    <ServiceItem isDarkMode={isDarkMode} Icon={BrainCircuit} text="AI Opt" />
                  </div>
                }
              />
            </div>

            {/* Right Scroll Button */}
            <button
              onClick={scrollRight}
              className={`absolute -right-4 top-1/2 -translate-y-1/2 p-3 rounded-full shadow-lg z-10 transition-colors duration-300 hidden md:flex ${
                isDarkMode ? 'bg-gray-800 text-blue-400 hover:bg-gray-700' : 'bg-white text-blue-800 hover:bg-blue-50'
              }`}
            >
              {">>"}
            </button>
          </div>
        </section>
      </main>

      {/* Footer handles its own theme via Context */}
      <Footer />
    </div>
  );
};

export default StartUpDirectoryPage;