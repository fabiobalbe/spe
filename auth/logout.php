<?php
session_start(); // Inicia a sessão (caso ainda não esteja iniciada)
session_unset(); // Remove todas as variáveis da sessão
session_destroy();// Destrói a sessão

header("Location: /auth");

exit;
