type BackgroundImageProps = {
  className?: string;
  src: string;
  alt: string;
};

export default function BackgroundImage({
  className,
  src,
  alt,
}: BackgroundImageProps) {
  return (
    <div
      aria-hidden
      className={`pointer-events-none select-none absolute  top-0 -z-10 h-full w-full overflow-visible opacity-3 ${className}`}
    >
      <img
        src={src}
        alt={alt}
        className="pointer-events-none  select-none top-0 h-full w-full object-cover"
      ></img>
    </div>
  );
}
