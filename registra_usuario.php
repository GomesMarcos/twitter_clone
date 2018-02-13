<?php

require_once ('db_class.php');

$usuario = $_POST['usuario'];
$email = $_POST['email'];
$senha = md5($_POST['senha']);

$objDB = new DB();
$link = $objDB->conecta_mysql();

$usuario_existe = FALSE;
$email_existe = FALSE;

//verificar se o usuário já existe
$sql = " SELECT * FROM usuarios WHERE usuario = '$usuario'";
$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {

    $dados_usuario = mysqli_fetch_array($resultado_id);

    if ($dados_usuario['usuario']) {
        $usuario_existe = true;
    }
}

//Verificar se o email já existe
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {

    $dados_usuario = mysqli_fetch_array($resultado_id);

    if (isset($dados_usuario['email'])) {
        $email_existe = true;
    }
}

if ($usuario_existe || $email_existe) {
    
    if ($usuario_existe) {
        header('Location: inscrevase.php?erro=2');
    }
    if ($email_existe) {
        header('Location: inscrevase.php?erro=3');
    }
    if ($usuario_existe && $email_existe) {
        header('Location: inscrevase.php?erro=4');
    }
 
    die('Usuário e email não cadastrados');
}
$sql = "INSERT INTO usuarios(usuario, email, senha) VALUES ('$usuario', '$email', '$senha')";

//executando a Query (Conexão com o Banco , QUERY)
if (mysqli_query($link, $sql)) {
    echo 'Usuário registrado com sucesso!';
    header('Location: home.php');
} else {
    echo 'Erro ao registrar usuário!';
}