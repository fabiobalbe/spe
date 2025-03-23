// Variável para rastrear alterações no formulário
let formAlterado = false;

// Seleciona apenas os campos dentro do formulário com id="form-paciente"
const campos = document.querySelectorAll("#form-paciente input, #form-paciente textarea, #form-paciente select");

// Adiciona listener de input apenas aos campos do formulário
campos.forEach((campo) => {
  campo.addEventListener("input", () => {
    formAlterado = true;
  });
});

// Listener para o evento beforeunload
window.addEventListener("beforeunload", function(event) {
  if (formAlterado) {
    event.preventDefault();
    event.returnValue = ""; // Dispara o alerta nativo do navegador
  }
});
