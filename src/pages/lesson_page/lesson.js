import VanillaTerminal from "./termC/term.js";
import { NavigationLesson } from "../../components/NavigationLesson/index.js";

const sectionLesson = document.querySelector(".section--lesson");


class LessonManager {
  lesson = 1;
  currentSection = "basics";
  sectionSize = 0;
  user = 0;
  lessons = [];
  constructor() {
    this.lesson = 1;
    this.currentSection = "basics";
    // may change this later to identify user
    this.setupListeners();
    this.user = 0;
    this.fetchUserInfoInit();
  }

  setupListeners() {
    document.addEventListener("section:update", this.handleLessonSectionChange);
    document.addEventListener("completed:update", this.handleLessonCompleted);
  }
  handleLessonCompleted = async()=>{
    // update our user completed json
    try {
      const response = await fetch("../../testAPI/updateLessonCompleted.php", {
        method: "POST",
        headers: {
          "Content-type": "application/json",
        },
        body: JSON.stringify({
          section: this.currentSection,
          lesson: this.lesson,
          completed:true,
        }),
      });
      if (!response.ok) {
        throw new Error(`response error`, response.status);
      }
      this.fetchUserInfo();
    } catch (error) {
      console.log(`error completing ${error}`);
    }
  }

  async fetchUserInfoInit() {
    try {
      const request = await fetch("../../testAPI/userInfo.json");
      if (!request.ok) {
        throw new Error("Could not load user info");
      }
      const data = await request.json();
      this.lesson = data[this.user]["lesson"];
      this.currentSection = data[this.user]["section"];
      this.fetchLessonsInit();
    } catch (error) {
      console.error(error);
    }
  }

  async fetchUserInfo() {
    try {
      const request = await fetch("../../testAPI/userInfo.json");
      if (!request.ok) {
        throw new Error("Could not load user info");
      }
      const data = await request.json();
      this.lesson = data[this.user]["lesson"];
      this.currentSection = data[this.user]["section"];
      this.broadcastUpdate();
    } catch (error) {
      console.error(error);
    }
  }

  async fetchLessonsInit() {
    try {
      const request = await fetch("../../testAPI/lessons.json");
      if (!request.ok) {
        throw new Error(`could not get lessons ${request.status}`);
      }
      const data = await request.json();
      this.lessons = data;
      this.sectionSize = this.lessons[this.currentSection][0][`section__size`];
      this.broadcastUpdate();
    } catch (error) {
      console.error(error);
    }
  }

  broadcastUpdate() {
    const event = new CustomEvent(`state:update`, {
      detail: {
        user: {
          currentLessonId: this.lesson,
          currentSection: this.currentSection,
        },
        lessons: this.lessons,
      },
    });
    document.dispatchEvent(event);
  }

  // handle lesson and section changes bundled
  handleLessonSectionChange = async (e) => {
    let { section, lessonId, action } = e.detail;
    if (action === "next") {
      // if we are at last lesson or beyond lesson scope
      if (lessonId >= this.sectionSize) {
        lessonId = this.sectionSize;
        console.log(`cant go over section size`);
      }
    }

    if (action === "prev") {
      // if we are at last lesson or beyond lesson scope
      if (lessonId <= 1) {
        lessonId = 1;
        console.log(`cant go under section size`);
      }
    }
    if( action === "change"){
      // make sure for new section change lessonid is within the new bounds
      if(this.lessons[section][0].section__size<=lessonId)lessonId = this.lessons[section][0].section__size;
    }

    // update our user info json
    try {
      const response = await fetch("../../testAPI/updateUserInfo.php", {
        method: "POST",
        headers: {
          "Content-type": "application/json",
        },
        body: JSON.stringify({
          section: section,
          lesson: lessonId,
        }),
      });
      if (!response.ok) {
        throw new Error(`response error`, response.status);
      }
      this.fetchUserInfo();
    } catch (error) {
      console.log(`error saving ${error}`);
    }
  };

  eventNewInfo(data) {
    const eventNewInfo = new CustomEvent("userinfo:update", { detail: {} });
    dispatchEvent(eventNewInfo);
  }
}


class LessonNav{
  isOpen = false;
  constructor(container=".lesson__nav"){
    this.container = document.querySelector(container);
    this.mount();
    this.openCloseButton = document.querySelector('.lesson__nav__button--open');
    this.dropdownContainer = document.querySelector('.lesson__nav__dropdown');
    this.listContainer = document.querySelector('.lesson__nav__links')
    this.initListeners();
  }

