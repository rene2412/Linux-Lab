import VanillaTerminal from "./termC/term.js";
import { NavigationLesson } from "../../components/NavigationLesson/index.js";




// this is no longer in use and is reference for structure of the json
const section = {
    basics:[
        {section__size:1, section__completed:false,},
        {
            id: 1,
            section: 'basics',
            title: 'cat',
            completed: false,
            content: `<p>what should we do today or i dont even know im just tping</p>
                    <p>this is suppposed to be some blahballhlsldajflalf salfjsaflasf</p>
                    <p>blahballhlsldajflalf salfjsafljflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf asfjflalf jflalf jflalf jflalf </p>
                    <code>ls directory</code>
                    <p>blahballhlsldajflalf sjflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf jflalf asfjflalf jflalf jflalf jflalf </p>
                    `,
        },
    ],
}



class lessonDisplay{
    curSection = 'basics';
    // LESSONS START FROM 1
    curLesson = 1;
    sectionSize = 0;
    modules = {};
    
    constructor(container,lessons = null){
        this.container = document.querySelector(container);
        this.nextButton = document.querySelector('.lesson__button--next');
        this.prevButton= document.querySelector('.lesson__button--prev');
        this.progBar = document.querySelector('.progress-bar__meter');
        this.misc = document.querySelector('.lesson');
        this.statusCross = document.querySelector('.lesson__status--cross');
        this.statusCheck = document.querySelector('.lesson__status--check');

        // bind the async function to use our locals;
        this.postInfo = this.postInfo.bind(this);

        this.getInfo();
        this.initListeners();
        this.getLessons();

        // this.initListeners();
        // this.changeSection();
        // this.updateMeter();
    }
    initialize(){
        this.changeSection();
        this.updateMeter();
        this.updateStatus();
        this.render();

    }


    initListeners(){
        this.nextButton.addEventListener('click',this.nextLesson);
        this.prevButton.addEventListener('click',this.prevLesson);
        this.misc.addEventListener('click',this.toggleLessonComplete);
        // custom command success event
        document.addEventListener('command-success',this.handleCorrectEvent);
    }
    update(){
        this.render();
        this.updateMeter();
        this.updateStatus();
    }
    render(){
        this.container.replaceChildren();
        this.container.innerHTML = `<h1 class="lesson__title">${this.modules[this.curSection][this.curLesson]['title']}</h1>
        <div class="lesson__content">${this.modules[this.curSection][this.curLesson][`content`]}</div>`;
    }
    nextLesson= ()=>{
        if(this.curLesson >= this.sectionSize) return;
        ++this.curLesson;
        // update user cur lesson
        this.postInfo();
        this.update();
    }
    prevLesson= ()=>{
        if(this.curLesson <= 1) return;
        --this.curLesson;
        // update user cur lesson
        this.postInfo();
        this.update();
    }
    changeSection(){
    //    this.sectionSize = section[this.curSection][0]['section__size'];
        // the 0 part of the section is the meta data [0]
       this.sectionSize = this.modules[this.curSection][0]['section__size'];
       console.log(this.sectionSize);
    }
    updateMeter(){
       let completedCount = this.modules[this.curSection].reduce((sum,lesson)=>{
        return (sum + (lesson.completed ? 1 : 0));
       },0)
       let progValue = (completedCount / this.sectionSize)*100;
       this.progBar.value=progValue;
       if(progValue===100){
        // change section stustua
       }
    }
    updateStatus(){
        if(this.modules[this.curSection][this.curLesson][`completed`] === true){
            this.statusCheck.classList.remove(`hidden`);
            this.statusCross.classList.add(`hidden`);
        }
        else{
            this.statusCheck.classList.add(`hidden`);
            this.statusCross.classList.remove(`hidden`);
        }
    }
    toggleLessonComplete=()=>{
        this.modules[this.curSection][this.curLesson][`completed`] = !this.modules[this.curSection][this.curLesson][`completed`];
        this.updateMeter();
        this.updateStatus();
    }

    // this will need to be done in DB or something to keep track of user info
    async getInfo(){
        try{
            const request = await fetch('../../testAPI/userInfo.json');
            if(!request.ok){
                throw new Error('Could not load user info');
            }
            const data = await request.json();
            // at 0 simply refers to first user in our case 
            this.curLesson = data[0].lesson;
            this.curSection= data[0].section;
            // this.getLessons();
        }        
        catch(error){
            console.log(`error ${error}`);
        }
    }
    
    //fetch the lesson after user info
    async getLessons(){
        try{
            const request = await fetch('../../testAPI/lessons.json');
            if(!request.ok){
                throw new Error('Could not load lesson');
            }
            const data = await request.json();
            this.modules = data;
            console.log(this.modules)
            // call init because we will update everything
            this.initialize();
        }        
        catch(error){
            console.log(`error ${error}`);
        }
    }
    // we should send back this lesson and this
    async postInfo(){
        try{
            const response = await fetch('../../testAPI/updateUserInfo.php',{
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',
                },
                // we want to update the user info current lesson and section 
                // for demonstration basics is hardcoded
                // we are seinding this json string
                body: JSON.stringify({
                    section: this.curSection,
                    lesson: this.curLesson,
                })
            })
            if(!response.ok){
                throw new Error(`response error`,response.status);
            }
            const data = await response.json();
        }
        catch(error){
            console.log(`error saving ${error}`)
        }
    }
    handleCorrectEvent= (e)=>{
        console.log(e);
        this.showSuccessMessage();
        // get lessons will update everything
        // will also update 
        this.getLessons();
    }

    showSuccessMessage() {
        // Create a simple popup or notification
        console.log(`showing success message`);
    }
};

const lessonDisplayController = new lessonDisplay('.lesson');
const terminal = new VanillaTerminal({
    apiEndpoint:'../../../api_commands.php',
});
const sidebarLesson = new NavigationLesson('.sidebar__container','.sidebar__button--open');

terminal.mount('#terminal__container');

const tux = document.querySelector('#tuxlogo');
tux.addEventListener('click',lessonDisplayController.postInfo);
