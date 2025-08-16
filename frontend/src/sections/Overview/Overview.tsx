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

gsap.registerPlugin(
  Draggable,
  Observer,
  InertiaPlugin,
  SplitText,
  ScrambleTextPlugin
);

const OVERVIEW_LINKS = [
  {
    name: 'Command Line',
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
        allowEventDefault:true,
      });
      gsap.set('.card__container', {
        display: 'none',
        opacity: 0,
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
      // color:'var(--color-highlight)',
      scrambleText: {
        text: target?.querySelector('.text__scramble')?.textContent || '',
        speed: 4,
        chars: '!#*_?,/ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvxyz',
      },
    });
    gsap.fromTo(
      modal,
      {
        opacity: 0,
        scale: 0.7,
        filter: 'blur(8px)',
        display: 'flex',
      },
      {
        opacity: 1,
        scale: 1,
        filter: 'blur(0px)',
        ease: 'power4.out',
        duration: 0.35,
      }
    );
  });

  const handleClose = contextSafe((e: React.MouseEvent<HTMLButtonElement>) => {
    console.log('click close')
    const target = e.target as HTMLElement;
    console.log(target);
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
    gsap.to(modal, {
      opacity: 0,
      scale: 0.7,
      filter: 'blur(8px)',
      display: 'none',
      ease: 'power4.out',
      duration: 0.35,
    });
  });

  return (
    <section
      ref={container}
      className="mx-4 mt-20  flex flex-col max-h-fit min-h-lvh overflow-x-visible"
    >
      <div className="relative grow flex flex-col h-full py-10">
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
        <ul className="flex h-full grow min-h-fit flex-col items-center my-10 justify-center gap-20 lg:gap-30">
          {OVERVIEW_LINKS.map(item => {
            return (
              <li
                className="flex items-center justify-center text-white"
                key={item.name}
              >
                <button
                  className="font-spencer group text-heading-h6 tracking-spencer-tight sm:text-heading-h4 lg:text-heading-h3 relative h-full w-full  touch-manipulation leading-none"
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
                <CardReading handleClose={handleClose} title={item.name}>
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
  handleClose: (e: React.MouseEvent<HTMLButtonElement>) => void;
}) {
  return (
    <article
      className={`draggable shadow-highlight/20 card__container absolute z-10 flex h-3/4 max-h-[650px] min-h-fit w-9/10 max-w-md origin-center flex-col rounded-sm bg-black/90 p-2 outline-2 outline-white backdrop-blur-xl hover:shadow-[0px_0px_64px] sm:gap-4 md:p-4 ${className}`}
    >
      <h2 className="text-heading-h6 lg:text-heading-h5 card__heading font-spencer leading-tighter text-white">
        {title}
      </h2>
      <div className="card__content tracking-sans-normal mt-2 flex flex-col gap-4 font-sans text-white lg:mt-0">
        {children}
      </div>
      <Button
        onClick={(e)=>{
          handleClose(e);
        }}
        variant='outline'
        className={`text-heading-slg mt-auto`}
        data-clickable="false"
      >
        Close
      </Button>
    </article>
  );
}
