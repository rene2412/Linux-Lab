import { Navigation } from "../../components/Navigation/index.js";
import {SettingModal} from "../../components/SettingModal/index.js"

const API_BASE_URL = "https://linux-lab.live";
const RATING_API_URL = `${API_BASE_URL}/api/rating`;
const RESUBMIT_RATING_API_URL = `${API_BASE_URL}/api/rating/resubmit`;
const COMMENTS_API_URL = `${API_BASE_URL}/api/comments`;

function showRatingResubmitPrompt(message) {
    return new Promise((resolve) => {
        const existingModal = document.querySelector("#rating-confirm-modal");
        if (existingModal) {
            existingModal.remove();
        }

        const modal = document.createElement("dialog");
        modal.id = "rating-confirm-modal";
        modal.className = "rating-confirm-modal";
        modal.innerHTML = `
            <div class="rating-confirm-modal__content">
                <div class="rating-confirm-modal__header">
                    <h3>Update your review?</h3>
                    <button type="button" class="rating-confirm-modal__close" aria-label="Close dialog">×</button>
                </div>
                <p>${message || "You have already submitted a rating. Do you want to resubmit another rating?"}</p>
                <div class="rating-confirm-modal__actions">
                    <button type="button" class="styled-button rating-confirm-modal__button rating-confirm-modal__button--cancel">No</button>
                    <button type="button" class="styled-button rating-confirm-modal__button rating-confirm-modal__button--confirm">Yes, resubmit</button>
                </div>
            </div>
        `;

        const close = () => {
            modal.close();
            modal.remove();
            resolve(false);
        };

        const confirm = () => {
            modal.close();
            modal.remove();
            resolve(true);
        };

        modal.addEventListener("click", (event) => {
            if (event.target === modal) {
                close();
            }
        });

        modal.querySelector(".rating-confirm-modal__close").addEventListener("click", close);
        modal.querySelector(".rating-confirm-modal__button--cancel").addEventListener("click", close);
        modal.querySelector(".rating-confirm-modal__button--confirm").addEventListener("click", confirm);

        document.body.appendChild(modal);
        modal.showModal();
    });
}

function showWarningPopup(message) {
    return new Promise((resolve) => {
        const existingModal = document.querySelector("#rating-warning-modal");
        if (existingModal) {
            existingModal.remove();
        }

        const modal = document.createElement("dialog");
        modal.id = "rating-warning-modal";
        modal.className = "rating-confirm-modal";
        modal.innerHTML = `
            <div class="rating-confirm-modal__content">
                <div class="rating-confirm-modal__header">
                    <h3>Submission blocked</h3>
                    <button type="button" class="rating-confirm-modal__close" aria-label="Close dialog">×</button>
                </div>
                <p>${message || "Your review could not be submitted right now."}</p>
                <div class="rating-confirm-modal__actions">
                    <button type="button" class="styled-button rating-confirm-modal__button rating-confirm-modal__button--confirm">OK</button>
                </div>
            </div>
        `;

        const close = () => {
            modal.close();
            modal.remove();
            resolve();
        };

        modal.addEventListener("click", (event) => {
            if (event.target === modal) {
                close();
            }
        });

        modal.querySelector(".rating-confirm-modal__close").addEventListener("click", close);
        modal.querySelector(".rating-confirm-modal__button--confirm").addEventListener("click", close);

        document.body.appendChild(modal);
        modal.showModal();
    });
}

async function AuthCheck(){
    try{
        const response = await fetch('../../user/user.php');
        if(!response.ok){
            throw new Error('Fail fetching auth info');
        }
        const data = await response.json()
        if(!data.isLoggedIn){
            window.location.href = `../login/login.php`;
        }
        else{
            const nav = new Navigation('.navigation__container', data.isLoggedIn,data)
            const dashboard = new DashboardManager('.dashboard__container',data);
        }
    }
    catch(error){
        console.error(error);
    }
}

AuthCheck();


class DashboardManager{

    constructor(container = '.dashboard__container',data){
        this.container = document.querySelector(container); 
        this.greeting = document.querySelector('.greeting__text')
        // change this line when JSON is fixed
        this.data=data;
        this.initialize();

    }

