// Trie Dynamique
const searchInput = document.querySelector("#book-search");
const bookCards = document.querySelectorAll(".book-card");
const noResultMessage = document.querySelector("#books-no-result");

/**
 * Normalise une chaîne afin de faciliter la recherche.
 * Exemple :
 * "Été" devient "ete".
 */
function normalizeText(text) {
  return text
    .toLowerCase()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "");
}

searchInput.addEventListener("input", function () {
  const search = normalizeText(this.value.trim());

  let visibleBooks = 0;

  bookCards.forEach(function (bookCard) {
    const title = normalizeText(bookCard.dataset.title);
    const author = normalizeText(bookCard.dataset.author);

    const matchesSearch = title.includes(search) || author.includes(search);

    if (matchesSearch) {
      bookCard.style.display = "";
      visibleBooks++;
    } else {
      bookCard.style.display = "none";
    }
  });

  // Affiche le message uniquement si aucun livre ne correspond.
  noResultMessage.hidden = visibleBooks !== 0;
});