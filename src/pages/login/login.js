const buttonLogin = document.querySelector('.auth__option--login');
const buttonSignup= document.querySelector('.auth__option--signup');
const loginSection = document.querySelector('.auth__form--login')
const signupSection= document.querySelector('.auth__form--signup')
const signupForm = document.querySelector('#signup__form');
const loginForm = document.querySelector('#login__form');

signupForm.addEventListener('submit',(e)=>{
    e.preventDefault();
})
loginForm.addEventListener('submit',(e)=>{
    e.preventDefault();
})

buttonLogin.addEventListener('click',()=>{
    buttonLogin.classList.add('active')
    buttonSignup.classList.remove('active');
    showLogin();
})
buttonSignup.addEventListener('click',()=>{
    buttonSignup.classList.add('active')
    buttonLogin.classList.remove('active');
    showSignup();
})

function showLogin(){
    signupSection.classList.add('hidden');
    loginSection.classList.remove('hidden');
}

function showSignup(){
    loginSection.classList.add('hidden');
    signupSection.classList.remove('hidden');

}