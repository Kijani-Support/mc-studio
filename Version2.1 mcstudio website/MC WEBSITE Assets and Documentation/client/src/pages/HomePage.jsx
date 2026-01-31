import Footer from "../components/Footer";
import Capture from "../assets/images/algo2.jpg";
import NavBar from "../components/NavBar";
import Portfolios from "../components/home_page/Portfolios"

const HomePage = () => {
  return (
    <div className="grid w-full">
      <NavBar />
      <div className="items-center  pt-24 sm:pt-40 text-center grid sm:gap-20 gap-2">
        {/* intro part */}
        <section className="sm:px-12 px-2 grid sm:grid-cols-2 grid-cols-1 gap-10">
          <div className=" pl-12 grid gap-8 items-center text-left  py-8">
            <h1 className="text-4xl max-w-[30%] font-extrabold  ">
              Innovate, Create, Impact.
            </h1>
            <p className=" max-w-[70%] text-sm">
              We empower visionary founders with bespoke web templates and
              strategic design, transforming ambitious ideas into impactful
              digital realities. Discover solutions designed to elevate your
              startup and projects.
            </p>

            <button className="bg-blue-900 py-1 text-sm text-white rounded-lg w-38">
              Explore Our Work
            </button>
          </div>
          <div className="  rounded-md grid items-center justify-items-center">
            <img
              src={Capture}
              alt="white board   presentation"
              className="rounded-2xl w-[70%] shadow-gray-700 shadow-md  "
            />
          </div>
        </section>

        {/* Latest report Section */}
        <section className="px-4 sm:px-12 grid gap-6 justify-items-center items-center bg-gray-100 py-20">
          <h1 className="font-extrabold text-2xl">
            Explore Our Startups Portfolio
          </h1>
          <section className="grid  sm:grid-cols-3 grid-cols-1 sm:max-w-full max-w-[90%]  bg-gray-100 sm:gap-16 gap-4 sm:px-12 px-2">

            {/* One */}
            < Portfolios 
              pic={Capture}
              title="The Future of Web Design: Trends of 2024"
              description="Explore the cutting-edge trends shaping web design in 2024, from AI-driven interfaces to immersive user experiences"
              author="By Jane Doe| October 26, 2023"
            />
          
            {/* two */}
            < Portfolios 
              pic={Capture}
              title="Building Scalable Startups: A Comprehensive Guide"
              description="Understand the foundational principles and strategies required to build and scale a succesful startup in today's competitive"
              author="By John Smith| October 20, 2023"
            />
  
            {/* Three */}
            < Portfolios 
              pic={Capture}
              title="Leverage AI in Project Management"
              description="Discover how artificial intelligence in revolutionizing project management, enhancing efficiency, and predicting."
              author="By Alice Johnson| October 15, 2023"
            />
          </section>
        </section>

        {/* StartUps Explore */}
        <section className="p-4 sm:p-16 bg-white/700 grid gap-4">
          <h1 className="font-extrabold text-2xl">
            Explore Our Startups Portfolio
          </h1>
          <div className="grid gap-8 sm:grid-cols-4">

            <div className="shadow-xl rounded-xl grid gap-4 items-center justify-items-center  py-4">
              <img src={Capture} alt="a pic" className="w-[40%]" />
              <div className="grid text-sm w-[50%]">

              <h1 className="font-bold text-xl">
                CloudForge
              </h1>
              <p className="text-gray-700">
                Innovating cloud infrastructure
              </p>
              </div>
            </div>
            <div className="shadow-xl rounded-xl grid gap-4 items-center justify-items-center  py-4">
              <img src={Capture} alt="a pic" className="w-[40%]" />
              <div className="grid text-sm w-[50%]">

              <h1 className="font-bold text-xl">
                BrightSpark
              </h1>
              <p className="text-gray-700">
                Igniting creative solutions
              </p>
              </div>
            </div>
            <div className="shadow-xl rounded-xl grid gap-4 items-center justify-items-center  py-4">
              <img src={Capture} alt="a pic" className="w-[40%]" />
              <div className="grid text-sm w-[50%]">

              <h1 className="font-bold text-xl">
                NexusHub
              </h1>
              <p className="text-gray-700">
                Connecting global communities
              </p>
              </div>
            </div>
            <div className="shadow-xl rounded-xl grid gap-4 items-center justify-items-center  py-4">
              <img src={Capture} alt="a pic" className="w-[40%]" />
              <div className="grid text-sm w-[50%]">

              <h1 className="font-bold text-xl">
                RocketReach
              </h1>
              <p className="text-gray-700">
                Accelerating market entry
              </p>
              </div>
            </div>
          </div>
        </section>

        {/* Global Reach, Local Impact section */}
        <section className="grid gap-8 py-16 w-full bg-gray-100 items-center justify-items-center">
          <div className="grid gap-2 mx-auto  w-[50%]">
            <h1 className="text-3xl font-bold">Global Reach, Local Impact</h1>
            <p className=" ">
              Explore our projects worldwide. Our interactive map showcases
              where {"we've"} made a difference connecting innovative solutions
              with communities across the globe.
            </p>
          </div>
          <div className="bg-gray-200 rounded-lg h-60 w-[80%]"></div>
        </section>

        {/* Trusted by industry Leaders section */}
        <section className="grid py-16 px-12 gap-8 justify-items-center items-center">
          <h1 className="font-bold text-3xl">Trusted by industry Leaders</h1>
          <div className=" grid sm:grid-cols-5 gap-8 ">
            
            <div className="h-20 w-40   ">
              <img src={Capture} alt="a capture " className="object-cover rounded-sm w-full h-full" />
            </div>
            <div className="h-20 w-40   ">
              <img src={Capture} alt="a capture " className="object-cover rounded-sm w-full h-full" />
            </div>
            <div className="h-20 w-40   ">
              <img src={Capture} alt="a capture " className="object-cover rounded-sm w-full h-full" />
            </div>
            <div className="h-20 w-40   ">
              <img src={Capture} alt="a capture " className="object-cover rounded-sm w-full h-full" />
            </div>
            <div className="h-20 w-40   ">
              <img src={Capture} alt="a capture " className="object-cover rounded-sm w-full h-full" />
            </div>
          </div>
        </section>

        {/* Newsletter Section */}
        <section className=" grid bg-gray-100 justify-items-center items-center gap-4 py-16  px-12">
          <div className=" grid gap-4 items-center justify-items-center">
            <h1 className="font-bold text-3xl w-[60%]">
              Stay Ahead. Join Our Newsletter.
            </h1>
            <p className=" w-[70%]">
              Recieve exclusive insights, updates, and offers directly in your
              inbox.
            </p>
          </div>
          <div className="flex gap-2 items-center">
            <input
              type="text"
              className="border border-gray-400 rounded-sm py-1 px-3"
              placeholder="Your Email Address"
            />
            <button className="bg-blue-800 py-1 px-2 rounded-md text-white">
              Subscribe
            </button>
          </div>
        </section>
      </div>
      {/* footer */}
      <Footer />
    </div>
  );
};

export default HomePage;
