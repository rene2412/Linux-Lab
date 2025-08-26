import React, { createContext, useContext, useState } from 'react';

type NavbarContextProps = {
  isOpen: boolean;
  setIsOpen: (value: boolean) => void;
};

type NavbarProviderProps = {
  children?: React.ReactNode;
};

const NavbarContext = createContext<NavbarContextProps | null>(null);

export default function NavbarProvider({ children }: NavbarProviderProps) {
  const [isOpen, setIsOpen] = useState(false);

  return (
    <NavbarContext value={{ isOpen, setIsOpen }}>{children}</NavbarContext>
  );
}

export function useNavbar() {
  const context = useContext(NavbarContext);

  if (!context) {
    throw new Error('useSidebar must be used within a NavbarProvider');
  }
  return context;
}
