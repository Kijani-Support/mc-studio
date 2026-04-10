import React from 'react';
import { useTheme } from "@/components/Context/ThemeContext";
import NavBar from "@/components/NavBar";
import Footer from "@/components/Footer";
import NewsletterContactSection from "@/components/NewsletterContactSection";

const ContactPage = () => {
  const { isDarkMode } = useTheme();

  return (
    <div className={`flex flex-col min-h-screen font-sans w-full overflow-x-hidden transition-colors duration-300 ${
      isDarkMode ? 'bg-black text-white' : 'bg-gray-50 text-gray-900'
    }`}>
      <div className="fixed top-0 left-0 w-full z-50">
        <NavBar />
      </div>

      <main className="flex-grow pt-24 sm:pt-32 flex items-center justify-center">
        {/* We reuse your existing component here */}
        <NewsletterContactSection />
      </main>

      <Footer />
    </div>
  );
};

export default ContactPage;