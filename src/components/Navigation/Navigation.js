export default class Navigation{
    constructor(container){
        this.container = document.querySelector(container);

        this.render();
        this.setElements();
        this.setListeners();
    }

    setElements(){
        this.sidebarBtnOpen = document.querySelector('.sidebar__button--open');
        this.sidebarBtnClose = document.querySelector('.sidebar__button')
        this.sidebar = document.querySelector('.sidebar');

    }
    setListeners(){
        this.sidebarBtnOpen.addEventListener('click',this.openSidebar);
        this.sidebarBtnClose.addEventListener('click',this.closeSidebar);
    }

    closeSidebar = ()=>{
        this.sidebar.classList.remove('sidebar--open');
        this.sidebar.classList.add('sidebar--close');
    }

    openSidebar = ()=>{
        this.sidebar.classList.remove('sidebar--close');
        this.sidebar.classList.add('sidebar--open');
    }

    createSidebarTemplate(){
        const sidebar = document.createElement('div');
        sidebar.classList.add('sidebar');
        sidebar.classList.add('sidebar--close');
        sidebar.innerHTML = `
            <div class="sidebar__top">
                <div class="sidebar__header">
                    <h2 class="sidebar__logo">Linux-Lab</h2>
                    <button type="button" class="button sidebar__button sidebar__button--close">X</button>
                </div>
                <nav class="sidebar__links">
                    <ul>
                        <li class="navbar__link"><a href="../../pages/landing_page/landing_page.html">Home</a></li>
                        <li class="navbar__link"><a href="#">Learn More</a></li>
                        <li class="navbar__link"><a href="../../pages/lesson_page/lesson.html">Try It</a></li>
                        <li class="navbar__link"><a href="../../pages/about_us/about_us.html">About Us</a></li>
                        <li class="navbar__link"><a href="../../pages/contact_page/contact.html">Contact Us</a></li>
                    </ul>
                </nav>
            </div>
            <div class="sidebar__bottom">
                <button type="button">
                    <img src="../assets/SVGs/cog-outline.svg " class="svg" alt="cog">
                </button>
            </div>
        `;
        return sidebar;
    }

    createNavbarTemplate(){
        const nav = document.createElement('nav');
        nav.classList.add('navbar');
        nav.innerHTML = `
            <button type="button" class="sidebar__button--open"><img class="svg" src="../assets/SVGs/sidebar-left-svgrepo-com.svg" alt="idk"></button>
            <div class="navbar__left">
                    <img src="../assets/SVGs/Tux.svg.png" class="logo" alt="Linux-Lab logo">
            </div> 
            <div class="navbar__right">
                <ul class="navbar__links">
                    <li class="navbar__link"><a href="../../pages/landing_page/landing_page.html">Home</a></li>
                    <li class="navbar__link"><a href="#">Learn More</a></li>
                    <li class="navbar__link"><a href="../../pages/lesson_page/lesson.html">Try It</a></li>
                    <li class="navbar__link"><a href="../../pages/about_us/about_us.html">About Us</a></li>
                    <li class="navbar__link"><a href="../../pages/contact_page/contact.html">Contact Us</a></li>
                </ul>
            </div> 
        `;
        return nav;
    }

    render(){
        this.container.appendChild(this.createSidebarTemplate());
        this.container.appendChild(this.createNavbarTemplate());
    }
}