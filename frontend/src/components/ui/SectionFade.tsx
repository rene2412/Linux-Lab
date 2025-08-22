type SectionFadeProps = {
  className?: string;
  variant: 'top' | 'bottom';
};

export default function SectionFade({ className, variant }: SectionFadeProps) {
  if (variant === 'top') {
    return (
      <div
        aria-hidden
        className={`pointer-events-none absolute top-0 z-10 h-24 w-full bg-gradient-to-b from-black to-black/0 ${className}`}
      ></div>
    );
  }
  if (variant === 'bottom') {
    return (
      <div
        aria-hidden
        className={`pointer-events-none absolute bottom-0 z-24 h-16 w-full bg-gradient-to-t from-black to-black/0 ${className}`}
      ></div>
    );
  }
}
