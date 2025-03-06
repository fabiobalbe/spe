document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("form-paciente");

  form.addEventListener("submit", function(event) {
    let isValid = true;

    let nome = document.getElementById("nome");
    let nascimento = document.getElementById("data-nascimento");
    let sexo = document.getElementById("sexo");
    let fatorRh = document.getElementById("fator-rh");

    // Validação do Nome
    if (nome.value.trim().length < 3) {
      nome.classList.add("is-invalid");
      isValid = false;
    } else {
      nome.classList.remove("is-invalid");
      nome.classList.add("is-valid");
    }

    // Validação da Data de Nascimento
    if (!nascimento.value) {
      nascimento.classList.add("is-invalid");
      isValid = false;
    } else {
      nascimento.classList.remove("is-invalid");
      nascimento.classList.add("is-valid");
    }

    // Validação do Sexo
    if (sexo.value === "") {
      sexo.classList.add("is-invalid");
      isValid = false;
    } else {
      sexo.classList.remove("is-invalid");
      sexo.classList.add("is-valid");
    }

    // Validação do Fator RH
    if (fatorRh.value === "") {
      fatorRh.classList.add("is-invalid");
      isValid = false;
    } else {
      fatorRh.classList.remove("is-invalid");
      fatorRh.classList.add("is-valid");
    }

    // Se algum campo for inválido, impede o envio do formulário
    if (!isValid) {
      event.preventDefault();
      event.stopPropagation();
    }

    form.classList.add("was-validated");
  });
});
