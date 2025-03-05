export default class PageTitle{
    constructor(container = '.page-title__container',title){
        this.container = document.querySelector(container);
        this.title = title;
    }

    getTemplate(){
        return(
        `<div>
            <h1 class="page-title animation--popup">${this.title}</h1>
        </div>
        `
        );
    }

    mount(){
        this.container.innerHTML = this.getTemplate();
    }
}