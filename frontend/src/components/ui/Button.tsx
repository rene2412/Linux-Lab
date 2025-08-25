import { useRef } from 'react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import ScrambleTextPlugin from 'gsap/ScrambleTextPlugin';
import { useState } from 'react';
gsap.registerPlugin(ScrambleTextPlugin);

type ButtonProps = React.ComponentPropsWithoutRef<'button'> & {
  className?: string | React.ReactNode;
  variant?: 'default' | 'outline';
  children: React.ReactNode;
};

export default function Button({
  variant = 'default',
  className,
  children,
  ...props
}: ButtonProps) {
  const container = useRef<HTMLButtonElement>(null);
  const tl = useRef<GSAPTimeline>(null);
  const [loading, setLoading] = useState(true);

  const { contextSafe } = useGSAP(
    () => {
      if (loading) {
        document.fonts.ready.then(() => {
          setLoading(false);
        });
      }

      if (loading) return;
      tl.current = gsap.timeline({});
      tl.current.to(container.current, {
        scrambleText: {
          text: '{original}',
        },
      });
    },
    { scope: container, dependencies: [loading] }
  );

  const active = contextSafe(() => {
    if (!tl?.current?.isActive()) tl?.current?.progress(0);
  });

  if (variant === 'default')
    return (
      <button
        onMouseEnter={active}
        ref={container}
        {...props}
        className={`shadow-highlight/0 bg-highlight hover:shadow-highlight/50 font-spencer relative flex cursor-pointer touch-manipulation items-center justify-center rounded-sm px-6 py-2 text-black shadow-[0px_0px_16px] transition-[box-shadow] duration-300 ease-out active:scale-95 ${className}`}
      >
        {children}
      </button>
    );
  if (variant === 'outline')
    return (
      <button
        onMouseEnter={active}
        ref={container}
        {...props}
        className={`outline-highlight shadow-highlight/0 hover:shadow-highlight/50 text-highlight font-spencer flex cursor-pointer touch-manipulation items-center justify-center rounded-sm px-6 py-2 shadow-[0px_0px_16px] outline-2 transition-[box-shadow] duration-300 ease-out focus:opacity-80 active:scale-98 ${className}`}
      >
        {children}
      </button>
    );
}
