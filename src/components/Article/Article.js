export default class Article {
    articleInnerHTML = '';
    observer = null;
    
    constructor(options = {}) {
        this.options = {
            apiEndpoint: '../../testAPI/aboutUsArticle.json',
            ...options
        };
    }
    
    mount(containerIdentifier) {
        this.container = document.querySelector(containerIdentifier);
        // Wait for articleInnerHTML to be populated
        this.createArticleTemplate().then(() => {
            this.container.innerHTML = this.articleInnerHTML;
            console.log(this.articleInnerHTML);
            
            // After the DOM is updated, initialize the observer
            this.initIntersectionObserver();
        });
    }
    
    async createArticleTemplate() {
        try {
            const response = await fetch('../../testAPI/aboutUsArticle.json');
            if (!response.ok) {
                throw new Error(`could not get articles`)
            }
            const data = await response.json();
            
            // Create articles HTML
            const articlesHTML = [];
            const articleListItems = [];
            
            data.articles.forEach(article => { 
                const paragraphs = article.content.map(paragraph => {
                    return `<p>${paragraph}</p>`
                }).join("");
                
                const newArticle = `
                <article class="article animation--popup">
                    <h3 class="article__title" id="${article.id}">${article.title}</h3>
                    <section class="article__content">
                    ${paragraphs}
                    </section>
                </article>
                `;
                
                articlesHTML.push(newArticle);
                const newArticleItem = `<li><a href="#${article.id}" class="article__link">${article.title}</a></li>`;
                articleListItems.push(newArticleItem);
            });
            
            // Create the complete structure matching your expected HTML
            this.articleInnerHTML = `
            <div class="articles">
                ${articlesHTML.join("")}
            </div>
            <nav class="articles__sidebar animation--popup">
                <h3 class="articles__title">Reading:</h3>
                <ul class="article__links">
                    ${articleListItems.join("")}
                </ul>
            </nav>
            `;
            
            return this.articleInnerHTML;
        }
        catch(error) {
            console.log(`an error has occurred ${error}`);
            throw error;
        }
    }
    
    updateArticleSideObs(titleText) {
        const articleLinks = this.container.querySelectorAll('.article__link');
        articleLinks.forEach((element) => {
            if (element.innerText === titleText) {
                element.classList.add('active');
            } else {
                element.classList.remove('active');
            }
        });
    }
    
    initIntersectionObserver() {
        const articleTitles = this.container.querySelectorAll('.article__title');
        
        this.observer = new IntersectionObserver((items) => {
            items.forEach((item) => {
                if (item.isIntersecting) {
                    this.updateArticleSideObs(item.target.firstElementChild.innerText);
                }
            });
        }, {
            root: null,
            rootMargin: "-40% 0px -70% 0px",
            threshold: 0,
        });
        
        // Start observing all article elements
        articleTitles.forEach((element) => {
            this.observer.observe(element.parentElement);
        });
    }
    
    // Method to clean up observer when no longer needed
    disconnect() {
        if (this.observer) {
            this.observer.disconnect();
        }
    }
}