// ===========================
// APERÇU IMAGE MODIFICATION LIVRE
// ===========================

const editBookImageInput = document.getElementById("image");
const editBookImagePreview = document.getElementById("bookImagePreview");

if (editBookImageInput && editBookImagePreview) {
  editBookImageInput.addEventListener("change", function () {
    const file = this.files[0];

    if (!file) {
      return;
    }

    // Vérifie que le fichier sélectionné est une image
    if (!file.type.startsWith("image/")) {
      return;
    }

    const reader = new FileReader();

    reader.addEventListener("load", function () {
      editBookImagePreview.src = reader.result;
    });

    reader.readAsDataURL(file);
  });
}