// const signInButton = document.getElementById('signIn');
// const signUpButton = document.getElementById('signUp');
// const containers = document.querySelector('.containers');

// signInButton.addEventListener('click', () => {
//     containers.classList.remove('right-panel-active');
// });

// signUpButton.addEventListener('click', () => {
//     containers.classList.add('right-panel-active');
// });

const loginText = document.querySelector(".title-text .login");
const loginForm = document.querySelector("form.login");
const loginBtn = document.querySelector("label.login");
const signupBtn = document.querySelector("label.signup");
const signupLink = document.querySelector("form .signup-link a");
signupBtn.onclick = (()=>{
  loginForm.style.marginLeft = "-50%";
  loginText.style.marginLeft = "-50%";
});
loginBtn.onclick = (()=>{
  loginForm.style.marginLeft = "0%";
  loginText.style.marginLeft = "0%";
});
signupLink.onclick = (()=>{
  signupBtn.click();
  return false;
});

