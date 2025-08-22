import { useRef } from 'react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import ScrambleTextPlugin from 'gsap/ScrambleTextPlugin';
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

  const { contextSafe } = useGSAP(() => {}, { scope: container });

  const active = contextSafe(() => {
    const tl = gsap.timeline();
    tl.to(container.current, {
      scrambleText: {
        text: '{original}',
      },
    });
  });

  if (variant === 'default')
    return (
      <button
        onMouseEnter={active}
        ref={container}
        {...props}
        className={`shadow-highlight/0 text-black bg-highlight hover:shadow-highlight/50 relative font-spencer flex cursor-pointer touch-manipulation items-center justify-center rounded-sm px-6 py-2 shadow-[0px_0px_16px] transition-[box-shadow] duration-300 ease-out ${className}`}
      >
        {children}
        {/* <div aria-hidden className='absolute top-0 left-0 w-full h-full button__text text-center text-dark'>{children}</div> */}
      </button>
    );
  if (variant === 'outline')
    return (
      <button
        ref={container}
        {...props}
        className={`outline-highlight shadow-highlight/0 hover:shadow-highlight/50 text-highlight font-spencer flex cursor-pointer touch-manipulation items-center justify-center rounded-sm px-6 py-2 shadow-[0px_0px_16px] outline-2 transition-[box-shadow] duration-300 ease-out focus:opacity-80 ${className}`}
      >
        {children}
      </button>
    );
}
