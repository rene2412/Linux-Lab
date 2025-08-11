import { useRef } from 'react';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import TextPlugin from 'gsap/TextPlugin';
import SplitText from 'gsap/SplitText';
import { useGSAP } from '@gsap/react';

gsap.registerPlugin(ScrollTrigger, SplitText, TextPlugin);

export default function About() {
  const container = useRef<HTMLElement>(null);
  const images = [
    {src:'media/'}
  ]
  console.log(images);

  useGSAP(
    () => {
      ScrollTrigger.create({
        trigger: '.pin__wrapper',
        start: 'top top',
        end: 'bottom bottom',
        pin: '.pin__content',
        // markers: true,
      });

      const split = SplitText.create('.split', {
        type: 'words',
        // mask: 'words',
      });
      gsap.from(split.words, {
        opacity: 0.1,
        filter: 'blur(3px)',
        ease: 'none',
        stagger: 0.5,
        scrollTrigger: {
          trigger: '.pin__wrapper',
          start: 'top top',
          end: 'bottom bottom',
          markers: true,
          scrub: true,
        },
      });
    },
    { scope: container }
  );


  return (
    <section ref={container} className="mx-4 my-auto mt-20 h-fit sm:min-h-lvh">
      <h1 className="text-h5 lg:text-heading-h6 xl:text-heading-h5 tracking-sans-normal text-white">
        About the{' '}
        <span className="tracking-spencer-normal text-highlight font-spencer">
          Linux-Lab
        </span>
      </h1>
      <div className="pin__wrapper h-[400lvh]">
        <div className="pin__content mt-10 grid h-lvh grid-cols-4 grid-rows-2 items-center gap-5 self-end justify-self-end sm:grid-cols-12 sm:grid-rows-1 lg:gap-5">
          <img
            src="media/bg2.png"
            className="col-span-3 col-start-2 mt-auto aspect-square object-contain sm:mt-0 xl:col-span-4 xl:col-start-2"
            alt="blackhole"
          ></img>
          <h2 className="text-heading-lg split md:text-heading-xl leading-tighten tracking-sans-wide lg:text-heading-h7 col-span-4 my-10 text-white sm:col-span-6 sm:col-start-7">
            <span className="text-highlight">Linux</span>-Lab is a web based
            learning platform meant to teach people from all knowledge levels
            about <span className="text-highlight">Linux</span>. We want to take
            an interactive approach to learning that doesn't really exist for{' '}
            <span className="text-highlight">Linux </span> currently. That is
            the reason for this project. Welcome.
          </h2>
        </div>
      </div>
    </section>
  );
}
