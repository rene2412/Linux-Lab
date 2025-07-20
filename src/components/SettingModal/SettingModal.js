// const modal = document.querySelector(".setting__container");
// const closeBtn = modal.querySelector(".setting__button--close");

// const emailForm = document.querySelector(".setting__form--email");
// const usernameForm = document.querySelector(".setting__form--name");
// const emailStatus = document.querySelector(".status__email");

// closeBtn.addEventListener("click", () => {
//   modal.close();
// });
// modal.showModal();

export default class SettingModal {

  constructor(settingContainer = ".setting__container") {
    this.container = document.querySelector(settingContainer);
    this.mount();
    this.setElements();
    this.setListeners();
    // this.container.showModal();
  }

  setElements = () => {
    this.closeBtn = this.container.querySelector(".setting__button--close");

    this.emailForm = document.querySelector(".setting__form--email");
    this.emailStatus = document.querySelector(".status__email");
    this.usernameForm = document.querySelector(".setting__form--name");
    this.usernameStatus = document.querySelector(".status__name");
    this.deleteBtn = document.querySelector(".setting__button--delete")
  };

  setListeners = () => {

    this.closeBtn.addEventListener('click',()=>{
      this.container.close()
    })

    document.addEventListener('modalopen',()=>{
      this.container.showModal()
    })

    this.deleteBtn.addEventListener('click', async ()=>{
      try {
        const response = await fetch("../../user/delete_account.php");
        if (!response.ok) {
          throw new Error("Bad response from delete change");
        }
        const resData = await response.json();
        console.log(resData);
      } catch (e) {
        console.error(e);
      }

    })


    this.emailForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const data = Object.fromEntries(formData);
      console.log(data);

      try {
        this.container.disabled
        const response = await fetch("../../user/change_email.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            new_email: data.newEmail,
            old_email: data.oldEmail,
          }),
        });
        if (!response.ok) {
          throw new Error("Bad response form email change");
        }
        const resData = await response.json();
        console.log(resData);
        this.emailStatus.innerText = "";
        this.emailStatus.classList.remove("status--error");
        this.emailStatus.classList.remove("status--success");
        if (resData["Error Logs: "].length > 0) {
          this.emailStatus.innerText = resData["Error Logs: "];
          this.emailStatus.classList.remove("status--success");
          this.emailStatus.classList.add("status--error");
        } else if (resData["Success Logs: "].length > 0) {
          this.emailStatus.innerText = resData["Success Logs: "];
          this.emailStatus.classList.remove("status--error");
          this.emailStatus.classList.add("status--success");
        } else {
          this.emailStatus.innerText = "";
        }
      } catch (e) {
        console.error(e);
      }
    });

    // user
    this.usernameForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const data = Object.fromEntries(formData);
      try {
        const response = await fetch("../../user/change_username.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            new_username: data.newName,
            old_username: data.oldName,
          }),
        });
        if (!response.ok) {
          throw new Error("Bad response form username change");
        }
        console.log(response);
        const resData = await response.json();
        console.log(resData);
        this.usernameStatus.innerText = "";
        this.usernameStatus.classList.remove("status--error");
        this.usernameStatus.classList.remove("status--success");
        if (resData["Error Logs: "] && resData["Error Logs: "] != "N/A") {
          this.usernameStatus.innerText = resData["Error Logs: "];
          this.usernameStatus.classList.remove("status--success");
          this.usernameStatus.classList.add("status--error");
        } else if (resData["Success Logs: "]) {
          this.usernameStatus.innerText = "Refreshing in 2 seconds, log back in";
          this.usernameStatus.classList.remove("status--error");
          this.usernameStatus.classList.add("status--success");
          setTimeout(()=>{
            window.location.replace("../../user/logout.php");
          },3000)


        } else {
          this.usernameStatus.innerText = "nothing";
        }
      } catch (e) {
        console.error(e);
      }
    });

  };

  mount = () => {
    this.container.innerHTML = `
      <div class="setting__header">
        <h2>Settings</h2>
        <button class="setting__button--close setting__button">
          <img src="../assets/SVGs/Close.svg" alt="close" />
        </button>
      </div>
      <div class="setting__content">
        <form
          class="setting__form setting__form--email setting__item"
          action="#"
          method="POST"
        >
          <h4 class="setting__form__title">Change Email</h4>
          <label for="oldEmail">Enter current Email:</label>
          <input
            class="input--single"
            placeholder="email@domain.com"
            id="oldEmail"
            name="oldEmail"
            type="email"
            required
          />
          <label for="newEmail">Enter new Email:</label>
          <input
            placeholder="email@domain.com"
            id="newEmail"
            name="newEmail"
            type="email"
            class="input--single"
            required
          />
          <button class="form__button--cpwd styled-button" type="submit">
            Change Email
          </button>
          <p class="status status__email"></p>
        </form>
        <form
          class="setting__form setting__form--name setting__item"
          action="#"
          method="POST"
        >
          <h4 class="setting__form__title">Change Username:</h4>
          <label for="oldName">Enter current Username:</label>
          <input
            class="input--single"
            placeholder="Current Username"
            id="oldName"
            name="oldName"
            type="text"
            required
          />
          <label for="newName">Enter new Username:</label>
          <input
            placeholder="New Username"
            id="newName"
            name="newName"
            type="text"
            class="input--single"
            required
          />
          <button class="form__button--name styled-button" type="submit">
            Change Name
          </button>
          <p class="status status__name"></p>
        </form>
        <div class="setting__item">
          <h4 class="setting__form__title">Delete Account:</h4>
          <button
            type="button"
            class="setting__button setting__button--delete styled-button"
          >
            Delete
          </button>
          <p class="status status--error">Goodbye...this is irreversable</p>
        </div>
      </div>
        `;
  };
}
