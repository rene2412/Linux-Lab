// import { useState } from 'react';
import './App.css';
import { Navbar } from './components/layout';
import Navmenu from './components/layout/Navmenu';
import LenisProvider from './context/LenisContext';
import NavbarProvider from './context/navContext';
import About from './sections/About';
import Hero from './sections/Hero';

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
            <div className="h-svh"></div>
          </main>
        </NavbarProvider>
      </main>
    </LenisProvider>
  );
}

export default App;
