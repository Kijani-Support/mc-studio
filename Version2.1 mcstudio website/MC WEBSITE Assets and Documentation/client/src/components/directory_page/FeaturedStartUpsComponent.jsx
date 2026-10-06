import React from 'react';

const FeaturedStartUpsComponent = ({ isDarkMode, pic, title, field, stage, description, services }) => {
  return (
    <div className={`p-6 h-fit shadow-lg rounded-lg transition-colors duration-300 ${
      isDarkMode ? 'bg-gray-800 shadow-black/80' : 'bg-cyan-200 shadow-black/50'
    }`}>
      <img
        src={pic}
        alt={`${title} logo`}
        className="w-20 h-20 rounded-[50%] object-cover"
      />
      <h1 className={`font-extrabold py-4 transition-colors duration-300 ${
        isDarkMode ? 'text-white' : 'text-gray-900'
      }`}>
        {title}
      </h1>
      
      <div className="flex gap-4 flex-wrap">
        <p className={`text-xs font-semibold px-3 rounded-xl py-1 transition-colors duration-300 ${
          isDarkMode ? 'bg-indigo-500 text-white' : 'bg-indigo-600 text-white/90'
        }`}>
          {field}
        </p>
        <p className={`text-xs font-semibold px-3 rounded-xl py-1 transition-colors duration-300 ${
          isDarkMode ? 'bg-cyan-700 text-white' : 'bg-cyan-600 text-white/90'
        }`}>
          {stage}
        </p>
      </div>
      
      <p className={`text-sm py-4 transition-colors duration-300 ${
        isDarkMode ? 'text-gray-300' : 'text-black/60'
      }`}>
        {description}
      </p>
      
      <div className={`text-sm transition-colors duration-300 ${
        isDarkMode ? 'text-gray-300' : 'text-black/60'
      }`}>
        <span className={`font-semibold ${
          isDarkMode ? 'text-gray-100' : 'text-black/80'
        }`}>Services:</span> {services}
      </div>
    </div>
  );
};

export default FeaturedStartUpsComponent;