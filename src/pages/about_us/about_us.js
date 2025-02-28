import { Navigation } from "../../components/Navigation/index.js";
import { Footer } from "../../components/Footer/index.js";
import { Article } from "../../components/Article/Index.js";

const navigation = new Navigation('.navigation__container');
const footer = new Footer('.footer__container');
const articleObject = new Article();
articleObject.mount('.articles__container');