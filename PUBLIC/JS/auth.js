import { fetchHandler, getRequestData } from "./fetchHandler.js"

import { openModal, closeModal, getCookie } from "./utils.js"

const d = document

d.addEventListener("DOMContentLoaded", e => {
    notifyRegistrationSuccess()
})

d.addEventListener("click", e => {
    if (e.target.matches(".open-register")) {
        toggleAuthLayers()
    }
})

d.addEventListener("submit", e => {
    e.preventDefault()
    if (e.target.matches(".login-form")) {
        login(e.target)
    } else if (e.target.matches(".register-form")) {
        register(e.target)
    }
})

const toggleAuthLayers = () => {
    d.querySelector(".login-container").classList.toggle("d-none")
    d.querySelector(".register-container").classList.toggle("d-none")
}

const login = async loginForm => {
    let url = "./../API/auth-service.php?login",
        userData = JSON.stringify({
            email: loginForm.email.value,
            password: loginForm.password.value
        })
    try {
        let loginResult = await fetchHandler(url, getRequestData("POST", userData))
        document.cookie = 'userId=' + loginResult
        closeModal()
    } catch (error) {
        d.querySelector('.login-error').classList.remove('d-none')
    }
}

const register = async registerForm => {
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
        window.location.href = '?registration-success=true'
    } catch (error) {
        d.querySelector(".registration-error").classList.remove("d-none")
    }
}

const notifyRegistrationSuccess = () => {
    let urlParams = new URLSearchParams(window.location.search),
        successParam = urlParams.get('registration-success')
    if (successParam === 'true') {
        openModal()
        d.querySelector('.registration-success').classList.remove('d-none')
    }
}