const d = document

d.addEventListener("click", e => {
    if (e.target.matches(".open-auth-modal i")) {
        openModal()
    } else if (e.target.matches(".close-modal")) {
        closeModal()
        if (!d.querySelector(".register-container").classList.contains("d-none")) {
            toggleAuthLayers()
        }
    }
})

const openModal = () => {
    d.querySelector('.auth-overlay').classList.remove('d-none')
}

const closeModal = () => {
    d.querySelector('.auth-overlay').classList.add('d-none')
}

const loadHtmlComponent = async (url, parentElement) => {
    let res = await fetch(url),
        layer = await res.text()
    parentElement.innerHTML += layer
}

const getCookie = name => {
    let cookieName = name + "=",
        cookie = d.cookie
    if (cookie.indexOf(cookieName) === 0) {
        return cookie.substring(cookieName.length, cookie.length)
    }
    return null
}

export {
    loadHtmlComponent,
    openModal,
    closeModal,
    getCookie
}