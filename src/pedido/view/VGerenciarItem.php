<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/controller/CItem.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";

    // Verifica a sessão e tipo de usuário
    $controller = new CUsuario();
    $controller->executarAcao("verificarSessaoBalconista", $_POST);

    // Instanciando os controllers utilizados por essa view
    $controller = new CItem();
    $saida = new Retorno(null, null, null);
    $saida = $controller->executarAcao("visualizarTodosItens", $_POST);

    // Se receber a acao, execute-a.
    if(isset($_GET["acao"]) and isset($_GET["acao"]) == "excluirItem") {
        $controller = new CItem();
        $saida = $controller->executarAcao("excluirItem", $_GET);
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
                    <form>
                        <?php
                            if (isset($_GET["status"]) and $_GET["status"] == 0) {
                                echo '<div class="alert alert-success" role="alert">
                                            Ação efetuada com sucesso!
                                          </div>';
                            }
                        ?>
                        <table id="lista_produtos" class="display">
                            <thead>
                                <tr>
                                    <th>PRODUTO</th>
                                    <th>QUANTIDADE<br>ESTOQUE</th>
                                    <th>PREÇO</th>
                                    <th>EDITAR</th>
                                    <th>EXCLUIR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Listando
                                    foreach ($saida->getRegistros() as $registro){
                                        echo '<tr>';
                                        echo "<td>" . $registro->nome . "</td>";
                                        echo "<td>" . $registro->quantidade . "</td>";
                                        echo "<td>" . $registro->preco . "</td>";
                                        echo '<td class="total-col"><a href="/public/produto/cadastro_item.php?iditem=' . $registro->idItem . '"><img width="24px" src="/public/assets/vendor/css-datatables/images/editar.png"></a></td>';
                                        echo '<td class="total-col"><a href="/public/produto/gerenciar_itens.php?acao=excluirItem&iditem=' . $registro->idItem . '"><img width="22px" src="/public/assets/vendor/css-datatables/images/delete1.png"></a></td>';
                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                        <a href="/public/produto/cadastro_item.php" class="site-btn submit-order-btn">NOVO</a>
                        <a href="/public/main.php" class="site-btn sb-dark">VOLTAR</a>
                    </form>
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