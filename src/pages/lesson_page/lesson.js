import VanillaTerminal from "./termC/term.js";
import { NavigationLesson } from "../../components/NavigationLesson/index.js";
import getUserCookie from "../../utils/getUserCookie.js";
import Navigation from "../../components/Navigation/Navigation.js";

const sectionLesson = document.querySelector(".section--lesson");

class LessonManager {
  lesson = 1;
  currentSection = "The Basics";
  sectionSize = 0;
  user = 0;
  lessons = [];
  completedLessons = {};
  constructor() {
    this.lesson = 1;
    this.currentSection = "The Basics";
    // may change this later to identify user
    this.setupListeners();
    this.user = 0;
    this.fetchUserInfoInit();
  }

  setupListeners() {
    document.addEventListener("section:update", this.handleLessonSectionChange);
    document.addEventListener("completed:update", this.handleLessonCompleted);
    document.addEventListener("command-success", this.handleLessonCompleted);
  }
  handleLessonCompleted = async (e) => {
    console.log('handle lesson completed')
    console.log(e.detail);
    try {
      const response = await fetch("../../../api_commands.php", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `command=${encodeURIComponent(e.detail.answer)}&lessonId=${encodeURIComponent(e.detail.lessonId)}`,
      })
      if (!response.ok) {
        throw new Error(`response error`, response.status);
      }
      const data = await response.json();
      console.log('data')
      console.log(data)
      this.fetchUserInfo();
      if(data.commandSuccess) {
        const successEvent = new CustomEvent('command-success', {
          detail:{
            command: commandToSend,
            output: data.output
          }
        });
        document.dispatchEvent(successEvent);
      }
    } catch (error) {
      console.log(`error completing ${error}`);
    }
  };

  async fetchUserInfoInit() {
    try {
      const request = await fetch("../../user/user.php");
      if (!request.ok) {
        throw new Error("Could not load user info");
      }
      const data = await request.json();
      this.lesson = data.currentModule.lessonId;
      if(!this.lesson)this.lesson=1;
      this.currentSection = data.currentModule.name;
      this.completedLessons= data.currentModule.lessonStatus;
      this.fetchLessonsInit();
    } catch (error) {
      console.error(error);
    }
  }

  async fetchUserInfo() {
    try {
      const request = await fetch("../../user/user.php");
      if (!request.ok) {
        throw new Error("Could not load user info");
      }
      const data = await request.json();
      this.lesson = data.currentModule.lessonId;
      this.currentSection = data.currentModule.name;
      this.completedLessons= data.currentModule.lessonStatus;
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
        lessonsCompleted: this.completedLessons,
        sectionSize: this.sectionSize
      },
    });
    document.dispatchEvent(event);
  }

  // handle lesson and section changes bundled
  handleLessonSectionChange = async (e) => {
    let { lessonId, action } = e.detail;
    if (action === "next") {
      this.lesson++
      // if we are at last lesson or beyond lesson scope
      if (lessonId >= this.sectionSize) {
        this.lesson = this.sectionSize;
        console.log(`cant go over section size`);
      }
    }

    if (action === "prev") {
      // if we are at last lesson or beyond lesson scope
      this.lesson--
      if (lessonId <= 1) {
        this.lesson = 1;
        console.log(`cant go under section size`);
      }
    }
    if (action === "change") {
      if(this.lesson > 0 && this.lesson <= this.sectionSize)
      this.lesson = lessonId;
    }

    terminal.setLesson(this.lesson);
    this.broadcastUpdate()
  };

  eventNewInfo(data) {
    const eventNewInfo = new CustomEvent("userinfo:update", { detail: {} });
    dispatchEvent(eventNewInfo);
  }
}

class LessonNav {
  isOpen = false;
  constructor(container = ".lesson__nav") {
    this.container = document.querySelector(container);
    this.mount();
    this.openCloseButton = document.querySelector(".lesson__nav__button--open");
    this.dropdownContainer = document.querySelector(".lesson__nav__dropdown");
    this.listContainer = document.querySelector(".lesson__nav__links");
    this.initListeners();
  }

  mount() {
    this.container.innerHTML = `
      <button class="lesson__nav__button--open"><span>loading...</span></button>
      <div class="lesson__nav__dropdown hidden">
          <ul class="lesson__nav__links">
          </ul>
      </div>
    `;
  }

  initListeners() {
    document.addEventListener("state:update", this.render);
    this.openCloseButton.addEventListener("click", this.handleToggle);
    this.dropdownContainer.addEventListener("click", this.handleClick);
  }

