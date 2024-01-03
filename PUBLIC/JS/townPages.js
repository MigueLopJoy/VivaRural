import { fetchHandler } from "./fetchHandler.js"
import { getCookie, loadHtmlComponent } from "./utils.js"

const d = document,
    body = d.querySelector("body")

d.addEventListener("DOMContentLoaded", async e => {
    let pageId = getPageId(),
        pageInfo = await getTownPageInfo(pageId)
    await renderBanner(pageInfo)
    await renderArticles(pageInfo)
    await handleCommentsSection(pageId)
    await loadHtmlComponent("./auth.html", d.querySelector(".auth-container"))
    await loadHtmlComponent("./footer.html", body)
})

d.addEventListener("submit", e => {
    e.preventDefault()
    if (e.target.matches(".comments-form")) {
        saveComment(e.target)
    }
})

const saveComment = commentsForm => {
    let pageId = getPageId(),
        comment = {
            rating: commentsForm.rating.value,
            pageId,
            userId: 1,
            comment: commentsForm.comment.value
        }

    console.log(comment)

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
    let url = `./../../API/pages-service.php?get-page=${pageId}`,
        comments = await fetchHandler(url)

    if (comments.length > 0) {
        let commentsContainer = d.querySelector(".comments-container")
        for (let i = 0; i < comments.length; i++) {
            let comment = comments[i],
                commentTemplate = d.querySelector(".comment-template"),
                commentClone = d.importNode(commentTemplate.content, true)
            commentsContainer.appendChild(commentClone)
            renderCommentContent(comment)
        }
    } else {
        console.log("NO HAY COMENTARIOS")
    }
}

const renderCommentContent = comment => {
    let commentHTML = d.querySelector(".comments-containert").lastElementChild
    commentHTML.querySelector(".comment-author").textContent = `${comment.firstname} ${comment.lastname}`
    commentHTML.querySelector(".comment-text").textContent = comment.commentText
    let commentStars = commentHTML.querySelectorAll(".comment-rating .star")
    for (let i = 0; i < comment.rating; i++) {
        commentStars[i].classList.add("active")
    }
}

const enableUsersRating = () => {
    const ratingLabels = document.querySelectorAll('.rating label')

    for (let i = 0; i < ratingLabels.length; i++) {
        let label = ratingLabels[i]
        console.log(label)
        label.addEventListener('click', e => {
            console.log(e.target)
            const selectedRating = label.previousElementSibling.value
            console.log('Valoración seleccionada:', selectedRating)
        })
    }
    d.addEventListener("click", e => {
        console.log(e.target)
    })
}