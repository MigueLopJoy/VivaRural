import { fetchHandler } from "./fetchHandler.js"
import { loadHtmlComponent } from "./layers.js"

const d = document,
    body = d.querySelector("body"),
    commentsForm = d.querySelector(".comments-form")

d.addEventListener("DOMContentLoaded", async e => {
    let pageId = getPageId(),
        pageInfo = await getTownPageInfo(pageId)
    await renderBanner(pageInfo)
    await renderArticles(pageInfo)
    await loadHtmlComponent("./footer.html", body)
})

d.addEventListener("sumbit", e => {
    if (e.target === commentsForm) {
        let comment = {
            rating: commentsForm.rating.value,
            userId: 1,
            comment: commentsForm.comment.value
        }

    }
})

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








