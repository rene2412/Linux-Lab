import { useNavbar } from '../../context/navContext';
import Button from '../ui/Button';
import { Logo } from './Navbar';

const DATA = {
  links: [
    { href: '#about', title: 'About' },
    { href: '#overview', title: 'Overview' },
    { href: '#benefits', title: 'Benefits' },
    { href: '#modules', title: 'Modules' },
  ],
};

export default function Navmenu() {
  const { isOpen, setIsOpen } = useNavbar();
  return (
    <menu
      className={`fixed top-0 left-0 h-dvh w-full flex-col bg-black/80 text-white backdrop-blur-xl ${isOpen ? 'flex' : 'hidden'}`}
    >
      <nav
        className={`relative flex justify-between px-4 py-4 font-sans text-white`}
      >
        <div className="bg-dark/80 absolute top-0 left-0 -z-10 h-full w-full backdrop-blur-xl"></div>
        <div className="aspect-square w-9">
          <Logo />
        </div>
        <div className="flex gap-4">
          <Button
            onClick={() => {
              setIsOpen(!isOpen);
            }}
            className="lg:hidden"
            variant="outline"
            type="submit"
          >
            Close
          </Button>
        </div>
      </nav>
      <div className="nav__content flex h-full flex-col justify-between p-4">
        <div className="top">
          <p className="font-spencer text-heading-lg flex items-center justify-center">
            Linux-Lab
          </p>
          <ul>
            {DATA.links.map(link => {
              return (
                <li className="flex justify-stretch" key={link.title}>
                  <a
                    className={`font-spencer nav__link text-heading-h5 w-full`}
                    href={link.href}
                  >
                    {link.title}
                  </a>
                </li>
              );
            })}
          </ul>
        </div>
        <div className="bottom">
          <div className="nav__buttons flex flex-col items-stretch justify-center gap-2">
            <Button className="py-4">Try it now</Button>
            <Button variant="outline" className="py-4">
              Login
            </Button>
          </div>
        </div>
      </div>
    </menu>
  );
}
