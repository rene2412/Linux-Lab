export default class ContactForm{
    // form,success,fail
    #state = 'form';
    constructor(container = '.contact-form__container'){
        this.container = document.querySelector(container);
        this.container.classList.add('contact-form__container')
        // this.handleSubmit = this.handleSubmit.bind(this);
    }

    getTemplate(){
        return(
            `
            <form class="contact-form">
            <fieldset>
                <legend>Contact Information</legend>
                <label for="contact__name">Name:</label>
                <input type="text" name="contact__name" id="contact__name" required placeholder="Enter name here...">
                <label for="contact__email">Email:</label>
                <input type="email" name="contact__email" id="contact__email" required placeholder="Enter email here...">
                <label for="contact__message">Message:</label>
                <textarea required name="contact__message" id="contact__message" maxlength="100" placeholder="Enter message here..."></textarea>
                <button type="submit" class="contact__button button styled-button">Submit</button>
            </fieldset>
            </form>
            <h3 class="hidden contact__message contact__message--success">Your message was sent!</h3>
            <h3 class="hidden contact__message contact__message-fail">Oops... try again later.</h3>
            `
        );
    }


    handleSubmit = async(e)=>{
        e.preventDefault();
        this.formData = new FormData(this.form);
        try{
            const response = await fetch('PLACEHOLDER',{
               method:'POST',
               headers: {
                'Content-type': 'application/json',
               },
               body: JSON.stringify({
                name:this.formData.get('contact__name'),
                email:this.formData.get('contact__email'),
                message:this.formData.get('contact__message'), 
               })
            })
            if(!response.ok){
                throw new Error(`Error sending message ${response.status}`)
            }
            const data = await response.json();
            this.mountSuccess();

        }
        catch(error){
            console.log(`error submitting${error}`)
            this.mountError();
        }

    }

    setupListeners(){
        this.form = document.querySelector('.contact-form');
        this.form.addEventListener('submit',this.handleSubmit)
    }

    mount(){
        this.container.innerHTML = this.getTemplate();
        this.setupListeners();
    }
    mountSuccess(){
        this.container.innerHTML = (`
            <h3 class="contact__message animation--popup contact__message--success">Your message was sent!</h3>
            `);

    }
    mountError(){
        this.container.innerHTML = (`
            <h3 class="contact__message animation--popup contact__message-fail">Oops... try again later.</h3>
            `);
    }
}