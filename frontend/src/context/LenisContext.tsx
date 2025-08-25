import Lenis from 'lenis';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import { createContext, useContext } from 'react';

gsap.registerPlugin(ScrollTrigger);

const LenisContext = createContext<Lenis | null>(null);

export default function LenisProvider({
  children,
}: {
  children: React.ReactNode;
}) {
  const lenis = new Lenis({
    prevent:(node)=> node.classList.contains('subscroll'),
  });

  // Synchronize Lenis scrolling with GSAP's ScrollTrigger plugin
  lenis.on('scroll', ScrollTrigger.update);

  // Add Lenis's requestAnimationFrame (raf) method to GSAP's ticker
  // This ensures Lenis's smooth scroll animation updates on each GSAP tick
  gsap.ticker.add(time => {
    lenis.raf(time * 1000); // Convert time from seconds to milliseconds
  });

  // Disable lag smoothing in GSAP to prevent any delay in scroll animations
  gsap.ticker.lagSmoothing(0);

  return <LenisContext value={lenis}>{children}</LenisContext>;
}

export function useLenis(){
    const lenis = useContext(LenisContext);
    if(!lenis){
        throw new Error('must be within LenisProvider to use hook');
    }
    return lenis;
}
