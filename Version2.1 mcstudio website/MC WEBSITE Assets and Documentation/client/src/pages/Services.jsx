import React, { useState } from 'react';
import { 
  Facebook, Twitter, Instagram, Linkedin, Youtube, 
  Lightbulb, Palette, Code, Users, CheckCircle2, ChevronDown, ChevronUp 
} from 'lucide-react';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';

// --- Mock Data ---

const COMPETENCIES = [
  {
    icon: <Lightbulb className="w-8 h-8 text-blue-600 mb-4" />,
    title: "Strategic Consultation",
    description: "Navigate your digital journey with confidence. We provide strategic consulting to align your technology investments with your business goals, ensuring every move drives value and competitive advantage.",
    linkText: "Explore Strategy"
  },
  {
    icon: <Palette className="w-8 h-8 text-blue-600 mb-4" />,
    title: "User Experience Design",
    description: "Crafting intuitive, engaging, and beautiful user experiences. Our design team focuses on the end-user, ensuring your digital products are not only aesthetically pleasing but also functional and easy to navigate.",
    linkText: "View Design Portfolio"
  },
  {
    icon: <Code className="w-8 h-8 text-blue-600 mb-4" />,
    title: "Full-Stack Development",
    description: "Robust, scalable, and secure software solutions tailored to your unique needs. From front-end interfaces to back-end architecture, our development team utilizes the latest technologies to build applications that perform flawlessly.",
    linkText: "Our Tech Stack"
  },
  {
    icon: <Users className="w-8 h-8 text-blue-600 mb-4" />,
    title: "Digital Transformation",
    description: "Modernizing businesses for the digital age. We guide you through the process of integrating digital technologies into all areas of your business, fundamentally changing how you operate and deliver value to customers.",
    linkText: "Transformation Cases"
  }
];

const PRICING_PLANS = [
  {
    title: "Basic Support",
    price: "$99/month",
    features: ["Standard Email Support", "Basic Analytics Access", "1 User Account", "Weekly Performance Reports", "Cancel Anytime"],
    buttonText: "Select Basic",
    isPopular: false
  },
  {
    title: "Premium Partnership",
    price: "$299/month",
    features: ["Dedicated Account Manager", "Priority Phone Support", "Advanced Custom Analytics", "Custom Dashboard Views", "Up to 5 User Accounts", "Custom Integration Assistance"],
    buttonText: "Choose Premium",
    isPopular: true
  },
  {
    title: "Enterprise Solutions",
    price: "Custom Quote",
    features: ["24/7 Enterprise Support", "On-site Consultations", "Custom Development Sprints", "Unlimited User Accounts", "Advanced Security Audits", "Dedicated Infrastructure"],
    buttonText: "Contact Sales",
    isPopular: false
  }
];

const FAQS = [
  {
    question: "What is Studiomodus chora?",
    answer: "We are a strategic design and development agency focused on driving digital transformation and innovation for businesses globally."
  },
  {
    question: "How does your strategic consultation process work?",
    answer: "Our process begins with a deep dive into your business goals, current tech stack, and market landscape. We then develop a tailored roadmap with actionable milestones."
  },
  {
    question: "Do you offer custom software development?",
    answer: "Yes, we specialize in full-stack custom software development tailored to your specific operational needs and user expectations."
  },
  {
    question: "What technologies do you specialize in?",
    answer: "Our team is proficient in modern web technologies including React, Node.js, Python, AWS, and various enterprise-grade database solutions."
  },
  {
    question: "Can you help with UI/UX design for existing products?",
    answer: "Absolutely. We offer comprehensive UI/UX audits and redesign services to improve user engagement and retention on your existing platforms."
  }
];

// --- Components ---

const Header = () => (
  <header className="relative top-0 z-50 w-full bg-white border-b border-gray-100 shadow-sm">
   <NavBar />
  </header>
);

const FAQItem = ({ faq }) => {
  const [isOpen, setIsOpen] = useState(false);

  return (
    <div className="border-b border-gray-200 py-4">
      <button 
        className="w-full flex justify-between items-center text-left focus:outline-none"
        onClick={() => setIsOpen(!isOpen)}
      >
        <span className="font-semibold text-gray-900">{faq.question}</span>
        {isOpen ? <ChevronUp className="text-gray-500" size={20} /> : <ChevronDown className="text-gray-500" size={20} />}
      </button>
      {isOpen && (
        <div className="mt-4 text-gray-600 text-sm leading-relaxed pr-8">
          {faq.answer}
        </div>
      )}
    </div>
  );
};



// --- Main Page ---