    render(){
        const cards = document.createElement('div');
        cards.classList.add('dashboard__cards');
        const col1 = document.createElement('div');
        const col2 = document.createElement('div');
        col1.classList.add('dashboard__column--1');
        col1.classList.add('dashboard__column');
        col2.classList.add('dashboard__column--2');
        col2.classList.add('dashboard__column');

        col1.innerHTML = this.getCol1Cards();
        col2.innerHTML = this.getCol2Cards();

        cards.appendChild(col1);
        cards.appendChild(col2);

        this.container.appendChild(cards);
        this.setupFeedbackForm();
        this.setupGeneralCommentsForm();
        this.greeting.innerHTML = `Welcome, <span class="green">@</span>${this.data.username}`
    }

    setupFeedbackForm(){
        const feedbackForm = document.querySelector("#feedback-form");
        const feedbackMessage = document.querySelector("#feedback-message");
        const feedbackStatus = document.querySelector("#feedback-status");
        const feedbackCount = document.querySelector("#feedback-message-count");
        const feedbackWarning = document.querySelector("#feedback-message-warning");
        const feedbackSubmit = document.querySelector("#feedback-submit");
        const ratingInput = document.querySelector("#feedback-rating");
        const ratingStars = document.querySelectorAll(".rating__star");
        const feedbackHistory = document.querySelector("#feedback-history");
        const MAX_REVIEW_LENGTH = 1000;

        const updateCharacterCount = () => {
            const currentLength = feedbackMessage.value.length;
            const isTooLong = currentLength > MAX_REVIEW_LENGTH;

            feedbackCount.textContent = `${currentLength}/${MAX_REVIEW_LENGTH}`;
            feedbackWarning.hidden = !isTooLong;
            feedbackMessage.classList.toggle("feedback__input--error", isTooLong);
            feedbackSubmit.disabled = isTooLong;
        };

        const populateHistory = (history) => {
            if (!feedbackHistory) return;

            const items = Array.isArray(history) ? history : [];
            feedbackHistory.innerHTML = "";

            const placeholder = document.createElement("option");
            placeholder.value = "";
            placeholder.textContent = items.length ? "Select previous review" : "No previous reviews";
            placeholder.disabled = true;
            placeholder.selected = true;
            feedbackHistory.appendChild(placeholder);

            items.forEach((entry, index) => {
                const option = document.createElement("option");
                const label = `${entry.last_review || 'Unknown date'} • ${entry.stars || 0}★`;
                option.value = String(index);
                option.textContent = label;
                option.dataset.review = entry.review || "";
                option.dataset.rating = entry.stars || "";
                feedbackHistory.appendChild(option);
            });
        };

        feedbackHistory?.addEventListener("change", (event) => {
            const selectedOption = event.target.selectedOptions?.[0];
            if (!selectedOption || !selectedOption.dataset.review) return;

            const selectedRating = Number(selectedOption.dataset.rating || 0);
            if (selectedRating >= 1 && selectedRating <= 5) {
                setRating(selectedRating);
            }

            feedbackMessage.value = selectedOption.dataset.review || "";
            updateCharacterCount();
        });

        const setRating = (rating) => {
            ratingInput.value = rating || "";
            ratingStars.forEach((ratingStar) => {
                ratingStar.classList.toggle(
                    "rating__star--selected",
                    Number(ratingStar.value) <= rating
                );
            });
        };

        ratingStars.forEach((star) => {
            star.addEventListener("click", () => {
                setRating(Number(star.value));
            });
        });

        feedbackMessage.addEventListener("input", updateCharacterCount);
        updateCharacterCount();

        feedbackForm.addEventListener("submit", async (event) => {
            event.preventDefault();

            const message = feedbackMessage.value.trim();
            const rating = Number(ratingInput.value);
            console.log("username:", this.data.username);
            console.log("user_id:", this.data.userId);
            if (!message || !rating || message.length > MAX_REVIEW_LENGTH) return;

            try {
                const response = await fetch(RATING_API_URL, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        rating,
                        message,
                        username: this.data.username,
                        user_id: this.data.userId
                    })
                });

                const responseData = await response.json().catch(() => ({}));

                if (!response.ok) {
                    if (responseData.status === "warning_existing_rating") {
                        const shouldResubmit = await showRatingResubmitPrompt(responseData.message || "You have already submitted a rating. Do you want to resubmit another rating?");
                        if (!shouldResubmit) {
                            feedbackStatus.textContent = "Review left unchanged.";
                            return;
                        }

                        const resubmitResponse = await fetch(RESUBMIT_RATING_API_URL, {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({
                                rating,
                                message,
                                username: this.data.username,
                                user_id: this.data.userId
                            })
                        });

                        const resubmitData = await resubmitResponse.json().catch(() => ({}));
                        if (!resubmitResponse.ok) {
                            const popupMessage = resubmitData.message || `HTTP error: ${resubmitResponse.status}`;
                            await showWarningPopup(popupMessage);
                            feedbackStatus.textContent = popupMessage;
                            return;
                        }

                        feedbackStatus.textContent = resubmitData.message || "Review updated successfully!";
                        return;
                    }

                    const popupMessage = responseData.message || `HTTP error: ${response.status}`;
                    await showWarningPopup(popupMessage);
                    feedbackStatus.textContent = popupMessage;
                    return;
                }

                feedbackStatus.textContent = responseData.message || "Feedback submitted!";
            } catch (error) {
                console.error("Review error:", error);
                feedbackStatus.textContent = "Failed to submit review.";
            }
        });

        fetch(`${RATING_API_URL}/show?user_id=${encodeURIComponent(this.data.userId)}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                const history = Array.isArray(data.history) ? data.history : [];
                const latestReview = history[0] || null;

                populateHistory(history);

                if (latestReview) {
                    const savedRating = Number(latestReview.stars);
                    const savedMessage = latestReview.review || "";

                    if (savedRating >= 1 && savedRating <= 5) {
                        setRating(savedRating);
                    }
                    if (savedMessage) {
                        feedbackMessage.value = savedMessage;
                        updateCharacterCount();
                    }
                }
            })
            .catch((error) => {
                console.error("Review retrieval error:", error);
                populateHistory([]);
            });
    }

    setupGeneralCommentsForm(){
        const generalCommentsForm = document.querySelector("#general-comments-form");
        const generalCommentsMessage = document.querySelector("#general-comments-message");
        const generalCommentsStatus = document.querySelector("#general-comments-status");
        const generalCommentsCount = document.querySelector("#general-comments-message-count");
        const generalCommentsWarning = document.querySelector("#general-comments-message-warning");
        const generalCommentsSubmit = document.querySelector("#general-comments-submit");
        const generalCommentsHistory = document.querySelector("#general-comments-history");
        const MAX_COMMENT_LENGTH = 1000;

        const updateCharacterCount = () => {
            const currentLength = generalCommentsMessage.value.length;
            const isTooLong = currentLength > MAX_COMMENT_LENGTH;

            generalCommentsCount.textContent = `${currentLength}/${MAX_COMMENT_LENGTH}`;
            generalCommentsWarning.hidden = !isTooLong;
            generalCommentsMessage.classList.toggle("feedback__input--error", isTooLong);
            generalCommentsSubmit.disabled = isTooLong;
        };

        const populateHistory = (history) => {
            if (!generalCommentsHistory) return;

            const items = Array.isArray(history) ? history : [];
            generalCommentsHistory.innerHTML = "";

            const placeholder = document.createElement("option");
            placeholder.value = "";
            placeholder.textContent = items.length ? "Select previous comment" : "No previous comments";
            placeholder.disabled = true;
            placeholder.selected = true;
            generalCommentsHistory.appendChild(placeholder);

            items.forEach((entry, index) => {
                const option = document.createElement("option");
                option.value = String(index);
                option.textContent = `${entry.modified || 'Unknown date'} • ${entry.comment ? entry.comment.slice(0, 35) : ''}`;
                option.dataset.comment = entry.comment || "";
                generalCommentsHistory.appendChild(option);
            });
        };

        generalCommentsHistory?.addEventListener("change", (event) => {
            const selectedOption = event.target.selectedOptions?.[0];
            if (!selectedOption || !selectedOption.dataset.comment) return;
            generalCommentsMessage.value = selectedOption.dataset.comment || "";
            updateCharacterCount();
        });

        generalCommentsMessage.addEventListener("input", updateCharacterCount);
        updateCharacterCount();

        generalCommentsForm.addEventListener("submit", async (event) => {
            event.preventDefault();

            const message = generalCommentsMessage.value.trim();
            if (!message || message.length > MAX_COMMENT_LENGTH) return;

            try {
                const response = await fetch(COMMENTS_API_URL, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        user_id: this.data.userId,
                        comment: message,
                        username: this.data.username
                    })
                });

                const responseData = await response.json().catch(() => ({}));

                if (!response.ok) {
                    const popupMessage = responseData.message || `HTTP error: ${response.status}`;
                    await showWarningPopup(popupMessage);
                    generalCommentsStatus.textContent = popupMessage;
                    return;
                }

                generalCommentsStatus.textContent = responseData.message || "Comment submitted!";
                generalCommentsMessage.value = "";
                updateCharacterCount();
                fetch(`${COMMENTS_API_URL}/history?user_id=${encodeURIComponent(this.data.userId)}`)
                    .then((res) => res.json())
                    .then((data) => populateHistory(data.history || []))
                    .catch(() => populateHistory([]));
            } catch (error) {
                console.error("General comments error:", error);
                const popupMessage = "Failed to submit comment.";
                await showWarningPopup(popupMessage);
                generalCommentsStatus.textContent = popupMessage;
            }
        });

        fetch(`${COMMENTS_API_URL}/history?user_id=${encodeURIComponent(this.data.userId)}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                populateHistory(data.history || []);
            })
            .catch((error) => {
                console.error("Comment history retrieval error:", error);
                populateHistory([]);
            });
    }

    getCol1Cards(){
        const cardContinueLearning = new CardContinueLearning(this.data.currentModule);
        const cardModules = new CardModules(this.data.modules);
        const cardGeneralComments = new CardGeneralComments();
        return cardContinueLearning.getCardTemplate()
            + cardModules.getCardTemplate()
            + cardGeneralComments.getCardTemplate();
    }

    getCol2Cards(){
        const cardProgress = new CardProgress(this.data.modules);
        const cardFeedback = new CardFeedback();
        const cardHTML = cardProgress.getCardTemplate()
            + cardFeedback.getCardTemplate();
        return cardHTML;
    }

    async initialize(){
        // this.data = await this.fetchData();
        this.render();
    }

    async fetchData(){
        return(
            {
                username:'herb',
                isLoggedIn:true,
                currentModule:{
                    name:'The Basics',
                    lessonId:3,
                    lessonName: 'cat',
                },
                modules:[
                    {
                        name:'The Basics',
                        completed: 13,
                        total:21,
                    },
                    
                ]
            }
        );

    }
}

