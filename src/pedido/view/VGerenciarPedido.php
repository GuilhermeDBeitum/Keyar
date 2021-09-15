<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/controller/CPedido.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";

    // Verifica a sessão e tipo de usuário
    $controller = new CUsuario();
    $controller->executarAcao("verificarSessaoCliente", $_POST);

    // Instanciando os controllers utilizados por essa view
    $controller = new CPedido();

    // Se estiver ação, executa-a
    if (isset($_GET["acao"])) {
        switch ($_GET["acao"]) {
            case "adicionarPedido":
                $parametros = ["idcliente" => $_SESSION["idcliente"], "idstatuspedido" => Status::PedidoEmAberto, "idformapagamento" => 1];
                $saida = $controller->executarAcao("adicionarPedido", $parametros);
                break;

            case "excluirPedido":
                $saida = $controller->executarAcao("excluirPedido", $_GET);
                break;

            default:
                $saida = new Retorno(null, null, null);
        }
    }
    // Senão, executa a padrão
    else {
        $saida = $controller->executarAcao("visualizarPedidosCliente", ["idcliente" => $_SESSION["idcliente"]]);
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

        <!-- checkout section  -->
        <section class="checkout-section">
            <div class="container">
                <div class="spad">
                    <div class="cart-table">
                        <h4>Gerenciamento De Pedidos</h4>
                        <?php
                            if (isset($_GET["status"]) and $_GET["status"] == 0) {
                                echo '<div class="alert alert-success" role="alert">
                                                Ação efetuada com sucesso!
                                              </div>';
                            }
                        ?>
                        <div class="cart-table-warp">
                            <table id="lista_produtos" class="display">
                                <thead>
                                <tr>
                                    <th>NUMERO DO PEDIDO</th>
                                    <th>VALOR TOTAL</th>
                                    <th>STATUS</th>
                                    <th>EDITAR</th>
                                    <th>CANCELAR</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Listando
                                foreach ($saida->getRegistros() as $registro){
                                    echo '<tr>';
                                    echo "<td>" . $registro->idpedido . "</td>";
                                    if($registro->valor_total == ""){
                                        echo "<td> R$ 0,00 </td>";
                                    }
                                    else{
                                        echo "<td> R$ " . number_format((float)$registro->valor_total, 2, ',', '') . "</td>";
                                    }
                                    echo "<td>" . $registro->status_pedido . "</td>";
                                    echo '<td class="total-col"><a href="/public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido=' . $registro->idpedido . '"><img width="24px" src="/public/assets/vendor/css-datatables/images/editar.png"></a></td>';
                                    echo '<td class="total-col"><a href="/public/pedido/gerenciar_pedidos.php?acao=excluirPedido&idpedido=' . $registro->idpedido . '"><img width="22px" src="/public/assets/vendor/css-datatables/images/delete1.png"></a></td>';
                                    echo '</tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container">
                        <br>
                        <a href="/public/pedido/gerenciar_pedidos.php?acao=adicionarPedido" class="site-btn">NOVO PEDIDO</a>
                        <a href="/public/main.php" class="site-btn sb-dark">VOLTAR</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Scripts -->
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/script_files_main.php"; ?>
        <script src="/public/assets/js/scripts.js"></script>
        <script src="/public/assets/vendor/datatables/datatables.minPagamento.js"> </script>
    </body>
</html>