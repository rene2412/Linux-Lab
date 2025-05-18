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
    this.container = document.querySelector(".message__rows__container");

    this.lastUser = 1;
    this.lastTimestamp = "";
    (this.messages = []), (this.messageRow = []);
    this.messageRowMessages = [];
    this.getMessages();
  }

  getMessages = async () => {
    try {
      const response = await fetch("global_chat.php");
      if (!response.status) {
        throw new Error(response.status);
      }
      const data = await response.json();
      console.log(data);
      this.renderMessages(data);
    } catch (e) {
      console.error(e);
    }
  };

  renderMessages(messages) {
    for (let message of [...messages.reverse(), { Username: null }]) {
      message = {
        Username: message["Username: "],
        Modified: message["Modified: "],
        Comment: message["Comment: "],
      };
      if (this.lastUser != message.Username) {
        // push previous message row
        if (this.lastUser != 1) {
          this.messageRow.push(
            this.createRow(
              this.lastUser,
              this.lastTimestamp,
              this.messageRowMessages.join('')
            )
          );
        }
        // reset messages and update last users
        this.messageRowMessages = [];
        this.lastUser = message.Username;
        this.lastTimestamp = message.Modified;
        this.messageRowMessages.push(
          `<div class="message !p-2 bg-[var(--color-overlay)] w-fit rounded-[var(--radius-med)]">
           ${message.Comment} 
            </div>`
        );
      } else if (this.lastUser === message.Username) {
        this.messageRowMessages.push(
          `<div class="message !p-2 bg-[var(--color-overlay)] w-fit rounded-[var(--radius-med)]">
           ${message.Comment} 
            </div>
            `
        );
      }
    }
    this.chatBox.replaceChildren();
    this.chatBox.innerHTML = this.messageRow.join('');
  }

  createRow(username, timestamp, messages) {
    return `
        <div class="message__row--other max-w-[80%] flex flex-col !mt-2 gap-2">
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
