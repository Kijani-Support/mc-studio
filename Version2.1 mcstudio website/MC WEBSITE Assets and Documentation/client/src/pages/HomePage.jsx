import Footer from "../components/Footer";
import Capture from "../assets/images/algo2.jpg";
import HomePageImage from "../assets/images/HomePage.jpg";
import NavBar from "../components/NavBar";
import Portfolios from "../components/home_page/Portfolios";

const HomePage = () => {
  return (
    <div className="w-full font-display">
      <NavBar />

      <main className="pt-24 sm:pt-40 grid gap-24">
        {/* HERO SECTION */}
        <section className="px-4 sm:px-12 grid gap-12 sm:grid-cols-2 items-center">
          {/* Text */}
          <div className="grid gap-6 text-center sm:text-left">
            <h1 className="text-3xl sm:text-5xl font-extrabold max-w-xl">
              Innovate, Create, Impact.
            </h1>

            <p className="text-sm sm:text-base max-w-xl text-gray-700">
              We empower visionary founders with bespoke web templates and
              strategic design, transforming ambitious ideas into impactful
              digital realities. Discover solutions designed to elevate your
              startup and projects.
            </p>

            <button className="bg-blue-900 text-white py-1 sm:py-2 px-6 rounded-lg w-fit text-sm sm:text-md mx-auto sm:mx-0">
              Explore Our Work
            </button>
          </div>

          {/* Image */}
          <div className="flex justify-center">
            <img
              src={HomePageImage}
              alt="presentation"
              className="w-full sm:w-[80%] rounded-2xl shadow-md"
            />
          </div>
        </section>

        {/* PORTFOLIOS */}
        <section className="bg-gray-100 py-20 px-4 sm:px-12 grid gap-12">
          <h1 className="text-2xl font-extrabold text-center">
            Explore Our Startups Portfolio
          </h1>

          <div className="grid gap-6 sm:grid-cols-3">
            <Portfolios
              pic={Capture}
              title="The Future of Web Design: Trends of 2024"
              description="Explore the cutting-edge trends shaping web design in 2024."
              author="By Jane Doe | October 26, 2023"
            />

            <Portfolios
              pic={Capture}
              title="Building Scalable Startups"
              description="Foundational principles to build and scale a startup."
              author="By John Smith | October 20, 2023"
            />

            <Portfolios
              pic={Capture}
              title="Leverage AI in Project Management"
              description="How AI enhances efficiency and prediction."
              author="By Alice Johnson | October 15, 2023"
            />
          </div>
        </section>

        {/* STARTUPS GRID */}
        <section className="px-4 sm:px-16 grid gap-12">
          <h1 className="text-2xl font-extrabold text-center">
            Our Startups
          </h1>

          <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            {["CloudForge", "BrightSpark", "NexusHub", "RocketReach"].map(
              (item) => (
                <div
                  key={item}
                  className="shadow-xl rounded-xl p-6 grid gap-4 justify-items-center"
                >
                  <img src={Capture} alt="" className="w-24" />
                  <div className="text-center">
                    <h2 className="font-bold text-lg">{item}</h2>
                    <p className="text-sm text-gray-600">
                      Innovating digital solutions
                    </p>
                  </div>
                </div>
              )
            )}
          </div>
        </section>

        {/* GLOBAL REACH */}
        <section className="bg-gray-100 py-20 px-4 grid gap-10 text-center">
          <div className="max-w-2xl mx-auto grid gap-4">
            <h1 className="text-3xl font-bold">
              Global Reach, Local Impact
            </h1>
            <p className="text-gray-700">
              Explore our projects worldwide and how we connect communities
              across the globe.
            </p>
          </div>

          <div className="bg-gray-300 rounded-lg h-60 w-full max-w-4xl mx-auto" />
        </section>

        {/* TRUSTED BY */}
        <section className="py-20 px-4 sm:px-12 grid gap-12 text-center">
          <h1 className="text-3xl font-bold">
            Trusted by Industry Leaders
          </h1>

          <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 justify-items-center">
            {Array(5)
              .fill(0)
              .map((_, i) => (
                <div key={i} className="h-20 w-32">
                  <img
                    src={Capture}
                    alt=""
                    className="w-full h-full object-cover rounded"
                  />
                </div>
              ))}
          </div>
        </section>

        {/* NEWSLETTER */}
        <section className="bg-gray-100 py-20 px-4 grid gap-8 text-center">
          <h1 className="text-3xl font-bold max-w-xl mx-auto">
            Stay Ahead. Join Our Newsletter.
          </h1>

          <p className="max-w-lg mx-auto text-gray-700">
            Receive exclusive insights, updates, and offers.
          </p>

          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <input
              type="email"
              placeholder="Your Email Address"
              className="border px-4 py-2 rounded-md w-full sm:w-80"
            />
            <button className="bg-blue-800 text-white px-6 py-2 rounded-md">
              Subscribe
            </button>
          </div>
        </section>
      </main>

      <Footer />
    </div>
  );
};

export default HomePage;