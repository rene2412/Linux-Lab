// import { useState } from 'react';
import './App.css';
import { Navbar } from './components/layout';
import Navmenu from './components/layout/Navmenu';
import LenisProvider from './context/LenisContext';
import NavbarProvider from './context/navContext';
import About from './sections/About';
import Hero from './sections/Hero';
import Overview from './sections/Overview';
import Benefits from './sections/Benefits';
import Globe from './sections/Globe/Globe';
import Modules from './sections/Modules/Modules';

function App() {
  return (
    <LenisProvider>
      <main className="bg-dark relative min-h-svh">
        <NavbarProvider>
          <Navbar className="z-10" />
          <Navmenu className="z-20" />
          <main className="isolate z-0">
            <Hero />
            <About/>
            <Overview/>
            <Benefits/>
            <Globe/>
            <Modules/>
            <div className="h-svh bg-dark"></div>
          </main>
        </NavbarProvider>
      </main>
    </LenisProvider>
  );
}

export default App;
