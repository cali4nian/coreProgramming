import { stylesheet, homePageStyles, servicesPageStyles, downloadsPageStyles, mainContentContainer } from "./variables.js"
import { homePageContent, servicesPageContent, downloadsPageContent } from "./htmlSnippets.js"

class Navigation {
  consturctor() {
    this.updateDOM(homePageContent, homePageStyles)
    this.showActiveBtns(["homeBtn", "homeFooterBtn"])
    this.events()
  }

  events() {
    // Main Nav Buttons
    document.getElementById("homeBtn").addEventListener("click", (e) => this.changeContent(e))
    document.getElementById("servicesBtn").addEventListener("click", (e) => this.changeContent(e))
    document.getElementById("downloadsBtn").addEventListener("click", (e) => this.changeContent(e))
    // Footer Buttons
    document.getElementById("homeFooterBtn").addEventListener("click", (e) => this.changeContent(e))
    document.getElementById("servicesFooterBtn").addEventListener("click", (e) => this.changeContent(e))
    document.getElementById("downloadsFooterBtn").addEventListener("click", (e) => this.changeContent(e))
  }

  // Methods
  changeContent(e) {
    switch (e.target.id) {
      case "homeBtn":
      case "homeFooterBtn":
        this.updateDOM(homePageContent, homePageStyles)
        this.showActiveBtns(["homeBtn", "homeFooterBtn"])
        break
      case "servicesBtn":
      case "servicesFooterBtn":
        this.updateDOM(servicesPageContent, servicesPageStyles)
        this.showActiveBtns(["servicesBtn", "servicesFooterBtn"])
        break
      case "downloadsBtn":
      case "downloadsFooterBtn":
        this.updateDOM(downloadsPageContent, downloadsPageStyles)
        this.showActiveBtns(["downloadsBtn", "downloadsFooterBtn"])
        break

      default:
        this.updateDOM(homePageContent, homePageStyles)
        break
    }
  }

  updateDOM(pageContent, stylesheetURL) {
    mainContentContainer.innerHTML = pageContent
    stylesheet.href = stylesheetURL
    window.scrollTo({ top: 0, behavior: "smooth" })
  }

  showActiveBtns(btnArray) {
    const buttons = document.getElementsByTagName("button")
    const buttonArray = Array.from(buttons)
    buttonArray.forEach((button) => {
      button.style.color = "#f97316"
    })
    btnArray.forEach((button) => {
      document.getElementById(button).style.color = "#FBBF24"
    })
    if (document.querySelector("#root > section > button")) document.querySelector("#root > section > button").style.color = "#000"
  }
}

export default Navigation
