import type React from 'react';
import tuxImage from '../../assets/tux.png';
import Button from '../ui/Button';
import { useNavbar } from '../../context/navContext';

export function Logo({ className }: { className?: string }) {
  return (
    <img
      src={tuxImage}
      className={`h-auto max-h-full w-32 max-w-full object-contain ${className}`}
    ></img>
  );
}

const DATA = {
  links: [
    { href: '#about', title: 'About' },
    { href: '#overview', title: 'Overview' },
    { href: '#benefits', title: 'Benefits' },
    { href: '#modules', title: 'Modules' },
  ],
};

type NavbarProps = React.ComponentPropsWithoutRef<'nav'> & {
  className?: string;
};

export default function Navbar({ className, ...props }: NavbarProps) {
  const { isOpen, setIsOpen } = useNavbar();

  return (
    <nav
      {...props}
      className={`flex justify-between px-4 py-4 sticky top-0 font-sans text-white ${className}`}
    >
      <div className="bg-dark/80 absolute top-0 left-0 -z-10 h-full w-full backdrop-blur-xl"></div>
      <div className="aspect-square w-9">
        <Logo />
      </div>
      <ul
        className={`absolute top-0 right-0 bottom-0 left-0 hidden items-center justify-center gap-6 lg:flex`}
      >
        {DATA.links.map(elem => {
          return (
            <li key={elem.title}>
              <a className="tracking-sans-normal" href={elem.href}>
                {elem.title}
              </a>
            </li>
          );
        })}
      </ul>
      <div className="flex gap-4">
        <Button
          onClick={() => {
            setIsOpen(!isOpen);
          }}
          className="lg:hidden"
          variant="outline"
          type="submit"
        >
          Menu
        </Button>
        <Button
          className="hidden lg:inline-block"
          variant="default"
          type="submit"
        >
          Try It Now
        </Button>
        <Button
          className="hidden lg:inline-block"
          variant="outline"
          type="submit"
        >
          Login
        </Button>
      </div>
    </nav>
  );
}
