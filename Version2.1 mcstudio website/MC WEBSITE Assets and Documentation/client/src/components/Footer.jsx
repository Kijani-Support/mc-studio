import React from 'react';
import { useTheme } from "@/components/Context/ThemeContext"; 
import facebookSvg from "@/assets/images/footer/facebook_converted.svg"
import twitterSvg from "@/assets/images/footer/twitter_converted.svg"
import instagramSvg from "@/assets/images/footer/instagram_converted.svg"
import youtubeSvg from "@/assets/images/footer/youtube_converted.svg"
import linkedinSvg from "@/assets/images/footer/linkedin_converted.svg"

const Footer = () => {
  // Pull the dark mode state directly from the global context
  const { isDarkMode } = useTheme(); 
  
  const currentYear = new Date().getFullYear();

  return (
    <footer className={`grid gap-6 sm:gap-8 pt-12 sm:pt-16 px-4 sm:px-8 lg:px-12 w-full transition-colors duration-300 ${
      isDarkMode ? 'bg-black border-t border-gray-800' : 'bg-gray-200'
    }`}>
      <section className="grid justify-items-center sm:grid-cols-3 gap-10 sm:gap-20">
        <div className="grid h-[70%] col-span-1">
          <h1 className={`text-md font-bold transition-colors duration-300 ${
            isDarkMode ? 'text-blue-400' : 'text-blue-900'
          }`}>
            modus chora studio
          </h1>
          <p className={`text-sm transition-colors duration-300 ${
            isDarkMode ? 'text-gray-400' : 'text-gray-500'
          }`}>
            Empowering innovation through strategic design and development
          </p>
          
          {/* social media links and icons */}
          <ul className="flex p-2 gap-4 no-bullets">
            <li>
              <a 
                href="https://www.linkedin.com/showcase/modus-chora-studio/?originalSubdomain=ke" 
                target="_blank" 
                rel="noopener noreferrer"
              >
                <img 
                  src={linkedinSvg} 
                  alt="linkedin logo" 
                  className={`h-5 transition-all duration-300 cursor-pointer hover:opacity-100 ${isDarkMode ? 'invert opacity-75' : ''}`} 
                />
              </a>
            </li>
            <li>
              <a 
                href="https://x.com" 
                target="_blank" 
                rel="noopener noreferrer"
              >
                <img 
                  src={twitterSvg} 
                  alt="twitter logo" 
                  className={`h-5 transition-all duration-300 cursor-pointer hover:opacity-100 ${isDarkMode ? 'invert opacity-75' : ''}`} 
                />
              </a>
            </li>
            <li>
              <a 
                href="https://web.facebook.com/ndutahs/" 
                target="_blank" 
                rel="noopener noreferrer"
              >
                <img 
                  src={facebookSvg} 
                  alt="facebook logo" 
                  className={`h-5 transition-all duration-300 cursor-pointer hover:opacity-100 ${isDarkMode ? 'invert opacity-75' : ''}`} 
                />
              </a>
            </li>
            <li>
              <a 
                href="https://www.instagram.com/mcsq_studio/" 
                target="_blank" 
                rel="noopener noreferrer"
              >
                <img 
                  src={instagramSvg} 
                  alt="instagram logo" 
                  className={`h-5 transition-all duration-300 cursor-pointer hover:opacity-100 ${isDarkMode ? 'invert opacity-75' : ''}`} 
                />
              </a>
            </li>
            <li>
              <a 
                href="https://www.youtube.com/@mcsqstudio" 
                target="_blank" 
                rel="noopener noreferrer"
              >
                <img 
                  src={youtubeSvg} 
                  alt="youtube logo" 
                  className={`h-5 transition-all duration-300 cursor-pointer hover:opacity-100 ${isDarkMode ? 'invert opacity-75' : ''}`} 
                />
              </a>
            </li>
          </ul>
        </div>

        <div className="col-span-2 gap-10 sm:gap-20 grid grid-cols-2 sm:grid-cols-4">
          <div>
            <h1 className={`font-bold text-md transition-colors duration-300 ${
              isDarkMode ? 'text-gray-200' : 'text-gray-900'
            }`}>Company</h1>
            <ul className={`text-sm sm:text-md space-y-2 mt-2 transition-colors duration-300 ${
              isDarkMode ? 'text-gray-400' : 'text-gray-600'
            }`}>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">About Us</li>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Career</li>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Partners</li>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Blog</li>
            </ul>
          </div>
          <div>
            <h1 className={`font-bold text-md transition-colors duration-300 ${
              isDarkMode ? 'text-gray-200' : 'text-gray-900'
            }`}>Services</h1>
            <ul className={`text-sm sm:text-md space-y-2 mt-2 transition-colors duration-300 ${
              isDarkMode ? 'text-gray-400' : 'text-gray-600'
            }`}>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Strategy</li>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Design</li>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Development</li>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Consulting</li>
            </ul>
          </div>
          <div>
            <h1 className={`font-bold text-md transition-colors duration-300 ${
              isDarkMode ? 'text-gray-200' : 'text-gray-900'
            }`}>Resources</h1>
            <ul className={`text-sm sm:text-md space-y-2 mt-2 transition-colors duration-300 ${
              isDarkMode ? 'text-gray-400' : 'text-gray-600'
            }`}>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Case Studies</li>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Projects</li>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">StartUps</li>
              <li>
                <a 
                  href="https://www.ibm.com/partnerplus/directory/company/9718" 
                  target="_blank" 
                  rel="noopener noreferrer"
                  className="hover:text-blue-500 transition-colors"
                >
                  IBM Products
                </a>
              </li>
              <li>
                <a 
                  href="https://www.ibm.com/partnerplus/directory/company/9718" 
                  target="_blank" 
                  rel="noopener noreferrer"
                  className="hover:text-blue-500 transition-colors"
                >
                  IBM Partnership
                </a>
              </li>
            </ul>
          </div>
          <div>
            <h1 className={`font-bold text-md transition-colors duration-300 ${
              isDarkMode ? 'text-gray-200' : 'text-gray-900'
            }`}>Legal</h1>
            <ul className={`text-sm sm:text-md space-y-2 mt-2 transition-colors duration-300 ${
              isDarkMode ? 'text-gray-400' : 'text-gray-600'
            }`}>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Privacy Policy</li>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Terms of Policy</li>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Cookie Policy</li>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Admin Portal</li>
              <li className="hover:text-blue-500 cursor-pointer transition-colors">Dashboard</li>
            </ul>
          </div>
        </div>
      </section>
      
      <hr className={`transition-colors duration-300 ${
        isDarkMode ? 'border-gray-800' : 'border-gray-400'
      }`} />
      
      <section className={`w-full pb-4 transition-colors duration-300 ${
        isDarkMode ? 'text-gray-500' : 'text-black'
      }`}>
        <div className="container mx-auto text-center">
          <p className="text-sm">
            &copy; {currentYear} ModusChora. All rights reserved.
          </p>
        </div>
      </section>
    </footer>
  );
};

export default Footer;