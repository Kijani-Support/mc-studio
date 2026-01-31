const Footer = () => {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="grid  gap-8 pt-16 bg-gray-200 px-12 w-full">
      <section className="grid justify-items-center   sm:grid-cols-3 gap-10 sm:gap-20">
        <div className=" grid h-[70%] col-span-1 ">
          <h1 className="text-md font-bold text-blue-900">
            modus chora studio
          </h1>
          <p className="text-sm text-gray-500">
            Empowering innovation through strategic design and development
          </p>
          {/* social media links and icons */}
          <ul className="flex gap-2 no-bullets">
            <li>icon</li>
            <li>icon</li>
            <li>icon</li>
            <li>icon</li>
          </ul>
        </div>

        <div className=" col-span-2 gap-10 sm:gap-20 grid grid-cols-2 sm:grid-cols-4">
          <div className="">
            <h1 className="font-bold text-md">Company</h1>
            <ul className="text-gray-600 text-sm sm:text-md">
              <li className="">About Us</li>
              <li className="">Career</li>
              <li className="">Partners</li>
              <li className="">Blog</li>
            </ul>
          </div>
          <div className="">
            <h1 className="font-bold text-md">Services</h1>
            <ul className="text-gray-600 text-sm sm:text-md">
              <li className="">Strategy</li>
              <li className="">Design</li>
              <li className="">Development</li>
              <li className="">Consulting</li>
            </ul>
          </div>
          <div className="">
            <h1 className="font-bold text-md">Resources</h1>
            <ul className="text-gray-600 text-sm sm:text-md">
              <li className="">Case Studies</li>
              <li className="">Projects</li>
              <li className="">StartUps</li>
              <li className="">IBM Products</li>
            </ul>
          </div>
          <div className="">
            <h1 className="font-bold text-md">Legal</h1>
            <ul className=" text-gray-600 text-sm sm:text-md">
              <li className="">Privacy Policy</li>
              <li className="">Terms of Policy</li>
              <li className="">Cookie Policy</li>
              <li className="">Admin Portal</li>
              <li className="">Dashboard</li>
            </ul>
          </div>
        </div>
      </section>
      <hr className="text-gray-400" />
      <section className=" w-full   text-black pb-4">
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
