<?php
function verificarLogin() {
  session_start();

  if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    header('Location: loginAdmin.php');
    exit; // Certifique-se de sair após o redirecionamento
  }
}
?>