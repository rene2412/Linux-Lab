import gsap from 'gsap';
import TextPlugin from 'gsap/TextPlugin';

gsap.registerPlugin(TextPlugin);

export const typewriterCycle = (
  element: GSAPTweenTarget,
  texts: string[],
  duration: number = 2
) => {
    gsap.killTweensOf(element);
    gsap.set(element,{text:''})
  const tl = gsap.timeline({ repeat: -1});
  texts.forEach(text => {
    tl.fromTo(
      element,
      {
        text: {
          value: '',
          rtl: true,
        },
        ease: 'none',
        duration: duration/1.5,
        delay: 1,
      },
      {
        text,
        duration,
        ease: 'none',
      }
    ).to(element, {
      text: {
        value: '',
        rtl: true,
      },
      ease: 'none',
      duration: duration/1.5,
      delay: 1,
    });
  });
  return tl;
};
