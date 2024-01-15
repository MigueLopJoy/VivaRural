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
            rating: commentsForm.ratingValue.value,
            pageId: getPageId(),
            userId: getCookie('userId'),
            commentText: commentsForm.commentText.value
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
        pageId = urlParams.get('pageId')
    return pageId
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
    bannerClone.querySelector(".page-title-container h2").textContent += pageInfo.townName

    bannerContainer.appendChild(bannerClone)
}

const renderArticles = async pageInfo => {
    let articles = pageInfo.articles
    for (let i = 0; i < articles.length; i++) {
        let articlesContainer = d.querySelector(".articles-section .articles-container"),
            article = articles[i],
            articleTemplate,
            templateType = article.templateType

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
            elementReference = element.elementReference

        if (elementReference === 'article-image') {
            article.querySelector(`.${elementReference}`).src = `./../../LIB/MEDIA/IMGS/${element.elementContent}`
        } else {
            article.querySelector(`.${elementReference}`).textContent = element.elementContent
        }
    }
}

const handleCommentsSection = async pageId => {
    let commentsSection = d.querySelector(".comments-container")
    if (getCookie("userId") !== null) {
        await loadHtmlComponent("./comments.html", commentsSection)
        enableUsersRating()
        await renderComments(pageId)
    } else {
        d.querySelector(".ask-for-login").classList.remove("d-none")
    }
}

const renderComments = async pageId => {
    let url = `./../../API/pages-service.php?get-comments&pageId=${pageId}`,
        comments = await fetchHandler(url)

    if (comments.length > 0) {
        let commentsWindow = d.querySelector(".comments-window")
        for (let i = 0; i < comments.length; i++) {
            let comment = comments[i],
                commentTemplate = d.querySelector(".comment-template"),
                commentClone = d.importNode(commentTemplate.content, true)
            commentsWindow.appendChild(commentClone)
            renderCommentContent(comment)
        }
    } else {
        console.log("No hay comentarios")
    }
}

const renderCommentContent = comment => {
    let commentsWindow = d.querySelector(".comments-window")
    if (commentsWindow) {
        let commentHTML = d.querySelector(".comments-window").lastElementChild
        commentHTML.querySelector(".comment-author").textContent = `${comment.firstname} ${comment.lastname}`
        commentHTML.querySelector(".comment-text").textContent = comment.commentText
        let commentStars = commentHTML.querySelectorAll(".comment-rating .rating-star")
        for (let i = 0; i < comment.rating; i++) {
            commentStars[i].classList.add("active")
        }
    }
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