export default function ServicesPage() {
  return (
    <div className="min-h-screen bg-white font-sans text-gray-900">
      <Header />
      
      <main>
        {/* HERO SECTION */}
        <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
          <div className="flex flex-col md:flex-row items-center gap-12">
            <div className="w-full md:w-1/2 space-y-6">
              <h1 className="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">
                Innovate, Design, Develop: Our Integrated Services
              </h1>
              <p className="text-gray-600 text-lg leading-relaxed">
                We empower businesses by bridging the gap between design and technology. Our comprehensive services are engineered to propel your brand forward, foster innovation, and ensure sustainable growth.
              </p>
              <button className="bg-blue-700 text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-800 transition-colors">
                Explore Services
              </button>
            </div>
            <div className="w-full md:w-1/2">
              <img 
                src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&q=80&w=1200" 
                alt="Team working together" 
                className="rounded-2xl shadow-xl w-full h-auto object-cover"
              />
            </div>
          </div>
        </section>

        {/* CORE COMPETENCIES (DARK SECTION) */}
        <section className="bg-slate-900 py-20 px-4 sm:px-6 lg:px-8">
          <div className="max-w-7xl mx-auto">
            <div className="text-center mb-16">
              <h2 className="text-3xl font-bold text-white mb-4">Our Core Competencies</h2>
              <p className="text-gray-400 max-w-2xl mx-auto">
                We offer specialized knowledge across key domains, ensuring every solution we build is robust, user-centric, and perfectly aligned with your business objectives.
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              {COMPETENCIES.map((comp, idx) => (
                <div key={idx} className="bg-white rounded-xl p-8 flex flex-col items-center text-center hover:-translate-y-1 transition-transform duration-300">
                  {comp.icon}
                  <h3 className="text-xl font-bold text-gray-900 mb-4">{comp.title}</h3>
                  <p className="text-gray-600 text-sm leading-relaxed mb-8 flex-grow">
                    {comp.description}
                  </p>
                  <button className="text-blue-600 font-semibold text-sm border border-blue-200 px-6 py-2 rounded-full hover:bg-blue-50 transition-colors w-full">
                    {comp.linkText}
                  </button>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* PRICING PLANS (LIGHT GREEN SECTION) */}
        <section className="bg-[#f0fdf4] py-20 px-4 sm:px-6 lg:px-8">
          <div className="max-w-7xl mx-auto">
            <div className="text-center mb-16">
              <h2 className="text-3xl font-bold text-gray-900 mb-4">Tailored Solutions: Kijani.co Plans</h2>
              <p className="text-gray-600 max-w-2xl mx-auto">
                Flexible pricing designed to grow with your business. Select the plan that matches your current operational needs and scale effortlessly.
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-8 items-center max-w-5xl mx-auto">
              {PRICING_PLANS.map((plan, idx) => (
                <div 
                  key={idx} 
                  className={`rounded-2xl p-8 flex flex-col ${
                    plan.isPopular 
                      ? 'bg-[#2f4f2f] text-white shadow-2xl scale-105 transform z-10' 
                      : 'bg-white text-gray-900 shadow-lg border border-gray-100'
                  }`}
                >
                  <h3 className={`text-lg font-bold mb-2 ${plan.isPopular ? 'text-green-300' : 'text-gray-500'}`}>
                    {plan.title}
                  </h3>
                  <div className="text-4xl font-extrabold mb-8">{plan.price}</div>
                  
                  <ul className="space-y-4 mb-8 flex-grow text-sm">
                    {plan.features.map((feature, i) => (
                      <li key={i} className="flex items-start">
                        <CheckCircle2 
                          size={18} 
                          className={`mr-3 mt-0.5 flex-shrink-0 ${plan.isPopular ? 'text-green-400' : 'text-green-600'}`} 
                        />
                        <span>{feature}</span>
                      </li>
                    ))}
                  </ul>

                  <button 
                    className={`w-full py-3 rounded-lg font-bold transition-colors ${
                      plan.isPopular 
                        ? 'bg-green-500 hover:bg-green-400 text-gray-900' 
                        : 'bg-white border-2 border-gray-200 hover:border-blue-600 hover:text-blue-600 text-gray-700'
                    }`}
                  >
                    {plan.buttonText}
                  </button>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* CTA SECTION */}
        <section className="py-20 px-4 text-center">
          <h2 className="text-2xl font-bold text-gray-900 mb-4">Building for a Customised Dataroom?</h2>
          <p className="text-gray-600 mb-8 max-w-xl mx-auto">
            If you have unique requirements, let's discuss your specific challenges and how we can architect a bespoke digital workspace tailored to your enterprise.
          </p>
          <button className="bg-blue-700 text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-800 transition-colors shadow-lg shadow-blue-900/20">
            Get a Custom Quote
          </button>
        </section>

        {/* FAQ SECTION */}
        <section className="bg-gray-50 py-20 px-4 sm:px-6 lg:px-8 border-t border-gray-200">
          <div className="max-w-3xl mx-auto">
            <div className="text-center mb-12">
              <h2 className="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
              <p className="text-gray-600">
                Find answers to common inquiries about our services, processes, and how we collaborate with our clients.
              </p>
            </div>
            
            <div className="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-200">
              {FAQS.map((faq, idx) => (
                <FAQItem key={idx} faq={faq} />
              ))}
            </div>
          </div>
        </section>

      </main>

      <Footer />
    </div>
  );
}