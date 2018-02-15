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

//qtd de tweets
$sql = " SELECT COUNT(tweet) AS qtd_tweets FROM tweet WHERE id_usuario = $id_usuario ";


$resultado_id = mysqli_query($link, $sql);


if ($resultado_id) {

    $registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
    $qtd_tweets = $registro['qtd_tweets'];
} else {
    echo 'Erro ao consultar a quantidade de Tweets';
}
?>

    <!DOCTYPE HTML>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">

        <title>Twitter clone</title>

        <!-- jquery - link cdn -->
        <script src="biblioteca/jquery-2.2.4.min.js"></script>

        <!-- bootstrap - link cdn -->
        <link rel="stylesheet" href="biblioteca/bootstrap.3.3.7.min.css">

        <!--font awesome icons-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!--Includes modal-->
        <script src="biblioteca/ajax-2.2.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/2.2.4/js/bootstrap.min.js"></script>-->

        <style type="text/css">


        </style>
        <script type="text/javascript">
            $(document).ready(function() {

                //associoar o evento de click ao botão
                $('#btn_tweet').click(function() {
                    if ($('#texto_tweet').val().length > 0) {
                        $.ajax({
                            url: 'incluir_tweet.php',
                            method: 'post',
                            data: $('#form_tweet').serialize(),
                            //serialize retorna um JSON para que os campos do form possam ser todos passados como {chave:valor}
                            //data: {texto_tweet: $('#texto_tweet').val()},
                            success: function(data) {
                                atualizarTweet();
                            }
                        });
                    } else {
                        alert('Tweet em branco.');
                    }
                });

                function atualizarTweet() {
                    //Carrega os tweets
                    $.ajax({
                        url: 'get_tweet.php',
                        success: function(data) {
                            $('#tweets').html(data);
                        }
                    });
                }

                function atualizarQtdTweets() {
                    //Carrega os tweets
                    $.ajax({
                        url: 'acoes.php?acao=contar_tweets',
                        success: function(data) {
                            $('#qtd_tweets').html(data);
                        }
                    });
                }

                function atualizarQtdSeguidores() {
                    //Carrega os tweets
                    $.ajax({
                        url: 'acoes.php?acao=contar_seguidores',
                        success: function(data) {
                            $('#qtd_seguidores').html(data);
                        }
                    });
                }
                atualizarTweet();
                atualizarQtdTweets();
                atualizarQtdSeguidores();




                //Modal Procurar Usuarios
                $('#procurar_usuarios').click(function() {
                    $.ajax({
                        url: 'acoes.php?acao=procurar_usuarios',
                        success: function(data) {
                            $(".modal-body").modal().html(data);
                            removerBackdrop();
                        }
                    });
                });

                //Modal Seguidores
                $('#qtd_seguidores').click(function() {
                    $.ajax({
                        url: 'acoes.php?acao=qtd_seguidores',
                        success: function(data) {
                            //                            alert(data);
                            $(".modal-body").modal().html(data);
                            removerBackdrop();
                        }
                    });
                });

            });

            //Excluir tweet
            function excluirTweet() {

                $('.btn-danger').click(function(event) {
                    id_tweet = event.target.id;
                    id_tweet = id_tweet.substring(id_tweet.indexOf('r') + 2, id_tweet.length);

                    $.ajax({
                        method: 'post',
                        url: 'acoes.php?acao=excluir_tweet',
                        data: {
                            id: id_tweet
                        },
                        success: function(data) {
                            console.log(id_tweet);
                            alert(data);
                        }
                    });
                });
            }

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

        </script>

    </head>

    <body>

        <!-- Static navbar -->
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#"><img src="imagens/icone_twitter.png" /></a>
                </div>

                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="sair.php">Sair</a></li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </nav>


        <div class="container">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>
                            <?= $_SESSION['usuario']; ?>
                        </h4>
                        <hr/>
                        <div class="col-md-6">
                            TWEETS <br> <a href="#" id="qtd_tweets"></a>
                        </div>
                        <div class="col-md-6">
                            SEGUIDORES <br> <a href="#" id="qtd_seguidores"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="input-group" id="form_tweet">
                            <input type="text" class="form-control" name="texto_tweet" id="texto_tweet" placeholder="O que está acontecendo agora?" maxlength="140">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" id="btn_tweet" type="button"><span class="fa fa-twitter"></span></button>
                            </span>
                        </form>
                    </div>
                </div>

                <div id="tweets" class="list-group"></div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4><a href="#" id="procurar_usuarios" data-toggle="modal" data-target="#procurar">Procurar Usuários</a></h4>
                    </div>
                </div>
            </div>

            <!--Modal Procurar-->
            <div id="procurar" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="close" data-dismiss="modal">&times;</span>
                            <h4 class="modal-title">Procurar Usuários</h4>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>

            <!--Modal Seguidores-->
            <div id="seguidores" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="close" data-dismiss="modal">&times;</span>
                            <h4 class="modal-title">Meus Seguidores</h4>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    </body>

    </html>
