const sidebarBtn = document.querySelector('.top__sidebar');
const sidebarBtnClose = document.querySelector('.sidebar__button')
const sidebar = document.querySelector('.sidebar');

sidebarBtn.addEventListener('click',()=>{
    sidebar.classList.toggle('hidden');
})
sidebarBtnClose.addEventListener('click',()=>{
    sidebar.classList.toggle('hidden');
})
const section = {
    basics:[
        {section__size:5, section__completed:false,},
        {
            id: 1,
            section: 'basics',
            title: 'cat',
            completed: false,
            content: `<p>what should we do today or i dont even know im just tping</p>
                    <p>this is suppposed to be some blahballhlsldajflalf salfjsaflasf</p>
                    <code>ls directory</code>`,
        },
        {
            id: 2,
            section: 'basics',
            title: 'ls',
            completed: false,
            content: `<p>should we do today or i dont even know im just tping</p>
                    <p>suppposed to be some blahballhlsldajflalf salfjsaflasf</p>
                    <code>ls directory</code>`,
        },
        {
            id: 3,
            section: 'basics',
            title: 'pwd',
            completed: false,
            content: `<p>what should we do today or i dont even know im just tping</p>
                    <p>this is suppposed to be some blahballhlsldajflalf salfjsaflasf</p>
                    <code>ls directory</code>`,
        },
        {
            id: 4,
            section: 'basics',
            title: 'whoami',
            completed: false,
            content: `<p>what should we do today or i dont even know im just tping</p>
                    <p>this is suppposed to be some blahballhlsldajflalf salfjsaflasf</p>
                    <code>ls directory</code>`,
        },
        {
            id: 5,
            section: 'basics',
            title: 'cd',
            completed: false,
            content: `<p>what should we do today or i dont even know im just tping</p>
                    <p>this is suppposed to be some blahballhlsldajflalf salfjsaflasf</p>
                    <code>ls directory</code>`,
        },
    ],
}


class lesson{
    curLesson = 1;
    curSection = 'basics';
    sectionSize = 0;
    
    constructor(container,lessons = null){
        this.container = document.querySelector(container);
        this.nextButton = document.querySelector('.lesson__button--next');
        this.prevButton= document.querySelector('.lesson__button--prev');
        this.nextButton.addEventListener('click',this.nextLesson);
        this.prevButton.addEventListener('click',this.prevLesson);
        this.progBar = document.querySelector('.progress-bar__meter');
        this.misc = document.querySelector('.lesson');
        this.misc.addEventListener('click',this.toggleLessonComplete);
        this.statusCross = document.querySelector('.lesson__status--cross');
        this.statusCheck = document.querySelector('.lesson__status--check');

        this.changeSection();
        this.updateMeter();
    }
    render(){
        this.container.replaceChildren();
        this.container.innerHTML = `<h1 class="lesson__title">${section[this.curSection][this.curLesson]['title']}</h1>
        <div class="lesson__content">${section[this.curSection][this.curLesson][`content`]}</div>`;
    }
    nextLesson= ()=>{
        if(this.curLesson >= this.sectionSize) return;
        ++this.curLesson;
        this.render();
        this.updateMeter();
        this.updateStatus();
    }
    prevLesson= ()=>{
        if(this.curLesson <= 1) return;
        --this.curLesson;
        this.render();
        this.updateMeter();
        this.updateStatus();
    }
    changeSection(){
       this.sectionSize = section[this.curSection][0]['section__size'];
    }
    updateMeter(){
       let completedCount = section[this.curSection].reduce((sum,lesson)=>{
        return (sum + (lesson.completed ? 1 : 0));
       },0)
       let progValue = (completedCount / this.sectionSize)*100;
       this.progBar.value=progValue;
    }
    updateStatus(){
        if(section[this.curSection][this.curLesson][`completed`] === true){
            this.statusCheck.classList.remove(`hidden`);
            this.statusCross.classList.add(`hidden`);
        }
        else{
            this.statusCheck.classList.add(`hidden`);
            this.statusCross.classList.remove(`hidden`);
        }
    }
    toggleLessonComplete=()=>{
        section[this.curSection][this.curLesson][`completed`] = !section[this.curSection][this.curLesson][`completed`];
        this.updateMeter();
        this.updateStatus();
    }
};

const lessonClass = new lesson('.lesson');
lessonClass.render();