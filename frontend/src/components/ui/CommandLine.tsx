import { typewriterCycle } from '../../utils/animations/textCycle';
import { useGSAP } from '@gsap/react';
import { useRef } from 'react';
import BlockCaret from './BlockCaret';

export default function CommandLine({
  user = 'user@linux-lab',
  text = ['Hello World'],
  className,
}: {
  user?: string;
  text?: string[];
  className?: string;
}) {
  const container = useRef(null);

  useGSAP(
    () => {
      typewriterCycle('.textCycle',text,2);
    },
    { scope: container }
  );

  return (
    <span
      aria-hidden
      ref={container}
      className={`text-heading-slg text-white ${className}`}
    >
      <span className="text-highlight font-spencer">{user}</span>
      <span className="font-spencer">
        :<span className="font-jersey">~$ </span>
      </span>
      <span className="font-spencer">
        <span className='textCycle'></span>
        <BlockCaret />
      </span>
    </span>
  );
}