  mount(){
    this.container.innerHTML = (`
      <button class="lesson__nav__button--open"><span>loading...</span></button>
      <div class="lesson__nav__dropdown hidden">
          <ul class="lesson__nav__links">
          </ul>
      </div>
    `);
  }

  initListeners(){
    document.addEventListener('state:update',this.render);
    this.openCloseButton.addEventListener('click',this.handleToggle);
    this.dropdownContainer.addEventListener('click',this.handleClick);
  }

  handleClick = (e)=>{
    const idStr = e.target.id;
    const id = parseInt(idStr.slice(idStr.indexOf(':')+1,idStr.length)) 
    const subSection = idStr.slice(0,idStr.indexOf(':'));
    document.dispatchEvent(new CustomEvent('section:update',{
      detail:{
        lessonId:id,
        // this is temporary as i will have to add more info to list elements
        // shoudl be the section belonging to that list element
        section:'basics',
        action:'change',
      }
    }))

    this.dropdownContainer.classList.add('hidden')
    this.isOpen=false;
  }


  handleToggle = (e)=>{
    if(!this.isOpen){
      this.dropdownContainer.classList.remove('hidden');
      this.isOpen = true;
    }
    else if(this.isOpen){
      this.dropdownContainer.classList.add('hidden');
      this.isOpen = false;
    } 
  }

  render =(e)=>{
    const lessons = e.detail.lessons;
    const lesson = e.detail.user.currentLessonId;
    const section = e.detail.user.currentSection;
    const openButtonText = `${lessons[section][lesson].section} - ${lessons[section][lesson].title}`;
    let lastSection = "";
    const listElements = lessons[section].filter(item => item.id>0).map((lessonData)=>{
      let returnString = '';
      if(lastSection != lessonData.section){
        lastSection = lessonData.section;
        returnString = `<li class="lesson__nav__subtitle"><h4>${lessonData.section}</h4></li>`
      }
      if(lesson === lessonData.id){
        return(returnString + `<li class="lesson__nav__lesson "><button class="lesson__nav__button active" id="${`${lessonData.section}:${lessonData.id}`}"" >${lessonData.title}</button></li>`);
      }
      else return(returnString + `<li class="lesson__nav__lesson "><button class="lesson__nav__button" id="${`${lessonData.section}:${lessonData.id}`}"" >${lessonData.title}</button></li>`);
    });
    let listElementsString = listElements.join('');
    this.openCloseButton.innerHTML = `<span>${openButtonText}</span>`;
    this.listContainer.innerHTML = `${listElementsString}`;


  }



}

class lessonDisplay {
  curSection = "basics";
  curLesson = 1;
  sectionSize = 0;
  modules = {};

  constructor(container, lessons = null) {
    this.container = document.querySelector(container);
    this.nextButton = document.querySelector(".lesson__button--next");
    this.prevButton = document.querySelector(".lesson__button--prev");
    this.progBar = document.querySelector(".progress-bar__meter");
    this.misc = document.querySelector(".lesson");
    this.statusCross = document.querySelector(".lesson__status--cross");
    this.statusCheck = document.querySelector(".lesson__status--check");
    this.lessonNavContainer = document.querySelector(".lesson__nav");


    document.addEventListener("state:update", this.handleChange);
    this.initListeners();
  }

  handleChange = (e) => {
    const data = e.detail;
    this.curSection = data[`user`][`currentSection`];
    this.curLesson = data["user"]["currentLessonId"];
    this.modules = data["lessons"];
    this.sectionSize = this.modules[this.curSection][0]["section__size"];
    this.update();
  };



  initListeners() {
    this.nextButton.addEventListener("click", this.nextLesson);
    this.prevButton.addEventListener("click", this.prevLesson);
    this.misc.addEventListener("click", this.toggleLessonComplete);
    document.addEventListener("command-success", this.handleCorrectEvent);
  }

  update() {
    this.render();
    this.updateMeter();
    this.updateStatus();
  }

  render() {
    this.container.replaceChildren();
    this.container.innerHTML = (`<h1 class="lesson__title">${
      this.modules[this.curSection][this.curLesson]["title"]
    }</h1>
        <div class="lesson__content">${
          this.modules[this.curSection][this.curLesson][`content`]
        }</div>
    `);
    // conditional render multichoice questions
    if(this.modules[this.curSection][this.curLesson].content_type === 'multichoice'){
      const questionsContainer = document.querySelector('.question__container');
      const questionEntries = Object.entries(this.modules[this.curSection][this.curLesson].questions);
      const questions = [];
      for ( const [key, value] of questionEntries){
        questions.push(`
          <button type="button" id="${key}" class="question__button"><span class="question__key">${key})</span><span class="question__value">${value}</span></button>
        `);
      }
      questionsContainer.innerHTML = questions.join('');
      questionsContainer.addEventListener('click',this.handleQuestion);
    }
  }

