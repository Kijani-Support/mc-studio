import { useState } from "react";
import { Sun, Moon } from "lucide-react";
import { Link, useLocation } from "react-router-dom";

const NavBar = ({ isDarkMode: propIsDarkMode, toggleTheme: propToggleTheme }) => {
  const [internalIsDarkMode, setInternalIsDarkMode] = useState(false);
  const location = useLocation();

  // Use prop values if provided, otherwise manage internal state
  const isDarkMode = propIsDarkMode !== undefined ? propIsDarkMode : internalIsDarkMode;
  const toggleTheme = propToggleTheme || (() => setInternalIsDarkMode(!internalIsDarkMode));

  const navItems = [
    { text: "Home", link: "/" },
    { text: "Startups", link: "/profile" },
    { text: "Projects", link: "/projects" },
    { text: "Case Studies", link: "/case-studies" },
    { text: "Services", link: "/services" },
    { text: "Media", link: "/article/1" },
  ];

  return (
    <header className={`flex items-center justify-between px-8 py-5 border-b sticky top-0 z-50 transition-colors duration-300 ${
      isDarkMode ? 'bg-black border-gray-800' : 'bg-white border-gray-200'
    }`}>
      <div className="flex items-center space-x-4">
        <Link
          to="/"
          className={`text-2xl font-bold cursor-pointer transition-colors ${isDarkMode ? 'text-blue-500 hover:text-blue-400' : 'text-blue-900 hover:text-blue-800'}`}
        >
          modus chora studio
        </Link>
      </div>
      
      <nav className={`hidden md:flex space-x-8 text-sm font-medium ${isDarkMode ? 'text-gray-400' : 'text-gray-600'}`}>
        {navItems.map((item) => (
          <Link
            key={item.text}
            to={item.link}
            className={`transition-colors ${
              location.pathname === item.link
                ? isDarkMode ? 'text-blue-500 border-b-2 border-blue-500 pb-1' : 'text-blue-700 border-b-2 border-blue-700 pb-1'
                : isDarkMode ? 'hover:text-white' : 'hover:text-blue-700'
            }`}
          >
            {item.text}
          </Link>
        ))}
      </nav>

      <div className="flex items-center space-x-4">
        <button 
          onClick={toggleTheme}
          className={`p-2 rounded-full transition-all duration-300 ${
            isDarkMode 
              ? 'bg-gray-800 text-yellow-400 hover:bg-gray-700' 
              : 'bg-gray-100 text-slate-700 hover:bg-gray-200'
          }`}
        >
          {isDarkMode ? <Sun size={20} /> : <Moon size={20} />}
        </button>

        <button className={`px-5 py-2 rounded text-sm font-medium transition-colors shadow-lg ${
          isDarkMode 
            ? 'bg-blue-600 text-white hover:bg-blue-700 shadow-blue-900/20' 
            : 'bg-blue-800 text-white hover:bg-blue-900 shadow-blue-200'
        }`}>
          Contact Us
        </button>
      </div>
    </header>
  );
};

export default NavBar;
