import type React from 'react'; // default props

type ButtonProps = React.ComponentPropsWithoutRef<'button'> & {
  className?: string;
  variant?: 'default' | 'outline';
  children: React.ReactNode;
};

export default function Button({
  variant = 'default',
  className,
  children,
  ...props
}: ButtonProps) {
  if (variant === 'default')
    return (
      <button
        {...props}
        className={`bg-highlight text-dark font-spencer flex touch-manipulation items-center justify-center rounded-sm px-6 py-2 ${className}`}
      >
        {children}
      </button>
    );
  if (variant === 'outline')
    return (
      <button
        {...props}
        className={`outline-highlight text-highlight font-spencer flex touch-manipulation items-center justify-center rounded-sm px-6 py-2 outline-2 ${className}`}
      >
        {children}
      </button>
    );
}
