import React, { useState } from 'react';
import { useTheme } from "@/components/Context/ThemeContext";

const NewsletterContactSection = () => {
  const { isDarkMode } = useTheme();
  
  const [formType, setFormType] = useState('newsletter'); // 'newsletter' or 'contact'
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState('');
  const [error, setError] = useState('');
  
  // Newsletter form state
  const [newsletterData, setNewsletterData] = useState({
    email: '',
    firstName: '',
  });
  
  // Contact form state
  const [contactData, setContactData] = useState({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
  });

  // Handle newsletter form change
  const handleNewsletterChange = (e) => {
    const { name, value } = e.target;
    setNewsletterData(prev => ({ ...prev, [name]: value }));
  };

  // Handle contact form change
  const handleContactChange = (e) => {
    const { name, value } = e.target;
    setContactData(prev => ({ ...prev, [name]: value }));
  };

  // Subscribe to newsletter via Brevo
  const handleNewsletterSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');
    setMessage('');

    try {
      // Call your backend API
      const response = await fetch('/api/subscribe', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          email: newsletterData.email,
          firstName: newsletterData.firstName,
        }),
      });

      if (!response.ok) {
        throw new Error('Failed to subscribe');
      }

      setMessage('✓ Successfully subscribed to our newsletter!');
      setNewsletterData({ email: '', firstName: '' });
    } catch (err) {
      setError('Failed to subscribe. Please try again.');
      console.error('Newsletter subscription error:', err);
    } finally {
      setLoading(false);
    }
  };

  // Submit contact form
  const handleContactSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');
    setMessage('');

    try {
      // Call your backend API
      const response = await fetch('/api/contact', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(contactData),
      });

      if (!response.ok) {
        throw new Error('Failed to send message');
      }

      setMessage('✓ Thank you! We\'ll get back to you soon.');
      setContactData({
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        subject: '',
        message: '',
      });
    } catch (err) {
      setError('Failed to send message. Please try again.');
      console.error('Contact form error:', err);
    } finally {
      setLoading(false);
    }
  };

  return (
    <section className={`w-full py-16 sm:py-20 px-4 sm:px-8 lg:px-12 transition-colors duration-300 ${
      isDarkMode ? 'bg-gray-900 border-t border-gray-800' : 'bg-white border-t border-gray-200'
    }`}>
      <div className="max-w-4xl mx-auto">
        {/* Section Heading */}
        <div className="text-center mb-12">
          <h2 className={`text-3xl sm:text-4xl font-bold mb-4 transition-colors duration-300 ${
            isDarkMode ? 'text-white' : 'text-gray-900'
          }`}>
            Stay Connected
          </h2>
          <p className={`text-lg transition-colors duration-300 ${
            isDarkMode ? 'text-gray-400' : 'text-gray-600'
          }`}>
            Subscribe for updates or get in touch with our team
          </p>
        </div>

        {/* Form Type Toggle */}
        <div className="flex gap-4 justify-center mb-8">
          <button
            onClick={() => {
              setFormType('newsletter');
              setMessage('');
              setError('');
            }}
            className={`px-6 py-2 font-semibold rounded transition-all duration-300 ${
              formType === 'newsletter'
                ? `${isDarkMode ? 'bg-blue-600 text-white' : 'bg-blue-500 text-white'}`
                : `${isDarkMode ? 'bg-gray-800 text-gray-300 hover:bg-gray-700' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`
            }`}
          >
            Newsletter
          </button>
          <button
            onClick={() => {
              setFormType('contact');
              setMessage('');
              setError('');
            }}
            className={`px-6 py-2 font-semibold rounded transition-all duration-300 ${
              formType === 'contact'
                ? `${isDarkMode ? 'bg-blue-600 text-white' : 'bg-blue-500 text-white'}`
                : `${isDarkMode ? 'bg-gray-800 text-gray-300 hover:bg-gray-700' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`
            }`}
          >
            Contact Us
          </button>
        </div>

        {/* Newsletter Form */}
        {formType === 'newsletter' && (
          <form onSubmit={handleNewsletterSubmit} className="space-y-4">
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <input
                type="text"
                name="firstName"
                placeholder="First Name (optional)"
                value={newsletterData.firstName}
                onChange={handleNewsletterChange}
                className={`w-full px-4 py-3 rounded border transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 ${
                  isDarkMode
                    ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500'
                    : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400'
                }`}
              />
              <input
                type="email"
                name="email"
                placeholder="Your Email *"
                value={newsletterData.email}
                onChange={handleNewsletterChange}
                required
                className={`w-full px-4 py-3 rounded border transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 ${
                  isDarkMode
                    ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500'
                    : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400'
                }`}
              />
            </div>

            <div className="flex items-center gap-2">
              <input
                type="checkbox"
                id="newsletter-consent"
                required
                className="w-4 h-4"
              />
              <label htmlFor="newsletter-consent" className={`text-sm transition-colors duration-300 ${
                isDarkMode ? 'text-gray-400' : 'text-gray-600'
              }`}>
                I agree to receive marketing emails and updates
              </label>
            </div>

            <button
              type="submit"
              disabled={loading}
              className={`w-full px-6 py-3 font-semibold rounded transition-all duration-300 ${
                isDarkMode
                  ? 'bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white'
                  : 'bg-blue-500 hover:bg-blue-600 disabled:opacity-50 text-white'
              }`}
            >
              {loading ? 'Subscribing...' : 'Subscribe to Newsletter'}
            </button>

            {message && (
              <p className={`text-center text-sm font-semibold ${
                isDarkMode ? 'text-green-400' : 'text-green-600'
              }`}>
                {message}
              </p>
            )}
            {error && (
              <p className={`text-center text-sm font-semibold ${
                isDarkMode ? 'text-red-400' : 'text-red-600'
              }`}>
                {error}
              </p>
            )}
          </form>
        )}

        {/* Contact Form */}
        {formType === 'contact' && (
          <form onSubmit={handleContactSubmit} className="space-y-4">
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <input
                type="text"
                name="firstName"
                placeholder="First Name *"
                value={contactData.firstName}
                onChange={handleContactChange}
                required
                className={`w-full px-4 py-3 rounded border transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 ${
                  isDarkMode
                    ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500'
                    : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400'
                }`}
              />
              <input
                type="text"
                name="lastName"
                placeholder="Last Name *"
                value={contactData.lastName}
                onChange={handleContactChange}
                required
                className={`w-full px-4 py-3 rounded border transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 ${
                  isDarkMode
                    ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500'
                    : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400'
                }`}
              />
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <input
                type="email"
                name="email"
                placeholder="Your Email *"
                value={contactData.email}
                onChange={handleContactChange}
                required
                className={`w-full px-4 py-3 rounded border transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 ${
                  isDarkMode
                    ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500'
                    : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400'
                }`}
              />
              <input
                type="tel"
                name="phone"
                placeholder="Phone Number (optional)"
                value={contactData.phone}
                onChange={handleContactChange}
                className={`w-full px-4 py-3 rounded border transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 ${
                  isDarkMode
                    ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500'
                    : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400'
                }`}
              />
            </div>

            <input
              type="text"
              name="subject"
              placeholder="Subject *"
              value={contactData.subject}
              onChange={handleContactChange}
              required
              className={`w-full px-4 py-3 rounded border transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 ${
                isDarkMode
                  ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500'
                  : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400'
              }`}
            />

            <textarea
              name="message"
              placeholder="Your Message *"
              value={contactData.message}
              onChange={handleContactChange}
              required
              rows="5"
              className={`w-full px-4 py-3 rounded border transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none ${
                isDarkMode
                  ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500'
                  : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400'
              }`}
            />

            <button
              type="submit"
              disabled={loading}
              className={`w-full px-6 py-3 font-semibold rounded transition-all duration-300 ${
                isDarkMode
                  ? 'bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white'
                  : 'bg-blue-500 hover:bg-blue-600 disabled:opacity-50 text-white'
              }`}
            >
              {loading ? 'Sending...' : 'Send Message'}
            </button>

            {message && (
              <p className={`text-center text-sm font-semibold ${
                isDarkMode ? 'text-green-400' : 'text-green-600'
              }`}>
                {message}
              </p>
            )}
            {error && (
              <p className={`text-center text-sm font-semibold ${
                isDarkMode ? 'text-red-400' : 'text-red-600'
              }`}>
                {error}
              </p>
            )}
          </form>
        )}
      </div>
    </section>
  );
};

export default NewsletterContactSection;
