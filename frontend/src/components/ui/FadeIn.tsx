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
export default function FadeIn({
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

      const elements = container.current?.querySelectorAll('.fadeIn')
      if(!elements)return;
      if (!loading) {
        gsap.from(elements, {
          duration:1,
          yPercent:70,
          opacity:0,
          scale:0.90,
          stagger:0.1,
          ease: 'power4.out',
          scrollTrigger: {
            trigger: container.current,
            markers: false,
            start: 'top 95%',
          },
        });
      }
    },
    { scope: container, dependencies: [loading] }
  );

  return <span className={className}  ref={container}>{children}</span>;
}
