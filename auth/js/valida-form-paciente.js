document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("form-paciente");

  form.addEventListener("submit", function(event) {
    event.preventDefault();
    event.stopPropagation();

    let isValid = true;

    let nome = document.getElementById("nome");
    let nascimento = document.getElementById("data-nascimento");
    let sexo = document.getElementById("sexo");
    let fatorRh = document.getElementById("fator-rh");
    let cpf = document.getElementById("cpf");
    let tel = document.getElementById("tel");

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

    // Criar promessas de validação assíncrona
    let promises = [];

    // Validação do CPF
    if (cpf.value.trim() !== "") {
      let cpfPromise = fetch("../api/api-valida-cpf.php?cpf=" + encodeURIComponent(cpf.value))
        .then(response => response.json())
        .then(data => {
          if (!data.isValid) {
            cpf.classList.add("is-invalid");
            isValid = false;
          } else {
            cpf.classList.remove("is-invalid");
            cpf.classList.add("is-valid");
          }
        })
        .catch(error => {
          console.error("Erro ao validar CPF:", error);
          cpf.classList.add("is-invalid");
          isValid = false;
        });
      promises.push(cpfPromise);
    } else {
      cpf.classList.remove("is-invalid");
      cpf.classList.add("is-valid");
    }

    // Validação do Email
    function isEmailValid(email) {
      const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      return regex.test(email);
    }
    if (!isEmailValid(email.value)) {
      email.classList.add("is-invalid");
      isValid = false;
    } else {
      email.classList.remove("is-invalid");
      email.classList.add("is-valid");
    }

    // Validação do Telefone
    if (tel.value.trim() !== "") {
      let telPromise = fetch("../api/api-valida-tel.php?tel=" + encodeURIComponent(tel.value))
        .then(response => response.json())
        .then(data => {
          if (!data.isValid) {
            tel.classList.add("is-invalid");
            tel.classList.remove("is-valid");
            isValid = false;
          } else {
            tel.classList.remove("is-invalid");
            tel.classList.add("is-valid");
          }
        })
        .catch(error => {
          console.error("Erro ao validar Telefone:", error);
          tel.classList.add("is-invalid");
          isValid = false;
        });
      promises.push(telPromise);
    } else {
      tel.classList.remove("is-invalid");
      tel.classList.add("is-valid");
    }

    // Espera todas as validações assíncronas antes de submeter o formulário
    Promise.all(promises).then(() => {
      if (isValid) {
        form.submit();
      }
    });

    form.classList.add("was-validated");
  });
});
