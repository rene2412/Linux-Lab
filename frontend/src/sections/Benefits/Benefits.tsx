import { useRef } from 'react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import { SplitText } from 'gsap/SplitText';
import ScrambleTextPlugin from 'gsap/ScrambleTextPlugin';
import ScrambleScroll from '../../components/ui/ScrambleScroll';
import FadeIn from '../../components/ui/FadeIn';

gsap.registerPlugin(SplitText, ScrambleTextPlugin);

export default function Benefits() {
  const container = useRef(null);

  useGSAP(
    () => {},

    { scope: container, dependencies: [] }
  );

  return (
    <section
      id="benefits"
      ref={container}
      className="mx-4 mt-20 flex max-h-fit min-h-lvh flex-col overflow-x-visible"
    >
      <h2 className="text-heading-xl lg:text-heading-h6 tracking-sans-normal font-sans text-white">
        <ScrambleScroll>Why Learn</ScrambleScroll>
        <span> </span>
        <ScrambleScroll className="font-spencer text-highlight">
          Linux?
        </ScrambleScroll>
      </h2>
      <FadeIn>
        <p className="fadeIn tracking-sans-normal mt-6 text-white">
          <span className="text-highlight">Linux</span> isn't just another skill
          - it's the foundation of modern tech. From servers to smartphones,{' '}
          <span className="text-highlight">Linux </span>
          runs the world. Learning it gives you direct access to how computers
          actually work, not just the pretty interfaces. If you want to truly
          understand technology instead of just using it,
          <span className="text-highlight"> Linux </span> is where you start.
        </p>
      </FadeIn>
      <p className="tracking-sans-normal text-heading-xl my-64 text-center font-sans text-white">
        Here are some reasons
      </p>
    </section>
  );
}
