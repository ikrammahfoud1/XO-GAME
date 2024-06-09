function toggleLoginForm() {
  const loginText = document.querySelector(".title-text .login");
  const loginForm = document.querySelector("form.login");
  const loginBtn = document.querySelector("label.login");
  const signupBtn = document.querySelector("label.signup");
  const signupLink = document.querySelector("form .signup-link a");

  signupBtn.onclick = () => {
    loginForm.style.marginLeft = "-50%";
    loginText.style.marginLeft = "-50%";
    window.location.hash = "#signup";
  };

  loginBtn.onclick = () => {
    loginForm.style.marginLeft = "0%";
    loginText.style.marginLeft = "0%";
    window.location.hash = "#login";
  };

  signupLink.onclick = (event) => {
    signupBtn.click();
    event.preventDefault();
  };
  console.log("window.location.hash", window.location.hash);
  if (window.location.hash === "#signup") {
    signupBtn.click();
  }
}
toggleLoginForm();
