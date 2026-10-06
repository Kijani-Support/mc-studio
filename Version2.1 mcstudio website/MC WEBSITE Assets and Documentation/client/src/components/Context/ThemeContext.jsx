import React, { createContext, useState, useEffect, useContext } from 'react'; 

// 1. Create the Context
const ThemeContext = createContext();

// 2. Create the Provider Component
export const ThemeProvider = ({ children }) => {
  // Initialize state from localStorage, defaulting to false (light mode)
  const [isDarkMode, setIsDarkMode] = useState(() => {
    try {
      const savedTheme = window.localStorage.getItem('isDarkMode');
      return savedTheme ? JSON.parse(savedTheme) : false;
    } catch (error) {
      console.error("Error accessing localStorage", error);
      return false;
    }
  });

  // Update localStorage whenever the theme changes
  useEffect(() => {
    try {
      window.localStorage.setItem('isDarkMode', JSON.stringify(isDarkMode));
      
      // Optional but recommended: add a 'dark' class to the body/html 
      // if you ever want to use global CSS overrides.
      if (isDarkMode) {
        document.documentElement.classList.add('dark');
        document.body.style.backgroundColor = 'black'; // prevents white flash on reload
      } else {
        document.documentElement.classList.remove('dark');
        document.body.style.backgroundColor = 'white';
      }
    } catch (error) {
      console.error("Error setting localStorage", error);
    }
  }, [isDarkMode]);

  const toggleTheme = () => setIsDarkMode(prev => !prev);

  // Provide the state and toggle function to the rest of the app
  return (
    <ThemeContext.Provider value={{ isDarkMode, toggleTheme }}>
      {children}
    </ThemeContext.Provider>
  );
};

// 3. Create a Custom Hook for easy access
export const useTheme = () => {
  return useContext(ThemeContext);
};