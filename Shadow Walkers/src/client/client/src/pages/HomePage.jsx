import Header from "../components/Header";
import Footer from "../components/Footer";

const HomePage = () => {
  return (
    <div>
      <Header />
      <div className="items- center pt-20 text-center grid gap-20">
        {/* intro part */}
        <section className="px-12 grid grid-cols-2 gap-10">
          <div className=" pl-12 grid gap-2 items-center text-left  py-8">
            <h1 className="text-3xl font-bold  ">
              Innovate, <br /> Create, <br /> Impact.
            </h1>
            <p className="">
              Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corporis
              commodi aut necessitatibus incidunt modi nisi praesentium at sit
              explicabo saepe nihil, perspiciatis iste eius eos magni similique
              consequuntur voluptates sunt.
            </p>

            <button className="bg-blue-900 text-white rounded-lg w-38">
              Explore Our Work{" "}
            </button>
          </div>
          <div className="border bg-gray-200 rounded-md"></div>
        </section>

        {/* Latest report Section */}
        <section className="px-12 grid gap-4">
          <h1 className="font-bold text-lg">Explore Our Startups Portfolio</h1>
            <section className="grid grid-cols-3  bg-gray-100 gap-8 px-12">
              <div className="border h-40">ja</div>
              <div className="border h-40">ja</div>
              <div className="border h-40">ja</div>
            </section>
        </section>

        {/* StartUps Explore */}
        <section className="px-12 grid gap-4">
          <h1 className="font-bold text-lg">Explore Our Startups Portfolio</h1>
          <div className="grid gap-8 grid-cols-4">
            <div className="border h-40">ja</div>
            <div className="border h-40">ja</div>
            <div className="border h-40">ja</div>
            <div className="border h-40">ja</div>
          </div>
        </section>
        <section className=""></section>
      </div>
      <Footer />
    </div>
  );
};

export default HomePage;
