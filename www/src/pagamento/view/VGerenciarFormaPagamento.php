<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pagamento/configuracao.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/TGerenciadorConexaoBD.php";
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
			    	<h4>Formas De Pagamento</h4>
				       <div class="cart-table-warp">
				         <table id="lista_produtos" class="display">
							<thead>
								<tr>
									<th>NUMERO NO CARTÃO</th>
									<th>EXPIRA</th>
									<th>CVC</th>
									<th>BANDEIRA</th>
									<th>EDITAR</th>
									<th>EXCLUIR</th>
								</tr>
							</thead>
							<tbody>
								<tr>
						        	<td>  
					              	<span>4111111111111111</span>
                                    <!-- <input type="number" name="gerencia" id="gerencia" value="411111"></span></td> -->
									<td>12/2030</td>
									<td>123</td>
									<td> <span class="bandeira-cartao"></span></td>

									<td class="total-col"><a href="/public/pagamento/modificar_forma_pagamento.php"><img width="24px" src="/public/assets/vendor/css-datatables/images/editar.png"></a></td>
									<td class="total-col"><img width="22px" src="/public/assets/vendor/css-datatables/images/delete1.png"></td>
								</tr>
							</tbody>
						</table>
					</div>
					</div>
					   <div class="container">
                             <br>
								<a href="/public/main.php" class="site-btn sb-dark">VOLTAR</a>
                            </form>
                           </div>
						</div>
                     </div>
                </div>
            </div>
        </section>

        <!-- Scripts -->
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/script_files_main.php"; ?>
        <script type="text/javascript" src="<?php echo SCRIPT_PAGSEGURO; ?>"></script>
        <script src="/src/pagamento/controller/CPagamento.js"> </script>
		<script src="/public/assets/js/scripts.js"></script>
        <script src="/public/assets/vendor/datatables/datatables.minPagamento.js"> </script>
	</body>
</html>