import { Navigation } from "../../components/Navigation/index.js";

async function AuthCheck(){
    try{
        const response = await fetch('../../user/user.php');
        if(!response.ok){
            throw new Error('Fail fetching auth info');
        }
        const data = await response.json()
        console.log(data);
        if(!data.isLoggedIn){
            window.location.href = `../login/login.php`;
        }
        else{
            const nav = new Navigation('.navigation__container', data.isLoggedIn,data )
            const dashboard = new DashboardManager('.dashboard__container',data);
        }
    }
    catch(error){
        console.error(error);
    }
}

AuthCheck();


class DashboardManager{

    constructor(container = '.dashboard__container',data){
        this.container = document.querySelector(container); 
        this.greeting = document.querySelector('.greeting__text')
        // change this line when JSON is fixed
        // this.data=data;
        this.initialize();

    }

    render(){
        const cards = document.createElement('div');
        cards.classList.add('dashboard__cards');
        const col1 = document.createElement('div');
        const col2 = document.createElement('div');
        col1.classList.add('dashboard__column--1');
        col1.classList.add('dashboard__column');
        col2.classList.add('dashboard__column--2');
        col2.classList.add('dashboard__column');

        col1.innerHTML = this.getCol1Cards();
        col2.innerHTML = this.getCol2Cards();

        cards.appendChild(col1);
        cards.appendChild(col2);

        this.container.appendChild(cards);
        this.greeting.innerHTML = `Welcome, <span class="green">@</span>${this.data.username}`
    }

    getCol1Cards(){
        const cardContinueLearning = new CardContinueLearning(this.data.currentModule);
        const cardModules = new CardModules(this.data.modules);
        return (cardContinueLearning.getCardTemplate() + cardModules.getCardTemplate())
    }

    getCol2Cards(){
        const cardProgress = new CardProgress(this.data.modules);
        const cardHTML = cardProgress.getCardTemplate();
        return cardHTML;
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
                    <a href="../lesson_page/lesson.html" class="card__link">
                        <p class="card__text">${this.data.name}</p>
                        <p class="card__text">Lesson:${this.data.lessonName}</p>
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
        console.log(data);
    }

    getElements(data){
        const elements = data.map((section)=>{
            return (`<li class="card__subtitle"><a href="#" class="card__link">${section.name}</a></li>`);
        })
        return elements;
    }

    getCardTemplate(){
        const elements = this.getElements(this.data);


        return(`
            <div class="dashboard__card dashboard__card--modules">
                <h3 class="no-select">Modules:</h3>
                <div class="card__content">
                    <ul class="card__ul">
                    ${elements.join('')}
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

// const nav = new Navigation('.navigation__container');
// const dashboard = new DashboardManager();