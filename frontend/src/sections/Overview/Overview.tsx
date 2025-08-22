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

gsap.registerPlugin(
  Draggable,
  Observer,
  InertiaPlugin,
  SplitText,
  ScrambleTextPlugin
);

const OVERVIEW_LINKS = [
  {
    name: 'Foundations',
    content: [
      <p>
        Morem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate
        libero et velit interdum, ac aliquet odio mattis. Class aptent taciti
        sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
      </p>,
      <p>
        Morem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate
        libero et velit interdum, ac aliquet odio mattis. Class aptent taciti
        sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
      </p>,
      <p>
        Morem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate
        libero et velit interdum, ac aliquet odio mattis. Class aptent taciti
        sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
      </p>,
    ],
  },
  {
    name: 'Networking',
    content: [
      <p>
        Morem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate
        libero et velit interdum, ac aliquet odio mattis. Class aptent taciti
        sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
      </p>,
      <p>
        Morem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate
        libero et velit interdum, ac aliquet odio mattis. Class aptent taciti
        sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
      </p>,
      <p>
        Morem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate
        libero et velit interdum, ac aliquet odio mattis. Class aptent taciti
        sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
      </p>,
    ],
  },
  {
    name: 'Bash Scripting',
    content: [
      <p>
        Morem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate
        libero et velit interdum, ac aliquet odio mattis. Class aptent taciti
        sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
      </p>,
      <p>
        Morem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate
        libero et velit interdum, ac aliquet odio mattis. Class aptent taciti
        sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
      </p>,
      <p>
        Morem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate
        libero et velit interdum, ac aliquet odio mattis. Class aptent taciti
        sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
      </p>,
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
    },

    { scope: container, dependencies: [] }
  );

  // list scroll trigger
  useGSAP(
    () => {
      // const items = document.querySelectorAll('.module__item');
      // items.forEach(element => {
      //   gsap.from(element, {
      //     yPercent:'100',
      //     ease: 'none',
      //     scrollTrigger: {
      //       markers: true,
      //       trigger: container.current,
      //       start: 'top+=30% bottom',
      //       end: 'top top',
      //       scrub: 1,
      //     },
      //   });
      // });
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
    <div className="relative">
      <BackgroundImage src="media/bg.png" alt="abstract dither" />
      <SectionFade variant="top" />
      <SectionFade variant="bottom" className='' />
      <section
        ref={container}
        className="mx-4 mt-20 max-h-fit min-h-lvh overflow-x-visible py-20"
      >
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
          <ul className="my-30 flex min-h-fit grow flex-col items-center justify-center gap-20 lg:my-10 lg:gap-20">
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
                    <ScrambleScroll className="text__scramble scrambleScroll pointer-events-none -z-10 h-full w-full">
                      {item.name}
                    </ScrambleScroll>
                    <span className="animate-cursor-blink arrow font-jersey text-highlight absolute right-full bottom-1/11 hidden -translate-x-1/11 group-focus-within:inline-block group-hover:inline-block">
                      &gt;
                    </span>
                  </button>
                  <CardReading className='z-30' handleClose={handleClose} title={item.name}>
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
      className={`draggable card__container group absolute z-10 flex h-3/4 max-h-[650px] min-h-fit w-9/10 max-w-md origin-center flex-col rounded-sm bg-black/100 p-2 outline-2 outline-white sm:gap-4 md:p-4 ${className}`}
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
