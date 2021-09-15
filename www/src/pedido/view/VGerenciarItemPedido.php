<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/controller/CItemPedido.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";

    // Verifica a sessão e tipo de usuário
    $controller = new CUsuario();
    $controller->executarAcao("verificarSessao", $_POST);

    // Instanciando os controllers utilizados por essa view
    $controller = new CItemPedido();

    // Se estiver ação, executa-a
    if (isset($_GET["acao"])) {
        switch ($_GET["acao"]) {
            case "adicionarItemPedido":
                $status2 = $controller->executarAcao("adicionarItemPedido", array_merge(["idpedido" => $_GET["idpedido"]], ["idcliente" => $_SESSION["idcliente"]], $_POST));
                break;

            case "alterarItemPedido":
                $status2 = $controller->executarAcao("alterarItemPedido", array_merge(["idpedido" => $_GET["idpedido"]], ["iditempedido" => $_GET["iditempedido"]], ["idcliente" => $_SESSION["idcliente"]], $_POST));
                break;

            case "visualizarTodosItensPedido":
                $status = $controller->executarAcao("visualizarTodosItensPedido", ["idpedido" => $_GET["idpedido"]]);
                break;

            default:
                $status = new Retorno(null, null, null);
        }
        $status = $controller->executarAcao("visualizarTodosItensPedido", ["idpedido" => $_GET["idpedido"]]);
    }
    else {
        // Senão, executa a padrão (assume que o idpedido da sessão é o correto)
        $_GET["idpedido"] = $_SESSION["idpedido"];
        $status = $controller->executarAcao("visualizarTodosItensPedido", $_SESSION);
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
        <!-- Header -->
        <header class="header-section">
            <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/header.php"; ?>
        </header>

        <!-- Conteúdo da Página -->
        <section class="product-filter-section">
            <div class="container">
                <div class="spad">
                    <div class="cart-table">
                        <?php
                            if($_SESSION["idPerfil"] == Perfil::Cliente) {
                                echo '<h4>Seleção dos Itens do Pedido</h4>';
                            }
                            else{
                                echo '<h4>Itens para retirada</h4>';
                            }
                        ?>
                        <div class="cart-table-warp">
                            <?php
                                if (isset($_GET["status"]) and $_GET["status"] == Status::Ok) {
                                    echo '<div class="alert alert-success" role="alert">
                                                Ação efetuada com sucesso!
                                              </div>';
                                }
                                if(isset($_GET["status"]) and $_GET["status"] == Status::QuantidadeIndisponivelParaVenda){
                                    echo '<div class="alert alert-danger" role="alert">
                                                Quantidade indisponível para venda!
                                              </div>';
                                }
                                if(isset($_GET["status"]) and $_GET["status"] == Status::PedidoSomenteVisualizacao){
                                    echo '<div class="alert alert-danger" role="alert">
                                                    Itens do pedido não podem ser alterados. Pedido cancelado ou com pagamento efetuado!
                                                  </div>';
                                }
                            ?>
                            <table id="lista_produtos" class="display">
                                <thead>
                                    <tr>
                                        <th>PRODUTO</th>
                                        <th>PREÇO</th>
                                        <?php
                                        if($_SESSION["idPerfil"] == Perfil::Cliente) {
                                            echo '<th>DISPONÍVEL</br>PARA VENDA</th>';
                                        }
                                        ?>
                                        <th>SELECIONADO</th>
                                        <?php
                                        if($_SESSION["idPerfil"] == Perfil::Cliente) {
                                            echo '<th>MODIFICAR</th>';
                                            echo '<th>AÇÃO</th>';
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Listando
                                        foreach ($status->getRegistros() as $registro){
                                            if($_SESSION["idPerfil"] == Perfil::Balconista and $registro->quantidade_pedido == 0){
                                                continue;
                                            }
                                            echo '<tr>';
                                            echo '<form method="post">';
                                            echo "<td>" . $registro->nome . "</td>";
                                            echo "<td> R$ " . number_format((float)$registro->preco, 2, ',', '') . "</td>";
                                            if($_SESSION["idPerfil"] == Perfil::Cliente) {
                                                echo "<td>" . $registro->quantidade_estoque . "</td>";
                                            }
                                            echo "<td>" . $registro->quantidade_pedido . "</td>";
                                            if($_SESSION["idPerfil"] == Perfil::Cliente) {
                                                echo "<td><input type='number' name='modificador' class='pedidoinput' value='0'> </td>";
                                                // Se não é item do pedido
                                                if ($registro->idpedido == "") {
                                                    echo "<td><input type='submit' formaction='/public/pedido/gerenciar_itens_pedido.php?acao=adicionarItemPedido&idpedido={$_GET["idpedido"]}' value='Adicionar'> </td>";
                                                    echo "<input type='hidden' name='iditem' value='{$registro->iditem}'>";
                                                } // Se é item do pedido
                                                else {
                                                    echo "<td><input type='submit' formaction='/public/pedido/gerenciar_itens_pedido.php?acao=alterarItemPedido&idpedido={$_GET["idpedido"]}&iditempedido={$registro->iditempedido}' value='Alterar'> </td>";
                                                    echo "<input type='hidden' name='iditempedido' value='{$registro->iditempedido}'>";
                                                }
                                            }
                                            echo '</form>';
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container">
                        <br>
                        <?php
                            if($_SESSION["idPerfil"] == Perfil::Cliente) {
                                echo '<a href="/public/pedido/gerenciar_pedidos.php" class="site-btn sb-dark">VOLTAR</a>';
                            }
                        ?>
                        <?php
                            if (isset($_GET["idpedido"]) and $_SESSION["idPerfil"] == Perfil::Cliente) {
                                echo '<a href="/public/pedido/visualizar_pedido.php?idpedido=' . $_GET["idpedido"] . '" class="site-btn">RESUMO DO PEDIDO</a>';
                            }
                            else if($_SESSION["idPerfil"] == Perfil::Balconista){
                                echo '<a href="/public/pedido/confirmar_retirada.php" class="site-btn">FINALIZAR RETIRADA</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Arquivos JS -->
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/script_files_main.php"; ?>
        <script src="/public/assets/js/scripts.js"></script>
        <script src="/public/assets/vendor/datatables/datatables.minMain.js"> </script>
    </body>
</html>
