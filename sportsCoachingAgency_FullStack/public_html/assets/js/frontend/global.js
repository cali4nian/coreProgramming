import { initializeNavigation } from "./navigation.js"
import BackToTopButton from "../BackToTopButton.js"

// Initialize the navigation
initializeNavigation()

// Classes
document.addEventListener("DOMContentLoaded", () => {
  new BackToTopButton("backToTop")
})
