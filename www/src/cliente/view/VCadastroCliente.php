<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/cliente/controller/CCliente.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";

    // Instanciando os controllers utilizados por essa view
    $controller = new CCliente();
    $status = new Retorno(null, null, null);

    // Se receber um POST, executa a acao
    if ($_POST) {
        $status = $controller->executarAcao("adicionarCliente", array_merge($_POST, ["idperfil" => Perfil::Cliente]));
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>KeyAr</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Stylesheets -->
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/css_files_index.php"; ?>
        <link rel='stylesheet' href='/public/assets/css/styles_novousuario2.css'>
    </head>
    <body>
        <div class="container-login100">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-30 p-b-30 container-custom" id=formulario-cliente>
                <form class="login100-form validate-form" method="post">
                    <span class="login100-form-title p-b-37"> NOVO CLIENTE </span>
                    <?php
                        if($status->statusErro(Status::CampoLoginInvalido) or
                            $status->statusErro(Status::CampoSenhaInvalido) or
                            $status->statusErro(Status::CampoNomeInvalido) or
                            $status->statusErro(Status::CampoSobrenomeInvalido) or
                            $status->statusErro(Status::CampoCpfInvalido) or
                            $status->statusErro(Status::CampoEmailInvalido) or
                            $status->statusErro(Status::CampoTelefoneInvalido) or
                            $status->statusErro(Status::CampoCepInvalido) or
                            $status->statusErro(Status::CampoLogradouroInvalido) or
                            $status->statusErro(Status::CampoNumeroInvalido) or
                            $status->statusErro(Status::CampoComplementoInvalido)){


                            echo '<div class="alert alert-danger" role="alert">';
                            echo 'Verifique os seguintes campos: <br>';
                            if($status->statusErro(Status::CampoLoginInvalido)){
                                echo '- Login <br>';
                            }
                            if($status->statusErro(Status::CampoSenhaInvalido)){
                                echo '- Senha <br>';
                            }
                            if($status->statusErro(Status::CampoNomeInvalido)){
                                echo '- Nome <br>';
                            }
                            if($status->statusErro(Status::CampoSobrenomeInvalido)){
                                echo '- Sobrenome <br>';
                            }
                            if($status->statusErro(Status::CampoCpfInvalido)){
                                echo '- CPF <br>';
                            }
                            if($status->statusErro(Status::CampoEmailInvalido)){
                                echo '- Email <br>';
                            }
                            if($status->statusErro(Status::CampoTelefoneInvalido)){
                                echo '- Telefone <br>';
                            }
                            if($status->statusErro(Status::CampoCepInvalido)){
                                echo '- CEP <br>';
                            }
                            if($status->statusErro(Status::CampoLogradouroInvalido)){
                                echo '- Logradouro <br>';
                            }
                            if($status->statusErro(Status::CampoNumeroInvalido)){
                                echo '- Número <br>';
                            }
                            if($status->statusErro(Status::CampoComplementoInvalido)){
                                echo '- Complemento <br>';
                            }
                            echo '</div>';
                        }
                    ?>
                    <div class="wrap-input100 validate-input m-b-20" data-validate="nomeusuario">
                        <input class="input100" type="text" name="login" placeholder="Login" value="<?php echo isset($_POST["login"])? $_POST["login"] : "" ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-20" data-validate="senha">
                        <input class="input100" type="text" name="senha" placeholder="Senha" value="<?php echo isset($_POST["senha"])? $_POST["senha"] : "" ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-20" data-validate="nome">
                        <input class="input100" type="text" name="nome" placeholder="Nome" value="<?php echo isset($_POST["nome"])? $_POST["nome"] : "" ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-20" data-validate="sobrenome">
                        <input class="input100" type="text" name="sobrenome" placeholder="Sobrenome" value="<?php echo isset($_POST["sobrenome"])? $_POST["sobrenome"] : "" ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-25" data-validate="cpf">
                        <input class="input100" type="text" name="cpf" placeholder="CPF" value="<?php echo isset($_POST["cpf"])? $_POST["cpf"] : "" ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-20" data-validate="telefone">
                        <input class="input100" type="text" name="telefone" placeholder="Telefone" value="<?php echo isset($_POST["telefone"])? $_POST["telefone"] : "" ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-20" data-validate="e-mail">
                        <input class="input100" type="text" name="email" placeholder="E-mail" value="<?php echo isset($_POST["email"])? $_POST["email"] : "" ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-20" data-validate="cep">
                        <input class="input100" type="text" name="cep" placeholder="CEP" value="<?php echo isset($_POST["cep"])? $_POST["cep"] : "" ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-20" data-validate="logradouro">
                        <input class="input100" type="text" name="logradouro" placeholder="Logradouro" value="<?php echo isset($_POST["logradouro"])? $_POST["logradouro"] : "" ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-25" data-validate="numero">
                        <input class="input100" type="text" name="numero" placeholder="Número" value="<?php echo isset($_POST["numero"])? $_POST["numero"] : "" ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-20" data-validate="complemento">
                        <input class="input100" type="text" name="complemento" placeholder="Complemento" value="<?php echo isset($_POST["complemento"])? $_POST["complemento"] : "" ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="text-center">
                            <button type="submit"> CRIAR CADASTRO </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Scripts -->
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/script_files_index.php"; ?>
    </body>
</html>