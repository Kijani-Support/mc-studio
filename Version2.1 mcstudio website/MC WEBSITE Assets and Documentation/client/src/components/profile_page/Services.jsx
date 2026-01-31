


const Services = ({icon, title, description}) => {
  return (
    <div className="h-full grid justify-items-center gap-4   bg-black shadow-sm  w-full p-4 rounded-lg">
      <div className="grid grid-cols-4">
        <p className="text-blue-500 col-span-1">{icon}</p>
        <h2 className="font-bold text-md sm:text-lg text-white col-span-3">
          {title}
        </h2>
      </div>
      <p className="text-xs sm:text-sm  text-white/60">
        {description}
      </p>
    </div>
  );
};

export default Services;
