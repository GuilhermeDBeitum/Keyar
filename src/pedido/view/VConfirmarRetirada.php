<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/controller/CPedido.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";

    $controller = new CUsuario();
    $controller->executarAcao("verificarSessaoBalconista", $_POST);

    // Instanciando os controllers utilizados por essa view
    $controller = new CPedido();

    // Se estiver ação, executa-a
    $status = new Retorno(null, null, null);
    if ($_POST) {
        $status = $controller->executarAcao("confirmarRetiradaPedido", $_POST);
    }
    // Senão, executa a padrão
    $saida = $controller->executarAcao("visualizarTodosPedidos", ["idstatuspedido" => Status::PedidoProntoRetirada]);
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
        <?php require_once "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/css_files_main.php"; ?>

    </head>
    <body>
        <!-- Page Preloder -->
        <div id="preloder">
            <div class="loader"></div>
        </div>

        <!-- Header -->
        <header class="header-section">
            <?php require_once "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/header.php"; ?>
        </header>

        <!-- checkout section  -->
        <section class="checkout-section">
            <div class="container">
                <div class="spad">
                    <div class="cart-table">
                        <h3>Confirmar Retirada de Pedidos</h3>
                        <div class="cart-table-warp">
                            <?php
                            if($status->statusErro(Status::CpfDiferentePedido)) {
                                echo '<div class="alert alert-danger" role="alert">
                                                CPF diferente do cadastrado ao efetuar o pedido!
                                          </div>';
                            }
                            ?>
                            <table id="lista_produtos" class="display">
                                <thead>
                                <tr>
                                    <th>NÚMERO DO PEDIDO</th>
                                    <th>CPF DO CLIENTE</th>
                                    <th>AÇÃO</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    // Listando
                                    foreach ($saida->getRegistros() as $registro){
                                        echo '<tr>';
                                            echo '<form method="post">';
                                                echo '<td>' . $registro->idpedido . '</td>';
                                                echo '<td><input style="width:130px" type="number" name="cpf"></td>';
                                                echo '<td class="total-col"><button type="submit">Confirmar Retirada</button></td>';
                                                echo '<input type="hidden" name="idpedido" value="' . $registro->idpedido . '">';
                                            echo '</form>';
                                        echo '</tr>';
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                 <div class="tamanho">        
                <div class="container">
                    <a href="/public/main.php" class="site-btn">VOLTAR</a>
               </div>
                </div>
            </div>
          </div>    
        </section>

        <!-- Scripts -->
        <?php require_once "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/script_files_main.php"; ?>
        <script src="/public/assets/js/scripts.js"></script>
        <script src="/public/assets/vendor/datatables/datatables.minMain.js"> </script>
    </body>
</html>
