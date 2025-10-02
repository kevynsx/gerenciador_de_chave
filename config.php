<?php

$dbhost = 'localhost';
$dbusername = 'root';
$dbpassword = 'root';
$dbname = 'sistemas';

try {
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbusername, $dbpassword);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>


