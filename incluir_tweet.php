<?php 
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?erro=1');
}

require_once ('db_class.php');


$texto_tweet = $_POST['texto_tweet'];
$id_usuario = $_SESSION['id_usuario'];

if($texto_tweet == '' && $id_usuario == ''){
    die();
}elseif($texto_tweet != '' && $id_usuario != ''){

    $objDB = new DB();
    $link = $objDB->conecta_mysql();

    $sql = " INSERT INTO tweet(id_usuario , tweet) VALUES($id_usuario , '$texto_tweet') ";

    $resultado_id = mysqli_query($link, $sql);
}
