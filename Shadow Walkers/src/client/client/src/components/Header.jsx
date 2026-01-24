

const Header = () => {
  return (
    <header className="font- grid grid-cols-7  shadow-md h-14 items-center px-2">
      <div className="col-span-2 font-bold">ModusChora Studio</div>
      <ul className="text-center col-span-4 flex no-bullets gap-2">
        <li className="text-blue-500">Home</li>
        <li className="">Startups</li>
        <li className="">Project</li>
        <li className="">Case Studies</li>
        <li className="">Services</li>
        <li className="">Media</li>
      </ul>
      <div className="col-span-1 text-center bg-blue-900 rounded-lg text-white">
        Contact Us
      </div>
    </header>
  )
}

export default Header
