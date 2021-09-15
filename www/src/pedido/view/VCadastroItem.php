<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/controller/CItem.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";

    // Verifica a sessão e tipo de usuário
    $controller = new CUsuario();
    $controller->executarAcao("verificarSessaoBalconista", $_POST);

    // Instanciando os controllers utilizados por essa view
    $controller = new CItem();
    $status = new Retorno(null, null, null);

    // Se estiver ação, executa-a
    if(isset($_GET["iditem"])){
        $saida = $controller->executarAcao("visualizarItem", ["iditem" => $_GET["iditem"]]);
    }
    if ($_POST and isset($_GET["acao"])) {
        switch ($_GET["acao"]) {
            case "adicionarItem":
                $status = $controller->executarAcao("adicionarItem", $_POST);
                break;

            case "alterarItem":
                $status = $controller->executarAcao("alterarItem", array_merge($_POST, ["iditem" => $_GET["iditem"]]));
                break;
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>KeyAr</title>
        <meta charset="UTF-8">
        <meta name="description" content=" Divisima | eCommerce Template">
        <meta name="keywords" content="divisima, eCommerce, creative, html">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon -->
        <link href="/public/assets/img/favicon.ico" rel="shortcut icon"/>

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">

        <!-- Stylesheets -->
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/css_files_main.php"; ?>

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
                    <div class="col-md-10">
                        <div class="cart-table">
                            <form class="checkout-form" method="post">
                                <?php
                                    if(isset($_GET["idpedido"])){
                                       echo "<h3>Alteração de Item</h3>";
                                    }
                                    else{
                                        echo "<h3>Cadastro de Item</h3>";
                                    }
                                ?>

                                <?php
                                    if ($_POST and isset($_GET["acao"])) {
                                    $erroCampoNomeInvalido = in_array(Status::CampoNomeInvalido, $status->getStatus());
                                    $erroCampoPrecoInvalido = in_array(Status::CampoPrecoInvalido, $status->getStatus());
                                    $erroCampoQuantidadeInvalido = in_array(Status::CampoQuantidadeInvalido, $status->getStatus());
                                    $erroCampoIdCategoriaInvalido = in_array(Status::CampoIdCategoriaInvalido, $status->getStatus());

                                    if ($erroCampoNomeInvalido or $erroCampoPrecoInvalido or
                                        $erroCampoQuantidadeInvalido or $erroCampoIdCategoriaInvalido) {
                                        echo '<div class="alert alert-danger" role="alert">';
                                        echo 'Verifique os seguintes campos: <br>';
                                        if ($erroCampoNomeInvalido) {
                                            echo '- Nome <br>';
                                        }
                                        if ($erroCampoPrecoInvalido) {
                                            echo '- Preço <br>';
                                        }
                                        if ($erroCampoQuantidadeInvalido) {
                                            echo '- Quantidade <br>';
                                        }
                                        if ($erroCampoIdCategoriaInvalido) {
                                            echo '- Categoria';
                                        }
                                        echo '</div>';
                                    }
                                }
                                ?>
                                <div class="row address-inputs">
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Nome" name="nome" id="nome" value=<?php echo (isset($_GET["iditem"]))? $saida->getRegistros()->nome : ""; ?>>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" placeholder="Preço" name="preco" id="preco" value=<?php echo (isset($_GET["iditem"]))? $saida->getRegistros()->preco : ""; ?>>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                            if(isset($_GET["iditem"])){
                                                echo "<input disabled type='number' placeholder='Quantidade Atual' value='{$saida->getRegistros()->quantidade}'>";
                                                echo "<input type='number' placeholder='Alterar Quantidade' name='modificador' value='0'>";
                                            }
                                            else{
                                                echo "<input style='width:120px' type='number' name='quantidade' placeholder='Quantidade'>";
                                            }
                                        ?>
                                          <div class="col-md-12">
                                        <select name="idcategoria">
                                            <option value="1">Salgados</option>
                                            <option value="2">Doces</option>
                                            <option value="3">Bebidas</option>
                                        </select>
                                    </div>
                                    </div>
                                    <hr>
                                </div>
                            </div> 
                           <div class="tamanho">
                                <?php
                                    if(isset($_GET["iditem"])){
                                        echo '<button class="site-btn submit-order-btn" formaction="/public/produto/cadastro_item.php?acao=alterarItem&iditem=' . $_GET["iditem"] . '">ALTERAR</button>';
                                    }
                                    else{
                                        echo '<button class="site-btn submit-order-btn" formaction="/public/produto/cadastro_item.php?acao=adicionarItem">CADASTRAR</button>';
                                    }
                                ?>
                                <a href="/public/produto/gerenciar_itens.php" class="site-btn sb-dark">VOLTAR</a>
                            </form>
                        </div>        
                    </div>
                </div>
            </div>
        </section>
        <!-- checkout section end -->

        <!-- Scripts -->
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/script_files_main.php"; ?>
        <script src="/public/assets/js/scripts.js"></script>
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#blah')
                            .attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </body>
</html>