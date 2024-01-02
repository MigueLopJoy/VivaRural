const d = document

d.addEventListener("click", e => {
    if (e.target.matches(".open-auth-modal i")) {
        openModal()
    } else if (e.target.matches(".close-modal")) {
        closeModal()
    }
})

const openModal = () => {
    d.querySelector('.auth-overlay').classList.remove('d-none')
}

const closeModal = () => {
    d.querySelector('.auth-overlay').classList.remove('d-none')
}

const loadHtmlComponent = async (url, parentElement) => {
    let res = await fetch(url),
        layer = await res.text()
    parentElement.innerHTML += layer
}

const getCookie = name => {
    let cookieName = name + "=",
        decodedCookie = decodeURIComponent(d.cookie),
        cookieArray = decodedCookie.split(';')
    console.log(decodeURIComponent(d.cookie))
    for (let i = 0; i < cookieArray.length; i++) {
        let cookie = cookieArray[i].trim()
        console.log(cookie)
        console.log(cookie.indexOf(cookieName))
        if (cookie.indexOf(cookieName) === 0) {
            console.log(cookie.substring(cookieName.length, cookie.length))
            return cookie.substring(cookieName.length, cookie.length)
        }
    }
    return null
}

export {
    loadHtmlComponent,
    closeModal,
    getCookie
}