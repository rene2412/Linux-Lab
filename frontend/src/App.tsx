// import { useState } from 'react';
import './App.css';
import { Navbar } from './components/layout';
import Navmenu from './components/layout/Navmenu';
import NavbarProvider from './context/navContext';
import About from './sections/About';
import Hero from './sections/Hero';
import Overview from './sections/Overview';
import Benefits from './sections/Benefits';
import Globe from './sections/Globe/Globe';
import Modules from './sections/Modules/Modules';
import MediaLarge from './sections/MediaLarge/MediaLarge';
import Footer from './components/ui/Footer';
import { ReactLenis, useLenis } from 'lenis/react';
import { useEffect } from 'react';
import gsap from 'gsap';

function App() {
  window.scrollTo(0, 0);
  if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
  }
  const lenis = useLenis(() => {});
  window.scrollTo(0, 0);
  lenis?.scrollTo(0, { immediate: true });
  lenis?.stop();

  useEffect(() => {
    // Force scroll to top on mount/refresh

    function update(time: number) {
      lenis?.raf(time * 1000);
    }

    gsap.ticker.add(update);

    return () => gsap.ticker.remove(update);
  }, []);

  return (
    <ReactLenis
      options={{
        prevent: node => node.id === 'navmenu',
      }}
      root
    >
      <main className="bg-dark selection:bg-highlight relative min-h-svh selection:text-black">
        <NavbarProvider>
          <Navbar className="z-10" />
          <Navmenu className="z-20" />
          <main className="isolate z-0">
            <Hero />
            <About />
            <Overview />
            <Benefits />
            <Globe />
            <Modules />
            <MediaLarge />
            <Footer />
          </main>
        </NavbarProvider>
      </main>
    </ReactLenis>
  );
}

export default App;
