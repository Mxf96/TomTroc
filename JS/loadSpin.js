// Roue de chargement
const loader = document.getElementById("pageLoader");
const content = document.getElementById("pageContent");

// Cache le loader
function hideLoader() {
  setTimeout(() => {
    loader.classList.add("page-loader--hidden");
    content.classList.add("page-content--visible");
  }, 100);
}

// pageshow fonctionne aussi lors d'un retour arrière
window.addEventListener("pageshow", () => {
  hideLoader();
});

// Affiche le loader lors d'une navigation
document.querySelectorAll("a").forEach((link) => {
  link.addEventListener("click", (event) => {
    const href = link.getAttribute("href");

    // Ignore les liens qui ne changent pas réellement de page
    if (
      !href ||
      href.startsWith("#") ||
      href.startsWith("javascript:") ||
      link.target === "_blank" ||
      event.ctrlKey ||
      event.metaKey ||
      event.shiftKey
    ) {
      return;
    }

    loader.classList.remove("page-loader--hidden");
  });
});