<?php
require_once DIR_ABS . '/spe/auth/access_control.php';
?>

<!-- Título e botão cancelar -->
<div class="row">
  <div class="col-12 d-flex">
    <h2>Lista de pacientes cadastrados:</h2>

    <div class="d-flex ms-auto">
      <a href="/pacientes/novo-paciente" class="btn btn-primary d-flex align-items-center">
        Cadastrar novo paciente
      </a>
    </div>

  </div>

</div>



<!-- Tabela -->
<div class="row mt-3 table-responsive link-underline-opacity-0">
  <div class="col-12 d-flex mx-auto">

    <table class="table table-striped table-hover rounded-2 overflow-hidden">

      <thead>
        <tr class="table-secondary">
          <th scope="col">Nome</th>
          <th scope="col">Idade</th>
          <th scope="col">Telefone</th>
          <th scope="col">Última consulta</th>
        </tr>
      </thead>
      <tbody>

        <tr onclick="window.location.href='/paciente/fabio-portela-balbe';"
          style="cursor: pointer;">
          <td>Fábio Portela Balbé</td>
          <td>29 anos</td>
          <td>
            <a class="link-success link-underline-opacity-100-hover"
              href="https://wa.me/55997112242"
              target="_blank">
              (55) 997112242
            </a>
          </td>
          <td>29/02/2024</td>
        </tr>

        <tr>
          <td>Fidelis Pinto</td>
          <td>62 anos</td>
          <td><a class="link-success link-underline-opacity-100-hover" href="https://wa.me/31999990862">
              (31) 999990862
            </a>
          </td>
          <td>04/06/2023</td>
        </tr>

        <tr>
          <td>Ranizinha da silva</td>
          <td>26 anos</td>
          <td><a class="link-success link-underline-opacity-100-hover" href="https://wa.me/31999996482">
              (31) 999996482
            </a>
          </td>
          <td>15/03/2025</td>
        </tr>

      </tbody>

    </table>


  </div>



</div>
