// Imports
import EmailSubscriber from "../EmailSubscriber.js"
import BackToTopButton from "../BackToTopButton.js"

// Classes
document.addEventListener("DOMContentLoaded", () => {
  new EmailSubscriber("subscriberForm", "endpointHere")
  new BackToTopButton("backToTop")
})
