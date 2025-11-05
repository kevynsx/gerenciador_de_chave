<?php

session_start();

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000,
        '/', $_SERVER['HTTP_HOST'] // Use 'false' para o quarto argumento se não precisar de domínio
    );
}
session_destroy();
header('Location: ../login.php?sucesso=0'); 