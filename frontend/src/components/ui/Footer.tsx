import { SITE_URL_FOUNDATIONS, SITE_URL_NETWORKING } from '../../utils/data';
import Marquee from './Marquee';
import ScrambleScroll from './ScrambleScroll';
import ScrambleText from './ScrambleText';

export default function Footer() {
  return (
    <footer
      className={`flex h-[650px] lg:h-[550px] flex-col justify-between pt-6 text-white`}
    >
      <ScrambleScroll className="font-spencer text-heading-xl mx-4 sm:hidden">
        Linux-Lab
      </ScrambleScroll>
      <div className="flex h-full grow grid-cols-12 flex-col justify-start sm:grid">
        <div className="col-span-6 row-start-0 my-auto hidden flex-col items-center justify-center gap-2 sm:flex">
          <ScrambleScroll className="font-spencer text-heading-h5 lg:text-heading-h4 leading-none">
            Linux-Lab
          </ScrambleScroll>
          <span className="text-center">Based, in California</span>
        </div>
        <nav className="col-span-6 col-start-7 mx-4 mt-10 grid h-fit grid-cols-2 grid-rows-2 gap-x-4 gap-y-10 sm:my-auto lg:col-start-8 lg:col-span-4">
          <NavLinkList title="Quick Links" data={FOOTER_DATA.quickLinks} />
          <NavLinkList title="Modules" data={FOOTER_DATA.modules} />
          <NavLinkList title="Socials" data={FOOTER_DATA.social} />
          <NavLinkList title="Misc" data={FOOTER_DATA.other} />
        </nav>
      </div>
      <div className="mt-auto flex w-full flex-col justify-end gap-2">
        <span className="text-center">
          © <span className="font-spencer">Linux-Lab 2025</span>
        </span>
        <Marquee className="bg-highlight shadow-highlight font-spencer h-fit !text-black shadow-[0px_0px_120px]">
          <span className="mx-2">
            Linux-Lab is here. Linux-Lab is there. Linux-Lab is alive.
            Linux-Lab is here. Linux-Lab is there. Linux-Lab is alive.
            Linux-Lab is here. Linux-Lab is there. Linux-Lab is alive.
            Linux-Lab is here. Linux-Lab is there. Linux-Lab is alive.
            Linux-Lab is here. Linux-Lab is there. Linux-Lab is alive.
            Linux-Lab is here. Linux-Lab is there. Linux-Lab is alive.
            Linux-Lab is here. Linux-Lab is there. Linux-Lab is alive.
            Linux-Lab is here. Linux-Lab is there. Linux-Lab is alive.
          </span>
        </Marquee>
      </div>
    </footer>
  );
}

function NavLinkList({ data, title = 'title', className }: NAVLINK_DATA) {
  return (
    <ul
      className={`tracking-sans-normal flex flex-col gap-2 leading-tight font-black ${className}`}
    >
      <li>
        <h4 className="tracking-sans-normal font-sans font-normal text-white/70">
          {title}
        </h4>
      </li>
      {data.map(element => {
        return (
          <li key={element.name}>
            <a href={element.href}>
              <ScrambleText>{element.name}</ScrambleText>
            </a>
          </li>
        );
      })}
    </ul>
  );
}

type NAVLINK = {
  name?: string;
  href?: string;
};

type NAVLINK_DATA = {
  data: NAVLINK[];
  title?: string;
  className?: string;
};

const FOOTER_DATA = {
  quickLinks: [
    { name: 'Home', href: '#' },
    { name: 'Overview', href: '#overview' },
    { name: 'Benefits', href: '#benefits' },
    { name: 'Modules', href: '#modules' },
  ],
  modules: [
    { name: 'Foundations', href: SITE_URL_FOUNDATIONS },
    { name: 'Networking', href: SITE_URL_NETWORKING },
  ],
  social: [
    { name: 'Email', href: 'mailto:Linuxlab012@gmail.com' },
  ],
  other: [
    { name: 'Misc', href: 'https://www.youtube.com/watch?v=4JZ-o3iAJv4' },
  ],
  copyright: '© Linux-Lab 2025',
};
