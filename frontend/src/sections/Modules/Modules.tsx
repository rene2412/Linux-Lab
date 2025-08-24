import { useRef, useState } from 'react';
import ScrambleScroll from '../../components/ui/ScrambleScroll';
import { Observer } from 'gsap/Observer';
import InertiaPlugin from 'gsap/InertiaPlugin';
import gsap from 'gsap';
import { Splide, SplideSlide, SplideTrack } from '@splidejs/react-splide';
import '@splidejs/react-splide/css';
import { Card, CardHeader, CardInfo } from '../../components/ui/Card';
import Button from '../../components/ui/Button';
import CommandLine from '../../components/ui/CommandLine';
import { useGSAP } from '@gsap/react';
import { useLenis } from '../../context/LenisContext';
import BackgroundImage from '../../components/ui/BackgroundImage';
import SectionFade from '../../components/ui/SectionFade';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { SITE_URL_FOUNDATIONS, SITE_URL_NETWORKING } from '../../utils/data';
import Anchor from '../../components/ui/Anchor';
gsap.registerPlugin(Observer, InertiaPlugin, ScrollTrigger);

const MODULES = [
  {
    title: 'Foundations',
    description:
      'Lets take it back to the start from learning about what the file system is? Why was it made this way? How do I create delete edit and move around this space? Weve got you covered.',
    info: {
      size: '70+ Lessons',
      time: '2+hr',
      difficulty: 'Beginner',
      price: 'Free',
    },
    buttonText: 'Begin Journey',
    cliText: ['Hello World', 'This is Foundations'],
    href: SITE_URL_FOUNDATIONS,
  },
  {
    title: 'Networking',
    description:
      'Oh the internet, what does it mean? what does it really do? could we ever know? yes and you are here to learn all about the basics and interacting with it through the command line.',
    info: {
      size: '25+ Lessons',
      time: '1hr 30m',
      difficulty: 'Beginner → Intermediate',
      price: 'Free',
    },
    buttonText: 'Scour the Webs',
    cliText: ['Networking!', 'WE LOVE THE INTERNET'],
    href: SITE_URL_NETWORKING,
  },
  {
    title: 'Scripting',
    description:
      'Move like a complete pro and unlock this idk im just yapping something related to bash scripting or what not like test or custom or scripts and what not.',
    info: {
      size: '25+ Lessons',
      time: '2hr',
      difficulty: 'Intermediate → Advanced',
      price: 'Free',
    },
    buttonText: 'Coming Soon',
    cliText: ['AUTOMATION', 'Very Cool!'],
  },
];

