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


async function AuthCheck(){
    try{
        const response = await fetch('../../user/user.php');
        if(!response.ok){
            throw new Error('Fail fetching auth info');
        }
        const data = await response.json()
        console.log(data);
        if(data.isLoggedIn){
            document.querySelector('.navigation__container').replaceChildren();
            const navigation = new Navigation('.navigation__container',data.isLoggedIn,data);
        }
        else{
            return;
        }
    }
    catch(error){
        console.error(error);
    }
}
AuthCheck();

