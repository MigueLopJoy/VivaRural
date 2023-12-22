const d = document
    
d.addEventListener('change', e => {
    if (e.target.matches('input[type="file"]')) {
        let fileInput = e.target,
        imgElement = fileInput.nextElementSibling.firstElementChild
        file = fileInput.files[0],
        reader = new FileReader()

        reader.onload = e => {
            imgElement.src = e.target.result
        }
        reader.readAsDataURL(file)
    }
})

d.addEventListener("click", e => {
    if (e.target.matches(".save-content-btn button")) {
        let article = e.target.parentElement.parentElement,
            articleId = article.getAttribute("articleiD"),
            imageUrl = article.querySelector(".editable-image").src,
            articleTitle = article.querySelector(".article-title").textContent,
            articleText = article.querySelector(".article-text").textContent,
            url = `?handle-article&edit-article='${articleId}`,
            requestBody = {
                "image-url": imageUrl,
                "article-title": articleTitle,
                "article-text": articleText
            }, 
            options = {
                method: 'POST',  
                headers: {
                    'Content-Type': 'application/json'  
                },
                body: JSON.stringify(requestBody) 
            }
        fetch(url, options)
    }
})