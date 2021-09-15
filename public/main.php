<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";

    $controller = new CUsuario();
    $controller->executarAcao("verificarSessao", $_POST);
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
		<!-- Header -->
		<header class="header-section">
			<?php require_once "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/header.php"; ?>
		</header>

         <div class="square" style="width: 30%">
             <img src="\public\assets\img\mobile.png" class="imgresp" height="170"  width="500">
             <div class="sq-content">Controle os seus gastos.</div>
          </div>


          <div class="square" style="width: 30%">
          <img src="\public\assets\img\stoque.png" class="imgresp" height="170"  width="500">
             <div class="sq-content">Compre o quanto quiser.</div>
          </div>

          <div class="square" style="width: 30%">
          <img src="\public\assets\img\relatorio.jpg" class="imgresp" height="170"  width="500">
             <div class="sq-content center">Gerencie na ponta do lápis.</div>
          </div>
          <hr>
          <div class="square" style="width: 30%">
          <img src="\public\assets\img\app.jpg" class="imgresp" height="170" width="500">
             <div class="sq-content">App amigável e descomplicado.</div>
          </div>

          <div class="square" style="width: 30%">
          <img src="\public\assets\img\card.jpg" class="imgresp" height="170"  width="500">
             <div class="sq-content">Pague e receba com segurança.</div>
          </div>

          <div class="square" style="width: 30%">
          <img src="\public\assets\img\venda.jpg" class="imgresp" height="170" width="500">
             <div class="sq-content">faça um bom negócio!</div>
          </div>
          <hr>
		<!-- Arquivos JS -->
		<?php require_once "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/script_files_main.php"; ?>
		<script src="/public/assets/vendor/datatables/datatables.minMain.js"> </script>
	</body>
</html>