export default function Modules() {
  const container = useRef<HTMLElement>(null);
  const pointer = useRef({ deltaX: 0, deltaY: 0 });
  const [activeIndex, setActiveIndex] = useState<null | number>(null);
  const lenis = useLenis();

  useGSAP(
    () => {
      Observer.create({
        target: container.current,
        onMove: e => {
          pointer.current.deltaX = e.deltaX;
          pointer.current.deltaY = e.deltaY;
        },
      });

      gsap.from('.module__card', {
        x: '-50%',
        y: '-20%',
        rotate: '5deg',
        opacity: 0,
        scale: 0.95,
        ease: 'power4.out',
        duration: 1.25,
        stagger: 0.1,
        scrollTrigger: {
          trigger: '.module__card',
          start: 'top 92%',
        },
      });

      const cards = container.current?.querySelectorAll('.module__card');
      if (!cards) return;
      cards.forEach((element: Element) => {
        element.addEventListener('mouseenter', () => {
          const tl = gsap.timeline({
            onComplete: () => {
              tl.kill();
            },
          });
          if (!lenis.isScrolling) {
            tl.to(element, {
              inertia: {
                x: {
                  velocity: pointer.current.deltaX * 2,
                  end: 0,
                },
                y: {
                  velocity: pointer.current.deltaY * 2,
                  end: 0,
                },
              },
            }).fromTo(
              element,
              {
                rotate: 0,
              },
              {
                rotate: (Math.random() - 0.5) * 2,
                duration: 0.4,
                yoyo: true,
                repeat: 1,
                ease: 'power1.out',
              },
              '<'
            );
          }
        });
      });
    },
    { scope: container }
  );

  return (
    <section
      id="modules"
      ref={container}
      className="relative mt-20 min-h-fit overflow-x-hidden py-20"
    >
      <BackgroundImage src="media/bg5.png" alt="abstract dither" />
      <SectionFade variant="top" />
      <SectionFade variant="bottom" className="!h-0" />
      <h1 className="text-h5 lg:text-heading-h6 xl:text-heading-h5 tracking-sans-normal text-center text-white">
        <ScrambleScroll>Where will you begin?</ScrambleScroll>
      </h1>
      <ModuleCarousel />
      <div className="mx-auto mt-10 hidden max-w-[1440px] items-center justify-center gap-10 px-5 lg:flex">
        {MODULES.map((module, index) => {
          return (
            <Card
              key={index}
              onMouseEnter={() => {
                setActiveIndex(index);
              }}
              onMouseLeave={() => {
                setActiveIndex(null);
              }}
              className="module__card group h-[70lvh] min-h-fit max-w-md grow-1 space-y-6"
            >
              <CardHeader>{module.title}</CardHeader>
              <p className="desc tracking-sans-normal text-white">
                {module.description}
              </p>
              <CommandLine
                active={index == activeIndex}
                text={module.cliText}
              ></CommandLine>
              <CardInfo
                className="flex flex-col gap-5"
                size={module.info.size}
                time={module.info.time}
                difficulty={module.info.difficulty}
                price={module.info.price}
              ></CardInfo>
              {module.href ? (
                <Anchor
                  href={module.href}
                  variant="outline"
                  className={'text-heading-slg mt-auto'}
                >
                  {module.buttonText}
                </Anchor>
              ) : (
                <Button
                  disabled
                  variant="outline"
                  className={
                    'text-heading-slg pointer-events-none mt-auto !cursor-not-allowed saturate-0'
                  }
                >
                  {module.buttonText}
                </Button>
              )}
            </Card>
          );
        })}
      </div>
      <p className="font-spencer text-heading-slg mt-10 text-center text-white">
        Off We Go
      </p>
    </section>
  );
}

function ModuleCarousel({ className = '' }: { className?: string }) {
  const [activeIndex, setActiveIndex] = useState<null | number>(null);
  return (
    <Splide
      hasTrack={false}
      onActive={e => {
        setActiveIndex(e.index);
      }}
      options={{
        arrows: false,
        padding: '16px',
        gap: '18px',
        pagination: true,
        mediaQuery: 'min',
        breakpoints: {
          768: {
            perPage: 2,
          },
          1024: {
            destroy: true,
          },
        },
        classes: {
          page: 'rounded-full outline-1 outline-white  h-3 w-3 [&.is-active]:outline-0 cursor-pointer  [&.is-active]:scale-110 [&.is-active]:bg-highlight ',
          pagination: 'flex justify-center mt-10 gap-2',
        },
      }}
      className={` ${className}`}
      aria-label="Modules Information"
    >
      <SplideTrack className="mt-10 !overflow-visible lg:hidden">
        {MODULES.map((module, index) => {
          return (
            <SplideSlide key={module.title} className="">
              <Card
                active={index === activeIndex}
                className={`mx-auto h-[70lvh] min-h-fit max-w-md space-y-6`}
              >
                <CardHeader>{module.title}</CardHeader>
                <p className="desc tracking-sans-normal text-white">
                  {module.description}
                </p>
                <CommandLine
                  active={index === activeIndex}
                  text={module.cliText}
                ></CommandLine>
                <CardInfo
                  className="flex flex-col gap-5"
                  size={module.info.size}
                  time={module.info.time}
                  difficulty={module.info.difficulty}
                  price={module.info.price}
                ></CardInfo>
                {module.href ? (
                  <Anchor
                    href={module.href}
                    variant="outline"
                    className={'text-heading-slg mt-auto'}
                  >
                    {module.buttonText}
                  </Anchor>
                ) : (
                  <Button
                    disabled
                    variant="outline"
                    className={
                      'text-heading-slg pointer-events-none mt-auto !cursor-not-allowed saturate-0'
                    }
                  >
                    {module.buttonText}
                  </Button>
                )}
              </Card>
            </SplideSlide>
          );
        })}
      </SplideTrack>
    </Splide>
  );
}
