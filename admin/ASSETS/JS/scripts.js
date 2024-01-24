const d = document

d.addEventListener('change', e => {
    if (e.target.matches('input[type="file"]')) {
        let fileInput = e.target,
            file = fileInput.files[0],
            reader = new FileReader()

        reader.onload = event => {
            if (e.target.matches("#bannerImage")) {
                pageBanner = d.querySelector(".page-banner .banner-img-container")
                console.log(pageBanner)
                console.log(event.target.result)
                pageBanner.style.backgroundImage = `url(${event.target.result})`
            } else {
                imgElement = fileInput.nextElementSibling.firstElementChild
                imgElement.src = event.target.result
            }
        }
        reader.readAsDataURL(file)
    }
})

d.addEventListener("input", e => {
    pageTitle = d.querySelector(".page-title-container input")
    if (e.target === pageTitle) {
        let inputSize = pageTitle.value.length
        pageTitle.style.width = `${inputSize}ch`;

    }
})