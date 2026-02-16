import { useState, useEffect } from "react";
import { AiOutlineClose, AiOutlineMenu } from "react-icons/ai";
import { Link, useLocation } from "react-router-dom";

const NavBar = () => {
  const [nav, setNav] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const location = useLocation();

  // Scroll effect
  useEffect(() => {
    const handleScroll = () => setScrolled(window.scrollY > 10);
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  // Close menu on route change
  useEffect(() => {
    setNav(false);
  }, [location.pathname]);

  const navItems = [
    { id: 1, text: "Home", link: "/" },
    { id: 2, text: "StartUps", link: "/profile" },
    { id: 3, text: "Projects", link: "/directory" },
    { id: 4, text: "Case Studies", link: "/studies" },
    { id: 5, text: "Services", link: "/services" },
    { id: 6, text: "Media", link: "/media" },
  ];

  return (
    <>
      {/* ================= HEADER ================= */}
      <header
        className={`fixed top-0 left-0 w-full z-50 isolate transition-all duration-300 ${
          scrolled
            ? "bg-white/95 backdrop-blur-sm py-3 shadow-xl"
            : "bg-white/80 py-4 "
        }`}
      >
        <div className="max-w-7xl mx-auto px-6">
          <div className="flex items-center justify-between">
            {/* Logo */}
            <Link to="/" className="flex items-center">
              <span className="text-sm font-bold text-blue-500 sm:hidden">
                Modus Chora Studio
              </span>
              <span className="hidden sm:inline text-xl  text-blue-800 font-extrabold">
                Modus Chora Studio 
              </span>
            </Link>

            {/* Desktop Nav */}
            <nav className="hidden md:flex items-center space-x-2">
              {navItems.map((item) => (
                <Link
                  key={item.id}
                  to={item.link}
                  className={`px-4 py-2 rounded-md text-sm font-medium transition-colors ${
                    location.pathname === item.link
                      ? " text-blue-800"
                      : "text-black  hover:text-blue-500"
                  }`}
                >
                  {item.text}
                </Link>
              ))}

              <div className="col-span-1 py-1 px-2 text-center bg-blue-900 rounded-lg text-white">
                Contact Us
              </div>
            </nav>

            {/* Mobile Toggle */}
            <button
              onClick={() => setNav(true)}
              aria-label="Open menu"
              className="md:hidden p-2 rounded-md text-gray-900 hover:text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <AiOutlineMenu size={24} />
            </button>
          </div>
        </div>
      </header>

      {/* ================= MOBILE OVERLAY ================= */}
      <div
        onClick={() => setNav(false)}
        className={`md:hidden fixed inset-0 z-[100] bg-black/60 transition-opacity duration-300 ${
          nav
            ? "opacity-100 pointer-events-auto"
            : "opacity-0 pointer-events-none"
        }`}
      >
        {/* ================= MOBILE PANEL ================= */}
        <aside
          onClick={(e) => e.stopPropagation()}
          className={`fixed top-0 left-0 h-full w-4/5 sm:w-3/5 bg-gray-900 border-r border-gray-800 shadow-2xl z-[101] transform transition-transform duration-300 ${
            nav ? "translate-x-0" : "-translate-x-full"
          }`}
        >
          <div className="flex flex-col h-full">
            {/* Header with Close Button */}
            <div className="flex items-center justify-between p-6 border-b border-gray-800">
              <Link
                to="/"
                className="text-2xl font-bold text-blue-500"
                onClick={() => setNav(false)}
              >
                Studio Modus Chora
              </Link>

              <button
                onClick={() => setNav(false)}
                aria-label="Close menu"
                className="p-2 rounded-md text-gray-900 hover:text-white hover:bg-gray-800"
              >
                <AiOutlineClose size={24} />
              </button>
            </div>

            {/* Links */}
            <nav className="flex-1 p-4 space-y-2 overflow-y-auto">
              {navItems.map((item) => (
                <Link
                  key={item.id}
                  to={item.link}
                  onClick={() => setNav(false)}
                  className={`block px-4 py-3 rounded-md text-base font-medium transition-colors ${
                    location.pathname === item.link
                      ? "bg-gray-800 text-blue-500"
                      : "text-gray-300 hover:bg-gray-800/50 hover:text-white"
                  }`}
                >
                  {item.text}
                </Link>
              ))}
            </nav>

            {/* Footer */}
            <div className="p-6 border-t border-gray-800 text-center text-sm text-gray-400">
              © {new Date().getFullYear()} Studio Modus Chora
            </div>
          </div>
        </aside>
      </div>
    </>
  );
};

export default NavBar;
