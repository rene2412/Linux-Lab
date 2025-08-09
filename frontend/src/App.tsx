// import { useState } from 'react';
import './App.css';
import { Navbar } from './components/layout';
import Navmenu from './components/layout/Navmenu';
import NavbarProvider from './context/navContext';
import Hero from './sections/Hero';

function App() {
  return (
    <main className="bg-dark relative min-h-svh">
      <NavbarProvider>
        <Navbar className='z-10' />
        <Navmenu className='z-20' />
        <main className="z-0 isolate">
          <Hero />
          <div className='h-svh'></div>
        </main>
      </NavbarProvider>
    </main>
  );
}

export default App;
