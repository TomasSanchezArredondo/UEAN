<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uean_bdd";

$conn = new mysqli($servername, $username, $password, $dbname);
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}