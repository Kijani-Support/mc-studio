import React from 'react';

const CaseStudies = ({ title, description, moreInfoBtn, isDarkMode }) => {
  return (
    <div className={`flex flex-col h-full p-6 sm:p-8 rounded-2xl border transition-all duration-300 ${
      isDarkMode 
        ? 'bg-gray-900 border-gray-800 hover:border-gray-700' 
        : 'bg-white border-gray-200 hover:border-blue-300 hover:shadow-lg'
    }`}>
      
      {/* THE FIX: Explicitly setting text-black when not in dark mode */}
      <h3 className={`text-xl font-bold mb-4 leading-snug transition-colors ${
        isDarkMode ? 'text-white' : 'text-black'
      }`}>
        {title}
      </h3>
      
      <p className={`text-sm leading-relaxed mb-8 flex-grow transition-colors ${
        isDarkMode ? 'text-gray-400' : 'text-gray-600'
      }`}>
        {description}
      </p>

      {/* Button styling to match the outline style in your screenshot */}
      <button className={`inline-flex items-center justify-center px-5 py-2 border rounded-md text-sm font-bold w-max transition-colors ${
        isDarkMode 
          ? 'border-gray-700 text-gray-300 hover:bg-gray-800 hover:text-white' 
          : 'border-gray-300 text-gray-700 hover:bg-gray-50 hover:text-black'
      }`}>
        {moreInfoBtn} 
      </button>
      
    </div>
  );
};

export default CaseStudies;