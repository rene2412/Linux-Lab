import React, { useRef } from 'react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import InertiaPlugin from 'gsap/InertiaPlugin';
import Draggable from 'gsap/Draggable';
import Observer from 'gsap/Observer';
import Button from '../../components/ui/Button';
import { SplitText } from 'gsap/SplitText';
import ScrambleTextPlugin from 'gsap/ScrambleTextPlugin';
import ScrambleScroll from '../../components/ui/ScrambleScroll';
import FadeIn from '../../components/ui/FadeIn';
import BackgroundImage from '../../components/ui/BackgroundImage';
import SectionFade from '../../components/ui/SectionFade';
import TextPlugin from 'gsap/TextPlugin';

gsap.registerPlugin(
  Draggable,
  Observer,
  InertiaPlugin,
  SplitText,
  ScrambleTextPlugin,
  TextPlugin
);

const OVERVIEW_LINKS = [
  {
    name: 'Foundations',
    content: [
      <p>
        Everything starts somewhere. In Linux, everything is a file - and understanding this core philosophy is where your journey begins. From the command line to the filesystem, we'll break down the building blocks.
      </p>,
      <p>
        Master the terminal, navigate directories like a pro, and learn the essential commands that make Linux tick. No fluff, just the fundamentals that'll set you up for everything else.
      </p>,
      <p>
        By the end, you'll be comfortable moving around your system and understand why Linux users swear by the command line. It's not magic - it's just really, really powerful.
      </p>,
    ],
  },
  {
    name: 'Networking',
    content: [
      <p>
        The internet isn't magic - it's just computers talking to each other. And Linux? It speaks fluent internet. Learn how data flows, what IP addresses really are, and why protocols matter.
      </p>,
      <p>
        From ping to curl, we'll cover the networking commands that let you diagnose connections, fetch data, and understand what's happening under the hood when you hit "send".
      </p>,
      <p>
        You'll go from wondering "how does this work?" to confidently troubleshooting network issues and leveraging Linux's networking power. The web will never look the same.
      </p>,
    ],
  },
  {
    name: 'Scripting',
    content: [
      <p>I couldve sworn something went here?... Coming soon please check back soon!</p>,
      // <p>However scripting is powerful level up waht you already know and be that Linux Guru!</p>,
    ],
  },
];

