export default class EmailSubscriber {
  constructor(formId, endpoint) {
    this.form = document.getElementById(formId)
    this.endpoint = endpoint
    this.submitButton = this.form ? this.form.querySelector("button[type='submit']") : null
    this.lastSubmissionTime = 0
    this.throttleTime = 5000 // 5 seconds throttle
    this.submittedEmails = JSON.parse(localStorage.getItem("submittedEmails")) || []
    this.init()
  }

  init() {
    if (!this.form) {
      console.error("Form not found")
      return
    }
    this.form.addEventListener("submit", (event) => this.handleSubmit(event))
    this.addInputListener()
  }

  addInputListener() {
    const emailInput = this.form.querySelector("input[name='email']")
    if (emailInput && this.submitButton) {
      emailInput.addEventListener("keyup", () => {
        this.submitButton.disabled = !this.validateEmail(emailInput.value)
      })
      this.submitButton.disabled = true
    }
  }

  sanitize(input) {
    const div = document.createElement("div")
    div.textContent = input
    return div.innerHTML.trim()
  }

  validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return emailRegex.test(email)
  }

  async handleSubmit(event) {
    event.preventDefault()
    const emailInput = this.form.querySelector("input[name='email']")
    if (!emailInput) {
      console.error("Email input not found")
      return
    }

    const email = this.sanitize(emailInput.value)
    if (!this.validateEmail(email)) {
      alert("Please enter a valid email address.")
      return
    }

    if (this.submittedEmails.includes(email)) {
      alert("This email has already been submitted successfully.")
      return
    }

    const currentTime = Date.now()
    if (currentTime - this.lastSubmissionTime < this.throttleTime) {
      alert("You are submitting too quickly. Please wait a moment.")
      return
    }
    this.lastSubmissionTime = currentTime

    // Take out after testing
    this.submittedEmails.push(email)
    console.log(email, currentTime, this.submittedEmails)

    // try {
    //     const response = await fetch(this.endpoint, {
    //         method: "POST",
    //         headers: {
    //             "Content-Type": "application/x-www-form-urlencoded",
    //         },
    //         body: new URLSearchParams({ email }),
    //     });

    //     const result = await response.text();
    //     alert(result);
    //     this.submittedEmails.push(email);
    //     localStorage.setItem("submittedEmails", JSON.stringify(this.submittedEmails));
    // } catch (error) {
    //     console.error("Error submitting form", error);
    // }
  }
}
