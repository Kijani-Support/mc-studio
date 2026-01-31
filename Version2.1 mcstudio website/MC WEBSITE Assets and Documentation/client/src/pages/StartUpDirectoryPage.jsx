import NavBar from "../components/NavBar";
import Footer from "../components/Footer";
import Capture from "../assets/images/algo2.jpg";
import OurStartUpComponent from "../components/directory_page/OurStartUpComponent"
import FeaturedStartUpsComponent from "../components/directory_page/FeaturedStartUpsComponent"
import { useRef } from "react";

const StartUpDirectoryPage = () => {
  // Our StartUps component side scrolling feature
    const scrollRef = useRef(null);

    const scrollLeft = () => {
      if (scrollRef.current) {
        scrollRef.current.scrollBy({ left: -300, behavior: "smooth" });
      }
    };

    const scrollRight = () => {
      if (scrollRef.current) {
        scrollRef.current.scrollBy({ left: 300, behavior: "smooth" });
      }
    };



  return (
    <div className="grid w-full   ">
      <NavBar />

    <section className="justify-items-center  ">
      {/* Innovators section */}
      <section className="bg-gradient-to-tl w-full  pt-30 sm:pt-40   from-cyan-400 via-cyan-400  to-blue-500  py-20 grid px-4 sm:px-12 gap-5 justify-items-center items-center">
        <h1 className="font-extrabold text-2xl sm:text-3xl ">
          Join Our Network of Innovators
        </h1>
        <p className="text-sm w-full sm:w-[50%]">
          Are you a groundbreaking startup looking for strategic partnership and
          growth opportunities? Apply to become part of the StudioModusChora
          ecosystem and accelerate our journey.
        </p>

        <button className="py-1 bg-blue-900 text-white rounded-md px-4 text-sm">
          Apply Now
        </button>
      </section>

      {/* Filter section */}
      <section className="grid w-full    justify-items-center items-center py-20">
        <div className="grid sm:grid-cols-2  border border-gray-300 rounded-md shadow-sm p-4 w-full gap-4 sm:w-[80%]">
          <div className="justify-self-center sm:justify-self-start">
            <input
              type="text"
              placeholder="search by name or keyword"
              className="border border-gray-300 text-sm outline-none rounded-md pr-18 px-2 py-1 shadow-sm"
            />
          </div>

          <div className="flex gap-2 justify-self-center sm:justify-self-end items-center">
            <input
              type="button"
              value="industry"
              className="border border-gray-300 shadow-sm rounded-md text-sm p-2"
            />
            <input
              type="button"
              value="stage"
              className="border border-gray-300 shadow-sm rounded-md text-sm p-2"
            />

            <div className="border-gray-300 border rounded-sm shadow-sm">
              <input
                type="button"
                value="|||"
                className=" text-sm p-2    bg-gray-200"
              />
              <input type="button" value="=" className=" text-sm p-2   " />
            </div>
          </div>
        </div>
      </section>

      {/* Featured startups section */}
      <section className="grid gap-8  py-18 px-4 sm:px-18   bg-gray-100">
        <h1 className="font-extrabold text-3xl">Featured StartUps</h1>

        <div className="grid sm:grid-cols-4 gap-y-16  gap-4">
        {/* One */}
        <FeaturedStartUpsComponent
          pic={Capture}
          title="QuantumLeap AI"
          field="Artificial Intelligence"
          stage="Series B"
          description="Developing cutting-edge Ai solutions for predictive analytics and
              automation."
          services=" AI
              Development, Cloud Infrastructure, Data Science"
        />
      

          {/* Two */}
        <FeaturedStartUpsComponent
          pic={Capture}
          title="EcoHarvest Farms"
          field="Sustainable Agriculture"
          stage="Seed"
          description="Innovating hydroponic syatems for urban farming and sustainable
              food."
          services="Product Design, Supply Chain Optimization, Market Research"
        />
      
        
          {/* Three */}
        <FeaturedStartUpsComponent
          pic={Capture}
          title="MediConnect Global"
          field="Health Tech"
          stage="Series A"
          description="A platform connecting patients with specialist doctors globally
              through telemedicine."
          services="Platform Development, UI/UX Design, Regulatory Compliance"
        />
       
          {/* Four */}
        <FeaturedStartUpsComponent
          pic={Capture}
          title="AeroDynamics"
          field="Aerospace"
          stage="Series C"
          description="Pioneering drone technology for logistics and environmental
              monitoring."
          services=" Hardware Prototyping, Software Engineering, Aerodynamic Testing"
        />
   
        </div>
      </section>

      {/* Our startup section */}
      <section className="grid gap-8 w-full p-18 px-4 sm:px-18  bg-gray-100">
        <h1 className="font-extrabold text-3xl">Our StartUps</h1>

        <div  className="relative">
         {/* Left Scroll Button */}
          <button
        onClick={scrollLeft}
        className="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-800 p-3 rounded-full shadow-lg z-10 hover:bg-orange-500 transition-colors duration-300"
      >
        {"<<"}
      </button>

        <div ref={scrollRef} 
        className=" grid sm:grid-cols-4 gap-4 gap-y-16 "
        // className="overflow-x-scroll flex space-x-4 sm:space-x-8 scrollbar-hide"
        >
          {/* one */}
          <OurStartUpComponent 
            pic={Capture}
            title="QuantumLeap AI"
            subTitle="Artificial Intelligence"
            stage="series B"
            solution="Developing Cutting-egde AI solutions for predictive analytics and automation."
            services="AI Development, Cloud Infrastructure, Data Science"
          />

          {/* two */}
          <OurStartUpComponent 
            pic={Capture}
            title="EcoHarvest Farms"
            subTitle="Suatainable Agriculture"
            stage="Seed"
            solution="Innovating hydroponic systems for urban farming and sustainable food"
            services="Product Design, SuppluChain Optimizations, Market Research"
          />

          {/* three */}
          <OurStartUpComponent 
            pic={Capture}
            title="MediConnect Global"
            subTitle="Health Tech"
            stage="series B"
            solution="A platform connecting patients with specialist doctors globally through telemedicine"
            services="Platform Development, UI/UX Design, Regulatory Compliance"
          />
          {/* four */}
          <OurStartUpComponent 
            pic={Capture}
            title="AerpDynamics X"
            subTitle="AeroSpace"
            stage="series C"
            solution="Pioneering drone technology for logistics and environmental monitoring."
            services="Hardware Prototyping, Software Engineering, Aerodynamic Testing"
          />

          {/* five */}
          <OurStartUpComponent 
            pic={Capture}
            title="FinFlow Insghts"
            subTitle="Fintech"
            stage="Growth"
            solution="Advanced financial analytics tools for retail investors"
            services="Data Visualiation, Security Audit, API Intergration"
          />

          {/* six */}
          <OurStartUpComponent 
            pic={Capture}
            title="ArtisanCraft Market"
            subTitle="E-commerce"
            stage="Seed"
            solution="An online marketplace for independent artisans to sell"
            services="E-commerce Platform, Branding, Community Building"
          />
          {/* seven */}
          <OurStartUpComponent 
            pic={Capture}
            title="NeuroSense VR"
            subTitle="Virtual Reality"
            stage="Series A"
            solution="Immersive VR experience fo therapy and cognitive training."
            services="VR Content Creation, Software Development, User Testing"
          />
          {/* eight */}
          <OurStartUpComponent 
            pic={Capture}
            title="GigaLogistics"
            subTitle="Logistics"
            stage="Series B"
            solution="Optimizing global supply chains with AI-driven route planning."
            services="Logistics Software, Cloud Computing, AI Optimization"
          />
        </div>

         {/* Right Scroll Button */}
         <button
        onClick={scrollRight}
        className="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-800 p-3 rounded-full shadow-lg z-10 hover:bg-orange-500 transition-colors duration-300"
      >
        {">>"}
      </button>
         </div>
      </section>
      </section>

      <Footer />
    </div>
  );
};

export default StartUpDirectoryPage;
