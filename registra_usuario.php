<?php

require_once ('db_class.php');

$usuario = $_POST['usuario'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$objDB = new DB();
$link = $objDB->conecta_mysql();

$sql = "INSERT INTO usuarios(usuario, email, senha) VALUES ('$usuario', '$email', '$senha')";

//executando a Query (Conexão com o Banco , QUERY)
if (mysqli_query($link, $sql)) {
    echo 'Usuário registrado com sucesso!';
} else {
    echo 'Erro ao registrar usuário!';
}
?>
