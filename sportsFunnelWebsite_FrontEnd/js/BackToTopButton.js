export default class BackToTopButton {
  constructor(buttonId) {
    this.button = document.getElementById(buttonId)
    this.scrollThreshold = 300 // Show button after 300px of scroll
    this.init()
  }

  init() {
    if (!this.button) {
      console.error("Back to Top button not found.")
      return
    }
    // Scroll event listener
    window.addEventListener("scroll", () => this.toggleButton())
    // Click event listener
    this.button.addEventListener("click", () => this.scrollToTop())
  }

  toggleButton() {
    if (window.scrollY > this.scrollThreshold) {
      this.button.classList.add("show")
    } else {
      this.button.classList.remove("show")
    }
  }

  scrollToTop() {
    window.scrollTo({ top: 0, behavior: "smooth" })
  }
}
