import React from "react";
import { useTheme } from "@/components/Context/ThemeContext";
import Footer from "@/components/Footer";
import Capture from "@/assets/images/algo2.jpg";
import HomePageImage from "@/assets/images/HomePage.jpg";
import NavBar from "@/components/NavBar";
import Portfolios from "@/components/home_page/Portfolios";
import HeroGlobe from "@/components/home_page/HeroGlobe";

const HomePage = () => {
  const { isDarkMode } = useTheme();

  return (
    <div className={`flex flex-col min-h-screen font-display w-full overflow-x-hidden transition-colors duration-300 ${
      isDarkMode ? 'bg-black text-white' : 'bg-white text-gray-900'
    }`}>
      
      <div className="fixed top-0 left-0 w-full z-50">
        <NavBar />
      </div>

      <main className="flex-grow pt-24 sm:pt-32 grid gap-24 pb-20">
        
        {/* HERO SECTION */}
        <section className="px-4 sm:px-12 grid gap-12 sm:grid-cols-2 items-center mt-8 sm:mt-12">
          <div className="grid gap-6 text-center sm:text-left">
            <h1 className={`text-4xl sm:text-5xl lg:text-6xl font-extrabold max-w-xl leading-tight ${
              isDarkMode ? 'text-white' : 'text-gray-900'
            }`}>
              Innovate, Create, Impact.
            </h1>
            <p className={`text-sm sm:text-base max-w-xl leading-relaxed ${
              isDarkMode ? 'text-gray-300' : 'text-gray-700'
            }`}>
              We empower visionary founders with bespoke web templates and
              strategic design, transforming ambitious ideas into impactful
              digital realities. Discover solutions designed to elevate your
              startup and projects.
            </p>
            <button className={`py-2.5 px-6 rounded-lg w-fit text-sm sm:text-md font-semibold mx-auto sm:mx-0 transition-colors shadow-lg ${
              isDarkMode 
                ? 'bg-blue-600 hover:bg-blue-500 text-white shadow-blue-900/20' 
                : 'bg-blue-900 hover:bg-blue-800 text-white shadow-blue-200'
            }`}>
              Explore Our Work
            </button>
          </div>
          <div className="flex justify-center">
            <img
              src={HomePageImage}
              alt="presentation"
              className={`w-full sm:w-[90%] lg:w-[80%] rounded-2xl object-cover transition-all ${
                isDarkMode ? 'shadow-2xl shadow-blue-900/20 opacity-90' : 'shadow-xl shadow-gray-200'
              }`}
            />
          </div>
        </section>

        {/* PORTFOLIOS */}
        <section className={`py-20 px-4 sm:px-12 grid gap-12 transition-colors duration-300 ${
          isDarkMode ? 'bg-gray-900/40 border-y border-gray-800' : 'bg-gray-50 border-y border-gray-100'
        }`}>
          <h2 className="text-2xl sm:text-3xl font-extrabold text-center">
            Explore Our Startups Portfolio
          </h2>
          <div className="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 max-w-7xl mx-auto w-full">
            <Portfolios
              isDarkMode={isDarkMode}
              pic={Capture}
              title="The Future of Web Design: Trends of 2024"
              description="Explore the cutting-edge trends shaping web design in 2024."
              author="By Jane Doe | October 26, 2023"
            />
            <Portfolios
              isDarkMode={isDarkMode}
              pic={Capture}
              title="Building Scalable Startups"
              description="Foundational principles to build and scale a startup."
              author="By John Smith | October 20, 2023"
            />
            <Portfolios
              isDarkMode={isDarkMode}
              pic={Capture}
              title="Leverage AI in Project Management"
              description="How AI enhances efficiency and prediction."
              author="By Alice Johnson | October 15, 2023"
            />
          </div>
        </section>

        {/* STARTUPS GRID */}
        <section className="px-4 sm:px-16 grid gap-12 max-w-7xl mx-auto w-full">
          <h2 className="text-2xl sm:text-3xl font-extrabold text-center">
            Our Startups
          </h2>
          <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            {["CloudForge", "BrightSpark", "NexusHub", "RocketReach"].map(
              (item) => (
                <div
                  key={item}
                  className={`rounded-xl p-6 grid gap-4 justify-items-center transition-all duration-300 ${
                    isDarkMode 
                      ? 'bg-gray-900/80 border border-gray-800 hover:shadow-blue-900/10' 
                      : 'bg-white shadow-xl hover:shadow-2xl shadow-gray-200'
                  }`}
                >
                  <img src={Capture} alt="" className="w-24 rounded-lg object-cover" />
                  <div className="text-center">
                    <h3 className="font-bold text-lg">{item}</h3>
                    <p className={`text-sm mt-1 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
                      Innovating digital solutions
                    </p>
                  </div>
                </div>
              )
            )}
          </div>
        </section>

        {/* GLOBAL REACH */}
        <section className="px-4 grid gap-10 text-center">
          <div className="max-w-2xl mx-auto grid gap-4">
            <h2 className="text-3xl font-bold">
              Global Reach, Local Impact
            </h2>
            <p className={`leading-relaxed ${isDarkMode ? 'text-gray-400' : 'text-gray-700'}`}>
              Explore our projects worldwide and how we connect communities
              across the globe.
            </p>
          </div>

          {/* GLOBE CONTAINER */}
          <div className={`relative overflow-hidden rounded-3xl h-[400px] sm:h-[500px] w-full max-w-6xl mx-auto transition-colors duration-300 ${
            isDarkMode ? 'bg-gray-900/50 border border-gray-800' : 'bg-gray-50 border border-gray-200 shadow-inner'
          }`}>
            
            <HeroGlobe isDarkMode={isDarkMode} />
            
            {/* Inner Glow / Vignette */}
            <div className="absolute inset-0 pointer-events-none rounded-3xl shadow-[inset_0_0_40px_rgba(0,0,0,0.1)] dark:shadow-[inset_0_0_60px_rgba(0,0,0,0.5)] z-20" />
          </div>
        </section>

        {/* TRUSTED BY */}
        <section className="px-4 sm:px-12 grid gap-12 text-center max-w-7xl mx-auto w-full">
          <h2 className="text-2xl sm:text-3xl font-bold">
            Trusted by Industry Leaders
          </h2>
          <div className="flex flex-wrap gap-8 justify-center items-center opacity-70">
            {Array(5)
              .fill(0)
              .map((_, i) => (
                <div key={i} className={`h-16 w-28 sm:h-20 sm:w-32 rounded-lg overflow-hidden ${
                  isDarkMode ? 'bg-gray-800' : 'bg-gray-200'
                }`}>
                  <img
                    src={Capture}
                    alt="Partner Logo"
                    className="w-full h-full object-cover mix-blend-multiply filter grayscale"
                  />
                </div>
              ))}
          </div>
        </section>

        {/* NEWSLETTER */}
        <section className={`py-24 px-4 grid gap-8 text-center transition-colors duration-300 ${
          isDarkMode ? 'bg-gray-900/50 border-t border-gray-800' : 'bg-gray-100 border-t border-gray-200'
        }`}>
          <h2 className="text-2xl sm:text-3xl font-bold max-w-xl mx-auto">
            Stay Ahead. Join Our Newsletter.
          </h2>
          <p className={`max-w-lg mx-auto ${isDarkMode ? 'text-gray-400' : 'text-gray-700'}`}>
            Receive exclusive insights, updates, and offers.
          </p>
          <form 
            onSubmit={(e) => e.preventDefault()} 
            className="flex flex-col sm:flex-row gap-4 justify-center max-w-2xl mx-auto w-full"
          >
            <input
              type="email"
              placeholder="Your Email Address"
              className={`px-4 py-3 rounded-lg w-full sm:w-80 border focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors ${
                isDarkMode 
                  ? 'bg-black border-gray-700 text-white placeholder-gray-500' 
                  : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400'
              }`}
              required
            />
            <button 
              type="submit"
              className={`font-semibold px-8 py-3 rounded-lg transition-colors ${
                isDarkMode 
                  ? 'bg-blue-600 hover:bg-blue-500 text-white' 
                  : 'bg-blue-900 hover:bg-blue-800 text-white'
              }`}
            >
              Subscribe
            </button>
          </form>
        </section>

      </main>

      <Footer />
    </div>
  );
};

export default HomePage;