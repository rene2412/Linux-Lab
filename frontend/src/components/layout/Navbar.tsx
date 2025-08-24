import type React from 'react';
import tuxImage from '../../assets/tux.png';
import Button from '../ui/Button';
import { useNavbar } from '../../context/navContext';
// import { ArrowRight } from 'lucide-react';
import ScrambleText from '../ui/ScrambleText';
import { useRef } from 'react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import Anchor from '../ui/Anchor';
import { SITE_URL_FOUNDATIONS, SITE_URL_LOGIN} from '../../utils/data.ts'

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
  const container = useRef(null);

  useGSAP(
    () => {
      gsap.from(container.current, {
        // yPercent:100,
        opacity: 0,
        delay: 5.1,
        ease: 'power4.out',
      });
    },
    { scope: container }
  );

  return (
    <>
      {/* <p className="bg-highlight font-spencer flex items-center justify-center gap-1 tracking-wide">
        Linux-Lab has received funding from China! 🇨🇳 <ArrowRight></ArrowRight>
      </p> */}
      <nav
        {...props}
        ref={container}
        className={`sticky top-0 flex justify-between px-4 py-4 font-sans text-white ${className}`}
      >
        <div className="bg-dark/80 absolute top-0 left-0 -z-10 h-full w-full backdrop-blur-xl"></div>
        <div className="aspect-square w-9">
          <Logo />
        </div>
        <div className="pointer-events-none absolute top-0 right-0 bottom-0 left-0 flex h-full w-full justify-center">
          <ul
            className={`pointer-events-auto hidden w-sm grid-cols-4 place-content-center items-center justify-center md:grid`}
          >
            {DATA.links.map(elem => {
              return (
                <li key={elem.title} className="grid place-items-center">
                  <a
                    className="tracking-sans-normal text-center"
                    href={elem.href}
                  >
                    <ScrambleText>{elem.title}</ScrambleText>
                  </a>
                </li>
              );
            })}
          </ul>
        </div>
        <div className="flex gap-4">
          <Button
            onClick={() => {
              setIsOpen(!isOpen);
            }}
            className="md:hidden"
            variant="outline"
            type="submit"
          >
            Menu
          </Button>
          <Anchor
            className="hidden w-26 !p-0 md:grid"
            variant="default"
            href={SITE_URL_FOUNDATIONS}
          >
            Try It Now
          </Anchor>
          <Anchor
            className="hidden w-18 md:grid"
            variant="outline"
            href={SITE_URL_LOGIN}
          >
            Login
          </Anchor>
        </div>
      </nav>
    </>
  );
}
