<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pagamento/configuracao.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";

    $controller = new CUsuario();
    $controller->executarAcao("verificarSessaoCliente", $_POST);

    $parametros = ["idcliente" => $_SESSION["idcliente"]];
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
        <?php require "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/css_files_main.php"; ?>
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

        <!-- checkout section  -->
        <section class="checkout-section">
            <div class="container">
                <div class="spad">
                    <div class="col-lg-8 order-2 order-lg-1">
                        <div class="cart-table">
                            <form class="checkout-form">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="menu-forma-pagamento">Selecione a forma de pagamento: </label>
                                    </div>
                                    <select class="custom-select" id="menu-forma-pagamento">
                                        <option selected>...</option>
                                        <option value="nomeCartao1"></option>
                                        <option value="nomeCartao2"></option>
                                        <option value="nomeCartao3"></option>
                                    </select>
                                </div>

                                <span class="endereco" data-endereco="<?php echo URL; ?>"></span>
                                <div class="container">
                                    <button onclick="pagamento()" class="site-btn">FINALIZAR PAGAMENTO</button>
                                    <a href="/public/main.php" class="site-btn sb-dark">VOLTAR</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Scripts -->
        <?php require "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/script_files_main.php"; ?>
        <script type="text/javascript" src="<?php echo SCRIPT_PAGSEGURO; ?>"></script>
    </body>
</html>