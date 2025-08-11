import Button from '../../components/ui/Button';
import Marquee from '../../components/ui/Marquee';

export default function Hero() {
  return (
    <>
      <section className="mx-4 grid-cols-12 grid-rows-none text-white lg:mx-5 lg:grid lg:gap-x-5">
        <div className="header col-span-10 col-start-2 flex items-center justify-center leading-tight lg:justify-between">
          <h1 className="tracking-sans-wide text-hero-lg hidden lg:block">
            Begin your Linux journey.
          </h1>
          <h1 className="text-highlight font-spencer text-hero-lg-serif text-heading-h3">
            Linux-Lab
          </h1>
        </div>
        <div className="card__container shadow-highlight/20 relative col-span-10 col-start-2 row-start-2 h-[73lvh] max-h-full min-h-fit max-w-full overflow-clip rounded-sm shadow-[0_0_180px] lg:h-[65vh]">
          <img
            className="absolute top-0 left-0 z-0 h-full w-full object-cover select-none"
            src="media/asciibh.png"
            alt="black hole monochrome"
          />
          {/* background darken imgae*/}
          <div className="absolute z-0 h-full w-full bg-black/70 lg:hidden"></div>
          <div className="relative z-20 mx-0 flex h-full w-full flex-col justify-between px-4 py-14 sm:mx-auto sm:max-w-lg md:max-w-xl lg:max-w-full lg:items-end lg:justify-end lg:px-14">
            <span className="padding text-transparent select-none lg:hidden">
              .
            </span>
            <h2 className="text-heading-h6 sm:text-heading-h5 tracking-sans-wide text-center leading-tight lg:hidden">
              Begin your <span className="text-highlight">Linux</span> Journey.
            </h2>
            <div className="bottom__cta flex flex-col gap-4">
              <span className="tracking-sans-normal text-center leading-tight lg:hidden">
                From command line basics, to networking we got you covered for
                free and in browser.
              </span>
              <div className="flex w-full items-center justify-stretch gap-4 rounded-sm lg:w-lg lg:bg-black/90 lg:p-4 lg:backdrop-blur-xl">
                <Button className="xl:text-heading-slg w-full py-4">
                  Try It Now
                </Button>
                <Button
                  className="xl:text-heading-slg w-full py-4"
                  variant="outline"
                >
                  Login
                </Button>
              </div>
            </div>
          </div>
        </div>
      </section>
      <Marquee className="mt-2">
        <span className="font-spencer md:text-heading-h6 text-heading-h7 mx-4 flex gap-8">
          <span>The Basics</span> <span>Networking</span>
          <span>Bash Scripting</span>
          <span>The Basics</span> <span>Networking</span>
          <span>Bash Scripting</span>
          <span>The Basics</span> <span>Networking</span>
          <span>Bash Scripting</span>
        </span>
      </Marquee>
    </>
  );
}
