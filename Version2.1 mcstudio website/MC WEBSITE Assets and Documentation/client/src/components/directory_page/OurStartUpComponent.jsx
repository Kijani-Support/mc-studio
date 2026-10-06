import React from 'react';

const OurStartUpComponent = ({ isDarkMode, pic, title, subTitle, stage, solution, services }) => {
  return (
    <div className={`min-w-[300px] w-[300px] p-6 shadow-md rounded-lg flex-shrink-0 transition-colors duration-300 ${
      isDarkMode ? 'bg-gray-800 border border-gray-700' : 'bg-white border border-gray-200'
    }`}>
      <img 
        src={pic} 
        alt={`${title} logo`} 
        className="w-16 h-16 rounded-full object-cover mb-4" 
      />
      <h3 className={`font-bold text-lg transition-colors duration-300 ${
        isDarkMode ? 'text-white' : 'text-gray-900'
      }`}>
        {title}
      </h3>
      <p className={`text-xs font-semibold mb-3 mt-1 transition-colors duration-300 ${
        isDarkMode ? 'text-blue-400' : 'text-blue-600'
      }`}>
        {subTitle} • {stage}
      </p>
      <p className={`text-sm mb-4 line-clamp-3 transition-colors duration-300 ${
        isDarkMode ? 'text-gray-300' : 'text-gray-600'
      }`}>
        {solution}
      </p>
      <div className="pt-2 border-t border-gray-200 dark:border-gray-700">
        <span className={`text-xs font-semibold block mb-2 ${
          isDarkMode ? 'text-gray-400' : 'text-gray-500'
        }`}>Services:</span>
        {services}
      </div>
    </div>
  );
};

export default OurStartUpComponent;