export default function Overview() {
  const container = useRef(null);

  const { contextSafe } = useGSAP(
    () => {
      Draggable.create('.draggable', {
        type: 'x,y',
        inertia: true,
        bounds: container.current,
        cursor: 'default',
        zIndexBoost: true,
        allowEventDefault: true,
      });
      gsap.set('.card__container', {
        display: 'none',
        opacity: 1,
      });
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: container.current,
          start: 'bottom bottom',
          end: 'bottom top',
          scrub: true,
        },
      });

      tl.to('.container__content', {
        yPercent: 30,
        scale: 0.65,
        ease: 'power1.inOut',
      }).fromTo(
        container.current,
        {},
        {
          clipPath: 'inset(0% 0% 100% 0%)',
          opacity: 0,
          ease: 'none',
        },
        '<'
      );
    },
    { scope: container, dependencies: [] }
  );

  // list scroll trigger
  useGSAP(
    () => {
      const items = document.querySelectorAll('.float__text');
      items.forEach((element, index) => {
        const tl = gsap.timeline({ repeat: -1 });
        tl.from(element, {
          delay: 0.05 * index,
          scrambleText: {
            text: '',
            chars: 'upperCase',
          },
        })
          .to(element, {
            scrambleText: {
              text: '{original}',
            },
          })
          .to(element, {
            delay: 0.5,
            scrambleText: {
              text: '',
            },
          });
      });
    },
    { scope: container, dependencies: [] }
  );

  const openModal = contextSafe((e: React.MouseEvent<HTMLButtonElement>) => {
    const target = e.target as HTMLElement;
    const modal = target.parentNode?.querySelector('.card__container');

    if (!modal) return;
    gsap.killTweensOf(target.querySelector('.text__scramble'));
    gsap.to(target.querySelector('.text__scramble'), {
      duration: 0.4,
      ease: 'none',
      scrambleText: {
        text: target?.querySelector('.text__scramble')?.textContent || '',
        speed: 4,
        chars: '!#*_?,/ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvxyz',
      },
    });
    const tl = gsap.timeline();
    tl.fromTo(
      modal,
      {
        opacity: 0,
        scaleX: 0.9,
        scaleY: 0.9,
        // filter: 'blur(4px)',
        display: 'flex',
      },
      {
        opacity: 1,
        scaleX: 1,
        scaleY: 1,
        // filter: 'blur(0px)',
        ease: 'power4.out',
        duration: 0.25,
      }
    );
  });

  const handleClose = contextSafe((e: React.MouseEvent<HTMLButtonElement>) => {
    const target = e.target as HTMLElement;
    const modal = target?.parentNode;
    if (!modal) return;

    const container = target.closest('li');
    if (!container) return;

    gsap.killTweensOf(container.querySelector('.text__scramble'));
    gsap.to(container.querySelector('.text__scramble'), {
      duration: 0.4,
      ease: 'none',
      scrambleText: {
        text: container?.querySelector('.text__scramble')?.textContent || '',
        speed: 4,
        chars: '!#*_?,/ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvxyz',
        rightToLeft: true,
      },
    });
    const tl = gsap.timeline();
    tl.to(modal, {
      opacity: 0,
      scale: 0.9,
      // filter: 'blur(8px)',
      display: 'none',
      ease: 'power4.out',
      duration: 0.25,
    });
  });

  return (
    <div ref={container} className="relative">
      <BackgroundImage src="media/bg.webp" alt="abstract dither" />
      <SectionFade variant="top" />
      <SectionFade variant="bottom" className="" />

      <section id='overview' className="container__content mx-4 mt-20 max-h-fit min-h-lvh overflow-x-visible py-20">
        <div className="flex h-full grow flex-col py-10">
          <h2 className="text-heading-xl lg:text-heading-h6 tracking-sans-normal font-sans text-white">
            <ScrambleScroll>Our content.</ScrambleScroll>
          </h2>
          <FadeIn>
            <div className="mt-4 grid max-w-lg grid-cols-4 gap-4 md:flex md:w-64">
              <p className="tracking-sans-normal fadeIn col-span-2 col-start-3 font-sans text-white">
                Click on any of these topics to get an overview at the topics we
                cover.
              </p>
            </div>
          </FadeIn>
          <ul className="list__container my-30 flex min-h-fit grow flex-col items-center justify-center gap-20 overflow-x-hidden lg:my-10 lg:gap-20">
            {OVERVIEW_LINKS.map(item => {
              return (
                <li
                  className="module__item flex items-center justify-center text-white"
                  key={item.name}
                >
                  <button
                    className="font-spencer group text-heading-h5 tracking-spencer-tight sm:text-heading-h4 lg:text-heading-h3 relative h-full w-full cursor-pointer touch-manipulation leading-none"
                    type="button"
                    onClick={e => {
                      openModal(e);
                    }}
                  >
                    <ScrambleScroll className="text__scramble scrambleScroll pointer-events-none -z-10 h-full w-full text-nowrap">
                      {item.name}
                    </ScrambleScroll>
                    <span className="animate-cursor-blink arrow font-jersey text-highlight absolute right-full bottom-1/11 hidden -translate-x-1/11 group-focus-within:inline-block group-hover:inline-block">
                      &gt;
                    </span>
                  </button>
                  <CardReading
                    className="z-30"
                    handleClose={handleClose}
                    title={item.name}
                  >
                    {item.content}
                  </CardReading>
                </li>
              );
            })}
          </ul>
          <span className="tracking-sans-normal text-center text-white lg:text-xl">
            What will you learn?
          </span>
        </div>
      </section>
    </div>
  );
}

function CardReading({
  title = 'Title',
  className = '',
  children,
  handleClose,
}: {
  title?: string;
  className?: string;
  children?: React.ReactNode;
  active?: boolean;
  handleClose: (e: React.MouseEvent<HTMLButtonElement>) => void;
}) {
  return (
    <article
      className={`draggable card__container group absolute z-10 flex h-3/4 max-h-[650px] min-h-[600px] w-9/10 max-w-md origin-center flex-col rounded-sm bg-black/100 p-2 outline-2 outline-white sm:gap-4 md:p-4 ${className}`}
    >
      <div className="bg-highlight card__bg absolute top-0 left-0 -z-20 h-full w-full opacity-0 blur-2xl transition-opacity duration-300 group-hover:opacity-50"></div>
      <div className="card__bg pointer-events-none absolute top-0 left-0 -z-10 h-full w-full bg-black"></div>
      <h2 className="text-heading-h6 lg:text-heading-h5 card__heading font-spencer leading-tighter text-white">
        {title}
      </h2>
      <div className="card__content tracking-sans-normal mt-2 flex flex-col gap-4 font-sans text-white lg:mt-0">
        {children}
      </div>
      <Button
        onClick={e => {
          handleClose(e);
        }}
        variant="outline"
        className={`text-heading-slg mt-auto`}
        data-clickable="false"
      >
        Close
      </Button>
    </article>
  );
}