  handleQuestion = (e) =>{
    let button = e.target;
    
    if(e.target.parentNode.tagName === "BUTTON" ) button = e.target.parentNode;
    button.classList.remove('question--wrong');
    button.classList.remove('animate-shake')
    if(button.tagName === 'BUTTON'){
      console.log(button.id);
      if(this.modules[this.curSection][this.curLesson].answer === button.id){
        button.classList.add('question--correct');
        button.parentNode.classList.add('question__container--correct');
        this.showSuccessMessage();
        document.dispatchEvent(
          new CustomEvent('completed:update'),{
            detail:{
              section: this.curSection,
              lessonId: this.curLesson,
              copmleted: true,
            }
          }
        )
      }
      else{
        button.classList.add('question--wrong');
        button.classList.add('animate-shake');
        console.log('wrong');
        setTimeout(()=>{
          button.classList.remove('question--wrong')
          button.classList.remove('animate-shake');
          console.log('wrong done')
        },1000*2);
      }
    }
  }

  nextLesson = () => {
    // if (this.curLesson >= this.sectionSize) return;
    ++this.curLesson;
    document.dispatchEvent(
      new CustomEvent("section:update", {
        detail: {
          action: "next",
          section: this.curSection,
          lessonId: this.curLesson,
        },
      })
    );
  };

  prevLesson = () => {
    if (this.curLesson <= 1) return;
    --this.curLesson;
    document.dispatchEvent(
      new CustomEvent("section:update", {
        detail: {
          action: "prev",
          section: this.curSection,
          lessonId: this.curLesson,
        },
      })
    );
  };

  changeSection() {
    this.sectionSize = this.modules[this.curSection][0]["section__size"];
    this.sectionSizeInteractive
  }

  updateMeter() {
    let interactiveCount = this.modules[this.curSection].reduce((sum,lesson)=>{
      let value = 0;
      if(lesson.content_type === 'interactive' || lesson.content_type === 'multichoice') value = 1;
      return sum + value;
    }, 0);
    let completedCount = this.modules[this.curSection].reduce((sum, lesson) => {
      if(lesson.content_type !='interactive' && lesson.content_type !='multichoice') return sum;
      return sum + (lesson.completed ? 1 : 0);
    }, 0);
    let progValue = (completedCount / interactiveCount) * 100;
    this.progBar.value = progValue;
    if (progValue === 100) {
      document.dispatchEvent(new CustomEvent('section:isComplete',{detail:{
        userInfo:{
          section: this.curSection,
          lesson: this.curLesson,
        }
      }}))
    }
  }

  updateStatus() {
    if (this.modules[this.curSection][this.curLesson][`completed`] === true) {
      this.statusCheck.classList.remove(`hidden`);
      this.statusCross.classList.add(`hidden`);
    } else {
      this.statusCheck.classList.add(`hidden`);
      this.statusCross.classList.remove(`hidden`);
    }
  }

  toggleLessonComplete = () => {
    this.modules[this.curSection][this.curLesson][`completed`] =
      !this.modules[this.curSection][this.curLesson][`completed`];
    this.updateMeter();
    this.updateStatus();
  };

  handleCorrectEvent = (e) => {
    this.showSuccessMessage();
  };

  showSuccessMessage() {
    const successMessage = `
            <div class="overlay--success">
                <img src="../assets/SVGs/Tux.svg.png" alt="tux" class="logo">
                <h3 class="overlay__message">Well done!</h3> 
            </div>
            `;
    const overlayContainer = document.createElement("div");
    overlayContainer.classList.add("overlay__container");
    overlayContainer.classList.add("overlay-popup");
    overlayContainer.innerHTML = successMessage;
    sectionLesson.prepend(overlayContainer);
    setTimeout(() => {
      overlayContainer.classList.remove("overlay-popout");
      overlayContainer.classList.add("overlay-fadeout");
    }, 1000 * 2);
    setTimeout(() => {
      overlayContainer.remove();
    }, 1000 * 3);
  }
}
const lessonManager = new LessonManager();

const lessonDisplayController = new lessonDisplay(".lesson");
const terminal = new VanillaTerminal({
  apiEndpoint: "../../../api_commands.php",
});

const lessonNav = new LessonNav();

const sidebarLesson = new NavigationLesson(
  ".sidebar__container",
  ".sidebar__button--open"
);

terminal.mount("#terminal__container");
