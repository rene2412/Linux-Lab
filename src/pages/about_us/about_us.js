import { Navigation } from "../../components/Navigation/index.js";
import { Footer } from "../../components/Footer/index.js";
import { Article } from "../../components/Article/Index.js";
import { PageTitle } from '../../components/PageTitle/index.js';

const navigation = new Navigation('.navigation__container');
const pageTitle = new PageTitle('.page-title__container','About Us');
pageTitle.mount();
const footer = new Footer('.footer__container');
const articleObject = new Article();
articleObject.mount('.articles__container');