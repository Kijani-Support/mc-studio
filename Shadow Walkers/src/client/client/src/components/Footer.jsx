
const Footer = () => {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="grid gap-8 px-12 w-full">
      <section className="grid grid-cols-3 gap-20">
        <div className="border col-span-1">ja</div>
        <div className="bordercol-span-2 grid grid-cols-4">
          <table className="grid gap-8">
            <thead className="flex gap-12">
              <th>one</th>
              <th>one</th>
              <th>one</th>
              <th>one</th>
            </thead>
            <tbody className="flex gap-12">
              <td>one</td>
              <td>one</td>
              <td>one</td>
              <td>one</td>
            </tbody>
            <tbody className="flex gap-12">
              <td>one</td>
              <td>one</td>
              <td>one</td>
              <td>one</td>
            </tbody>
            <tbody className="flex gap-12">
              <td>one</td>
              <td>one</td>
              <td>one</td>
              <td>one</td>
            </tbody>
          </table>
        </div>
      </section>

    <section className="bg-gray-100 w-full mt-8  text-black py-4">
      <div className="container mx-auto text-center">
        <p className="text-sm">
          &copy; {currentYear} ModusChora. All rights reserved.
        </p>

      </div>
    </section>
    </footer>
  );
};

export default Footer;