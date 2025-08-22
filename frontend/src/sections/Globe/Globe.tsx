import { useRef } from 'react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import { SplitText } from 'gsap/SplitText';
import ScrambleScroll from '../../components/ui/ScrambleScroll';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(SplitText, ScrollTrigger);

export default function Globe() {
  const container = useRef(null);

  useGSAP(
    () => {
      //   const chars = SplitText.create('.text', { type: 'chars' });
      gsap.from('.img__container', {
        yPercent: 50,
        scale: 1.5,
        rotate: -100,
        scrollTrigger: {
          trigger: container.current,
          start: 'top bottom',
          end: 'top top',
          markers: false,
          scrub: 1.2,
        },
        ease: 'none',
      });
      gsap.to('.text', {
        opacity: 0,
        yPercent: 30,
        rotate: 3,
        scale: 0.9,
        filter: 'blur(8px)',
        scrollTrigger: {
          trigger: container.current,
          start: 'top+=10% top',
          end: 'bottom top',
          markers: false,
          scrub: 1,
        },
        ease: 'none',
      });
    },
    { scope: container }
  );

  return (
    <section
      id="benefits"
      ref={container}
      className="relative mx-4 mt-40 h-lvh overflow-clip lg:mx-5"
    >
      <div className="absolute bottom-0 z-10 h-1/4 w-full bg-gradient-to-t from-black to-black/0"></div>
      <div className="img__container globe absolute top-[53lvh] left-0 z-0 h-full w-full">
        <img
          src="media/earth.png"
          alt="earth dither"
          className="mx-auto h-auto max-w-full"
        ></img>
      </div>
      <p className="text lg:text-heading-h4 text-heading-h7 font-spencer relative z-10 mx-auto hidden h-full w-full max-w-xs flex-col items-center justify-center text-center text-white mix-blend-exclusion lg:mx-0 lg:flex lg:max-w-none lg:flex-row">
        <ScrambleScroll className="">Welcome to the world of</ScrambleScroll>
        <span className="lg:flex">&nbsp;</span>
        <ScrambleScroll className="text-highlight"> Linux </ScrambleScroll>
        <span className="lg:flex">&nbsp;!</span>
      </p>
      <span className="text text-mobile text-heading-h6 font-spencer relative z-10 flex h-full w-full items-center justify-center pb-30 text-white mix-blend-exclusion">
        <span className="text-center">
          <span className="">Welcome to the world of</span>
          <span className="lg:flex">&nbsp;</span>
          <span className="text-highlight"> Linux </span>
          <span className="lg:flex">&nbsp;!</span>
        </span>
      </span>
    </section>
  );
}
