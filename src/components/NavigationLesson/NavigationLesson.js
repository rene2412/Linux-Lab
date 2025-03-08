export default class NavigationLesson{
    constructor(container,button){
        this.container = document.querySelector(container);
        this.container.classList.remove('hidden');
        this.sidebarBtnOpen = document.querySelector(button);
        this.render();
        this.setElements();
        this.setListeners();
    }

    setElements(){
        this.sidebarBtnClose = document.querySelector('.sidebar__button--close')
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
        this.container.classList.add('sidebar');
        this.container.innerHTML = `
            <div class="sidebar__top">
                <div class="sidebar__header">
                    <h2 class="sidebar__logo">Linux-Lab</h2>
                    <button type="button" class="button sidebar__button sidebar__button--close">X</button>
                </div>
                <nav class="sidebar__links">
                    <ul>
                        <li class="navbar__link"><a href="../../pages/landing_page/landing_page.html">Home</a></li>
                        <li class="navbar__link"><a href="#">Learn More</a></li>
                        <li class="navbar__link"><a href="../../pages/about_us/about_us.html">About Us</a></li>
                        <li class="navbar__link"><a href="../../pages/contact_page/contact.html">Contact Us</a></li>
                        <li class="navbar__link"><a href="../../pages/login/login.php">login</a></li>
                    </ul>
                </nav>
            </div>
            <div class="sidebar__bottom">
                <button type="button">
                    <img src="../assets/SVGs/cog-outline.svg " class="svg" alt="cog">
                </button>
            </div>
        `;
        // return sidebar;
    }

    render(){
        this.createSidebarTemplate();
    }
}