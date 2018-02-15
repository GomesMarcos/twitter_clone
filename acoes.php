<?php

session_start();

//Se o usuário não existir, redirecionar o acesso à página index
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?erro=1');
}

require_once ('db_class.php');

$id_usuario = $_SESSION['id_usuario'];

$objDB = new DB();
$link = $objDB->conecta_mysql();

$qtd_tweets = 0;
$qtd_seguidores = 0;


$acao = $_GET['acao'];

switch ($acao) {
    case 'contar_tweets':

        //qtd de tweets
        $sql = " SELECT COUNT(tweet) AS qtd_tweets FROM tweet WHERE id_usuario = $id_usuario ";


        $resultado_id = mysqli_query($link, $sql);


        if ($resultado_id) {

            $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
            echo $qtd_tweets = $registro['qtd_tweets'];
        } else {
            echo 'Erro ao consultar a quantidade de Tweets';
        }

        break;

    case 'contar_seguidores':

        //qtd de seguidores
        $sql = " SELECT COUNT(seguindo_id_usuario) AS qtd_seguidores FROM usuarios_seguidores WHERE id_usuario = $id_usuario ";


        $resultado_id = mysqli_query($link, $sql);

        if ($resultado_id) {

            $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
            echo $qtd_seguidores = $registro['qtd_seguidores'];
        } else {
            echo 'Erro ao consultar a quantidade de Seguidores';
        }

        break;

    case 'procurar_usuarios':
        include_once 'procurar_pessoas.php';

        break;

    case 'qtd_seguidores':

        include_once 'seguidores.php';

        break;

    case 'excluir_tweet':

        $id_tweet = $_POST['id_tweet'];
        $sql = " DELETE tweet FROM tweet WHERE id_usuario = $id_usuario AND id = $id_tweet ";

        var_dump($sql);
//        $resultado_id = mysqli_query($link, $sql);


//        if ($resultado_id) {
//
//            $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
//            echo $qtd_tweets = $registro['qtd_tweets'];
//        } else {
//            echo 'Erro ao excluir Tweet';
//        }

        break;

    default:
        break;
}
