import { useRef } from 'react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import InertiaPlugin from 'gsap/InertiaPlugin';

import Draggable from 'gsap/Draggable';
import Button from '../../components/ui/Button';

gsap.registerPlugin(Draggable, InertiaPlugin);

const OVERVIEW_LINKS = [
  { name: 'Command Line', Content: [<p>Hello world</p>] },
  { name: 'Networking', Content: [<p>Hello world</p>] },
  { name: 'Bash Scripting', Content: [<p>Hello world</p>] },
];

export default function Overview() {
  const container = useRef(null);

  useGSAP(() => {
    Draggable.create('.draggable', {
      type: 'x,y',
      //   inertia: true,
      bounds: container.current,
      cursor: 'default',
    });
  });

  return (
    <section
      ref={container}
      className="mx-4 mt-20 h-lvh max-h-fit min-h-fit overflow-clip"
    >
      <div className="flex h-full w-full flex-col py-10">
        <h2 className="text-heading-xl lg:text-heading-h6 tracking-sans-normal font-sans text-white">
          Our content.
        </h2>
        <div className="mt-4 grid grid-cols-4 gap-4">
          <p className="tracking-sans-normal col-span-2 col-start-3 font-sans text-white">
            Click on any of these topics to get an overview at the topics we
            cover.
          </p>
        </div>
        <ul className="flex h-full w-full flex-col items-center justify-center gap-20">
          {OVERVIEW_LINKS.map(item => {
            return (
              <li
                className="flex items-center justify-center text-white"
                key={item.name}
              >
                <button
                  className="font-spencer text-heading-h6 h-full w-full"
                  type="button"
                >
                  {item.name}
                </button>
              </li>
            );
          })}
        </ul>
        <article className="draggable bg-black/80 backdrop-blur-xl absolute max-w-lg rounded-sm outline-2 outline-white">
          <h2 className="text-heading-h6 font-spencer text-white">
            Networking
          </h2>
          <p className="text-white">hello world</p>
          <Button variant="outline">Close</Button>
        </article>
        <span className="tracking-sans-normal text-center text-white">
          What will you learn?
        </span>
      </div>
    </section>
  );
}
