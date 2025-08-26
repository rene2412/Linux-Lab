import type React from 'react';

export function Card({
  children,
  className,
  active,
  ...props
}: React.HTMLAttributes<HTMLDivElement> & {
  children?: React.ReactNode;
  className?: string;
  active?: boolean;
}) {
  return (
    <article
      {...props}
      className={`shadow-highlight/0 card__container hover:shadow-highlight/20 z-10 flex h-3/4 max-h-[650px] min-h-fit max-w-md origin-center flex-col rounded-sm bg-black/90 p-2 shadow-[0px_0px_64px] outline-2 outline-white backdrop-blur-xl transition-[box-shadow] duration-300 ${active && 'shadow-highlight/40'} sm:gap-4 md:p-4 ${className}`}
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
      className={`text-heading-h6 lg:text-heading-h5 card__heading font-spencer text-white ${className}`}
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
      <CardInfoItem term="Size">{size}</CardInfoItem>
      <CardInfoItem term="Time to Complete">{time}</CardInfoItem>
      <CardInfoItem term="Difficulty">{difficulty}</CardInfoItem>
      <CardInfoItem term="Price">{price}</CardInfoItem>
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
      <p className="font-black">{term}:</p>
      <p>{children}</p>
    </span>
  );
}
