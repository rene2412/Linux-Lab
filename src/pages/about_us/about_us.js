import { Navigation } from "../../components/Navigation/index.js";
import { Footer } from "../../components/Footer/index.js";

const navigation = new Navigation('.navigation__container');
const footer = new Footer('.footer__container');
const nav = document.querySelector('.navbar');

const articleTitles= document.querySelectorAll('.article__title');
const articleLinks = document.querySelectorAll('.article__link');

function updateArticleSideObs(e){
    articleLinks.forEach((element) => {
        if(element.innerText === e){
            element.classList.add('active');
        }
        else{
            element.classList.remove('active')
        }
        
    });
}

const observer = new IntersectionObserver((items)=>{
    items.forEach((item)=>{
        const itemName = item.target.firstElementChild.id;
        if(item.isIntersecting){
            console.log(item.target.firstElementChild.innerText);
            updateArticleSideObs(item.target.firstElementChild.innerText);
        }
        else{
            
            // console.log(item.target.innerText)
        }
    })

}
,{
    root: null,
    rootMargin: "-40% 0px -70% 0px",
    threshold: 0,
})

function startView(){
    articleTitles.forEach((element)=>{
        observer.observe(element.parentElement);
    })
}

startView();