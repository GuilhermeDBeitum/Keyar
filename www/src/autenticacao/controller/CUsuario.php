<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/model/MUsuario.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/cliente/model/MCliente.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/model/MPedido.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/TValidadorCampos.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/ControllerBase.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Perfil.php";

class CUsuario implements ControllerBase {
    use ValidadorCampos;
    private $model;
    private $model_cliente;
    private $model_pedido;

    public function __construct() {
        $this->model = new MUsuario();
        $this->model_cliente = new MCliente();
        $this->model_pedido = new MPedido();
    }

    function executarAcao($acao, $dados) {
        $saida = new Retorno(null, null, null);
        switch ($acao) {
            case "efetuarLogin":
                $saida = $this->efetuarLogin($dados);
                break;

            case "adicionarUsuario":
                $saida = $this->adicionarUsuario($dados);
                break;

            case "excluirUsuario":
                $saida = $this->excluirUsuario($dados);
                break;

            case "visualizarUsuario":
                $saida = $this->visualizarUsuario($dados);
                break;

            case "visualizarUltimoUsuario":
                $saida = $this->visualizarUltimoUsuario($dados);
                break;

            case "alterarUsuario":
                $saida = $this->alterarUsuario($dados);
                break;

            case "verificarSessao":
                $this->verificarSessao();
                break;

            case "verificarSessaoCliente":
                $this->verificarSessao();
                $this->verificarSessaoCliente();
                break;

            case "verificarSessaoBalconista":
                $this->verificarSessao();
                $this->verificarSessaoBalconista();
                break;

            default:
                $saida = $this->efetuarLogin($dados);
        }
        return $saida;
    }

    public function efetuarLogin($dados) {
        $this->model->beginTransaction();
        // Validando os campos
        $saida = $this->model->validarCampos($dados);
        // Se todos OK
        if($this->todosCamposValidos($saida, 2)) {
            // Efetua o login
            $saida = $this->model->efetuarLogin();

            // Verifica se li do banco de dados apenas um registro
            if ($saida->getTotalRegistros() == 1) {
                // Se sim, lê o mesmo
                $usuario = $saida->getRegistros();
                // E compara a senha de entrada (criptografada no setSenha()) com a do banco de dados
                if ($usuario->senha == $this->model->getSenha()) {
                    // Se iguais, inicia sessão de usuário, carrega o tipo do perfil e se for cliente, carrega o id dele
                    session_start();
                    $_SESSION["login"] = Status::Ok;
                    $_SESSION["idPerfil"] = $usuario->idperfil;
                    $_SESSION["idusuario"] = $usuario->idusuario;
                    if($_SESSION["idPerfil"] == Perfil::Cliente){
                        $status = $this->model_cliente->validarCampos(["idusuario" => $usuario->idusuario]);
                        if($this->todosCamposValidos($status, 1)) {
                            $saida = $this->model_cliente->visualizarClienteByIdUsuario();
                            if($saida->statusOK()){
                                $_SESSION["idcliente"] = $saida->getRegistros()->idCliente;
                                // Restaurar ultimo pedido desse cliente, se status dele for "Em Aberto"
                                $status = $this->model_pedido->validarCampos(["idcliente" => $_SESSION["idcliente"]]);
                                if($this->todosCamposValidos($status, 1)) {
                                    $saida = $this->model_pedido->visualizarUltimoPedidoCliente();
                                    if($saida->getTotalRegistros() != 0 and $saida->getRegistros()->idStatusPedido == Status::PedidoEmAberto){
                                        $_SESSION["idpedido"] = $saida->getRegistros()->idPedido;
                                    }
                                }                                
                            }
                        }
                    }
                    $this->model->commit();
                    header("location: /public/main.php");
                }
                $saida->setStatus(array(Status::SenhaIncorreta));
            }
            else{
                $saida->setStatus(array(Status::CampoLoginInvalido));
            }
        }
        $this->model->rollback();
        return $saida;
    }

    public function adicionarUsuario($dados) {
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 3)){
            $saida = $this->model->adicionarUsuario();
            if($saida->statusOK()){
                return $saida;
            }
        }
        return $status;
    }

    public function excluirUsuario($dados) {
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 1)){
            $saida = $this->model->excluirUsuario();
            if($saida->statusOK()){
                return $saida;
            }
        }
        return $status;
    }

    public function visualizarUsuario($dados) {
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 1)){
            $saida = $this->model->visualizarUsuario();
            if($saida->statusOK()){
                return $saida;
            }
        }
        return $status;
    }

    public function visualizarUltimoUsuario() {
        // Mesmo que o adicionarItem()
        $saida = $this->model->visualizarUltimoUsuario();
        return $saida;
    }

    public function alterarUsuario($dados) {
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 1)){
            $saida = $this->model->alterarUsuario();
            if($saida->statusOK()){
                return $saida;
            }
        }
        return $status;
    }

    public function verificarSessao() {
        session_start();
        if(!isset($_SESSION["login"])){
            header('location:/public/index.php');
        }
    }

    public function verificarSessaoCliente() {
        // se nao for cliente
        if($_SESSION["idPerfil"] != Perfil::Cliente){
            header('location:/public/index.php');
        }
    }

    public function verificarSessaoBalconista() {
        // se nao for balconista
        if($_SESSION["idPerfil"] != Perfil::Balconista){
            header('location:/public/index.php');
        }
    }
}