  handleClick = (e) => {
    const idStr = e.target.id;
    const id = parseInt(idStr.slice(idStr.indexOf(":") + 1, idStr.length));
    const subSection = idStr.slice(0, idStr.indexOf(":"));
    // clicking headers should not break code
    if(id > 0){
    document.dispatchEvent(
      new CustomEvent("section:update", {
        detail: {
          lessonId: id,
          // this is temporary as i will have to add more info to list elements
          // shoudl be the section belonging to that list element
          action: "change",
        },
      })
    );
      this.dropdownContainer.classList.add("hidden");
      this.isOpen = false;
    }

  };

  handleToggle = (e) => {
    // stop document from initial click so it doesnt close instantly
    e.stopPropagation()
    if (!this.isOpen) {
      this.dropdownContainer.classList.remove("hidden");
      this.isOpen = true;
      // handle not on container click
      document.addEventListener('click',(e)=>{
        const within = this.dropdownContainer.contains(e.target);
        if(!within && this.isOpen){
          this.dropdownContainer.classList.add("hidden");
          this.isOpen = false;
        }
      })
    } else if (this.isOpen) {
      this.dropdownContainer.classList.add("hidden");
      this.isOpen = false;
    }
  };

  render = (e) => {
    console.log('render nav');
    const lessons = e.detail.lessons;
    const lesson = e.detail.user.currentLessonId;
    const section = e.detail.user.currentSection;
    const lessonStatus = e.detail.lessonsCompleted;
    const status = "";
    // get subtitle and lesson name
    const openButtonText = `${lessons[section][lesson].section} - ${lessons[section][lesson].title}`;
    let lastSection = "";
    const listElements = lessons[section]
      .filter((item) => item.id > 0)
      .map((lessonData) => {
        let statusImgSrc= "#";
        let statusImgClass = " no-status ";
        if(lessonData.content_type != "article"){
          if(lessonStatus[lessonData.title] === true){
            statusImgSrc="../assets/SVGs/check.svg"
            statusImgClass = " has-status ";
          }
          else{
            statusImgSrc="../assets/SVGs/cross.svg"
            statusImgClass = " has-status ";
          }
        }
        let returnString = "";
        // Subtitle
        if (lastSection != lessonData.section) {
          lastSection = lessonData.section;
          returnString = `<li class="lesson__nav__subtitle"><span>${lessonData.section}</span></li>`;
        }
        // Lessons
        if (lesson === lessonData.id) {
          // lesson active
          return (
            returnString +
            `<li class="lesson__nav__lesson "><button class="lesson__nav__button active" id="${`${lessonData.section}:${lessonData.id}`}"" >${
              lessonData.title
            }</button><div class="lesson__nav__lesson__status"><img class="${statusImgClass}" src="${statusImgSrc}"></div> </li>`
          );
        } else
          // lesson not active 
          return (
            returnString +
            `<li class="lesson__nav__lesson "><button class="lesson__nav__button" id="${`${lessonData.section}:${lessonData.id}`}"" >${
              lessonData.title
            }</button><div class="lesson__nav__lesson__status"><img class="${statusImgClass}"  src="${statusImgSrc}"></div></li>`
          );
      });
    let listElementsString = listElements.join("");
    this.openCloseButton.innerHTML = `<span>${openButtonText}</span>`;
    this.listContainer.innerHTML = `${listElementsString}`;
  };
}

class lessonDisplay {
  curSection = "The Basics";
  curLesson = 1;
  lessonsCompleted = {};
  sectionSize = 0;
  modules = {};

  constructor(container, lessons = null) {
    this.container = document.querySelector(container);
    this.nextButton = document.querySelector(".lesson__button--next");
    this.prevButton = document.querySelector(".lesson__button--prev");
    this.progBar = document.querySelector(".progress-bar__bar");
    this.misc = document.querySelector(".lesson");
    this.statusCross = document.querySelector(".lesson__status--cross");
    this.statusCheck = document.querySelector(".lesson__status--check");
    this.lessonNavContainer = document.querySelector(".lesson__nav");

    document.addEventListener("state:update", this.handleChange);
    this.initListeners();
  }

  handleChange = (e) => {
    const data = e.detail;
    // console.log('handlechange')
    // console.log(data)
    this.curSection = data[`user`][`currentSection`];
    this.curLesson = data["user"]["currentLessonId"];
    this.modules = data["lessons"];
    this.sectionSize = data.sectionSize;
    this.completedLessons = data.lessonsCompleted;
    this.update();
  };

  initListeners() {
    this.nextButton.addEventListener("click", this.nextLesson);
    this.prevButton.addEventListener("click", this.prevLesson);
    document.addEventListener("command-success", this.handleCorrectEvent);
  }

  update() {
    this.updateMeter();
    this.updateStatus();
    this.render();
  }

