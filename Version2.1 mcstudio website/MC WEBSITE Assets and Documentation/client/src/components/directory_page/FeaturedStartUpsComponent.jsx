




const FeaturedStartUpsComponent = ({pic, title, field, stage, description, services}) => {
  return (
    <div className=" bg-cyan-200 p-6 h-fit   shadow-black/50 shadow-lg rounded-lg">
      <img
        src={pic}
        alt="replaceable host"
        className="w-20 h-20 rounded-[50%]"
      />
      <h1 className="font-extrabold py-4">{title}</h1>
      <div className="flex gap-4  flex-wrap">
        <p className=" text-xs font-semibold text-white/80 px-2 rounded-xl py-1 bg-indigo-600">
          {field}
        </p>
        <p className="text-xs font-semibold text-white/80 px-2 rounded-xl py-1 bg-cyan-600">
          {stage}
        </p>
      </div>
      <p className="text-sm py-4 text-black/60">
        {description}
      </p>
      <div className="text-sm text-black/60">
        <span className="text-black/80 font-semibold">Services:</span> {services}
      </div>
    </div>
  );
};

export default FeaturedStartUpsComponent;
