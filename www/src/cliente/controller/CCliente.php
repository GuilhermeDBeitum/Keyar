<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/src/cliente/model/MCliente.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/TValidadorCampos.php";

class CCliente implements ControllerBase {
    use ValidadorCampos;
    private $model;
    private $model_usuario;

    public function __construct() {
        $this->model = new MCliente();
        $this->model_usuario = new MUsuario();
    }

    function executarAcao($acao, $dados) {
        $saida = new Retorno(null, null, null);
        switch ($acao) {
            case "adicionarCliente":
                $saida = $this->adicionarCliente($dados);
                break;

            case "excluirCliente":
                $saida = $this->excluirCliente($dados);
                break;

            case "visualizarCliente":
                $saida = $this->visualizarCliente($dados);
                break;

            case "alterarCliente":
                $saida = $this->alterarCliente($dados);
                break;
        }
        return $saida;
    }

    public function adicionarCliente($dados) {
        $this->model->beginTransaction();
        // Adiciona o usuario e se tudo ok, adiciona o cliente
        $status = $this->model_usuario->validarCampos($dados);
        if($this->todosCamposValidos($status, 3)){
            $saida = $this->model_usuario->adicionarUsuario();
            if($saida->statusOK()){
                // Leio o ultimo cliente cadastrado, se ok, adiciona o cliente, utilizando o idusuario
                $saida = $this->model_usuario->visualizarUltimoUsuario();
                if($saida->statusOK()){
                    $status = $this->model->validarCampos(array_merge($dados, ["idusuario" => $saida->getRegistros()->idUsuario]));
                    if($this->todosCamposValidos($status, 10)){
                        $saida = $this->model->adicionarCliente();
                        if($saida->statusOK()){
                            $this->model->commit();
                            header("location: /public/index.php?status=0");
                        }
                    }
                }
            }
        }
        $this->model->rollback();
        return $status;
	}

	public function excluirCliente($dados) {
        $this->model->beginTransaction();
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 2)){
            $saida = $this->model->excluirCliente();
            if($saida->statusOK()){
                $status = $this->model_usuario->validarCampos($dados);
                if($this->todosCamposValidos($status, 1)){
                    $saida = $this->model_usuario->excluirUsuario();
                    if($saida->statusOK()){
                        $this->model->commit();
                        session_destroy();
                        header("location: /public/index.php");
                    }
                }
            }
        }
        $this->model->rollback();
        return $status;
	}

	public function visualizarCliente($dados) {
        $this->model->beginTransaction();
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 1)){
            $saida = $this->model->visualizarCliente();
            if($saida->statusOK()){
                $this->model->commit();
                return $saida;
            }
        }
        $this->model->rollback();
        return $status;
    }

    public function visualizarClienteByIdUsuario($dados) {
        $this->model->beginTransaction();
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 1)){
            $saida = $this->model->visualizarCliente();
            if($saida->statusOK()){
                $this->model->commit();
                return $saida;
            }
        }
        $this->model->rollback();
        return $status;
    }

	public function alterarCliente($dados) {
        $this->model->beginTransaction();
        // Mesmo que o adicionarItem()
        // Se senha passada nao estiver vazia, altera ela
        if($dados["senha"] != ""){
            $status = $this->model_usuario->validarCampos($dados);
            if($this->todosCamposValidos($status, 2)){
                $saida =  $this->model_usuario->alterarUsuario();
                if(!$saida->statusOK()){
                    $this->model_usuario->rollback();
                }
            }
        }
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 8)){
            $saida =  $this->model->alterarCliente();
            if($saida->statusOK()){
                $this->model->commit();
                header("location: /public/cliente/gerenciar_perfil.php?status=0");
            }
        }
        $this->model->rollback();
        return $status;
	}
}