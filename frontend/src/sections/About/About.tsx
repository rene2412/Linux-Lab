import { useRef, useState } from 'react';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import TextPlugin from 'gsap/TextPlugin';
import SplitText from 'gsap/SplitText';
import { useGSAP } from '@gsap/react';
import ScrambleScroll from '../../components/ui/ScrambleScroll';

gsap.registerPlugin(ScrollTrigger, SplitText, TextPlugin);

export default function About() {
  const container = useRef<HTMLElement>(null);
  const [currentImageIndex, setCurrentImageIndex] = useState(0);
  const [loading, setLoading] = useState(true);
  const images = [
    { src: 'media/bg.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg2.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg3.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg4.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg5.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg6.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg7.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg8.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg9.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg10.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg11.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg12.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg13.webp', alt: 'abstract dither pattern' },
    { src: 'media/bg14.webp', alt: 'abstract dither pattern' },
  ];

  useGSAP(
    () => {
      if (loading) {
        document.fonts.ready.then(() => {
          setLoading(false);
        });
      }

      if (!loading) {
        ScrollTrigger.create({
          trigger: '.pin__wrapper',
          start: 'top top',
          end: 'bottom bottom',
          pin: '.pin__content',
        });

        const split = SplitText.create('.split', {
          type: 'words',
          // mask: 'words',
        });
        gsap.from(split.words, {
          opacity: 0.1,
          filter: 'blur(4px)',
          ease: 'none',
          stagger: 0.5,
          scrollTrigger: {
            trigger: '.pin__wrapper',
            start: 'top top',
            end: 'bottom bottom',
            markers: false,
            scrub: true,
          },
        });
        ScrollTrigger.create({
          trigger: '.pin__wrapper',
          start: 'top top',
          end: 'bottom bottom',
          onUpdate: self => {
            const newIndex = Math.min(
              Math.floor(self.progress * images.length),
              images.length - 1
            );
            setCurrentImageIndex(newIndex);
          },
        });

        gsap.from('.pin__img', {
          yPercent: -20,
          xPercent: -40,
          opacity: 0,
          clipPath: 'inset(10%)',
          rotate: -2,
          ease: 'none',
          scrollTrigger: {
            trigger: '.pin__wrapper',
            start: 'top bottom',
            end: ' top bottom',
            //   markers: true,
            scrub: 1.1,
          },
        });
      }
    },
    { scope: container, dependencies: [loading] }
  );

  return (
    <section
      id="about"
      ref={container}
      className="mx-4 my-auto mt-40 h-fit overflow-x-hidden relative sm:min-h-lvh"
    >
      <h1 className="text-h5 lg:text-heading-h6 xl:text-heading-h5 tracking-sans-normal text-white">
        <ScrambleScroll>About the </ScrambleScroll>
        <span> </span>
        <ScrambleScroll className="tracking-spencer-normal text-highlight font-spencer">
          Linux-Lab
        </ScrambleScroll>
      </h1>
      <div className="pin__wrapper h-[200lvh] overflow-hidden">
        <div className="pin__content mt-10 grid h-lvh grid-cols-4 grid-rows-2 items-center gap-5 self-end justify-self-end sm:grid-cols-12 sm:grid-rows-1 lg:gap-5">
          <div className="pin__img col-span-3 col-start-2 mt-auto mix-blend-hard-light sm:mt-0 xl:col-span-4 xl:col-start-2">
            <img
              src={images[currentImageIndex].src}
              key={currentImageIndex}
              className="aspect-square object-cover mix-blend-lighten"
              alt={images[currentImageIndex].alt}
            />
          </div>
          <h2 className="text-heading-lg split pin__text md:text-heading-xl leading-tighten tracking-sans-wide lg:text-heading-h7 col-span-4 my-10 text-white sm:col-span-6 sm:col-start-7">
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