  render() {
    this.container.replaceChildren();
    if(this.curLesson=== 1) {this.prevButton.style.pointerEvents= `none`; this.prevButton.style.opacity='0'}
    else{this.prevButton.style.pointerEvents= `auto`; this.prevButton.style.opacity='1'}
    if(this.curLesson === this.modules[this.curSection][0].section__size) {this.nextButton.style.pointerEvents= `none`; this.nextButton.style.opacity='0'}
    else{this.nextButton.style.pointerEvents= `auto`; this.nextButton.style.opacity='1'}

    this.container.innerHTML = `<h1 class="lesson__title">${
      this.modules[this.curSection][this.curLesson]["title"]
    }</h1>
        <div class="lesson__content">${
          this.modules[this.curSection][this.curLesson][`content`]
        }</div>
    `;

    // conditional render multichoice questions
    let completed = false;
    if (
      this.modules[this.curSection][this.curLesson].content_type ===
      "multichoice"
    ) {
      const questionsContainer = document.querySelector(".question__container");
      const questionEntries = Object.entries(
        this.modules[this.curSection][this.curLesson].questions
      );
      const questions = [];
      // render correct questions
      for (const [key, value] of questionEntries) {
        if (
          this.modules[this.curSection][this.curLesson].answer === key &&
          this.completedLessons[this.modules[this.curSection][this.curLesson].title]
        ) {
          completed = true;
          questions.push(`
            <button type="button" id="${key}" class="question__button question--correct"><span class="question__key">${key})</span><span class="question__value">${value}</span></button>
          `);
        } else {
          questions.push(`
          <button type="button" id="${key}" class="question__button"><span class="question__key">${key})</span><span class="question__value">${value}</span></button>
        `);
        }
      }
      questionsContainer.innerHTML = questions.join("");
      if (completed)
        questionsContainer.classList.add("question__container--correct");
      if (!completed)
        questionsContainer.addEventListener("click", this.handleQuestion);
    }
  }

  // HANDLE THE QUESTION
  handleQuestion = (e) => {
    let button = e.target;
    if (e.target.parentNode.tagName === "BUTTON") button = e.target.parentNode;
    if (button.tagName === "BUTTON") {
      let answer = this.modules[this.curSection][this.curLesson].answer;
      if (answer === button.id) {
        button.classList.add("question--correct");
        button.parentNode.classList.add("question__container--correct");
        document.dispatchEvent(
          new CustomEvent("completed:update", {
            detail: {
              section: this.curSection,
              lessonId: this.curLesson,
              completed: true,
              answer:answer,
            },
          })
        );
        this.showSuccessMessage();
      } else {
        button.classList.add("question--wrong");
        button.classList.add("animate-shake");
        setTimeout(() => {
          button.classList.remove("question--wrong");
          button.classList.remove("animate-shake");
        }, 1000 * 2);
      }
    }
  };

  nextLesson = () => {
    if (this.curLesson >= this.sectionSize) return;
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
    // terminal.setLesson(this.curLesson);
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

  updateMeter() {
    let value = 0;
    for(let key in this.completedLessons){
      if(this.completedLessons[key])value++;
    }
    let progress = value/this.modules[this.curSection][0].interactive__size;
    this.progBar.style.transform = `scalex(${progress})`

  }

  updateStatus() {
    let title = this.modules[this.curSection][this.curLesson].title;
    if(this.modules[this.curSection][this.curLesson].content_type==="article"){
      this.statusCheck.classList.add(`hidden`);
      this.statusCross.classList.add(`hidden`);
    }
    else if (this.completedLessons[title]) {
      this.statusCheck.classList.remove(`hidden`);
      this.statusCross.classList.add(`hidden`);
    } else {
      this.statusCheck.classList.add(`hidden`);
      this.statusCross.classList.remove(`hidden`);
    }
  }

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

let terminal;

// conditional render cookie
const userObj = getUserCookie();
if(userObj){
  terminal = new VanillaTerminal({
    apiEndpoint: "../../../api_commands.php",
    username:userObj.username,
  });
  terminal.mount("#terminal__container");

  const nav = new Navigation(".sidebar__container",userObj.isLoggedIn,userObj,false,)
}
else{

  terminal = new VanillaTerminal({
    apiEndpoint: "../../../api_commands.php",
  });
  terminal.mount("#terminal__container");

const sidebarLesson = new NavigationLesson(
  ".sidebar__container",
  ".sidebar__button--open"
);
}

const lessonNav = new LessonNav();



async function test(){
  try{
    const res = await fetch("../../user/user.php");
    const data = await res.json();
    console.log('test')
    console.log(data);
  }
  catch(e){
    console.error(e);
  }
}
test();