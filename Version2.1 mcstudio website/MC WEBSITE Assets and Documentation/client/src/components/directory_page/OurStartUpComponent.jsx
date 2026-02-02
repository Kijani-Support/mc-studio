

const OurStartUpComponent = ({pic, title,stage, subTitle, solution, services}) => {
  return (
    <div className=" bg-white/80 py-6 px-6 sm:px-3 h-fit max-w-70 sm:max-w-50 flex-shrink-0 sm:w-fit  shadow-black/10 shadow-md rounded-lg">
      <img
        src={pic}
        alt="replaceable host"
        className="w-20 h-20 rounded-[50%]"
      />
      <h1 className="font-extrabold py-4">{title}</h1>
      <div className="flex gap-4  flex-wrap">
        <p className=" text-xs font-semibold text-white/80 px-2 rounded-xl py-1 bg-indigo-600">
          {subTitle}
        </p>
        <p className="text-xs font-semibold text-white/80 px-2 rounded-xl py-1 bg-cyan-600">
          {stage}
        </p>
      </div>
      <p className="text-sm py-4 text-black/60">
        {solution}
      </p>
      <div className="text-sm text-black/60">
        <span className="text-black/80 font-semibold">Services:</span> {services}
      </div>
    </div>
  );
};

export default OurStartUpComponent;
