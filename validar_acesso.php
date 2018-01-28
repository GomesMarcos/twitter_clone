<?php

require_once ('db_class.php');

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";

$objDB = new DB();
$link = $objDB->conecta_mysql();


$resultado_id = mysqli_query($link, $sql);

//update result mode: true/false
//insert result mode: true/false
//select result mode: false/resource(objetos ou arrays)
//delete result mode: true/false

if ($resultado_id) {
    $dados_usuario = mysqli_fetch_array($resultado_id);
    if(isset($dados_usuario['usuario'])){
        echo 'Usuário existe';    
    } else {
        header('Location: index.php?erro=1');
    }
} else {
    echo "Erro na consulta. Favor entrar em contato com o Admin do Site";

}
