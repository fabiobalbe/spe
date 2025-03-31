document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-paciente");
  const salvarBtn = document.getElementById("salvar-btn");

  // Lista de campos que serão validados
  const fields = ["nome", "data-nascimento", "sexo", "fator-rh", "cpf", "email", "tel"];

  // Armazena os valores iniciais do formulário
  const initialData = new FormData(form);

  // Função para verificar se houve alterações no formulário
  const checkFormChanges = () => {
    const currentData = new FormData(form);
    const formChanged = [...initialData.entries()].some(([key, value]) => currentData.get(key) !== value);
    salvarBtn.disabled = !(formChanged && form.checkValidity());
  };

  form.addEventListener("input", checkFormChanges);
  form.addEventListener("change", checkFormChanges);

  const setValidationState = (element, isValid) => {
    element.classList.toggle("is-invalid", !isValid);
    element.classList.toggle("is-valid", isValid);
  };

  const validateField = (field, condition) => {
    setValidationState(field, condition);
    return condition;
  };

  // Validação do CPF sem a última etapa
  const validateCPF = async (cpf) => {
    if (!cpf.value.trim()) return setValidationState(cpf, true);

    try {
      const cpfResponse = await fetch(`../../api/api-valida-cpf.php?cpf=${encodeURIComponent(cpf.value)}`);
      const { isValid } = await cpfResponse.json();
      if (!isValid) return setValidationState(cpf, false);

      const existsResponse = await fetch(`../../api/api-existe-cpf.php?cpf=${encodeURIComponent(cpf.value)}`);
      const { existe: cpfExists } = await existsResponse.json();
      if (cpfExists) return setValidationState(cpf, false);
    } catch (error) {
      console.error("Erro ao validar CPF:", error);
      setValidationState(cpf, false);
    }
  };

  const validateEmail = (email) => {
    if (!email.value.trim()) return setValidationState(email, true);
    return validateField(email, /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email.value));
  };

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

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    const elements = Object.fromEntries(fields.map(id => [id, document.getElementById(id)]));

    let isValid = true;
    isValid &= validateField(elements.nome, elements.nome.value.trim().length >= 3);
    isValid &= validateField(elements["data-nascimento"], !!elements["data-nascimento"].value);
    isValid &= validateField(elements.sexo, elements.sexo.value !== "");
    isValid &= validateField(elements["fator-rh"], elements["fator-rh"].value !== "");
    validateEmail(elements.email);

    await Promise.all([
      validateCPF(elements.cpf),
      validateTel(elements.tel)
    ]);

    if (isValid) form.submit();
    else form.classList.add("was-validated");
  });
});
