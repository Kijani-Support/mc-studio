



const Achievements = ({icon, title, subTitle, description}) => {
  return (
    <div className="h-fit p-4 bg-black text-center justify-items-center text-white w-fit grid   shadow-sm rounded-md">
      <div className="grid text-blue-700">{icon}</div>
      <h1 className="font-extrabold text-xl sm:text-2xl">{title}</h1>
      <h3 className="text-sm text-white/50">{subTitle}</h3>
      <p className="text-xs text-white/50  max-w-[100%] sm:max-w-[80%] ">
        {description}
      </p>
    </div>
  );
};
export default Achievements;
