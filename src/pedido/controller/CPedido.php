<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/model/MPedido.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/cliente/model/MCliente.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/controller/CItemPedido.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/TValidadorCampos.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";


class CPedido{
    use ValidadorCampos;
    private $model;
    private $model_cliente;

    public function __construct() {
        $this->model = new MPedido();
        $this->model_cliente = new MCliente();
    }

    function executarAcao($acao, $dados) {
       $saida = new Retorno(null, null, null);
        switch ($acao) {
            case "adicionarPedido":
                $saida = $this->adicionarPedido($dados);
                break;

            case "excluirPedido":
                $saida = $this->excluirPedido($dados);
                break;

            case "visualizarPedido":
                $saida = $this->visualizarPedido($dados);
                break;

            case "visualizarUltimoPedidoCliente":
                $saida = $this->visualizarUltimoPedidoCliente($dados);
                break;

            case "visualizarPedidosCliente":
                $saida = $this->visualizarPedidosCliente($dados);
                break;

            case "visualizarTodosPedidos":
                $saida = $this->visualizarTodosPedidos($dados);
                break;

            case "alterarPedido":
                $saida = $this->alterarPedido($dados);
                break;

            case "confirmarRetiradaPedido":
                $saida = $this->confirmarRetiradaPedido($dados);
                break;

            default:
                $saida = $this->visualizarPedidosCliente($dados);
        }
        return $saida;
    }

    public function adicionarPedido($dados) {
        $this->model->beginTransaction();
        // Seleciona o último pedido do cliente
        $parametros = ["idcliente" => $dados["idcliente"]];
        $saida = $this->executarAcao("visualizarUltimoPedidoCliente", $parametros);

        // Se o status dele for "Em Aberto", restaura ele ao invés de criar um novo e redireciona para selecao de itens
        if($saida->getTotalRegistros() != 0 and $saida->getRegistros()->idStatusPedido == Status::PedidoEmAberto){
            $_SESSION["idpedido"] = $saida->getRegistros()->idPedido;
            $this->model->commit();
            header("location: /public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido={$_SESSION["idpedido"]}");
        }
        else {
            // Cria o pedido
            $saida = $this->model->validarCampos($dados);
            if ($this->todosCamposValidos($saida, 3)) {
                $saida = $this->model->adicionarPedido();
                // Se adicionou com sucesso, seleciona-o
                if ($saida->statusOK()) {
                    $status = $this->model->validarCampos($parametros);
                    if ($this->todosCamposValidos($status, 1)) {
                        $saida = $this->model->visualizarUltimoPedidoCliente();
                        // Se seleção foi feita com sucesso, fixa-o na sessao e redireciona para seleção de itens
                        if ($saida->statusOK()) {
                            $_SESSION["idpedido"] = $saida->getRegistros()->idPedido;
                            $this->model->commit();
                            header("location: /public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido={$_SESSION["idpedido"]}");
                        }
                    }
                }
            }
        }
        $this->model->rollback();
        return $saida;
	}

	public function excluirPedido($dados) {
        $this->model->beginTransaction();
        // Mesmo que o adicionarItem()
        // OBS: A exclusão do pedido é apenas o cancelamento do mesmo
        $status = $this->model->validarCampos(array_merge($dados, ["idstatuspedido" => Status::PedidoCancelado]));
        if($this->todosCamposValidos($status, 2)){
            $saida = $this->model->excluirPedido();
            if($saida->statusOK()){
                $this->model->commit();
                header("location: /public/pedido/gerenciar_pedidos.php?status=" . Status::Ok);
            }
        }
        $this->model->rollback();
        return $status;
	}

	public function visualizarPedido($dados) {
        $this->model->beginTransaction();
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 2)){
            $saida = $this->model->visualizarPedido();
            if($saida->statusOK()){
                $this->model->commit();
                return $saida;
            }
        }
        $this->model->rollback();
        return $status;
	}

    public function visualizarPedidosCliente($dados) {
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 1)){
            $saida = $this->model->visualizarPedidosCliente();
            $saida->converterRegistroParaVetor();
            return $saida;
        }
        return $status;
    }

    public function visualizarTodosPedidos($dados) {
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 1)){
            $saida = $this->model->visualizarTodosPedidos();
            $saida->converterRegistroParaVetor();
            return $saida;
        }
        return $status;
    }

    public function visualizarUltimoPedidoCliente($dados) {
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 1)){
            $saida = $this->model->visualizarUltimoPedidoCliente();
            if($saida->statusOK()){
                return $saida;
            }
        }
        return $status;
    }

	public function alterarPedido($dados) {
        $this->model->beginTransaction();
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 4)){
            $saida = $this->model->alterarPedido();
            if($saida->statusOK()){
                $this->model->commit();
                return $saida;
            }
        }
        $this->model->rollback();
        return $status;
	}

    public function confirmarRetiradaPedido($dados) {
        $this->model->beginTransaction();
        // Validando dados de cliente
        $status = $this->model_cliente->validarCampos($dados);
        if($this->todosCamposValidos($status, 1)) {
            // Se ok, lendo o cliente do banco de dados
            $saida = $this->model_cliente->visualizarClienteByCpf();
            // Se leitura ok, validando os dados do pedido (idpedido, vindo do formulário, e idcliente, lido na consulta)
            if($saida->statusOK() and $saida->getTotalRegistros() == 1){
                $cpf_formulario = $dados["cpf"];
                $status = $this->model->validarCampos(["idcliente" => $saida->getRegistros()->idCliente,
                                                        "idpedido" => $dados["idpedido"]]);

                if($this->todosCamposValidos($status, 2)) {
                    // Lendo os dados do pedido
                    $saida = $this->model->visualizarPedido();
                    // Se leitura ok
                    if($saida->statusOK() and $saida->getTotalRegistros() == 1){
                        $cpf_cliente = $saida->getRegistros()->cpf;
                        // Se o CPF lido do formulário for igual ao cadastrado ao realizar o pedido
                        if($cpf_formulario == $cpf_cliente){
                            // Altera o status do pedido
                            $status = $this->model->validarCampos(["idpedido" => $dados["idpedido"], "idstatuspedido" => Status::PedidoRetirado]);
                            if($this->todosCamposValidos($status, 2)) {
                                $saida = $this->model->confirmarRetiradaPedido();
                                if($saida->statusOK()){
                                    // Se alteracao Ok, redireciona para tela de visualizar os itens do pedido
                                    $this->model->commit();
                                    header("location: /public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido={$dados["idpedido"]}&status=" . Status::Ok);
                                }
                                else{
                                    $saida->setStatus([Status::CpfDiferentePedido]);
                                    $this->model->rollback();
                                    return $saida;
                                }
                            }
                        }
                    }
                    else{
                        $this->model->rollback();
                        $saida->setStatus([Status::CpfDiferentePedido]);
                        return $saida;
                    }
                }

            }
            else{
                $this->model->rollback();
                $saida->setStatus([Status::CpfDiferentePedido]);
                return $saida;
            }
        }
        $this->model->rollback();
        return $status;
    }
}