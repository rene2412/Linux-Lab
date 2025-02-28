export default class Footer{
    constructor(container){
        this.container = document.querySelector(container);
        this.render();
    }

    setTemplate(){
        const html = `
        <div class="footer__main">
            <section class="footer__information">
                <h2 class="footer__title">Linux-Lab</h2>
                <ul class="footer__links footer__list">
                    <li><p>Fresno, CA</p></li>
                </ul>
            </section>
            <section class="footer__socials">
                <h2 class="footer__title">Socials</h2>
                <ul class="footer__links footer__list">
                    <li><p>these links dont work yet... working on it!</p></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">X</a></li>
                    <li><a href="#">TikTok</a></li>
                </ul>
            </section>
        </div>
        <div class="footer__end">
            <img src="../assets/SVGs/Tux.svg.png"class="footer__logo" alt="TUX the penguin">
            <p>made by code</p>
        </div> 
        `;
        return html;
    }
    render(){
        this.container.innerHTML = this.setTemplate();
        
    }
}