import { currentYear, currentYearSpan } from "./variables.js"
import Navigation from "./navigation.js"
function start() {
  const navigation = new Navigation()
  navigation.consturctor()
  currentYearSpan.innerHTML = currentYear
}
start()
