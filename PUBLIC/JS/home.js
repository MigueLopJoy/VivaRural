import { fetchHandler } from "./fetchHandler.js"
import {
    loadHtmlComponent
} from "./utils.js"

const d = document

d.addEventListener("DOMContentLoaded", async () => {
    await renderDestinations()
    await loadHtmlComponent("./HTML/auth.html", d.querySelector(".auth-container"))
    await loadHtmlComponent("./HTML/footer.html", d.querySelector("body"))
    notifyRegistrationSuccess()
})

const renderDestinations = async () => {
    let destinations = await getDestinations()
    for (let i = 0; i < destinations.length; i++) {
        let destinationsContainer = d.querySelector(".destinations .row"),
            destination = destinations[i],
            destinationTemplate = d.querySelector(".destination-template"),
            cardClone = d.importNode(destinationTemplate.content, true)

        cardClone.querySelector(".card-link").href = `./HTML/town-page.html?pageId=${destination.pageId}`
        cardClone.querySelector(".img-container img").src = `./../LIB/MEDIA/IMGS/${destination.thumbnail}`
        cardClone.querySelector(".img-container img").alt = `${destination.townName}`
        cardClone.querySelector(".destination-name").textContent = destination.townName

        destinationsContainer.appendChild(cardClone)
    }
}

const getDestinations = async () => {
    let url = "./../API/towns-service.php?get-destinations"
    return await fetchHandler(url)
}