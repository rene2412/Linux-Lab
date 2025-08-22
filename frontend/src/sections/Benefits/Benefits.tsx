import React, { useRef } from 'react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import { SplitText } from 'gsap/SplitText';
import ScrambleTextPlugin from 'gsap/ScrambleTextPlugin';
import ScrambleScroll from '../../components/ui/ScrambleScroll';
import FadeIn from '../../components/ui/FadeIn';
import TextPlugin from 'gsap/TextPlugin';
import ScrollTrigger from 'gsap/ScrollTrigger';
import SectionFade from '../../components/ui/SectionFade';
import BackgroundImage from '../../components/ui/BackgroundImage';

gsap.registerPlugin(SplitText, ScrambleTextPlugin, TextPlugin, ScrollTrigger);

const STATS = [
  {
    header: 'A big Number',
    value: '98000',
    children:
      ' Linux professionals earn around $98,000+ annually, well above the $45,760 average for all occupations 73% of open-source hiring managers identify Linux knowledge as a top factor in candidate selection.',
    variant: 'currency' as const,
  },
  {
    header: 'The OS of the Internet',
    value: '45',
    children:
      'Linux holds 45% of the global server operating system market and more than 75% of edge devices worldwide will run Linux by 2025. You’re learning the language of the internet itself.',
    variant: 'percent' as const,
  },
  {
    header: 'Commanality',
    value: '92',
    children:
      'Over 92% of the world’s top 500 fastest supercomputers run on Linux.  Its literally everywhere, try to think of your favorite electronic appliance and figure out what its built on.',
    variant: 'percent' as const,
  },
  {
    header: 'A Large Toolset',
    value: 'dev tool',
    children:
      'Work quickly and use tools that are lightweight and powerful, often resulting in faster performance and just getting things done faster. Plus if you are a developer its a must to know',
    variant: 'default' as const,
  },
];

export default function Benefits() {
  const container = useRef(null);

  useGSAP(
    () => {},

    { scope: container, dependencies: [] }
  );

  return (
    <div className="relative overflow-x-hidden">
      <BackgroundImage
        src="media/bg2.png"
        alt="abstract dither"
      ></BackgroundImage>
      <SectionFade variant="top" className="" />
      <SectionFade variant="bottom" className="" />
      <section
        id="benefits"
        ref={container}
        className="relative mx-4 mt-20 flex max-h-fit min-h-lvh flex-col overflow-x-visible py-20 lg:mx-5"
      >
        <h2 className="text-heading-xl lg:text-heading-h6 tracking-sans-normal font-sans text-white">
          <ScrambleScroll>Why Learn</ScrambleScroll>
          <span> </span>
          <ScrambleScroll className="font-spencer text-highlight">
            Linux?
          </ScrambleScroll>
        </h2>
        <FadeIn>
          <p className="fadeIn tracking-sans-normal mt-6 max-w-lg text-white">
            <span className="text-highlight">Linux</span> isn't just another
            skill - it's the foundation of modern tech. From servers to
            smartphones, <span className="text-highlight">Linux </span>
            runs the world. Learning it gives you direct access to how computers
            actually work, not just the pretty interfaces. If you want to truly
            understand technology instead of just using it,
            <span className="text-highlight"> Linux </span> is where you start.
          </p>
        </FadeIn>
        <div className="flex flex-col items-center justify-center lg:hidden">
          <FadeIn>
            <p className="tracking-sans-normal fadeIn text-heading-xl mt-64 text-center font-sans text-white">
              Here are some reasons
            </p>
          </FadeIn>
          <img
            src="media/tux8.png"
            alt="a pixelated version of the Linux mascot tux, sitting down"
            className="my-32 mix-blend-lighten"
          ></img>
        </div>
        <dl className="flex w-full grid-cols-12 grid-rows-3 flex-col items-center justify-center gap-32 overflow-clip text-white lg:grid lg:content-center lg:gap-x-5 lg:gap-y-16">
          <Statistic
            key={STATS[0].header}
            header={STATS[0].header}
            value={STATS[0].value}
            variant={STATS[0].variant}
            className="col-span-full mx-auto"
          >
            {STATS[0].children}
          </Statistic>
          <Statistic
            key={STATS[1].header}
            header={STATS[1].header}
            value={STATS[1].value}
            variant={STATS[1].variant}
            className="col-span-3 col-start-2 row-start-2"
          >
            {STATS[1].children}
          </Statistic>
          <div className="col-span-2 col-start-6 row-start-2 mx-auto hidden aspect-square h-full w-full lg:block">
            <img
              src="media/tux8.png"
              alt="a pixelated version of the Linux mascot tux, sitting down"
              className="h-full w-full object-contain mix-blend-lighten"
            ></img>
          </div>
          <Statistic
            key={STATS[2].header}
            header={STATS[2].header}
            value={STATS[2].value}
            variant={STATS[2].variant}
            className="col-span-3 col-start-9 row-start-2"
          >
            {STATS[2].children}
          </Statistic>
          <Statistic
            key={STATS[3].header}
            header={STATS[3].header}
            value={STATS[3].value}
            variant={STATS[3].variant}
            className="col-span-full row-start-3 mx-auto"
          >
            {STATS[3].children}
          </Statistic>
        </dl>
      </section>
    </div>
  );
}

function Statistic({
  variant = 'default',
  header = 'Default Header',
  value = 'Value',
  children,
  className,
}: {
  variant?: 'default' | 'currency' | 'percent';
  header?: string;
  value?: string;
  className?: string;
  children?: React.ReactNode;
}) {
  const container = useRef(null);

  useGSAP(
    () => {
      if (variant != 'default') {
        gsap.from('.animate-number', {
          duration: 0.6,
          ease: 'power4.out',
          textContent: '0',
          snap: 'textContent',
          scrollTrigger: {
            trigger: '.animate-number',
            start: 'top 95%',
          },
        });
      }
    },
    { scope: container }
  );

  return (
    <div
      ref={container}
      className={`flex max-w-md flex-col items-center justify-center ${className}`}
    >
      <h3 className="font-spencer text-heading-lg md:text-heading-xl text-nowrap">
        <ScrambleScroll>{header}</ScrambleScroll>
      </h3>
      <dt className="relative leading-none">
        {variant === 'currency' && (
          <span className="text-heading-h6 md:text-heading-h5 text-highlight font-jersey absolute top-1/5 right-full -translate-x-1/8">
            $
          </span>
        )}
        {variant === 'percent' && (
          <span className="text-heading-h6 md:text-heading-h5 text-highlight font-jersey absolute top-1/5 left-full translate-x-1/8">
            %
          </span>
        )}
        <span className="font-spencer text-heading-h3 md:text-heading-h2">
          {variant === 'default' ? (
            <ScrambleScroll className="text-nowrap">{value}</ScrambleScroll>
          ) : (
            <span className="animate-number text-nowrap">{value}</span>
          )}
        </span>
      </dt>
      <FadeIn>
        <div className="fadeIn tracking-sans-normal text-center font-sans">
          {children}
        </div>
      </FadeIn>
    </div>
  );
}
