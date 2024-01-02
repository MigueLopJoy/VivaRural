import { fetchHandler, getRequestData } from "./fetchHandler.js"

import { closeModal, getCookie } from "./utils.js"

const d = document,
    loginContainer = d.querySelector(".login-container"),
    loginBtn = d.querySelector(".nav-link.login"),
    registerContainer = d.querySelector(".register-container"),
    registerBtn = d.querySelector(".nav-link.register"),
    loginForm = d.querySelector(".form.login-form"),
    registerForm = d.querySelector(".form.register-form")


d.addEventListener("DOMContentLoaded", e => {
    notifyRegistrationSuccess()
})

d.addEventListener("click", e => {
    if (e.target === loginBtn ||
        e.target === registerBtn
    ) {
        loginContainer.classList.toggle("d-none")
        registerContainer.classList.toggle("d-none")
    }
})

d.addEventListener("submit", e => {
    e.preventDefault()
    if (e.target === loginForm) {
        login()
    } else if (e.target === registerForm) {
        register()
    }
})

const login = async () => {
    let url = "./../API/auth-service.php?login",
        userData = {
            email: loginForm.email.value,
            password: loginForm.password.value
        }
    try {
        let loginResult = await fetchHandler(url, getRequestData("POST", JSON.stringify(userData)))
        document.cookie = 'userId=' + loginResult
        closeModal()
        console.log(getCookie())
    } catch (error) {
        d.querySelector('.login-error').classList.remove('d-none')
    }
}

const register = async () => {
    let url = "./../API/auth-service.php?register",
        userData = {
            firstname: registerForm.firstname.value,
            lastname: registerForm.lastname.value,
            email: registerForm.email.value,
            phoneNumber: registerForm.phoneNumber.value,
            userName: registerForm.userName.value,
            password: registerForm.password.value,
            birthDate: registerForm.birthDate.value
        }
    try {
        await fetchHandler(url, getRequestData("POST", JSON.stringify(userData)))
        window.location.href = 'auth.html?registration-success=true'
    } catch (error) {
        d.querySelector(".registration-error").classList.remove("d-none")
    }
}


const notifyRegistrationSuccess = () => {
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('registration-success');
    if (successParam === 'true') {
        d.querySelector('.registration-success').classList.remove('d-none')
    }
}