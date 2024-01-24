import { fetchHandler, getRequestData } from "./fetchHandler.js"
import { getCookie, loadHtmlComponent } from "./utils.js"
import { notifyRegistrationSuccess } from "./auth.js"

const d = document,
    body = d.querySelector("body")

d.addEventListener("DOMContentLoaded", async e => {
    let pageId = getPageId(),
        pageInfo = await getTownPageInfo(pageId)
    await renderBanner(pageInfo)
    await renderArticles(pageInfo)
    await loadHtmlComponent("./auth.html", d.querySelector(".auth-container"))
    await handleCommentsSection(pageId)
    await loadHtmlComponent("./footer.html", body)
    notifyRegistrationSuccess()
})

d.addEventListener("submit", e => {
    e.preventDefault()
    if (e.target.matches(".comments-form")) {
        saveComment(e.target)
    }
})

const saveComment = async commentsForm => {
    let url = `./../../API/pages-service.php?save-comment`,
        comment = JSON.stringify({
            rating: commentsForm.rating.value,
            page: getPageId(),
            user: getCookie('userId'),
            text: commentsForm.text.value
        })
    try {
        let commentResult = await fetchHandler(url, getRequestData("POST", comment))
        if (commentResult) location.href = location.href
    } catch (error) {
        console.log(error)
    }

}

const getPageId = () => {
    let values = window.location.search,
        urlParams = new URLSearchParams(values),
        id = urlParams.get('id')
    return id
}

const getTownPageInfo = async pageId => {
    let url = `./../../API/pages-service.php?get-page=${pageId}`
    return await fetchHandler(url)
}

const renderBanner = async pageInfo => {
    let bannerContainer = d.querySelector(".page-section.page-banner"),
        bannerTemplate = d.querySelector(".banner-template"),
        bannerClone = d.importNode(bannerTemplate.content, true)

    bannerClone.querySelector(".banner-img-container").style.backgroundImage = `url(./../../LIB/MEDIA/IMGS/${pageInfo.bannerImage})`
    bannerClone.querySelector(".page-title-container h2").textContent += pageInfo.town

    bannerContainer.appendChild(bannerClone)
}

const renderArticles = async pageInfo => {
    let articles = pageInfo.articles
    for (let i = 0; i < articles.length; i++) {
        let articlesContainer = d.querySelector(".articles-section .articles-container"),
            article = articles[i],
            articleTemplate,
            templateType = article.template

        switch (templateType) {
            case "1":
                articleTemplate = d.querySelector(".article-template-1")
                break;
            case "2":
                articleTemplate = d.querySelector(".article-template-2")
                break;
        }
        let articleClone = d.importNode(articleTemplate.content, true)
        articlesContainer.appendChild(articleClone)
        renderArticleContent(article.elements)
    }
}

const renderArticleContent = articleElements => {
    for (let i = 0; i < articleElements.length; i++) {
        let article = d.querySelector(".articles-section .articles-container").lastElementChild,
            element = articleElements[i],
            elementReference = element.reference

        if (elementReference === 'article-image') {
            article.querySelector(`.${elementReference}`).src = `./../../LIB/MEDIA/IMGS/${element.content}`
        } else {
            article.querySelector(`.${elementReference}`).textContent = element.content
        }
    }
}

const handleCommentsSection = async pageId => {
    let commentsSection = d.querySelector(".comments-container")
    if (getCookie("userId")) {
        await loadHtmlComponent("./comments.html", commentsSection)
        enableUsersRating()
        await renderComments(pageId)
        await getTownRating(pageId)
    } else {
        d.querySelector(".ask-for-login").classList.remove("d-none")
    }
}

const renderComments = async (pageId) => {
    let url = `./../../API/pages-service.php?get-comments&id=${pageId}`,
        comments = await fetchHandler(url)

    if (comments.length > 0) {
        let commentsWindow = d.querySelector(".comments-window")

        for (let i = 0; i < comments.length; i++) {
            let comment = comments[i]
            let commentContainer = document.createElement("div")
            commentContainer.classList.add("col-4")

            let commentCard = document.createElement("div")
            commentCard.classList.add("comment-card", "p-3", "mb-3", "rounded", "shadow")

            let commentRating = document.createElement("div")
            commentRating.classList.add("comment-rating", "mb-2")
            for (let j = 0; j < 5; j++) {
                let star = document.createElement("span")
                star.classList.add("rating-star")
                if (j < comment.rating) {
                    star.classList.add("active")
                }
                star.textContent = "★"
                commentRating.appendChild(star)
            }

            let commentAuthor = document.createElement("h5")
            commentAuthor.classList.add("comment-author", "mb-2")
            commentAuthor.textContent = `${comment.firstname} ${comment.lastname}`

            let commentText = document.createElement("p")
            commentText.classList.add("comment-text", "mb-2")
            commentText.textContent = comment.text

            commentCard.appendChild(commentRating)
            commentCard.appendChild(commentAuthor)
            commentCard.appendChild(commentText)
            commentContainer.appendChild(commentCard)

            commentsWindow.appendChild(commentContainer)
        }
    } else {
        console.log("No hay comentarios")
    }
}

const getTownRating = async pageId => {
    let url = `./../../API/pages-service.php?get-rating&id=${pageId}`,
        averageRating = await fetchHandler(url),
        roundedValue = Math.round(averageRating * 10) / 10,
        averageRatingSpan = d.querySelector(".average-rating")
    averageRatingSpan.textContent = `${roundedValue}/5`;
}

const enableUsersRating = () => {
    d.addEventListener("click", e => {
        if (e.target.matches(".rating .rating-star")) {
            let ratingValueInput = d.querySelector(".rating-value"),
                stars = d.querySelectorAll(".rating .rating-star"),
                starValue = e.target.getAttribute("value")
            for (let i = 0; i < stars.length; i++) {
                if (stars[i].classList.contains("active")) {
                    stars[i].classList.remove("active")
                }
            }
            for (let i = 1; i <= starValue; i++) {
                stars[stars.length - i].classList.add("active")
            }
            ratingValueInput.value = starValue
        }
    })
}

export { getPageId }