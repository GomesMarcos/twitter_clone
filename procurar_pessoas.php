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


//qtd de tweets
$sql = " SELECT COUNT(tweet) AS qtd_tweets FROM tweet WHERE id_usuario = $id_usuario ";


$resultado_id = mysqli_query($link, $sql);

$qtd_tweets = 0;
$qtd_seguidores = 0;

if ($resultado_id) {

    $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
    $qtd_tweets = $registro['qtd_tweets'];
} else {
    echo 'Erro ao consultar a quantidade de Tweets';
}


//qtd de seguidores
$sql = " SELECT COUNT(seguindo_id_usuario) AS qtd_seguidores FROM usuarios_seguidores WHERE id_usuario = $id_usuario ";


$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {

    $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
    $qtd_seguidores = $registro['qtd_seguidores'];
} else {
    echo 'Erro ao consultar a quantidade de Seguidores';
}
?>

<!DOCTYPE HTML>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">

        <title>Twitter clone</title>
        <!-- jquery - link cdn -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>-->;

        <!-- bootstrap - link cdn -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!--Includes modal-->
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- jquery - link cdn -->
        <!--        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>-->

        <!-- bootstrap - link cdn -->
        <!--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

        <script type="text/javascript">
            $(document).ready(function () {

                //associoar o evento de click ao botão
                $('#btn_procurar_pessoa').click(function () {
                    if ($('#nome_pessoa').val().length > 0) {
                        $.ajax({
                            url: 'get_pessoas.php',
                            method: 'post',
                            data: $('#form_procurar_pessoas').serialize(),
                            success: function (data) {
                                $('#pessoas').html(data);

                                $('.btn_seguir').click(function () {

                                    var id_usuario = $(this).data('id_usuario');

                                    $(this).hide();
                                    $('#btn_deixar_seguir_' + id_usuario).show();

                                    $.ajax({
                                        url: 'seguir.php',
                                        method: 'post',
                                        data: {
                                            seguir_id_usuario: id_usuario
                                        },
                                        success: function (data) {}
                                    });
                                });

                                $('.btn_deixar_seguir').click(function () {

                                    var id_usuario = $(this).data('id_usuario');

                                    $(this).hide();
                                    $('#btn_seguir_' + id_usuario).show();

                                    $.ajax({
                                        url: 'deixar_seguir.php',
                                        method: 'post',
                                        data: {
                                            deixar_seguir_id_usuario: id_usuario
                                        },
                                        success: function (data) {}
                                    });
                                });
                            }
                        });
                    } else {
                        alert('Favor digitar um nome.');
                    }
                });
                function removerBackdrop() {
                    if ($('.modal-backdrop').length > 1) {
                        var i = 0;
                        while (i < $('.modal-backdrop').length) {
                            if (i > 0) {
                                var div = $('div.modal-backdrop').last();
                                div.remove();
                            }
                            i++;
                        }
                    }
                }
                removerBackdrop();
            });

        </script>

    </head>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <body>
        <div style="width: auto;">
            <div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="input-group" id="form_procurar_pessoas" method="post">
                            <input type="text" class="form-control" name="nome_pessoa" id="nome_pessoa" placeholder="Quem você está procurando agora?" maxlength="140">
                            <span class="input-group-btn">
                                <button class="btn btn-default" id="btn_procurar_pessoa" type="button"><span class="fa fa-search"></span></button>
                            </span>
                        </form>
                    </div>
                </div>

                <div id="pessoas" class="list-group"></div>
            </div>
        </div>
    </body>



</html>
