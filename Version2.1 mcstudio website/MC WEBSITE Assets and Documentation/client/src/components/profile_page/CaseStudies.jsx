







const CaseStudies = ({title, description, moreInfoBtn}) => {
  return (
    <div className="grid sm:grid-cols-2 w-[90%] sm:w-[70%] items-center ">
      <div className="grid   justify-self-start">
        <h1 className="font-bold text-white  ">
          {title}
        </h1>
        <p className="text-sm text-gray-500">
          {description}
        </p>
      </div>
      <div className="justify-self-end">
        <button className="border rouded-md text-gray-600 rounded-md border-gray-600 px-2 text-sm py-1">
          {moreInfoBtn}
        </button>
      </div>
    </div>
  );
};

export default CaseStudies;
