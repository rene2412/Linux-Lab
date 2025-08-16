import { useNavbar } from '../../context/navContext';
import Button from '../ui/Button';
import { Logo } from './Navbar';
import { useRef, useState } from 'react';
import { useGSAP } from '@gsap/react';
import gsap from 'gsap';
import SplitText from 'gsap/SplitText';
import TextPlugin from 'gsap/TextPlugin';
import { typewriterCycle } from '../../utils/animations/textCycle';
import ScrambleTextPlugin from 'gsap/ScrambleTextPlugin';

gsap.registerPlugin(SplitText, TextPlugin, ScrambleTextPlugin);

const DATA = {
  links: [
    { href: '#about', title: 'About' },
    { href: '#overview', title: 'Overview' },
    { href: '#benefits', title: 'Benefits' },
    { href: '#modules', title: 'Modules' },
  ],
};

export default function Navmenu({ className = ' ' }) {
  const { isOpen, setIsOpen } = useNavbar();
  const [firstOpen, setFirstOpen] = useState<boolean>(false);
  const container = useRef<HTMLElement>(null);

  // open animation
  useGSAP(
    () => {
      if (isOpen) {
        gsap.set(container.current, { display: 'flex', clipPath: 'inset(0)' });
        const tl = gsap.timeline({ paused: false });
        gsap.set('.navbar__header', { opacity: 0 });
        gsap.set('.navbar__content', { opacity: 0 });
        gsap.killTweensOf('.navbar__link');
        tl.from(container.current, {
          backdropFilter: 'blur(0px)',
          ease: 'power3.inOut',
          duration: 0.2,
          opacity: 0,
        })
          .fromTo(
            '.navbar__bg2',
            {
              clipPath: 'inset(0% 0% 100% 0%)',
            },
            {
              clipPath: 'inset(0% 0% 0% 0%)',
              ease: 'power4.in',
              duration: 0.3,
            }
          )
          .set('.navbar__header', { opacity: 1 })
          .set('.navbar__content', { opacity: 1 })
          .to('.navbar__bg2', {
            clipPath: 'inset(100% 0% 0% 0%)',
            delay: 0.1,
            ease: 'power1.out',
            duration: 0.3,
          })
          .from('.navbar__deco__container', {
            clipPath: 'inset(0 0 100% 0)',
            y: 5,
            ease: 'power4.out',
          })
          .from(
            '.navbar__link',
            {
              text: {
                value: '',
              },
              yPercent: 30,
              opacity: 1,
              stagger: 0.1,
              duration: 0.6,
              ease: 'power3.out',
            },
            '-=0.2'
          )
          .from(
            '.nav__buttons > *',
            {
              yPercent: 50,
              opacity: 0,
              stagger: 0.1,
              ease: 'power4.out',
              onComplete: () => {
                setFirstOpen(true);
              },
            },
            '-=0.6'
          );
      }
    },
    { dependencies: [isOpen], scope: container }
  );

  // closing animation
  useGSAP(
    () => {
      if (firstOpen && !isOpen) {
        const tl = gsap.timeline();
        tl.fromTo(
          '.navbar__bg2',
          {
            clipPath: 'inset(0% 0% 100% 0%)',
          },
          {
            clipPath: 'inset(0% 0% 0% 0%)',
            ease: 'power4.in',
            duration: 0.3,
          }
        ).to(container.current, {
          clipPath: 'inset(100% 0 0 0)',
          delay: 0.1,
          ease: 'power1.out',
          duration: 0.3,
        });
      }
    },
    { dependencies: [isOpen, firstOpen], scope: container }
  );

  // typewriter
  useGSAP(
    () => {
      if (isOpen) {
        const phrases = ['Linux-Lab', 'Hello World!', 'What is a pointer?'];
        typewriterCycle('.navbar__deco', phrases);
      }
    },
    { dependencies: [isOpen], scope: container }
  );

  return (
    <menu
      ref={container}
      className={`fixed top-0 left-0 hidden h-dvh w-full flex-col bg-black/90 text-white backdrop-blur-md md:!hidden ${className}`}
    >
      <div className="navbar__bg absolute top-0 left-0 -z-10 h-full w-full"></div>
      <div className="navbar__bg2 bg-highlight absolute top-0 left-0 z-10 flex h-full w-full items-center justify-center backdrop-blur-xl">
        <span className="font-spencer text-heading-h5 text-black">
          {/* Linux-Lab */}
        </span>
      </div>
      <nav
        className={`navbar__header navc1 relative flex justify-between px-4 py-4 font-sans text-white`}
      >
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
      <div className="navbar__content flex h-full flex-col justify-between p-4 pt-0">
        <div className="top">
          <span className="text-heading-lg navbar__deco__container flex items-center justify-center rounded-sm border-2 border-white py-2">
            <p className="font-spencer navbar__deco flex items-center justify-center">
              Linux-Lab
            </p>
            <span
              style={{ clipPath: 'inset(15% 0% 25% 0%)' }}
              className="animate-cursor-blink font-spencer ml-0.5 h-fit w-fit bg-white"
            >
              a
            </span>
          </span>
          <ul>
            {DATA.links.map(link => {
              return (
                <li className="flex justify-stretch" key={link.title}>
                  <a
                    className={`font-spencer navbar__link text-heading-h5 w-full leading-snug`}
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
          <div className="nav__buttons flex flex-col items-center justify-center gap-2">
            <span className="tracking-sans-normal">Start learning now.</span>
            <Button className="w-full py-4">Try it now</Button>
            <Button variant="outline" className="w-full py-4">
              Login
            </Button>
          </div>
        </div>
      </div>
    </menu>
  );
}