class CardContinueLearning{
    constructor(data){
        this.data = data;
    }

    getCardTemplate(){
        return(`
            <div class="dashboard__card dashboard__card--continue">
                <h3 class="card__title">Continue Learning:</h3>
                <div class="card__content">
                    <a href="../lesson_page/lesson.html" class="card__link">
                        <p class="card__text">${this.data.name}</p>
                        <p class="card__text">Lesson: ${this.data.lessonName}</p>
                    </a>
                    <button class="styled-button card__button"><a href="../lesson_page/lesson.html">continue</a></button>
                </div>
            </div>
        `);
    }
}


class CardModules{
    constructor(data){
        this.data = data;
    }

    getElements(data){
        const elements = data.map((section)=>{
            return (`<li class="card__subtitle"><a href="#" class="card__link">${section.name}</a></li>`);
        })
        return elements;
    }

    getCardTemplate(){
        const elements = this.getElements(this.data);


        return(`
            <div class="dashboard__card dashboard__card--modules">
                <h3 class="no-select">Modules:</h3>
                <div class="card__content">
                    <ul class="card__ul">
                    ${elements.join('')}
                    </ul>
                    <p class="card__message no-select animate-pulse">Coming Soon...</p>
                </div>
            </div>
        `);
    }
}

class CardProgress{
    constructor(data){
        this.data = data;
        this.getElements();
    }

