import React from 'react';
import { Link, useLocation } from 'react-router-dom'; // <-- Import useLocation
import { Sun, Moon } from 'lucide-react';
import { useTheme } from '../components/context/ThemeContext';

const NavBar = () => {
  const { isDarkMode, toggleTheme } = useTheme();
  const location = useLocation(); // <-- Get the current route/URL

  // Helper function to dynamically set the link styles based on the active page
  const getLinkClass = (path) => {
    // Check if the current URL matches the link's path
    // (Added a check so that any article page highlights the "Media" link)
    const isActive = location.pathname === path || (path.startsWith('/article') && location.pathname.startsWith('/article'));

    if (isActive) {
      // ACTIVE STATE
      return `transition-colors font-bold ${
        isDarkMode ? 'text-blue-400' : 'text-blue-700'
      }`;
    }
    
    // INACTIVE STATE
    return `transition-colors font-medium hover:text-blue-500 ${
      isDarkMode ? 'text-gray-400' : 'text-gray-600'
    }`;
  };

  return (
    <nav className={`flex items-center justify-between px-8 py-5 w-full transition-colors duration-300 ${
      isDarkMode ? 'bg-black text-white' : 'bg-white text-gray-900'
    }`}>
      
      {/* BRAND / LOGO */}
      <div className={`text-2xl font-bold transition-colors duration-300 ${
        isDarkMode ? 'text-blue-400' : 'text-blue-900'
      }`}>
        <Link to="/">modus chora studio</Link>
      </div>

      {/* NAVIGATION LINKS */}
      <div className="hidden md:flex space-x-8 text-sm">
        <Link to="/" className={getLinkClass('/')}>
          Home
        </Link>
        <Link to="/directory" className={getLinkClass('/directory')}>
          Startups
        </Link>
        <Link to="/projects" className={getLinkClass('/projects')}>
          Projects
        </Link>
        <Link to="/case-studies" className={getLinkClass('/case-studies')}>
          Case Studies
        </Link>
        <Link to="/services" className={getLinkClass('/services')}>
          Services
        </Link>
        <Link to="/article/1" className={getLinkClass('/article/1')}>
          Media
        </Link>
      </div>

      {/* ACTIONS: THEME TOGGLE & CONTACT BUTTON */}
      <div className="flex items-center space-x-4">
        
        {/* The Global Theme Toggle Button */}
        <button 
          onClick={toggleTheme} 
          className={`p-2 rounded-full transition-all duration-300 ${
            isDarkMode 
              ? 'bg-gray-800 text-yellow-400 hover:bg-gray-700' 
              : 'bg-gray-100 text-slate-700 hover:bg-gray-200'
          }`}
          aria-label="Toggle Dark Mode"
        >
          {isDarkMode ? <Sun size={20} /> : <Moon size={20} />}
        </button>

        <button className={`px-5 py-2 rounded text-sm font-medium transition-colors shadow-lg ${
          isDarkMode 
            ? 'bg-blue-600 hover:bg-blue-500 text-white shadow-blue-900/20' 
            : 'bg-blue-800 hover:bg-blue-900 text-white shadow-blue-200'
        }`}>
          Contact Us
        </button>
      </div>
    </nav>
  );
};

export default NavBar;