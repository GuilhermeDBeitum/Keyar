<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/cliente/controller/CCliente.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/TGerenciadorConexaoBD.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";

    $controller = new CUsuario();
    $controller->executarAcao("verificarSessaoCliente", $_POST);

    // Instanciando os controllers utilizados por essa view (usuário também é utilizado)
    $controller2 = new CCliente();
    $status = new Retorno(null, null, null);

    // Se estiver ação, executa-a
    if ($_POST and isset($_GET["acao"])) {
        switch ($_GET["acao"]) {
            case "excluirCliente":
                $status = $controller2->executarAcao("excluirCliente", ["idcliente" => $_SESSION["idcliente"], "idusuario" => $_SESSION["idusuario"]]);
                break;

            case "alterarCliente":
                $status = $controller2->executarAcao("alterarCliente", array_merge(["idcliente" => $_SESSION["idcliente"], "idusuario" => $_SESSION["idusuario"]], $_POST));
                break;
        }
    }
    $saida = $controller->executarAcao("visualizarUsuario", ["idusuario" => $_SESSION["idusuario"]]);
    $saida2 = $controller2->executarAcao("visualizarCliente", ["idcliente" => $_SESSION["idcliente"]]);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>KeyAr</title>
        <meta charset="UTF-8">
        <meta name="description" content=" Divisima | eCommerce Template">
        <meta name="keywords" content="divisima, eCommerce, creative, html">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Stylesheets -->
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/css_files_main.php"; ?>
        <link rel='stylesheet' href='/public/assets/css/styles_editarperfil.css'>
	</head>
	<body>
        <!-- Page Preloder -->
        <div id="preloder">
            <div class="loader"></div>
        </div>
        <!-- Header -->
        <header class="header-section">
            <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/header.php"; ?>
        </header>
        <section class="checkout-section">
            <div class="container">
                <div class="tamanho">
                    <div class="spad">
                        <div class="cart-table">
                            <h4 class="mb-3">GERENCIAR PERFIL</h4>
                            <hr>
                            <form method="post">
                                <?php
                                    if( $status->statusErro(Status::CampoSenhaInvalido) or
                                        $status->statusErro(Status::CampoEmailInvalido) or
                                        $status->statusErro(Status::CampoTelefoneInvalido) or
                                        $status->statusErro(Status::CampoCepInvalido) or
                                        $status->statusErro(Status::CampoLogradouroInvalido) or
                                        $status->statusErro(Status::CampoNumeroInvalido) or
                                        $status->statusErro(Status::CampoComplementoInvalido)){


                                        echo '<div class="alert alert-danger" role="alert">';
                                        echo 'Verifique os seguintes campos: <br>';
                                        if($status->statusErro(Status::CampoSenhaInvalido)){
                                            echo '- Senha <br>';
                                        }
                                        if($status->statusErro(Status::CampoEmailInvalido)){
                                            echo '- Email <br>';
                                        }
                                        if($status->statusErro(Status::CampoTelefoneInvalido)){
                                            echo '- Telefone <br>';
                                        }
                                        if($status->statusErro(Status::CampoCepInvalido)){
                                            echo '- CEP <br>';
                                        }
                                        if($status->statusErro(Status::CampoLogradouroInvalido)){
                                            echo '- Logradouro <br>';
                                        }
                                        if($status->statusErro(Status::CampoNumeroInvalido)){
                                            echo '- Número <br>';
                                        }
                                        if($status->statusErro(Status::CampoComplementoInvalido)){
                                            echo '- Complemento <br>';
                                        }
                                        echo '</div>';
                                    }
                                    if (isset($_GET["status"]) and $_GET["status"] == 0) {
                                        echo '<div class="alert alert-success" role="alert">
                                                Ação efetuada com sucesso!
                                              </div>';
                                    }
                                ?>
                                <div class="row">
                                    <div class="col">
                                        <label>E-mail
                                            <?php
                                                echo '<input type="text" name="email" class="form-control" value="' . $saida2->getRegistros()->email . '">';
                                            ?>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label>Senha
                                            <?php
                                                echo '<input type="password" name="senha" class="form-control" value="">';
                                            ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Telefone
                                            <?php
                                                echo '<input type="text" name="telefone" class="form-control" value="' . $saida2->getRegistros()->telefone . '">';
                                            ?>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label>CEP
                                            <?php
                                                echo '<input type="text" name="cep" class="form-control" value="' . $saida2->getRegistros()->cep . '">';
                                            ?>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label>Número
                                            <?php
                                                echo '<input type="number" name="numero" class="form-control" value="' . $saida2->getRegistros()->numero . '">';
                                            ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Logradouro
                                            <?php
                                                echo '<input type="text" name="logradouro" class="form-control" value="' . $saida2->getRegistros()->logradouro . '">';
                                            ?>
                                        </label>
                                    </div>

                                    <div class="col">
                                        <label>Complemento
                                            <?php
                                                echo '<input type="text" name="complemento" class="form-control" value="' . $saida2->getRegistros()->complemento .  '">';
                                            ?>
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" formaction="?acao=alterarCliente" class="site-btn">ALTERAR CADASTRO</button>
                                <a href="/public/main.php" class="site-btn sb-dark">VOLTAR</a>
                                <button type="button" class="site-btn botao-vermelho" data-toggle="modal" data-target="#modal-exclusao">EXCLUIR CADASTRO</button>
                                <!-- Modal -->
                                <div class="modal fade" id="modal-exclusao" tabindex="-1" role="dialog" aria-labelledby="modal-exclusao" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Excluir Cadastro</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Tem certeza que deseja excluir o seu cadastro?<br>
                                                Esta ação não poderá ser desfeita!
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" formaction="?acao=excluirCliente" class="btn btn-primary botao-vermelho">Excluir Cadastro</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

         <!-- Scripts -->
         <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/script_files_main.php"; ?>
         
    </body>
</html>
