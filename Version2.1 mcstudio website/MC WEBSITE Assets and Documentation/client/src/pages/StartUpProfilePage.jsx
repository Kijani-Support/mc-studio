import React from 'react';
import { useTheme } from '../components/context/ThemeContext'; // <-- Import the hook
import NavBar from "../components/NavBar";
import Footer from "../components/Footer";
import ProfilePageImage from "../assets/images/ProfilePage.jpg";
import Achievements from "../components/profile_page/Achievements";
import Services from "../components/profile_page/Services";
import CaseStudies from "../components/profile_page/CaseStudies";

// Import icons from lucide-react
import { 
  DollarSign, Users, TrendingUp, Globe, 
  Code, Palette, ShieldCheck, Compass, Megaphone, Lightbulb 
} from 'lucide-react';

const StartUpProfilePage = () => {
  // Get the global dark mode state
  const { isDarkMode } = useTheme();

  return (
    <div className={`flex flex-col min-h-screen font-sans w-full overflow-x-hidden transition-colors duration-300 ${
      isDarkMode ? 'bg-black text-white' : 'bg-gray-50 text-gray-900'
    }`}>
      
      {/* FIX ADDED HERE: 
        Wrap the NavBar in a fixed container with high z-index to pin it to the top.
      */}
      <div className="fixed top-0 left-0 w-full z-50">
        <NavBar />
      </div>

      <main className="flex-grow">
        {/* Hero Section */}
        <section className={`w-full pt-32 sm:pt-40 py-24 px-8 sm:px-12 grid gap-12 sm:gap-16 sm:grid-cols-2 items-center justify-items-center transition-colors duration-300 ${
          isDarkMode ? 'bg-gray-900/40' : 'bg-[#f4f6f9]'
        }`}>
          <div className="grid gap-4 sm:gap-6 w-full sm:w-[80%]">
            <h1 className={`text-4xl sm:text-5xl font-extrabold leading-tight ${
              isDarkMode ? 'text-white' : 'text-gray-900'
            }`}>
              QuantumLeap Innovations
            </h1>
            <h2 className={`font-bold text-xl sm:text-2xl ${
              isDarkMode ? 'text-gray-400' : 'text-gray-500'
            }`}>
              Pioneering the Future of{" "}
              <span className={isDarkMode ? 'text-blue-400' : 'text-blue-600'}>AI-Driven Solutions</span>
            </h2>
            <p className={`text-sm sm:text-base leading-relaxed ${
              isDarkMode ? 'text-gray-300' : 'text-gray-600'
            }`}>
              QuantumLeap innovations is at the forefront of developing
              groundbreaking technologies that revolutionize industries. From
              advanced predictive analytics to intelligent automation platforms,
              our solutions empower businesses to achieve unprecedented efficiency
              and innovation. We are committed to pushing the boundaries of what is
              possible with artificial intelligence, creating a smarter, more
              connected world.
            </p>

            {/* Buttons */}
            <div className="flex flex-wrap gap-4 pt-6">
              <button className={`text-sm font-semibold rounded-lg py-2.5 px-6 transition-colors shadow-lg ${
                isDarkMode ? 'bg-blue-600 hover:bg-blue-500 text-white shadow-blue-900/20' : 'bg-blue-700 hover:bg-blue-800 text-white shadow-blue-200'
              }`}>
                Apply Now
              </button>
              <button className={`text-sm font-semibold rounded-lg py-2.5 px-6 border-2 transition-colors ${
                isDarkMode 
                  ? 'bg-transparent border-gray-600 text-gray-300 hover:border-gray-400 hover:text-white' 
                  : 'bg-gray-900 border-gray-900 text-white hover:bg-black hover:border-black'
              }`}>
                Contact Us
              </button>
            </div>
          </div>
          
          <div className="w-full flex justify-center items-center">
            <img 
              src={ProfilePageImage} 
              alt="Devs collaborating"  
              className={`w-full max-w-md shadow-2xl rounded-2xl object-cover transition-all ${
                isDarkMode ? 'shadow-blue-900/20 opacity-90' : 'shadow-gray-300'
              }`}
            />
          </div>
        </section>

        {/* Achievement Section */}
        <section className={`py-20 px-4 sm:px-12 grid gap-12 items-center justify-items-center transition-colors duration-300 ${
          isDarkMode ? 'bg-black border-y border-gray-800' : 'bg-[#15171e]'
        }`}>
          <h2 className="font-bold text-white text-2xl sm:text-3xl text-center">
            Key Metrics & Achievements
          </h2>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 justify-items-center w-full max-w-7xl">
            <Achievements
              isDarkMode={isDarkMode}
              icon={<DollarSign size={28} className="text-blue-500" />}
              title="$75M"
              subTitle="Funding Raised"
              description="Seed & Series B secured"
            />
            <Achievements
              isDarkMode={isDarkMode}
              icon={<Users size={28} className="text-blue-500" />}
              title="120+"
              subTitle="Employee Count"
              description="Dedicated team of innovators"
            />
            <Achievements
              isDarkMode={isDarkMode}
              icon={<TrendingUp size={28} className="text-blue-500" />}
              title="150%"
              subTitle="Annual Growth"
              description="Year-over-year revenue increase"
            />
            <Achievements
              isDarkMode={isDarkMode}
              icon={<Globe size={28} className="text-blue-500" />}
              title="5 Countries"
              subTitle="Global Presence"
              description="Expanding reach and impact"
            />
          </div>
        </section>

        {/* Services Section */}
        <section className={`py-20 px-8 sm:px-20 grid gap-12 items-center justify-items-center transition-colors duration-300 ${
          isDarkMode ? 'bg-gray-900/30' : 'bg-white'
        }`}>
          <h2 className={`font-extrabold text-2xl sm:text-3xl ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
            Services Utilized
          </h2>
          
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl w-full">
            <Services
              isDarkMode={isDarkMode}
              icon={<Code size={24} className={isDarkMode ? 'text-blue-400' : 'text-blue-600'} />}
              title="Custom Software Dev"
              description="Tailored solutions for unique business needs."
            />
            <Services
              isDarkMode={isDarkMode}
              icon={<Palette size={24} className={isDarkMode ? 'text-blue-400' : 'text-blue-600'} />}
              title="UI/UX Design & Proto"
              description="Creating intuitive and engaging user experiences."
            />
            <Services
              isDarkMode={isDarkMode}
              icon={<ShieldCheck size={24} className={isDarkMode ? 'text-blue-400' : 'text-blue-600'} />}
              title="Cybersecurity Consulting"
              description="Ensuring robust protection against digital threats."
            />
            <Services
              isDarkMode={isDarkMode}
              icon={<Compass size={24} className={isDarkMode ? 'text-blue-400' : 'text-blue-600'} />}
              title="Strategic Market Entry"
              description="Guidance for successful expansion into new markets."
            />
            <Services
              isDarkMode={isDarkMode}
              icon={<Megaphone size={24} className={isDarkMode ? 'text-blue-400' : 'text-blue-600'} />}
              title="Brand & Marketing Strategy"
              description="Developing powerful brands and impactful campaigns."
            />
            <Services
              isDarkMode={isDarkMode}
              icon={<Lightbulb size={24} className={isDarkMode ? 'text-blue-400' : 'text-blue-600'} />}
              title="Innovation Workshops"
              description="Fostering creativity and problem-solving within teams."
            />
          </div>
        </section>

        {/* Case Studies Section */}
        <section className={`py-20 px-4 sm:px-12 grid items-center justify-items-center gap-12 transition-colors duration-300 ${
          isDarkMode ? 'bg-black border-t border-gray-800' : 'bg-[#15171e]'
        }`}>
          {/* Changed header color to always be white because the background is dark in both themes */}
          <h2 className="font-bold text-white text-2xl sm:text-3xl text-center">
            Impactful Case Studies
          </h2>

          {/* Changed to flex-col to tile vertically as requested */}
          <div className="flex flex-col gap-6 max-w-5xl w-full">
            <CaseStudies
              isDarkMode={isDarkMode}
              title="Enhancing Customer Engagement for E-commerce Giant"
              description="Our AI chatbots and personalized recommendation engines boosted conversion rates by 15% for a leading online retailer."
              moreInfoBtn="View"
            />
            <CaseStudies
              isDarkMode={isDarkMode}
              title="Streamlining Financial Operations for a Fintech Startup"
              description="Implemented robust, secure backend architectures that reduced processing latency by 40% and improved security compliance."
              moreInfoBtn="View"
            />
            <CaseStudies
              isDarkMode={isDarkMode}
              title="Revolutionizing Agricultural Yield Production"
              description="Deployed IoT sensors and predictive machine learning models to help farmers increase annual crop yields by 22%."
              moreInfoBtn="View"
            />
          </div>
        </section>

        {/* Partners */}
        <section className={`grid w-full items-center justify-items-center py-16 px-12 gap-10 transition-colors duration-300 ${
          isDarkMode ? 'bg-gray-900/50 border-t border-gray-800' : 'bg-white border-t border-gray-200'
        }`}>
          <h2 className={`font-bold text-2xl ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
            Our Valued Partners
          </h2>
          
          <div className="flex flex-wrap justify-center items-center gap-8 sm:gap-16 w-full max-w-5xl opacity-60">
            {/* Replace these text elements with actual partner logos later */}
            <span className={`text-xl font-bold uppercase tracking-widest ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>Partner One</span>
            <span className={`text-xl font-bold uppercase tracking-widest ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>Partner Two</span>
            <span className={`text-xl font-bold uppercase tracking-widest ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>Partner Three</span>
            <span className={`text-xl font-bold uppercase tracking-widest ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>Partner Four</span>
          </div>
        </section>
      </main>

      {/* Footer handles its own theme via Context */}
      <Footer />
    </div>
  );
};

export default StartUpProfilePage;