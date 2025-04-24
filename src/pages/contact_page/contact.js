import { Navigation } from "../../components/Navigation/index.js";
import { PageTitle } from "../../components/PageTitle/index.js";
import { ContactForm } from "../../components/ContactForm/index.js";
import { Footer } from "../../components/Footer/index.js";
import getUserCookie from "../../utils/getUserCookie.js";

const pageTitle = new PageTitle('.page-title__container','Contact Us');
pageTitle.mount();
const contactForm = new ContactForm('.contact-form__container');
contactForm.mount();
const footer = new Footer('.footer__container');

// cookie for auth init
const userObj = getUserCookie();
if(userObj){
    document.querySelector('.navigation__container').replaceChildren();
    const navigation = new Navigation(
      ".navigation__container",
      userObj.isLoggedIn,
      userObj
    );
}
else{
const navigation = new Navigation('.navigation__container');
}

