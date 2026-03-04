import React from 'react';
import { Link } from 'react-router-dom';
import { Sun, Moon } from 'lucide-react';
import { useTheme } from '../components/context/ThemeContext'; // <-- Adjust this path to wherever your ThemeContext is

const NavBar = () => {
  // 1. Pull the state and the toggle function right out of the context!
  const { isDarkMode, toggleTheme } = useTheme();

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
      <div className="hidden md:flex space-x-8 text-sm font-medium">
        <Link to="/" className={`transition-colors hover:text-blue-500 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
          Home
        </Link>
        <Link to="/directory" className={`transition-colors hover:text-blue-500 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
          Startups
        </Link>
        <Link to="/projects" className={`transition-colors hover:text-blue-500 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
          Projects
        </Link>
        <Link to="/case-studies" className={`transition-colors hover:text-blue-500 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
          Case Studies
        </Link>
        <Link to="/services" className={`transition-colors hover:text-blue-500 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
          Services
        </Link>
        {/* Example of linking to a specific article, change as needed */}
        <Link to="/article/1" className={`transition-colors hover:text-blue-500 ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
          Media
        </Link>
      </div>

      {/* ACTIONS: THEME TOGGLE & CONTACT BUTTON */}
      <div className="flex items-center space-x-4">
        
        {/* 2. The Global Theme Toggle Button */}
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