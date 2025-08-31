import { Stars } from "@react-three/drei";
import { useControls } from "leva";
import { useMemo, useRef } from "react";
import { useThree } from "@react-three/fiber";
import { EffectComposer } from "@react-three/postprocessing";
import { ASCIIEffect } from "../Ascii";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";
import { Observer } from "gsap/Observer";
import { useGLTF } from "@react-three/drei";
import type { Mesh } from "three";
import { Group } from "three/examples/jsm/libs/tween.module.js";

gsap.registerPlugin(Observer);

export default function Experience() {
  const starRef = useRef<Mesh>(null);
  const { camera, size } = useThree();
  console.log(size);
  const width = window.innerWidth;
  const height = window.innerHeight;

  const bhContainer = useRef<Group>(null);

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
  } = useControls({
    characters: { value: ".:,'-^=*+?!|0#X%WM@" },
    color: "white",
    fontSize: { value: 75, min: 0, max: 100, step: 1 },
    cellSize: { value: 3, min: 2, max: 100, step: 1 },
    radius: { value: 50, min: 1, max: 100, step: 1 },
    invert: false,
    rotX: { value: 3.06, min: -Math.PI, max: Math.PI, step: 0.01 },
    rotY: { value: -0.57, min: -Math.PI, max: Math.PI, step: 0.01 },
    rotZ: { value: 0.17, min: -Math.PI, max: Math.PI, step: 0.01 },
  });

  const asciiEffect = useMemo(() => {
    return new ASCIIEffect({ characters, color, fontSize, cellSize, invert });
  }, [characters, color, fontSize, cellSize, invert]);

  useGSAP(() => {
    const xTo = gsap.quickTo(camera.position, "x", {
      duration: 2,
      ease: "power2.out",
    });
    const yTo = gsap.quickTo(camera.position, "y", {
      duration: 2,
      ease: "power2.out",
    });

    Observer.create({
      target: window,
      onMove: (e) => {
        xTo((e.x / width - 0.5) * 2);
        yTo((e.y / height - 0.5) * 2);
      },
    });

    gsap.to(starRef.current.rotation, {
      y: Math.PI * 2,
      duration: 400,
      ease: "none",
      repeat: -1,
    });

    gsap.to(bhContainer.current.rotation, {
      y: Math.PI * 2,
      duration: 120,
      ease: "none",
      repeat: -1,
    });

    gsap.to(camera.position,{
        z:-50,
        ease:'none',
        scrollTrigger:{
            start:`top top`,
            end:`900px top`,
            markers:true,
            scrub:true,
        }

    })

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
  const model = useGLTF("models/bh-transformed.glb",true);
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
