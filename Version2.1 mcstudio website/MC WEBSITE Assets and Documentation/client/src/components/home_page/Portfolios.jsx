import React from 'react';

const Portfolios = ({ pic, title, description, author, isDarkMode }) => {
  return (
    <div className={`flex flex-col rounded-2xl overflow-hidden border transition-all duration-300 hover:-translate-y-1 hover:shadow-xl ${
      isDarkMode 
        ? 'bg-gray-900 border-gray-800 hover:shadow-blue-900/20' 
        : 'bg-white border-gray-200 hover:shadow-gray-300'
    }`}>
      {/* Image Container */}
      <div className="h-48 sm:h-56 w-full overflow-hidden relative group">
        <img 
          src={pic} 
          alt={title} 
          className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
        />
        {/* Optional subtle overlay on hover */}
        <div className="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300" />
      </div>

      {/* Content Container */}
      <div className="p-6 flex flex-col flex-grow">
        <h3 className={`font-bold text-xl mb-3 leading-snug transition-colors duration-300 ${
          isDarkMode ? 'text-white' : 'text-gray-900'
        }`}>
          {title}
        </h3>
        
        <p className={`text-sm mb-6 flex-grow leading-relaxed transition-colors duration-300 ${
          isDarkMode ? 'text-gray-400' : 'text-gray-600'
        }`}>
          {description}
        </p>
        
        {/* Author / Date */}
        <div className={`text-xs font-semibold pt-4 border-t transition-colors duration-300 ${
          isDarkMode ? 'border-gray-800 text-gray-500' : 'border-gray-100 text-gray-400'
        }`}>
          {author}
        </div>
      </div>
    </div>
  );
};

export default Portfolios;