import { Navigation } from "../../components/Navigation/index.js";
import { Footer } from "../../components/Footer/index.js";
import getUserCookie from "../../utils/getUserCookie.js";

// cookie for auth init
const userObj = getUserCookie();
console.log(userObj)
if(userObj){
    document.querySelector('.navigation__container').replaceChildren();
    const navigation = new Navigation(
      ".navigation__container",
      userObj.isLoggedIn,
      userObj
    );
}
else{
document.querySelector('.navigation__container').replaceChildren();
const navigation = new Navigation('.navigation__container');
}


const footer = new Footer('.footer__container');
