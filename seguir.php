<?php 
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?erro=1');
}

require_once ('db_class.php');


$id_usuario = $_SESSION['id_usuario'];
$seguir_id_usuario = $_POST['seguir_id_usuario'];

if($seguir_id_usuario == '' && $id_usuario == ''){
    die();
}elseif($seguir_id_usuario != '' && $id_usuario != ''){

    $objDB = new DB();
    $link = $objDB->conecta_mysql();

    $sql = " INSERT INTO usuarios_seguidores(id_usuario , seguindo_id_usuario) VALUES($id_usuario , $seguir_id_usuario) ";
    
    $resultado_id = mysqli_query($link, $sql);
}
