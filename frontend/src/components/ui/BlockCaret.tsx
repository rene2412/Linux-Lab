export default function BlockCaret({ className = '' }) {
  return (
    <span
      style={{ clipPath: 'inset(0% 0% 0% 0%)' }}
      className={`animate-cursor-blink font-spencer ml-0.5 h-fit w-fit bg-white ${className}`}
    >
      a
    </span>
  );
}
