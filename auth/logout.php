<?php
require_once dirname(__DIR__) . '/auth/access_control.php';
session_start(); // Inicia a sessão (caso ainda não esteja iniciada)
session_unset(); // Remove todas as variáveis da sessão
session_destroy();// Destrói a sessão

header("Location: /auth");

exit;
