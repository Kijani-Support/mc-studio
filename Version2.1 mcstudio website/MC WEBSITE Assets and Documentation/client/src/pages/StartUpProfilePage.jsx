import NavBar from "../components/NavBar";
import Footer from "../components/Footer";
// import Capture from "../assets/images/algo2.jpg"
import ProfilePageImage from "../assets/images/ProfilePage.jpg"
import Achievements from "../components/profile_page/Achievements"
import Services from "../components/profile_page/Services"
import CaseStudies from "../components/profile_page/CaseStudies"

const StartUpProfilePage = () => {
  return (
    <div className="grid w-full font-display ">
      <NavBar />

      {/* section */}
      <section className="py-24  w-full  pt-30 sm:pt-40 bg-gray-200 px-8 sm:px-12 grid gap-16 sm:gap-16 sm:grid-cols-2 items-center justify-items-center">
        <div className="grid gap-2 sm:gap-4 w-full sm:w-[70%]">
          <h1 className="text-3xl sm:text-4xl font-extrabold ">QuantumLeap Innovations</h1>
          <h2 className="w-full sm:w-[60%] text-gray-400 font-bold text-xl  sm:text-2xl">
            Pioneering the Future of{" "}
            <span className="text-blue-700">AI-Driven Solutions</span>
          </h2>
          <p className="text-sm w-full sm:w-[86%] ">
            QuantumLeap innovations is the forefront of developing
            groundbreaking technologies that revolutionize industries. From
            advanced predictive analytics to intelligent automation platforms.
            Our solutions empower businesses to achieve unprecedented efficiency
            and innovation. We are commited to pushing the boundaries of what is
            possible with artificial intelligence, creating a smarter, more
            connected world.
          </p>

          {/* buttons */}
          <div className="flex gap-4 pt-10">
            <button className="bg-blue-700 text-sm rounded-lg py-1 px-4 text-white">
              Apply Now
            </button>
            <button className="bg-black text-sm rounded-lg py-1 px-4 text-white">
              Contact Us
            </button>
          </div>
        </div>
        <div className="grid  text-center items-center rounded-md  w-full h-full">
          <img src={ProfilePageImage} alt="Devs collaborating"  className=" shadow-xl rounded-xl"/>
        </div>
      </section>

      {/* Achievement section */}
      <section className="py-16 px-4 sm:px-12 grid gap-8 items-center justify-items-center bg-black/97 ">
        <h1 className="font-bold text-white text-xl">
          Key Metrices & Achievements
        </h1>

        {/* Achievements */}
        <div className="grid sm:grid-cols-4 gap-12 justify-items-center ">

          {/* one */}
          <Achievements
            icon="icon"
            title="$75M"
            subTitle="Funding Raised"
            description="Seed Series B secured"
          />
          {/* two */}
          <Achievements
            icon="icon"
            title="120+"
            subTitle="Employee Count"
            description="Dedicated team of innovators"
          />
          {/* three */}
          <Achievements
            icon="icon"
            title="150%"
            subTitle="Annual Archive"
            description="Year-over-year revenue increase"
          />
          {/* four */}
          <Achievements
            icon="icon"
            title="5 Countries"
            subTitle="Global Presence"
            description="Expanding reach and impact"
          />

        </div>
      </section>

      {/*  Services section */}
      <section className="py-16 pb-30 px-8 sm:px-20 gap-8 grid items-center justify-items-center bg-gray-200">
        <h1 className="font-extrabold text-2xl ">Services Utilized</h1>
        <div className="grid sm:grid-cols-3 gap-10">
          

          {/* 1 */}
          <Services
          icon="icon"
          title="Custom software Development"
          description="Tailored solutions for uniques business needs."
          />
          {/* 2 */}
          <Services
          icon="icon"
          title="UI/UX Design & Prototyping"
          description="Creating intuitive and engaging user experiences."
          />
          {/* 3 */}
          <Services
          icon="icon"
          title="Cybersecurity consulting"
          description="Ensuring robust protection against digital threats."
          />
          {/* 4 */}
          <Services
          icon="icon"
          title="Strategic Market Entry"
          description="Guidance for successful expansion into new markets."
          />
          {/* 4 */}
          <Services
          icon="icon"
          title="Brand & Marketing Strategy"
          description="Developing powerful branch and impactful campaigns."
          />
          {/* 5 */}
          <Services
          icon="icon"
          title="Innovation Workshops"
          description="Fostering creativity and problem-solving within teams."
          />
        </div>
      </section>

      {/* Case studies section */}
      <section className="py-16 px-4 sm:px-12 grid bg-black items-center justify-items-center gap-8">
        <h1 className="text-white font-bold text-2xl">
          Impactful Case Studies{" "}
        </h1>

        <div className="grid justify-items-center items-center gap-12 ">

          {/* case one */}
          <CaseStudies
            title="Enhancing Customer Engagement for E-commerce Gaint"
            description=" Our AI chatbots and personalized recommendation engines boosted
                conversation rates by 15% for a leading online retailer."
            moreInfoBtn="Read More"
          />
         
          {/* case two */}
          <CaseStudies
            title="Streamlining Financial Operations for a Fintech Startup"
            description="Our AI chatbots and personalized recommendation engines boosted
                conversation rates by 15% for a leading online retailer."
            moreInfoBtn="Read More"
          />
         
          {/* case three */}
          <CaseStudies
            title="Revolutionizing Agricultural Yield Production"
            description="Our AI chatbots and personalized recommendation engines boosted
                conversation rates by 15% for a leading online retailer."
            moreInfoBtn="Read More"
          />
         

        </div>
      </section>


      {/* Partners */}
      <section className="grid w-full items-center justify-items-center py-16 px-12 gap-8">
        <h1 className="font-bold text-2xl ">Our Valued Partners</h1>
        <ul className="flex w-[70%] justify-between items-center no-bullets">
            <li className="">One</li>
            <li className="">One</li>
            <li className="">One</li>
            <li className="">One</li>
        </ul>
      </section>
      <Footer />
    </div>
  );
};

export default StartUpProfilePage;
