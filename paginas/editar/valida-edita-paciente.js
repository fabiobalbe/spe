document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-paciente");
  const salvarBtn = document.getElementById("salvar-btn");
  let clickedButton = null; // Variável para armazenar o botão clicado

  // Lista de campos que serão validados
  const fields = ["id", "nome", "data-nascimento", "sexo", "fator-rh", "cpf", "email", "tel"];

  // Armazena os valores iniciais do formulário
  const initialData = new FormData(form);

  // Função para verificar se houve alterações no formulário
  const checkFormChanges = () => {
    const currentData = new FormData(form);
    const formChanged = [...initialData.entries()].some(([key, value]) => currentData.get(key) !== value);
    salvarBtn.disabled = !(formChanged && form.checkValidity());
  };

  // Adiciona eventos para detectar mudanças no formulário
  form.addEventListener("input", checkFormChanges);
  form.addEventListener("change", checkFormChanges);

  // Função para adicionar ou remover classes de validação
  const setValidationState = (element, isValid) => {
    element.classList.toggle("is-invalid", !isValid);
    element.classList.toggle("is-valid", isValid);
  };

  // Função para validar campos individuais
  const validateField = (field, condition) => {
    setValidationState(field, condition);
    return condition;
  };

  // Validação do CPF com verificações assíncronas
  const validateCPF = async (cpf, id) => {
    if (!cpf.value.trim()) return setValidationState(cpf, true);
    try {
      const cpfResponse = await fetch(`../../api/api-valida-cpf.php?cpf=${encodeURIComponent(cpf.value)}`);
      const { isValid } = await cpfResponse.json();
      if (!isValid) return setValidationState(cpf, false);

      const existsResponse = await fetch(`../../api/api-existe-cpf.php?cpf=${encodeURIComponent(cpf.value)}`);
      const { existe: cpfExists } = await existsResponse.json();

      const idResponse = await fetch(`../../api/api-id-cpf.php?cpf=${encodeURIComponent(cpf.value)}`);
      const { id: existingId } = await idResponse.json();

      if (cpfExists && existingId != id.value) return setValidationState(cpf, false);
    } catch (error) {
      console.error("Erro ao validar CPF:", error);
      setValidationState(cpf, false);
    }
  };

  // Validação de email apenas se estiver preenchido
  const validateEmail = (email) => {
    if (!email.value.trim()) return setValidationState(email, true);
    return validateField(email, /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email.value));
  };

  // Validação do telefone com verificação assíncrona
  const validateTel = async (tel) => {
    if (!tel.value.trim()) return setValidationState(tel, true);
    try {
      const response = await fetch(`../../api/api-valida-tel.php?tel=${encodeURIComponent(tel.value)}`);
      const { isValid } = await response.json();
      setValidationState(tel, isValid);
    } catch (error) {
      console.error("Erro ao validar Telefone:", error);
      setValidationState(tel, false);
    }
  };

  // Captura o botão clicado
  form.querySelectorAll('button[type="submit"]').forEach(button => {
    button.addEventListener('click', (e) => {
      clickedButton = e.target; // Armazena o botão clicado
    });
  });

  // Evento acionado ao submeter o formulário
  form.addEventListener("submit", async (event) => {
    event.preventDefault(); // Impede o envio imediato do formulário

    // Obtém os elementos do formulário
    const elements = Object.fromEntries(fields.map(id => [id, document.getElementById(id)]));

    let isValid = true;
    isValid &= validateField(elements.nome, elements.nome.value.trim().length >= 3);
    isValid &= validateField(elements["data-nascimento"], !!elements["data-nascimento"].value);
    isValid &= validateField(elements.sexo, elements.sexo.value !== "");
    isValid &= validateField(elements["fator-rh"], elements["fator-rh"].value !== "");
    validateEmail(elements.email);

    // Validações assíncronas (CPF e telefone)
    await Promise.all([
      validateCPF(elements.cpf, elements.id),
      validateTel(elements.tel)
    ]);

    // Se todas as validações passarem, adiciona o valor do botão clicado e submete
    if (isValid) {
      if (clickedButton) {
        const acao = clickedButton.value; // Pega o valor do botão clicado
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'acao';
        hiddenInput.value = acao;
        form.appendChild(hiddenInput); // Adiciona ao formulário
      }
      form.submit(); // Envia o formulário
    } else {
      form.classList.add("was-validated");
    }
  });
});
