document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("form-paciente");
  const salvarBtn = document.getElementById("salvar-btn");

  // Armazena os valores iniciais do formulário
  const initialData = new FormData(form);

  // Função para verificar se houve alterações e se o formulário é válido
  function checkFormChanges() {
    const currentData = new FormData(form);
    let formChanged = false;

    // Compara os valores iniciais com os atuais
    for (let [key, value] of initialData.entries()) {
      if (currentData.get(key) !== value) {
        formChanged = true;
        break;
      }
    }

    // Verifica se o formulário é válido (usando a API de validação HTML5)
    const isValid = form.checkValidity();
    salvarBtn.disabled = !(formChanged && isValid);
  }

  // Adiciona eventos de mudança a todos os campos do formulário
  form.addEventListener("input", checkFormChanges);
  form.addEventListener("change", checkFormChanges); // Para selects e outros elementos

  form.addEventListener("submit", function(event) {
    let isValid = true;

    const nome = document.getElementById("nome");
    const nascimento = document.getElementById("data-nascimento");
    const sexo = document.getElementById("sexo");
    const fatorRh = document.getElementById("fator-rh");
    const cpf = document.getElementById("cpf");
    const email = document.getElementById("email"); // Corrigido: declarado aqui
    const tel = document.getElementById("tel");

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
      let cpfPromise = fetch("../../api/api-valida-cpf.php?cpf=" + encodeURIComponent(cpf.value))
        .then(response => response.json())
        .then(data => {
          if (!data.isValid) {
            cpf.classList.add("is-invalid");
            isValid = false;
          } else {
            return fetch("../../api/api-existe-cpf.php?cpf=" + encodeURIComponent(cpf.value))
              .then(response => response.json())
              .then(data => {
                if (data.isValid) {
                  cpf.classList.add("is-invalid");
                  isValid = false;
                } else {
                  cpf.classList.remove("is-invalid");
                  cpf.classList.add("is-valid");
                }
              });
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
    if (email.value.trim() !== "") {
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
    }

    // Validação do Telefone
    if (tel.value.trim() !== "") {
      let telPromise = fetch("../../api/api-valida-tel.php?tel=" + encodeURIComponent(tel.value))
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

    // Espera todas as validações assíncronas
    event.preventDefault(); // Impede o envio até que as validações assíncronas terminem
    Promise.all(promises).then(() => {
      if (isValid) {
        form.submit(); // Envia o formulário se tudo for válido
      } else {
        form.classList.add("was-validated");
      }
    });
  });
});
