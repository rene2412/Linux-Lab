const buttonLogin = document.querySelector('.auth__option--login');
const buttonSignup= document.querySelector('.auth__option--signup');
const loginSection = document.querySelector('.auth__form--login')
const signupSection= document.querySelector('.auth__form--signup')
const signupForm = document.querySelector('#signup__form');
const loginForm = document.querySelector('#login__form');


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


async function AuthCheck(){
    try{
        const response = await fetch('../../user/user.php');
        if(!response.ok){
            throw new Error('Fail fetching auth info');
        }
        const data = await response.json()
        console.log(data);
        if(data.isLoggedIn){
            window.location.href = `../../pages/dashboard/dashboard.html`;
        }
        else{
            return;
        }
    }
    catch(error){
        console.error(error);
    }
}

AuthCheck();