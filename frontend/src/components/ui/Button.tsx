import { useRef } from 'react';

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

  if (variant === 'default')
    return (
      <button
        ref={container}
        {...props}
        className={`shadow-highlight/0 bg-highlight hover:shadow-highlight/50 text-dark font-spencer flex touch-manipulation items-center justify-center rounded-sm px-6 py-2 shadow-[0px_0px_16px] transition-[box-shadow] duration-300 ease-out ${className}`}
      >
        {children}
      </button>
    );
  if (variant === 'outline')
    return (
      <button
        ref={container}
        {...props}
        className={`outline-highlight shadow-highlight/0 hover:shadow-highlight/50 text-highlight font-spencer flex touch-manipulation items-center justify-center rounded-sm px-6 py-2 shadow-[0px_0px_16px] outline-2 transition-[box-shadow] duration-300 ease-out focus:opacity-80 ${className}`}
      >
        {children}
      </button>
    );
}
