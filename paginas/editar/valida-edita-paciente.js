document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-paciente");
  const salvarBtn = document.getElementById("salvar-btn");

  // Lista de campos que serão validados
  const fields = ["id", "nome", "data-nascimento", "sexo", "fator-rh", "cpf", "email", "tel"];

  // Armazena os valores iniciais do formulário
  const initialData = new FormData(form);

  // Função para verificar se houve alterações no formulário
  const checkFormChanges = () => {
    const currentData = new FormData(form);
    // Verifica se algum campo teve seu valor alterado
    const formChanged = [...initialData.entries()].some(([key, value]) => currentData.get(key) !== value);
    // Habilita o botão somente se houver mudanças e se o formulário for válido
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
      // Verifica com a API se o CPF é válido
      const cpfResponse = await fetch(`../../api/api-valida-cpf.php?cpf=${encodeURIComponent(cpf.value)}`);
      const { isValid } = await cpfResponse.json();

      // Condiciona a reposta da API
      if (!isValid) return setValidationState(cpf, false);

      // Verifica com API se o CPF já está cadastrado
      const existsResponse = await fetch(`../../api/api-existe-cpf.php?cpf=${encodeURIComponent(cpf.value)}`);
      const { existe: cpfExists } = await existsResponse.json();

      // Verifica com API se CPF já pertence ao usuário
      const idResponse = await fetch(`../../api/api-id-cpf.php?cpf=${encodeURIComponent(cpf.value)}`);
      const { id: existingId } = await idResponse.json();

      // Condiciona as respostas da API
      if (cpfExists && existingId != id.value) return setValidationState(cpf, false);

    } catch (error) {
      console.error("Erro ao validar CPF:", error);
      setValidationState(cpf, false);
    }
  };

  // Validação de email apenas se estiver preenchido
  const validateEmail = (email) => {
    if (!email.value.trim()) return setValidationState(email, true); // Se estiver vazio, é válido
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

  // Evento acionado ao submeter o formulário
  form.addEventListener("submit", async (event) => {
    event.preventDefault(); // Impede o envio imediato do formulário

    // Obtém os elementos do formulário
    const elements = Object.fromEntries(fields.map(id => [id, document.getElementById(id)]));

    let isValid = true;
    isValid &= validateField(elements.nome, elements.nome.value.trim().length >= 3); // Nome com pelo menos 3 caracteres
    isValid &= validateField(elements["data-nascimento"], !!elements["data-nascimento"].value); // Data de nascimento preenchida
    isValid &= validateField(elements.sexo, elements.sexo.value !== ""); // Sexo selecionado
    isValid &= validateField(elements["fator-rh"], elements["fator-rh"].value !== ""); // Fator RH selecionado
    validateEmail(elements.email); // Apenas valida se estiver preenchido

    // Validações assíncronas (CPF e telefone)
    await Promise.all([
      validateCPF(elements.cpf, elements.id),
      validateTel(elements.tel)
    ]);

    // Se todas as validações passarem, submete o formulário
    if (isValid) form.submit();
    else form.classList.add("was-validated");
  });
});
