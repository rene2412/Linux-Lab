import { useGSAP } from '@gsap/react';
import gsap from 'gsap';
// import { useGSAP } from "@gsap/react";
import ScrambleTextPlugin from 'gsap/ScrambleTextPlugin';
import SplitText from 'gsap/SplitText';
import React, { useRef, useState } from 'react';
gsap.registerPlugin(ScrambleTextPlugin, SplitText);

// make sure to make parent relative for full hover fill vs text
/**
 * A text component that creates a scrambling animation effect on hover
 * PARENT MUST BE Relative to work with active
 * @param children - The text content to display and animate
 */
export default function ScrambleText({
  children,
}: {
  children: React.ReactNode;
}) {
  const container = useRef<HTMLSpanElement>(null);
  const [loading, setLoading] = useState(true);
  const tl = useRef<GSAPTimeline>(null);

  const { contextSafe } = useGSAP(
    () => {
      if (loading) {
        document.fonts.ready.then(() => {
          setLoading(false);
        });
      }

      if (!loading) {
        tl.current = gsap.timeline({
          paused: false,
        });
        tl.current.from(container.current, {
          filter: 'blur(1px)',
          duration: 0.4,
          ease: 'none',
          scrambleText: {
            chars: '!#*_?,/ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvxyz',
            speed: 0.5,
          },
        });
      }
    },
    { scope: container, dependencies: [loading] }
  );

  const active = contextSafe(() => {
    if (!tl?.current?.isActive()) tl?.current?.progress(0);
  });

  return (
      <span onMouseEnter={active} className='text-center' ref={container}>{children}</span>
  );
}
