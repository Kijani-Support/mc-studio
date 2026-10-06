import React, { useState } from 'react';
import { Link, useLocation } from 'react-router-dom'; // <-- Import useLocation
import { FiSun, FiMoon, FiMenu, FiX } from 'react-icons/fi';
// With absolute paths setup, it always looks like this:
import { useTheme } from "@/components/Context/ThemeContext";

const NavBar = () => {
  const { isDarkMode, toggleTheme } = useTheme();
  const location = useLocation(); // <-- Get the current route/URL
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

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

  const navLinks = [
    { path: '/', label: 'Home' },
    { path: '/directory', label: 'Startups' },
    { path: '/projects', label: 'Projects' },
    { path: '/case-studies', label: 'Case Studies' },
    { path: '/services', label: 'Services' },
    { path: '/article/1', label: 'Media' }
  ];

  return (
    <>
      <nav className={`flex items-center justify-between px-4 md:px-8 py-5 w-full transition-colors duration-300 ${
        isDarkMode ? 'bg-black text-white' : 'bg-white text-gray-900'
      }`}>
        
        {/* BRAND / LOGO */}
        <div className={`text-xl md:text-2xl font-bold transition-colors duration-300 ${
          isDarkMode ? 'text-blue-400' : 'text-blue-900'
        }`}>
          <Link to="/">modus chora studio</Link>
        </div>

        {/* NAVIGATION LINKS - Desktop */}
        <div className="hidden md:flex space-x-8 text-sm">
          {navLinks.map(link => (
            <Link key={link.path} to={link.path} className={getLinkClass(link.path)}>
              {link.label}
            </Link>
          ))}
        </div>

        {/* ACTIONS: THEME TOGGLE & CONTACT BUTTON & MOBILE MENU */}
        <div className="flex items-center space-x-2 md:space-x-4">
          
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
            {isDarkMode ? <FiSun size={20} /> : <FiMoon size={20} />}
          </button>

          {/* CONTACT BUTTON - Desktop Only */}
          <Link to="/contact" className={`hidden md:inline-block px-5 py-2 rounded text-sm font-medium transition-colors shadow-lg ${
            isDarkMode 
              ? 'bg-blue-600 hover:bg-blue-500 text-white shadow-blue-900/20' 
              : 'bg-blue-800 hover:bg-blue-900 text-white shadow-blue-200'
          }`}>
            Contact Us
          </Link>
          <button
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            className={`md:hidden p-2 rounded transition-all duration-300 ${
              isDarkMode
                ? 'text-gray-400 hover:bg-gray-800'
                : 'text-gray-600 hover:bg-gray-100'
            }`}
            aria-label="Toggle Mobile Menu"
          >
            {mobileMenuOpen ? <FiX size={24} /> : <FiMenu size={24} />}
          </button>
        </div>
      </nav>

      {/* MOBILE MENU */}
      {mobileMenuOpen && (
        <div className={`md:hidden w-full border-b transition-colors duration-300 ${
          isDarkMode ? 'bg-gray-900 border-gray-800' : 'bg-gray-50 border-gray-200'
        }`}>
          <div className="flex flex-col space-y-1 p-4">
            {navLinks.map(link => (
              <Link
                key={link.path}
                to={link.path}
                onClick={() => setMobileMenuOpen(false)}
                className={`px-4 py-3 rounded transition-colors ${getLinkClass(link.path)}`}
              >
                {link.label}
              </Link>
            ))}
            <Link 
              to="/contact" 
              onClick={() => setMobileMenuOpen(false)} 
              className={`block w-full text-center px-4 py-3 rounded text-sm font-medium transition-colors ${
                isDarkMode 
                  ? 'bg-blue-600 hover:bg-blue-500 text-white' 
                  : 'bg-blue-800 hover:bg-blue-900 text-white'
              }`}
            >
              Contact Us
            </Link>
          </div>
        </div>
      )}
    </>
  );
};

export default NavBar;