// import { useState } from 'react';
import './App.css';
import { Navbar } from './components/layout';
import Navmenu from './components/layout/Navmenu';
import NavbarProvider from './context/navContext';

function App() {
  return (
    <main className="bg-dark min-h-svh">
      <NavbarProvider>
        <Navbar />
        <Navmenu/>
      </NavbarProvider>
    </main>
  );
}

export default App;
