<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/controller/CPedido.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/controller/CItemPedido.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";

    // Verifica a sessão e tipo de usuário
    $controller = new CUsuario();
    $controller->executarAcao("verificarSessaoCliente", $_POST);

    // Instanciando os controllers utilizados por essa view
    $controller = new CPedido();
    $controller2 = new CItemPedido();

    $saida = new Retorno(null, null, null);
    $saida2 = new Retorno(null, null, null);

    // Se receber o idpedido, executa a ação, com o mesmo.
    if (isset($_GET["idpedido"])) {
        $saida = $controller->executarAcao("visualizarPedido", ["idpedido" => $_GET["idpedido"], "idcliente" => $_SESSION["idcliente"]]);
        $saida2 = $controller2->executarAcao("visualizarTodosItensPedido", ["idpedido" => $_GET["idpedido"]]);
    }
    // Senão, executa a padrão (fixo da sessão), se existir
    else {
        if(isset($_SESSION["idpedido"])){
            $saida = $controller->executarAcao("visualizarPedido", ["idpedido" => $_SESSION["idpedido"], "idcliente" => $_SESSION["idcliente"]]);
            $saida2 = $controller2->executarAcao("visualizarTodosItensPedido", ["idpedido" => $_SESSION["idpedido"]]);
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

    <!-- cart section end -->
    <section class="cart-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="cart-table">
                        <h4>Seu Pedido</h4>
                        <hr>
                        <div class="cart-table-warp">
                            <table>
                                <tbody>
                                <?php
                                    // Listando
                                    if($saida->getTotalRegistros() > 0 and $saida->getRegistros()->valor_total > 0) {
                                        foreach ($saida2->getRegistros() as $registro) {
                                            if ($registro->quantidade_pedido > 0) {
                                                echo '<tr>';
                                                echo '<td class= "qtde-data"><data type = "text" id = "qtde" name = "qtde" maxlength = "3" size = "2" >' . 'Quantidade ' . $registro->quantidade_pedido . '</data ></td >';
                                               
                                                echo '<td class="product-col" >';
                                                echo '<div class="pc-title">';
                                                echo '<span><u>Preço unitário: </u></span>';
                                                echo '<span> R$' . number_format((float)$registro->preco, 2, ',', '') . '</span>';
                                                echo '<p>' . $registro->nome . '</p></td>';
                                                echo '</td>';
                                                echo '<td class="product-col" >';
                                                echo '<div class="pc-title">';
                                                echo '<h4>R$' . number_format((float)$registro->preco * $registro->quantidade_pedido, 2, ',', '') . '</h4></td>';
                                         echo '</tr>';
                                            }
                                        }
                                    }
                                    else{
                                        echo '<h5>Seu pedido está vazio ou ainda não foi criado.</h5><br>Crie e gerencie os seus pedidos através do menu superior direito "Perfil", e clicando na opção "Gerenciar Pedidos".';
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="total-cost">
                            <?php
                                if (isset($_GET["idpedido"]) or isset($_SESSION["idpedido"])) {
                                    echo '<h6>Valor Total: R$ ' . number_format((float)$saida->getRegistros()->valor_total, 2, ',', '') . '</h6>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 card-right">
                    <?php
                        // Se existir idpedido , exibe o botão de ir para pagamento
                        if (isset($_GET["idpedido"]) and $saida->getRegistros()->valor_total > 0) {
                            echo '<a href="/public/pagamento/selecao_forma_pagamento.php?idpedido=' . $_GET["idpedido"] . '" class="site-btn">CONTINUAR PARA PAGAMENTO</a>';
                            echo '<a href="/public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido=' . $_GET["idpedido"]. '" class="site-btn sb-dark">ADICIONAR MAIS</a>';
                        }
                        // Se não
                        else{
                            if(isset($_SESSION["idpedido"]) and $saida->getRegistros()->valor_total > 0) {
                                echo '<a href="/public/pagamento/selecao_forma_pagamento.php?idpedido=' . $_SESSION["idpedido"] . '" class="site-btn">CONTINUAR PARA PAGAMENTO</a>';
                                echo '<a href="/public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido=' . $_SESSION["idpedido"]. '" class="site-btn sb-dark">ADICIONAR MAIS</a>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- cart section end -->

    <!-- Scripts -->
    <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/script_files_main.php"; ?>
    </body>
</html>