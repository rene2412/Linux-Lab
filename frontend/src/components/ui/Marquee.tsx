import { useGSAP } from '@gsap/react';
import gsap from 'gsap';
import { useLenis } from 'lenis/react';
import React, { useRef, useState, useEffect } from 'react';

export default function Marquee({
  className,
  children = 'This is the default text just pass in the string but make sure it fills the viewport so do a good buffer  ',
}: {
  children?: React.ReactNode;
  className?: string;
}) {
  const container = useRef<HTMLDivElement>(null);
  const [loading, setLoading] = useState(true);
  const [marqueeWidth, setMarqueeWidth] = useState(0);
  const lenis = useLenis();

  useEffect(() => {
    if (!loading && container.current) {
      const width = container.current.querySelector('.marquee__item')?.clientWidth || 0;
      setMarqueeWidth(width);
    }
  }, [loading, children]);

  useGSAP(
    () => {
      if (loading) {
        document.fonts.ready.then(() => {
          setLoading(false);
        });
      }

      if(!lenis)return;
      if (!loading && container.current && marqueeWidth > 0) {
        const half = marqueeWidth;
        // console.log(half);
        const wrap = gsap.utils.wrap(-half, 0);

        const xSet = gsap.quickTo(container.current, 'x', {
          duration: 0.5,
          ease: 'power4.out',
          modifiers: {
            x: gsap.utils.unitize(wrap),
          },
        });

        let value = 0;
        const MAX_SCROLL_VEL = 10;
        const MIN_SCROLL_VEL = -10;
        const CONST_VEL = 1;
        let direction = 1;
        function move() {
          if(!lenis)return;
          if (lenis?.direction != 0) {
            direction = lenis.direction;
          }
            xSet(
              (value =
                value +
                gsap.utils.clamp(
                  MIN_SCROLL_VEL,
                  MAX_SCROLL_VEL,
                  lenis.velocity
                ) +
                CONST_VEL * direction)
            );
          requestAnimationFrame(move);
        }
        move();
      }
    },
    { dependencies: [loading, lenis, marqueeWidth], scope: container }
  );

  return (
    <div aria-hidden className={`h-full w-full overflow-hidden ${className}`}>
      <div
        ref={container}
        className="marquee__track aria-hidden: pointer-events-none flex text-nowrap select-none"
      >
        <div className="marquee__item">{children}</div>
        <div className="marquee__item">{children}</div>
      </div>
    </div>
  );
}
