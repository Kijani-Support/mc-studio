import React, { useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { Facebook, Twitter, Instagram, Linkedin, Youtube, Mail, ArrowRight, Clock, User } from 'lucide-react';
import NavBar from '../components/NavBar';

// --- Articles Database ---
const ARTICLES_DATABASE = [
  {
    id: 1,
    title: "The Future of Digital Transformation: Trends & Insights",
    author: "Charity Mwangi",
    date: "October 26, 2026",
    heroImage: "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=1600",
    content: [
      "Digital transformation is no longer just a buzzword; it's an imperative for businesses aiming to thrive in an increasingly dynamic market. The pace of technological change continues to accelerate, bringing with it new opportunities and challenges.",
      "One of the most significant trends we're seeing is the **integration of AI and Machine Learning** across all business functions. From automating routine tasks to providing predictive analytics, AI is reshaping how companies operate.",
      "Another key area is **hyper-personalization**. Consumers today expect tailored experiences. Leveraging data analytics to deliver highly relevant content, products, and services is paramount.",
      "Furthermore, the focus on **cybersecurity and data privacy** has intensified. As digital footprints expand, so do the risks. Businesses must invest in robust security measures.",
      "Finally, **sustainable technology and green IT initiatives** are gaining traction. Companies are increasingly looking for ways to reduce their environmental impact."
    ]
  },
  {
    id: 2,
    title: "Building Resilient Startup Ecosystems",
    author: "David Chen",
    date: "October 15, 2026",
    heroImage: "https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&q=80&w=1600",
    content: [
      "Building a resilient startup ecosystem requires collaboration, support systems, and access to resources. In today's competitive landscape, startups need more than just capital to succeed.",
      "A **strong community network** is essential. Mentorship programs, networking events, and knowledge-sharing platforms help startups navigate challenges and accelerate growth.",
      "Access to **funding and investment capital** remains critical. However, equally important are grants, accelerators, and alternative financing options that provide flexibility.",
      "**Government support and regulatory frameworks** play a vital role. Forward-thinking policies can either facilitate or hinder startup development.",
      "Finally, **continuous learning and adaptation** are key to building sustainable ecosystems. Startups that embrace change and innovation are more likely to thrive."
    ]
  },
  {
    id: 3,
    title: "Global Projects: Bridging Continents",
    author: "Maria Rodriguez",
    date: "September 28, 2026",
    heroImage: "https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=1600",
    content: [
      "Global projects bring together diverse teams, cultures, and perspectives to solve complex problems. The interconnected nature of today's world demands international collaboration.",
      "**Cross-cultural communication** is the foundation of successful global projects. Understanding different working styles, time zones, and cultural nuances helps teams work effectively.",
      "Leveraging **distributed teams and remote work tools** allows organizations to tap talent from around the world. Technology enables seamless collaboration across borders.",
      "**Risk management and adaptability** are crucial when working globally. Different markets, regulations, and conditions require flexible strategies.",
      "Ultimately, global projects foster **innovation and growth** through diverse perspectives, creating solutions that impact millions worldwide."
    ]
  },
  {
    id: 4,
    title: "Design Thinking for Modern Applications",
    author: "Sophie Laurent",
    date: "September 10, 2026",
    heroImage: "https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&q=80&w=1600",
    content: [
      "Design thinking is a human-centered approach to problem-solving that has become essential in modern application development. It focuses on understanding user needs and iterating solutions.",
      "The **empathy phase** involves deeply understanding users' pain points, motivations, and contexts. This foundation ensures the solution addresses real problems.",
      "**Ideation and prototyping** allow teams to explore multiple solutions quickly without large investments. Rapid iteration helps identify the best approaches.",
      "**User testing and feedback loops** provide valuable insights that shape product development. Continuous feedback ensures products evolve to meet user expectations.",
      "When applied rigorously, design thinking leads to **innovative, user-centric applications** that create meaningful value for both users and organizations."
    ]
  }
];

const getRecentArticles = (currentArticleId) => {
  return ARTICLES_DATABASE.filter(article => article.id !== currentArticleId).slice(0, 3);
};

// --- Components ---


const SidebarCard = ({ article, isDarkMode, onClick }) => (
  <div 
    onClick={onClick}
    className="flex gap-4 group cursor-pointer"
  >
    <div className={`w-20 h-16 flex-shrink-0 rounded-lg overflow-hidden ${isDarkMode ? 'bg-gray-800' : 'bg-gray-200'}`}>
      <img 
        src={article.heroImage || article.image} 
        alt={article.title} 
        className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
      />
    </div>
    <h4 className={`font-bold text-sm leading-snug transition-colors group-hover:text-blue-500 ${
      isDarkMode ? 'text-gray-300' : 'text-gray-800'
    }`}>
      {article.title}
    </h4>
  </div>
);

const NewsletterWidget = ({ isDarkMode }) => (
  <div className={`rounded-xl p-6 border transition-colors duration-300 ${
    isDarkMode ? 'bg-gray-900/50 border-gray-800' : 'bg-white border-gray-200 shadow-sm'
  }`}>
    <h3 className={`text-xl font-bold mb-2 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
      Stay Updated
    </h3>
    <p className={`text-xs mb-4 leading-relaxed ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
      Sign up for our newsletter to receive the latest updates, articles, and exclusive offers.
    </p>
    <div className="space-y-3">
      <div className="relative">
        <input 
          type="email" 
          placeholder="Enter your email" 
          className={`w-full border text-sm rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-blue-500 transition-all ${
            isDarkMode 
              ? 'bg-black border-gray-700 text-gray-300 placeholder-gray-600' 
              : 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-400'
          }`}
        />
        <Mail className={`absolute right-3 top-3 ${isDarkMode ? 'text-gray-600' : 'text-gray-400'}`} size={16} />
      </div>
      <button className={`w-full font-bold py-3 rounded-lg text-sm transition-all ${
        isDarkMode 
          ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-[0_4px_14px_0_rgba(37,99,235,0.39)]' 
          : 'bg-blue-800 hover:bg-blue-900 text-white shadow-md'
      }`}>
        Subscribe Now
      </button>
    </div>
  </div>
);

const Footer = ({ isDarkMode }) => (
  <footer className={`pt-16 pb-8 px-8 border-t text-xs mt-20 transition-colors duration-300 ${
    isDarkMode ? 'bg-black border-gray-800' : 'bg-gray-50 border-gray-200'
  }`}>
    <div className="max-w-7xl mx-auto">
      <div className="grid grid-cols-1 md:grid-cols-5 gap-8 mb-12">
        <div className="col-span-1 md:col-span-2 pr-8">
          <h4 className={`text-xl font-bold mb-4 ${isDarkMode ? 'text-blue-500' : 'text-blue-900'}`}>
            modus chora studio
          </h4>
          <p className={`mb-6 max-w-xs leading-relaxed ${isDarkMode ? 'text-gray-400' : 'text-gray-500'}`}>
            Empowering innovation through strategic design and development.
          </p>
          <div className={`flex space-x-4 ${isDarkMode ? 'text-gray-500' : 'text-gray-400'}`}>
            <Linkedin size={18} className="hover:text-blue-500 cursor-pointer transition-colors" />
            <Twitter size={18} className="hover:text-blue-400 cursor-pointer transition-colors" />
            <Facebook size={18} className="hover:text-blue-600 cursor-pointer transition-colors" />
            <Instagram size={18} className="hover:text-pink-500 cursor-pointer transition-colors" />
            <Youtube size={18} className="hover:text-red-500 cursor-pointer transition-colors" />
          </div>
        </div>
        
        {['Company', 'Services', 'Legal'].map((section, idx) => (
          <div key={idx}>
            <h5 className={`font-bold mb-4 uppercase tracking-wider text-[10px] ${
              isDarkMode ? 'text-white' : 'text-gray-900'
            }`}>
              {section}
            </h5>
            <ul className={`space-y-3 ${isDarkMode ? 'text-gray-500' : 'text-gray-500'}`}>
              {[1, 2, 3, 4].map((item) => (
                <li key={item}><a href="#" className="hover:text-blue-500 transition-colors">Link Item {item}</a></li>
              ))}
            </ul>
          </div>
        ))}
      </div>
      <div className={`text-center pt-8 border-t ${isDarkMode ? 'text-gray-600 border-gray-800' : 'text-gray-400 border-gray-200'}`}>
        &copy; 2024 Modus Chora Studio. All rights reserved.
      </div>
    </div>
  </footer>
);

// --- Main App ---

export default function ArticleDetailPage() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [isDarkMode, setIsDarkMode] = useState(true);

  const toggleTheme = () => setIsDarkMode(!isDarkMode);

  // Get the current article or default to first article
  const currentArticle = ARTICLES_DATABASE.find(article => article.id === parseInt(id)) || ARTICLES_DATABASE[0];
  const recentArticles = getRecentArticles(currentArticle.id);

  const handleNavigateToArticle = (articleId) => {
    navigate(`/article/${articleId}`);
  };

  return (
    <div className={`min-h-screen font-sans transition-colors duration-300 ${
      isDarkMode ? 'bg-black text-gray-300' : 'bg-gray-50 text-gray-600'
    }`}>
      <NavBar isDarkMode={isDarkMode} toggleTheme={toggleTheme} />
      
      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
          
          {/* LEFT COLUMN: MAIN ARTICLE */}
          <div className="lg:col-span-2">
            {/* Hero Image */}
            <div className={`w-full h-80 md:h-[450px] rounded-2xl overflow-hidden mb-8 relative shadow-2xl ${
              isDarkMode ? 'shadow-blue-900/20' : 'shadow-gray-200'
            }`}>
              <img 
                src={currentArticle.heroImage} 
                alt="Article Hero" 
                className="w-full h-full object-cover"
              />
              <div className={`absolute inset-0 bg-gradient-to-t ${
                isDarkMode ? 'from-black/60 to-transparent' : 'from-gray-900/20 to-transparent'
              }`} />
            </div>

            {/* Article Header */}
            <h1 className={`text-3xl md:text-5xl font-bold mb-6 leading-tight ${
              isDarkMode ? 'text-white' : 'text-gray-900'
            }`}>
              {currentArticle.title}
            </h1>

            <div className={`flex items-center space-x-6 text-sm mb-8 pb-8 border-b ${
              isDarkMode ? 'text-blue-400 border-gray-800' : 'text-blue-700 border-gray-200'
            }`}>
              <div className="flex items-center space-x-2">
                <User size={16} />
                <span className="font-semibold">{currentArticle.author}</span>
              </div>
              <div className="flex items-center space-x-2">
                <Clock size={16} />
                <span>{currentArticle.date}</span>
              </div>
            </div>

            {/* Article Content */}
            <article className="prose prose-lg max-w-none">
              {currentArticle.content.map((paragraph, index) => {
                const parts = paragraph.split(/(\*\*.*?\*\*)/g);
                return (
                  <p key={index} className={`leading-8 mb-6 font-light ${
                    isDarkMode ? 'text-gray-300' : 'text-gray-600'
                  }`}>
                    {parts.map((part, i) => {
                      if (part.startsWith('**') && part.endsWith('**')) {
                        return <strong key={i} className={`font-bold ${
                          isDarkMode ? 'text-white' : 'text-gray-900'
                        }`}>
                          {part.slice(2, -2)}
                        </strong>;
                      }
                      return part;
                    })}
                  </p>
                );
              })}
            </article>

            {/* Bottom CTA */}
            <div className={`mt-12 p-6 rounded-xl flex justify-between items-center border ${
              isDarkMode 
                ? 'bg-blue-900/20 border-blue-900/50' 
                : 'bg-blue-50 border-blue-100'
            }`}>
              <div>
                <h4 className={`font-bold mb-1 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                  Enjoying this read?
                </h4>
                <p className={`text-sm ${isDarkMode ? 'text-blue-300' : 'text-blue-600'}`}>
                  Share it with your network.
                </p>
              </div>
              <div className="flex space-x-3">
                 <button className={`p-2 rounded-full text-white transition-colors ${isDarkMode ? 'bg-blue-600 hover:bg-blue-500' : 'bg-blue-600 hover:bg-blue-700'}`}>
                   <Twitter size={16}/>
                 </button>
                 <button className={`p-2 rounded-full text-white transition-colors ${isDarkMode ? 'bg-blue-800 hover:bg-blue-700' : 'bg-blue-800 hover:bg-blue-900'}`}>
                   <Linkedin size={16}/>
                 </button>
              </div>
            </div>
          </div>

          {/* RIGHT COLUMN: SIDEBAR */}
          <div className="space-y-8">
            
            {/* Recent Articles Widget */}
            <div className={`rounded-2xl p-6 border transition-colors duration-300 ${
              isDarkMode ? 'bg-gray-900/50 border-gray-800' : 'bg-white border-gray-200 shadow-sm'
            }`}>
              <h3 className={`text-xl font-bold mb-6 border-b pb-4 ${
                isDarkMode ? 'text-white border-gray-800' : 'text-gray-900 border-gray-100'
              }`}>
                Recent Articles
              </h3>
              <div className="space-y-5">
                {recentArticles.map(article => (
                  <SidebarCard 
                    key={article.id} 
                    article={article} 
                    isDarkMode={isDarkMode}
                    onClick={() => handleNavigateToArticle(article.id)}
                  />
                ))}
              </div>
            </div>

            {/* Newsletter Widget */}
            <NewsletterWidget isDarkMode={isDarkMode} />

          </div>
        </div>
      </main>

      <Footer isDarkMode={isDarkMode} />
    </div>
  );
}