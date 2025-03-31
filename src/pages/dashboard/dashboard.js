import { Navigation } from "../../components/Navigation/index.js";

const nav = new Navigation('.navigation__container');

class DashboardManager{

    constructor(container = '.dashboard__container',isLoggedIn){
        this.container = document.querySelector(container); 
        this.initialize();
    }

    render(){
        const cards = document.createElement('div');
        cards.classList.add('dashboard__cards');
        const col1 = document.createElement('div');
        const col2 = document.createElement('div');
        col1.classList.add(['dashboard__column--1', 'dashboard__column']);
        col2.classList.add(['dashboard__column--2', 'dashboard__column']);

        col1.innerHTML = this.getCol1Cards();
        console.log(col1);
        // col2.innerHTML = this.getCol2Cards();
        cards.appendChild(col1);
        console.log(cards);
        this.container.appendChild(cards);

        
    }

    getCol1Cards(){
        const card = new CardProgress(this.data.modules);
        const cardHTML = card.getCardTemplate();
        console.log(cardHTML);
        return cardHTML;
    }

    getCol2Cards(){

    }

    async initialize(){
        this.data = await this.fetchData();
        this.render();
    }

    async fetchData(){
        return(
            {
                username:'herb',
                isLoggedIn:true,
                currentModule:{
                    name:'The Basics',
                    lessonId:3,
                    lessonName: 'cat',
                },
                modules:[
                    {
                        name:'The Basics',
                        completed: 13,
                        total:21,
                    },
                    {
                        name:'Networking',
                        completed: 18,
                        total:21,
                    },
                    {
                        name:'IDK',
                        completed: 1,
                        total:17,
                    },
                ]
            }
        );

    }
}

class CardContinueLearning{
    constructor(data){
        this.data = data;
    }

    getCardTemplate(){
        return(`
            <div class="dashboard__card dashboard__card--continue">
                <h3 class="card__title">Continue Learning:</h3>
                <div class="card__content">
                    <a href="../lesson_page/lesson.js" class="card__link">
                        <p class="card__text">${this.data.currentModule.name}</p>
                        <p class="card__text">Lesson:${this.data.currentModule.lessonName}</p>
                    </a>
                    <button class="styled-button card__button"><a href="../lesson_page/lesson.js">continue</a></button>
                </div>
            </div>
        `);
    }
}


class CardModules{
    constructor(data){
        this.data = data;
    }

    getCardTemplate(){
        return(`
            <div class="dashboard__card dashboard__card--modules">
                <h3 class="no-select">Modules:</h3>
                <div class="card__content">
                    <ul class="card__ul">
                        <li class="card__subtitle"><a href="#" class="card__link">${this.data.modules[0].name}</a></li>
                    </ul>
                    <p class="card__message no-select animate-pulse">Coming Soon...</p>
                </div>
            </div>
        `);
    }
}

class CardProgress{
    constructor(data){
        this.data = data;
        this.getElements();
    }

    getElements(){
        let barSize = 20;
        const elements = this.data.map((section)=>{
            return(`
                <p class="card__text">${section.name}</p>
                ${this.getProgressBar(section.completed,section.total)}
                <p class="card__text">${section.completed}/${section.total}</p>
            `);
        })
        console.log(elements);
        return elements;
    }

    getProgressBar(completed,size){
        let barSize = 20;
        const greenBar = Math.floor((completed/size)*20);
        const empty = barSize-greenBar;
        const blockChar = '█'
        const emptyChar = '░'
        return(`<span class="card__progress-bar">[<span class="green">${blockChar.repeat(greenBar)}</span>${emptyChar.repeat(empty)}]</span>`);
    }

    getCardTemplate(){
        const elements = this.getElements();
        return(`
            <div class="dashboard__card dashboard__card--progress">
                <h3>Your Progress:</h3>
                <div class="card__content">
                    <div class="card__content--progress">
                    ${elements.join('')}
                    </div>
                </div>
            </div>
        `);
    }
}


const DATA = [
    {
    name:'The Basics',
    completed: 13,
    total:21,
    },
    {
    name:'Newtorking',
    completed: 18,
    total:21,
    },
    {
    name:'IDK',
    completed: 1,
    total:17,
    },
]

const card = new CardProgress(DATA);

const dashboard = new DashboardManager();