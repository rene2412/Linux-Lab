import { Navigation } from "../../components/Navigation/index.js";
import { PageTitle } from "../../components/PageTitle/index.js";
import { ContactForm } from "../../components/ContactForm/index.js";
import { Footer } from "../../components/Footer/index.js";

const navigation = new Navigation('.navigation__container');
const pageTitle = new PageTitle('.page-title__container','Contact Us');
pageTitle.mount();
const contactForm = new ContactForm('.contact-form__container');
contactForm.mount();
const footer = new Footer('.footer__container');
