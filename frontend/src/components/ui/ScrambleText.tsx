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
  className,
}: {
  children: React.ReactNode;
  className?: string;
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
        tl.current.to(container.current, {
          // filter: 'blur(4px)',
          duration:0.3,
          ease: 'none',
          scrambleText: {
            text: container.current?.textContent || '',
            chars: '!#*_?,/ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvxyz',
            speed: 5,
            // rightToLeft:true
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
    <span onMouseEnter={active} className={`text-center hover:text-highlight ${className}`} ref={container}>
      {children}
    </span>
  );
}
