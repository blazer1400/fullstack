function loginVisible() {
    document.getElementById("loginContainer").style.visibility = "visible";
    closeRegister();
}
function registerVisible() {
    document.getElementById("registerContainer").style.visibility = "visible";
    closeLogin();
}
function closeLogin() {
    document.getElementById("loginContainer").style.visibility = "hidden";
}
function closeRegister() {
    document.getElementById("registerContainer").style.visibility = "hidden";
}