const validation = new JustValidate("#signup");

validation
  .addField("#nome", [
    {
      rule: "required"
    }
  ])

  .addField("#email", [
    {
      rule: "required"
    },
    {
      rule: "email"
    }
  ])


  .addField("#senha", [
    {
      rule: "required"
    },
    {
      rule: "password"
    }
  ])

  .addField("#confirmar-senha", [
    {
      rule: "required"
    },
    {
      validator: (value, fields) => {
        return value === fields["#senha"].elem.value;
      },
      errorMessage: "Senhas devem ser iguais!"
    }
  ])

  .onSuccess((event) => {
    document.getElementById("signup").submit();
  });
