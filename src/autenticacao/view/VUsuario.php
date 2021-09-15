<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";

    $controller = new CUsuario();
    $status = new Retorno(null, null, null);
    if($_POST){
        $status = $controller->executarAcao("efetuarLogin", $_POST);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>KeyAr</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Arquivos CSS -->
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/css_files_index.php"; ?>
    </head>
	<body>	
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-50 p-b-30">
				<form class="login100-form validate-form" method="post" action=".?acao=efetuarLogin">
					<span class="login100-form-title p-b-37">
						LOGIN
					</span>
					<?php
                        if($status->statusErro(Status::SenhaIncorreta)){
                            echo '<div class="alert alert-danger" role="alert">
                                    Senha incorreta, tente novamente!
                                  </div>';
                        }
                        if($status->statusErro(Status::CampoLoginInvalido) or $status->statusErro(Status::CampoSenhaInvalido)){
                            echo '<div class="alert alert-danger" role="alert">';
                            echo 'Verifique os seguintes campos: <br>';
                            if($status->statusErro(Status::CampoLoginInvalido)){
                                echo '- Login <br>';
                            }
                            if($status->statusErro(Status::CampoSenhaInvalido)){
                                echo '- Senha';
                            }
                            echo '</div>';
                        }
                        if(isset($_GET["status"]) and $_GET["status"] == Status::Ok){
                            echo '<div class="alert alert-success" role="alert">
                                        Usuário cadastrado com sucesso!<br><br>
                                        Efetue o seu login com as suas credenciais criadas!
                                      </div>';
                        }
					?>
					<div class="wrap-input100 validate-input m-b-20" data-validate="login">
						<input class="input100" type="text" name="login" placeholder="Login">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-25" data-validate="senha">
						<input class="input100" type="password" name="senha" placeholder="Senha">
						<span class="focus-input100"></span>
					</div>
					<br>
					<br>
					<br>
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							LOGIN
						</button>
					</div>

					<div class="text-center p-t-57 p-b-20">
						<div class="text-center">
							<a href="/public/cliente/novo_cliente.php">Novo Usuário? Cadastre-se! </a>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- Scripts -->
		<?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/script_files_index.php"; ?>
	</body>
</html>