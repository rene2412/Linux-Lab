import { typewriterCycle } from '../../utils/animations/textCycle';
import { useGSAP } from '@gsap/react';
import { useRef } from 'react';
import BlockCaret from './BlockCaret';

export default function CommandLine({
  user = 'user@linux-lab',
  text = ['Hello World'],
  className,
  active,
}: {
  user?: string;
  active?: boolean;
  text?: string[];
  className?: string;
}) {
  const container = useRef(null);
  const tl = useRef<GSAPTimeline>(null);

  useGSAP(
    () => {
      tl.current = typewriterCycle('.textCycle', text, 2);
      if (!active) {
        tl.current.pause();
      }
      if (active) {
        tl.current.play();
      }
    },
    { scope: container, dependencies: [active] }
  );

  return (
    <span
      aria-hidden
      ref={container}
      className={`text-heading-slg saturate-0 transition-[filter] ${active && 'saturate-100'} text-white ${className}`}
    >
      <span className="text-highlight font-spencer">{user}</span>
      <span className="font-spencer">
        :<span className="font-jersey">~$ </span>
      </span>
      <span className="font-spencer">
        <span className="textCycle"></span>
        <BlockCaret />
      </span>
    </span>
  );
}
