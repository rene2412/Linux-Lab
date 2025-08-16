import { useGSAP } from '@gsap/react';
import gsap from 'gsap';
// import { useGSAP } from "@gsap/react";
import ScrambleTextPlugin from 'gsap/ScrambleTextPlugin';
import ScrollTrigger from 'gsap/ScrollTrigger';
import SplitText from 'gsap/SplitText';
import React, { useRef, useState } from 'react';
gsap.registerPlugin(ScrambleTextPlugin, SplitText, ScrollTrigger);

// make sure to make parent relative for full hover fill vs text
/**
 * A text component that creates a scrambling animation effect on hover
 * PARENT MUST BE Relative to work with active
 * @param children - The text content to display and animate
 */
export default function ScrambleScroll({
  children,
  className,
}: {
  children: React.ReactNode;
  className?: string; 
}) {
  const container = useRef<HTMLSpanElement>(null);
  const [loading, setLoading] = useState(true);

  useGSAP(
    () => {
      if (loading) {
        document.fonts.ready.then(() => {
          setLoading(false);
        });
      }

      if (!loading) {
        gsap.from(container.current, {
          duration:0.6,
          ease: 'none',
          scrambleText: {
            text: '_',
            chars: '!#*_?,/ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvxyz',
            speed: 1,
          },
          scrollTrigger: {
            trigger: container.current,
            markers: false,
            start: 'top 100%',
          },
        });
      }
    },
    { scope: container, dependencies: [loading] }
  );

  return <span className={className}  ref={container}>{children}</span>;
}