    getElements(){
        let barSize = 20;
        const elements = this.data.map((section)=>{
            return(`
                <p class="card__text">${section.name}</p>
                ${this.getProgressBar(section.completed,section.total)}
                <p class="card__text">${section.completed}/${section.total}</p>
            `);
        })
        return elements;
    }

    getProgressBar(completed,size){
        let barSize = 20;
        const greenBar = Math.floor((completed/size)*20);
        const empty = barSize-greenBar;
        const blockChar = '█'
        const emptyChar = '░'
        return(`<span class="card__progress-bar">[<span class="green">${blockChar.repeat(greenBar)}</span>${emptyChar.repeat(empty)}]</span>`);
    }

    getCardTemplate(){
        const elements = this.getElements();
        return(`
            <div class="dashboard__card dashboard__card--progress">
                <h3>Your Progress:</h3>
                <div class="card__content">
                    <div class="card__content--progress">
                    ${elements.join('')}
                    </div>
                </div>
            </div>
        `);
    }
}

class CardFeedback{
    getCardTemplate(){
        return(`
            <div class="dashboard__card dashboard__card--feedback">
                <h3>Review:</h3>
                <div class="card__content">
                    <form id="feedback-form" class="feedback__form">
                        <fieldset class="rating">
                            <div class="rating__stars" role="group" aria-label="Rating from one to five stars">
                                <input type="hidden" id="feedback-rating" value="">
                                ${[1, 2, 3, 4, 5].map((rating) => `<button type="button" class="rating__star" value="${rating}" aria-label="${rating} star${rating === 1 ? '' : 's'}">★</button>`).join('')}
                            </div>
                        </fieldset>
                        <label class="feedback__history-label" for="feedback-history">Previous submissions</label>
                        <select id="feedback-history" class="feedback__history" aria-label="Previous review history">
                            <option value="">Loading...</option>
                        </select>
                        <textarea
                            id="feedback-message"
                            class="feedback__input"
                            maxlength="1000"
                            placeholder="Leave a comment about your rating..."
                            required
                        ></textarea>
                        <div class="feedback__meta">
                            <span id="feedback-message-count" class="card__message">0/1000</span>
                            <span id="feedback-message-warning" class="card__message" hidden>Review too long. Please shorten it.</span>
                        </div>
                        <button id="feedback-submit" type="submit" class="styled-button card__button feedback__submit">Submit Review</button>
                    </form>
                    <p id="feedback-status" class="card__message"></p>
                </div>
            </div>
        `);
    }
}

