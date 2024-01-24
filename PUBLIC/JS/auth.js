import { fetchHandler, getRequestData } from "./fetchHandler.js"

import { openModal, getCookie } from "./utils.js"

import { getPageId } from "./townPages.js"

const d = document

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
    let url = location.href.includes('/HTML/') ? "./../../API/auth-service.php?login" : "./../API/auth-service.php?login",
        userData = {
            email: loginForm.email.value,
            password: loginForm.password.value
        }
    try {
        let loginResult = await fetchHandler(url, getRequestData("POST", JSON.stringify(userData)))
        d.cookie = 'userId=' + loginResult.userId
        location.href = location.href.includes('id') ?
            `http://localhost/practicas/vivarural/public/HTML/town-page.html?id=${getPageId()}` : location.href
    } catch (error) {
        console.log(error)
        d.querySelector('.login-error').classList.remove('d-none')
    }
}

const register = async registerForm => {
    let url = location.href.includes('/HTML/') ? "./../../API/auth-service.php?register" : "./../API/auth-service.php?register",
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
        let suffix = location.href.includes('id') ? '&registration-success=true' : '?registration-success=true';
        location.href = location.href.includes('index') ? location.href + suffix : location.href + 'index.html' + suffix;
    } catch (error) {
        console.log(error)
        d.querySelector(".registration-error").classList.remove("d-none")
    }
}

const notifyRegistrationSuccess = () => {
    if (getCookie("userId") === null) {
        let urlParams = new URLSearchParams(window.location.search),
            successParam = urlParams.get('registration-success')
        if (successParam === 'true') {
            openModal()
            d.querySelector('.registration-success').classList.remove('d-none')
        }
    }
}

export { notifyRegistrationSuccess }