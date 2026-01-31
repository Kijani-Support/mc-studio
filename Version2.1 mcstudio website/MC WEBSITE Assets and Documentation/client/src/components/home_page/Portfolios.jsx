



const Portfolios = ({pic, title, description, author}) => {
  return (
    <section className="h-100 rounded-xl   text-start shadow-md">
      <div className="relative h-[50%]   overflow-hidden">
        <img
          src={pic}
          alt="another image"
          className="absolute inset-0 w-full h-full rounded-t-xl object-cover"
        />
        <div className="absolute inset-x-0 bottom-0 left-0 backdrop-blur-sm bg-gradient-to-t from-white/90 via-white/70 to-transparent right-0 p-12  text-black [mask-image:linear-gradient(to_top,white,transparent)] "></div>
      </div>
      <div className="py-2 px-6 grid gap-2">
        <h1 className="font-bold text-xl">
          {title}
        </h1>
        <p className="text-sm opacity-90 text-black/70">
          {description}
        </p>

        <p className="text-xs text-black/50 mt-2">
         {author}
        </p>
      </div>
    </section>
  );
};

export default Portfolios;
