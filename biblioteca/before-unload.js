window.addEventListener("beforeunload", function(event) {
  if (formAlterado) {
    event.preventDefault();
    event.returnValue = ""; // Depreciado mas e o que tem.
  }
});

let formAlterado = false;

// Marca o formulário como alterado quando o usuário digita algo
document.querySelectorAll("input, textarea, select").forEach((campo) => {
  campo.addEventListener("input", () => {
    formAlterado = true;
  });
});
