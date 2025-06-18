export function toggleMenu() {
  const nav = document.querySelector(".mainNavigation ul")
  nav.classList.toggle("active")
}

export function initializeNavigation() {
  document.addEventListener("DOMContentLoaded", () => {
    const hamburger = document.querySelector(".hamburger")
    if (hamburger) {
      hamburger.addEventListener("click", toggleMenu)
    }
  })
}
