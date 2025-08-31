// import Button from '../../components/ui/Button';
import Marquee from '../../components/ui/Marquee';
import GSDevTools from 'gsap/GSDevTools';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import { useRef } from 'react';
import ScrambleTextPlugin from 'gsap/ScrambleTextPlugin';
import BlockCaret from '../../components/ui/BlockCaret';
import TextPlugin from 'gsap/TextPlugin';
import { SITE_URL_FOUNDATIONS, SITE_URL_LOGIN } from '../../utils/data';
import Anchor from '../../components/ui/Anchor';
import { useLenis } from 'lenis/react';
import { Canvas } from '@react-three/fiber';
import Experience from '../../components/ui/Experience';

gsap.registerPlugin(GSDevTools, ScrambleTextPlugin, TextPlugin);

export default function Hero() {
  const container = useRef(null);
  const lenis = useLenis();
  useGSAP(
    () => {
      if (!lenis) return;
      const tl = gsap.timeline({
        paused: false,
      });

      // text sequence
      tl.from('.cli__prompt', { opacity: 0, ease: 'poewer4.out' })
        .to(
          '.cli__prompt',
          {
            scrambleText: {
              text: '{original}',
            },
            duration: 0.8,
            ease: 'none',
          },
          '<'
        )
        .to('.textCycle', {
          text: './ linux-lab.sh',
          delay: 1,
          duration: 1,
        })
        .to('.split__left', {
          delay: 0.8,
          xPercent: -100,
          scale: 0.8,
          duration: 0.5,
          clipPath: 'inset(0 100% 0 0)',
          ease: 'power4.inOut',
          // ease:'power1.out',
          // ease:'none',
        })
        .to(
          '.split__right',
          {
            ease: 'power4.inOut',
            // ease:'power1.out',
            // ease:'none',
            scale: 0.8,
            duration: 0.5,
            xPercent: 100,
            clipPath: 'inset(0 0 0 100%)',
          },
          '<'
        )
        // hero sequence
        .fromTo(
          '.card__container',
          {
            clipPath: 'inset(100%)',
          },
          {
            duration: 1,
            clipPath: 'inset(0%)',
            ease: 'power4.out',
          },
          '<+=0.05'
        )
        .set('.card__container', { clipPath: 'none' })
        .from(
          '.card__container',
          {
            scale: 0.3,
            ease: 'power4.inOut',
            duration: 1.3,
          },
          '-=0.2'
        )
        .from(
          '.marquee__container',
          {
            yPercent: -50,
            clipPath: 'inset(50% 0)',
            opacity: 0,
            scale: 1,
            skewX: '20deg',
            duration: 1,
            ease: 'power3.out',
          },
          '-=0.65'
        )
        .from(
          '.text__hero__mobile',
          {
            yPercent: 50,
            opacity: 0,
            duration: 1,
            ease: 'power4.out',
            stagger: 0.1,
          },
          '<'
        )
        .fromTo(
          '.text__hero',
          {
            opacity: 0,
            yPercent: 50,
          },
          {
            ease: 'power4.out',
            yPercent: 0,
            opacity: 1,
            duration: 1.2,
            scrambleText: {
              text: '{original}',
              speed: 4,
              chars:
                '!#*_?,/ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvxyz',
            },
          },
          '<+=0'
        )
        .from(
          '.buttons__hero',
          {
            // clipPath: 'inset(70% 0 0 0)',
            opacity: 0,
            scale: 0.9,
            duration: 0.8,
            yPercent: 60,
            ease: 'power4.out',
            onComplete: () => {
              lenis?.start();
            },
          },
          '<+=0.15'
        );

      // GSDevTools.create({ animation: tl });
    },
    { scope: container, dependencies: [lenis] }
  );
  return (
    <div ref={container} className="relative overflow-x-hidden pb-12">
      <div
        aria-hidden
        className="absolute top-1/2 left-1/2 grid h-full w-full -translate-x-1/2 -translate-y-1/2 place-content-center"
      >
        <span
          aria-hidden
          className={`text-heading-slg cli font-mono text-white`}
        >
          <span className="text-highlight split__left cli__prompt font-spencer inline-block">
            {'user@linux-lab'}
          </span>
          <span className="split__right inline-block">
            <span className="font-spencer cli__prompt">
              :<span className="font-jersey cli__prompt">~$ </span>
            </span>
            <span className="font-spencer">
              <span className="textCycle"></span>
              <BlockCaret />
            </span>
          </span>
        </span>
      </div>
      <section className="mx-4 grid-cols-12 grid-rows-none text-white lg:mx-5 lg:grid lg:gap-x-5">
        <div className="header col-span-10 col-start-2 flex items-center justify-center overflow-hidden leading-tight text-nowrap lg:justify-between">
          <h1 className="tracking-sans-wide text__hero text-hero-lg hidden lg:block">
            Begin your Linux journey.
          </h1>
          <h1 className="text-highlight text__hero font-spencer text-hero-lg-serif text-heading-h3">
            Linux-Lab
          </h1>
        </div>
        <div className="card__container lg:outline-2 outline-white shadow-highlight/20 lg:shadow-highlight/0  relative col-span-10 col-start-2 row-start-2 h-[73lvh] max-h-full min-h-fit max-w-full overflow-clip rounded-sm bg-black shadow-[0_0_180px] lg:h-[65vh]">
          <Canvas
            dpr={1}
            camera={{ near: 0.1, far: 2000, fov: 20, position: [0, 0, -220] }}
            className="!absolute hidden lg:block !inset-0  !z-0 !h-full !w-full contrast-100 brightness-170 bg-black"
            resize={{offsetSize:true}}
          >
            <Experience />
          </Canvas>
          <img
            className="absolute top-0 left-0 -z-10 h-full w-full object-cover select-none"
            src="media/asciibh.webp"
            alt="black hole monochrome"
          />
          {/* background darken imgae*/}
          <div className="absolute z-0 h-full w-full bg-black/70 lg:hidden"></div>
          <div className="relative z-20 mx-0 flex h-full w-full flex-col justify-between px-4 py-14 sm:mx-auto sm:max-w-lg md:max-w-xl lg:max-w-full lg:items-end lg:justify-end lg:px-8 lg:py-8">
            <span className="padding text-transparent select-none lg:hidden">
              .
            </span>
            <h2 className="text-heading-h6 sm:text-heading-h5 text__hero__mobile tracking-sans-wide text-center leading-tight lg:hidden">
              Begin your <span className="text-highlight">Linux</span> Journey.
            </h2>
            <div className="bottom__cta flex flex-col gap-4">
              <span className="tracking-sans-normal text__hero__mobile text-center leading-tight lg:hidden">
                From command line basics, to networking we got you covered for
                free and in browser.
              </span>
              <div className="buttons__hero flex w-full origin-bottom-right items-center justify-stretch gap-4 rounded-sm lg:w-md lg:bg-black/10 lg:p-4 ">
                <Anchor
                  href={SITE_URL_FOUNDATIONS}
                  className="xl:text-heading-slg w-full py-4"
                >
                  Try It Now
                </Anchor>
                <Anchor
                  className="xl:text-heading-slg w-full py-4"
                  variant="outline"
                  href={SITE_URL_LOGIN}
                >
                  Login
                </Anchor>
              </div>
            </div>
          </div>
        </div>
      </section>
      <Marquee className="marquee__container mt-2 text-white">
        <span className="font-spencer md:text-heading-h6 text-heading-h7 mx-4 flex gap-8">
          <span>Command Line</span> <span>Networking</span>
          <span>Bash Scripting</span>
          <span>Command Line</span> <span>Networking</span>
          <span>Bash Scripting</span>
          <span>Command Line</span> <span>Networking</span>
          <span>Bash Scripting</span>
          <span>Command Line</span> <span>Networking</span>
          <span>Bash Scripting</span>
          <span>Command Line</span> <span>Networking</span>
          <span>Bash Scripting</span>
        </span>
      </Marquee>
    </div>
  );
}
