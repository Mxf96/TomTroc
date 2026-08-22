// ===========================
// APERÇU IMAGE AJOUT LIVRE
// ===========================

const imageInput = document.getElementById("image");
const imagePreview = document.getElementById("add-book-image-preview");
const imagePlaceholder = document.getElementById("add-book-image-placeholder");

if (imageInput && imagePreview && imagePlaceholder) {
  imageInput.addEventListener("change", function () {
    const file = this.files[0];

    if (!file) {
      imagePreview.removeAttribute("src");
      imagePreview.style.display = "none";
      imagePlaceholder.style.display = "flex";

      return;
    }

    // Vérifie qu'il s'agit bien d'une image
    if (!file.type.startsWith("image/")) {
      return;
    }

    const reader = new FileReader();

    reader.addEventListener("load", function () {
      imagePreview.src = reader.result;

      imagePlaceholder.style.display = "none";
      imagePreview.style.display = "block";
    });

    reader.readAsDataURL(file);
  });
}