class CardGeneralComments{
    getCardTemplate(){
        return(`
            <div class="dashboard__card dashboard__card--general-comments">
                <h3>General Comments:</h3>
                <div class="card__content">
                    <form id="general-comments-form" class="feedback__form">
                        <label class="feedback__history-label" for="general-comments-history">Previous comments</label>
                        <select id="general-comments-history" class="feedback__history" aria-label="Previous comments history">
                            <option value="">Loading...</option>
                        </select>
                        <textarea
                            id="general-comments-message"
                            class="feedback__input"
                            maxlength="1000"
                            placeholder="Report a bug, issues, or share general feedback..."
                            required
                        ></textarea>
                        <div class="feedback__meta">
                            <span id="general-comments-message-count" class="card__message">0/1000</span>
                            <span id="general-comments-message-warning" class="card__message" hidden>Comment too long. Please shorten it.</span>
                        </div>
                        <button id="general-comments-submit" type="submit" class="styled-button card__button feedback__submit">Submit Comment</button>
                    </form>
                    <p id="general-comments-status" class="card__message"></p>
                </div>
            </div>
        `);
    }
}


const DATA = [
    {
    name:'The Basics',
    completed: 13,
    total:21,
    },
    {
    name:'Newtorking',
    completed: 18,
    total:21,
    },
    {
    name:'IDK',
    completed: 1,
    total:17,
    },
]

const modal = new SettingModal();