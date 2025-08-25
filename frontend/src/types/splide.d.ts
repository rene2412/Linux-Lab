// Type declarations for @splidejs/react-splide
// This file resolves TypeScript module resolution issues with the library

// Why this file exists:
// @splidejs/react-splide v0.7.12 has type definitions at /dist/types/index.d.ts
// but they're not properly exposed via the package.json "exports" field.
// This causes TypeScript to treat the module as having an implicit 'any' type.
// Creating this declaration file provides explicit types for the library.

declare module '@splidejs/react-splide' {
  import { ComponentType, ReactNode, RefObject } from 'react';

  // Splide options interface - based on the core Splide library
  export interface Options {
    type?: 'loop' | 'slide' | 'fade';
    rewind?: boolean;
    speed?: number;
    rewindSpeed?: number;
    width?: number | string;
    height?: number | string;
    fixedWidth?: number | string;
    fixedHeight?: number | string;
    heightRatio?: number;
    autoWidth?: boolean;
    autoHeight?: boolean;
    perPage?: number;
    perMove?: number;
    clones?: number;
    start?: number;
    focus?: number | 'center';
    gap?: number | string;
    padding?: number | string | { left?: number | string; right?: number | string };
    arrows?: boolean;
    pagination?: boolean;
    paginationKeyboard?: boolean;
    paginationDirection?: 'ltr' | 'rtl' | 'ttb' | 'btt';
    autoplay?: boolean;
    interval?: number;
    pauseOnHover?: boolean;
    pauseOnFocus?: boolean;
    resetProgress?: boolean;
    lazyLoad?: boolean | 'nearby' | 'sequential';
    preloadPages?: number;
    easing?: string;
    keyboard?: boolean | 'focused' | 'global';
    drag?: boolean | 'free';
    snap?: boolean;
    noDrag?: string;
    direction?: 'ltr' | 'rtl' | 'ttb';
    cover?: boolean;
    slideFocus?: boolean;
    isNavigation?: boolean;
    trimSpace?: boolean | 'move';
    updateOnMove?: boolean;
    throttle?: number;
    destroy?: boolean;
    breakpoints?: Record<number, Partial<Options>>;
    classes?: {
      root?: string;
      slider?: string;
      track?: string;
      list?: string;
      slide?: string;
      container?: string;
      arrows?: string;
      arrow?: string;
      prev?: string;
      next?: string;
      pagination?: string;
      page?: string;
      clone?: string;
    };
    i18n?: {
      prev?: string;
      next?: string;
      first?: string;
      last?: string;
      slideX?: string;
      pageX?: string;
      carousel?: string;
      select?: string;
      slide?: string;
    };
    [key: string]: any;
  }

  // Props for the main Splide component
  export interface SplideProps {
    options?: Options;
    extensions?: Record<string, any>;
    transition?: Record<string, any>;
    hasTrack?: boolean;
    tag?: keyof JSX.IntrinsicElements;
    className?: string;
    style?: React.CSSProperties;
    children?: ReactNode;
    onMounted?: (splide: any) => void;
    onUpdated?: (splide: any) => void;
    onMove?: (splide: any, newIndex: number, prevIndex: number) => void;
    onMoved?: (splide: any, newIndex: number, prevIndex: number) => void;
    onDrag?: (splide: any) => void;
    onDragged?: (splide: any) => void;
    onVisible?: (splide: any, slide: any) => void;
    onHidden?: (splide: any, slide: any) => void;
    onActive?: (splide: any, slide: any) => void;
    onInactive?: (splide: any, slide: any) => void;
    onClick?: (splide: any, slide: any, e: Event) => void;
    onArrowsMounted?: (splide: any, prev: Element, next: Element) => void;
    onArrowsUpdated?: (splide: any, prev: Element, next: Element) => void;
    onPaginationMounted?: (splide: any, data: any) => void;
    onPaginationUpdated?: (splide: any, data: any) => void;
    onNavigationMounted?: (splide: any, splideNav: any) => void;
    onAutoplayPlaying?: (splide: any, rate: number) => void;
    onAutoplayPaused?: (splide: any) => void;
    onLazyLoadLoaded?: (splide: any, img: HTMLImageElement, slide: any) => void;
    [key: string]: any;
  }

  // Props for individual slide components
  export interface SplideSlideProps {
    tag?: keyof JSX.IntrinsicElements;
    className?: string;
    style?: React.CSSProperties;
    children?: ReactNode;
    [key: string]: any;
  }

  // Props for the track component (container for slides)
  export interface SplideTrackProps {
    tag?: keyof JSX.IntrinsicElements;
    className?: string;
    style?: React.CSSProperties;
    children?: ReactNode;
    [key: string]: any;
  }

  // Main Splide carousel component
  export const Splide: ComponentType<SplideProps>;
  
  // Individual slide component
  export const SplideSlide: ComponentType<SplideSlideProps>;
  
  // Track component (wraps slides)
  export const SplideTrack: ComponentType<SplideTrackProps>;
}

// Declaration for CSS imports
// This tells TypeScript that importing the CSS file is valid
declare module '@splidejs/react-splide/css' {
  const content: any;
  export default content;
}

// Alternative CSS import paths that might be used
declare module '@splidejs/react-splide/css/themes/splide-default.min.css' {
  const content: any;
  export default content;
}

declare module '@splidejs/react-splide/css/themes/splide-sea-green.min.css' {
  const content: any;
  export default content;
}

declare module '@splidejs/react-splide/css/themes/splide-skyblue.min.css' {
  const content: any;
  export default content;
}