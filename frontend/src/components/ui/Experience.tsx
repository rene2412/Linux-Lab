import { Stars } from '@react-three/drei';
import { useMemo, useRef } from 'react';
import { useThree } from '@react-three/fiber';
import { EffectComposer } from '@react-three/postprocessing';
import { ASCIIEffect } from '../Ascii';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import { Observer } from 'gsap/Observer';
import { useGLTF } from '@react-three/drei';
import { Group } from 'three';
import * as THREE from 'three';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(Observer, ScrollTrigger);

export default function Experience() {
  const starRef = useRef<THREE.Points>(null);
  const { camera } = useThree();
  const width = window.innerWidth;
  const height = window.innerHeight;

  const bhContainer = useRef<Group>(null);

  const config = {
    characters: ".:,'-^=*+?!|0#X%WM@",
    color: 'white',
    fontSize: 75,
    cellSize: 3,
    radius: 50,
    invert: false,
    rotX: 3.12,
    rotY: -0.57,
    rotZ: 0.17,
  };

  const {
    radius,
    characters,
    color,
    fontSize,
    cellSize,
    invert,
    rotX,
    rotY,
    rotZ,
  } = config;

  const asciiEffect = useMemo(() => {
    return new ASCIIEffect({ characters, color, fontSize, cellSize, invert });
  }, [characters, color, fontSize, cellSize, invert]);

  useGSAP(() => {
    const xTo = gsap.quickTo(camera.position, 'x', {
      duration: 2,
      ease: 'power2.out',
    });
    const yTo = gsap.quickTo(camera.position, 'y', {
      duration: 2,
      ease: 'power2.out',
    });

    Observer.create({
      target: window,
      onMove: e => {
        if (e.x !== undefined && e.y !== undefined) {
          xTo((e.x / width - 0.5) * 2);
          yTo((e.y / height - 0.5) * 2);
        }
      },
    });

    if (starRef.current) {
      gsap.to(starRef.current.rotation, {
        y: Math.PI * 2,
        duration: 400,
        ease: 'none',
        repeat: -1,
      });
    }

    if (bhContainer.current) {
      gsap.to(bhContainer.current.rotation, {
        y: Math.PI * 2,
        duration: 120,
        ease: 'none',
        repeat: -1,
      });
    }

    gsap.to(camera.position, {
      z: -50,
      ease: 'none',
      scrollTrigger: {
        start: `top top`,
        end: `900px top`,
        scrub: true,
      },
    });
  });

  return (
    <>
      {/* <OrbitControls makeDefault /> */}
      <spotLight intensity={50} position={[1, 2, 3]}></spotLight>

      <group rotation={[rotX, rotY, rotZ]} position={[0, 0, -2]}>
        <mesh ref={bhContainer} position={[0, 0, 0]} scale={30}>
          <BlackHole />
        </mesh>
      </group>

      <EffectComposer>
        <primitive object={asciiEffect}></primitive>
      </EffectComposer>

      <Stars ref={starRef} radius={radius}></Stars>
    </>
  );
}

function BlackHole() {
  const model = useGLTF('models/bh-transformed.glb', true);
  const blackHoleRef = useRef(null);

  return (
    <primitive
      ref={blackHoleRef}
      position={[0, 0, 0]}
      // rotation={[]}
      scale={1}
      object={model.scene}
    />
  );
}
