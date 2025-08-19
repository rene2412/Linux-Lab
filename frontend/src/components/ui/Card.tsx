import type React from 'react';

export function Card({
  children,
  className,
}: {
  children?: React.ReactNode;
  className?: string;
}) {
  return (
    <article
      className={`shadow-highlight/20 card__container z-10 flex h-3/4 max-h-[650px] min-h-fit max-w-md origin-center flex-col rounded-sm bg-black/90 p-2 outline-2 outline-white backdrop-blur-xl hover:shadow-[0px_0px_64px] sm:gap-4 md:p-4 ${className}`}
    >
      {children}
    </article>
  );
}

export function CardHeader({
  children,
  className,
}: {
  children?: React.ReactNode;
  className?: string;
}) {
  return (
    <h2
      className={`text-heading-h6 lg:text-heading-h5 card__heading font-spencer leading-tighter text-white ${className}`}
    >
      {children}
    </h2>
  );
}

export function CardInfo({
  className,
  size = 'size',
  time = 'time',
  difficulty = 'diff',
  price = 'price',
}: {
  children?: React.ReactNode;
  className?: string;
  size?: string;
  time?: string;
  difficulty?: string;
  price?: string;
}) {
  return (
    <dl className={`text-white ${className}`}>
      <CardInfoItem term='Size'>{size}</CardInfoItem>
      <CardInfoItem term='Time to Complete'>{time}</CardInfoItem>
      <CardInfoItem term='Difficulty'>{difficulty}</CardInfoItem>
      <CardInfoItem term='Price'>{price}</CardInfoItem>
    </dl>
  );
}

export function CardInfoItem({
  term = 'term',
  children = '',
  className,
}: {
  className?: string;
  term: string;
  children: string;
}) {
  return (
    <span className={`flex gap-1 ${className}`}>
      <dt className=' font-black '>{term}:</dt>
      <dd>{children}</dd>
    </span>
  );
}
