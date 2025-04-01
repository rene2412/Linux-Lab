import { Navigation } from "../../components/Navigation/index.js";
import { Footer } from "../../components/Footer/index.js";

const navigation = new Navigation('.navigation__container');
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