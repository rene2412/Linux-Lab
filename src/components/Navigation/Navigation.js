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
        this.sidebar.classList.add('hidden');

    }

    openSidebar = ()=>{
        this.sidebar.classList.remove('hidden');
    }

    createSidebarTemplate(){
        const sidebar = document.createElement('div');
        sidebar.classList.add('sidebar');
        sidebar.classList.add('hidden');
        sidebar.innerHTML = `
            <div class="sidebar__top">
                <div class="sidebar__header">
                    <h2 class="sidebar__logo">lab</h2>
                    <button type="button" class="button sidebar__button sidebar__button--close">X</button>
                </div>
                <nav class="sidebar__links">
                    <ul>
                        <li class="navbar__link"><a href="#">Home</a></li>
                        <li class="navbar__link"><a href="#">About Us</a></li>
                        <li class="navbar__link"><a href="#">FAQ</a></li>
                        <li class="navbar__link"><a href="#">Contact Us</a></li>
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
                    <li class="navbar__link"><a href="#">Home</a></li>
                    <li class="navbar__link"><a href="#">Learn More</a></li>
                    <li class="navbar__link"><a href="#">About Us</a></li>
                    <li class="navbar__link"><a href="#">FAQ</a></li>
                    <li class="navbar__link"><a href="#">Contact Us</a></li>
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