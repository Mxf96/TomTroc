// Menu Burger
const burgerButton = document.querySelector(".burger-button");
const mobileMenu = document.querySelector(".mobile-menu");

burgerButton.addEventListener("click", () => {
  burgerButton.classList.toggle("active");
  mobileMenu.classList.toggle("active");

  const isOpen = mobileMenu.classList.contains("active");

  burgerButton.setAttribute("aria-expanded", isOpen);
});