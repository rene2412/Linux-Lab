import { Navigation } from "../../components/Navigation/index.js";
import { Footer } from "../../components/Footer/index.js";
import getUserCookie from "../../utils/getUserCookie.js";

// cookie for auth init
const userObj = getUserCookie();
console.log(userObj);
if (userObj) {
  document.querySelector(".navigation__container").replaceChildren();
  const navigation = new Navigation(
    ".navigation__container",
    userObj.isLoggedIn,
    userObj
  );
} else {
  document.querySelector(".navigation__container").replaceChildren();
  const navigation = new Navigation(".navigation__container");
}

const footer = new Footer(".footer__container");

class messageManager {
  constructor() {
    this.chatForm = document.querySelector("#chatForm");
    this.chatForm.addEventListener("submit", this.handleFormSubmit);
    this.chatBox = document.querySelector("#message__rows");
    this.lastUser = "";
    this.currentRowMessages = [],
    this.currentRow = "",
    this.currentRowTimestamp = "",
    this.currentMessages = 
      this.getMessages();
  }

  getMessages = async () => {
    try {
      const response = await fetch("global_chat.php");
      if (!response.status) {
        throw new Error(response.status);
      }
      const data = await response.json();
      this.renderMessages(data);
    } catch (e) {
      console.error(e);
    }
  };

  renderMessages(messages) {
    messages.reverse().map((message) => {
      console.log(message);
      if (message.username != this.lastUser) {
        this.lastUser = message.username;
        this.currentRowTimestamp = message.Modified;
        this.currentRowMessages.push(`
                  <div class="message !p-2 bg-[var(--color-overlay)] w-fit rounded-[var(--radius-med)]">
                   ${message.Comment} 
                  </div>
                `);
      } else if (message.username === this.lastUser) {
        this.currentRowMessages.push(`
                  <div class="message !p-2 bg-[var(--color-overlay)] w-fit rounded-[var(--radius-med)]">
                   ${message.Comment} 
                  </div>
                `);
      }

      // if(userObj.username === message.Username){
      //     return(`

      //     `)
      // }
    });
  }

  createRow(username, timestamp, messages) {
    return `
        <div class="message__row--other max-w-[80%] flex flex-col gap-2">
            <div
            class="message__header gap-2 flex items-center !-mb-2"
            >
            <p class="green">@${username}</p>
            <p class="text-xs text-[var(--text-color-secondary)] ">| ${timestamp}</p>
            </div>
            ${messages}
        </div>
    `;
  }

  handleFormSubmit = async (e) => {
    e.preventDefault();
    try {
      // Create form data directly from the form
      const formData = new FormData(e.target);

      // Send the POST request
      const response = await fetch("./global_chat.php", {
        method: "POST",
        body: formData,
        credentials: "include",
      });

      // Get the response text
      const responseText = await response.text();
      console.log("Server response:", responseText);

      // Clear the textarea if successful
      if (responseText.includes("Comment Succesfully published")) {
        // Clear the form
        e.target.reset();
      }
    } catch (error) {
      console.error("Error posting comment:", error);
    }
  };
}

const messageManage = new messageManager();
