<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/model/MItemPedido.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/model/MItem.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/model/MPedido.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/TValidadorCampos.php";

class CItemPedido implements ControllerBase
{
    use ValidadorCampos;
    private $model;
    private $model_item;
    private $model_pedido;

    public function __construct()
    {
        $this->model = new MItemPedido();
        $this->model_item = new MItem();
        $this->model_pedido = new MPedido();
    }

    function executarAcao($acao, $dados)
    {
        switch ($acao) {
            case "adicionarItemPedido":
                $saida = $this->adicionarItemPedido($dados);
                break;

            case "visualizarTodosItensPedido":
                $saida = $this->visualizarTodosItensPedido($dados);
                break;

            case "alterarItemPedido":
                $saida = $this->alterarItemPedido($dados);
                break;

            default:
                $saida = $this->visualizarTodosItensPedido($dados);
        }
        return $saida;
    }

    public function adicionarItemPedido($dados) {
        $this->model->beginTransaction();
        // Validando os dados de pedido
        $status = $this->model_pedido->validarCampos($dados);
        // Se dados ok, seleciona o pedido, para verificar o status
        if($this->todosCamposValidos($status, 2) and $dados["modificador"] > 0){
            $saida = $this->model_pedido->visualizarPedido();
            // Se o status do pedido for "Em Aberto", pode prosseguir com a ação.
            if($saida->getRegistros()->idstatuspedido == Status::PedidoEmAberto){
                // Instanciando o retorno e validando os campos de entrada
                $status = $this->model_item->validarCampos($dados);

                // Se os campos forem válidos e modificador >= 0
                if ($this->todosCamposValidos($status, 2) and $dados["modificador"] >= 0) {
                    // Lendo o item do banco de dados e calculando a quantidade atualizada
                    $item = $this->model_item->visualizarItem();
                    $quantidade_estoque = $item->getRegistros()->quantidade;
                    $quantidade_atualizada = $quantidade_estoque - $dados["modificador"];

                    // Se a quantidade está disponível em estoque, atualizar valor
                    if ($quantidade_atualizada >= 0) {
                        // Montando o novo registro
                        $item_atualizado = ["nome" => $item->getRegistros()->nome,
                            "preco" => $item->getRegistros()->preco,
                            "idcategoria" => $item->getRegistros()->idCategoria,
                            "quantidade" => $quantidade_atualizada,
                            "iditem" => $item->getRegistros()->idItem];

                        // Validando os campos e se tudo estiver ok, efetuar a atualização do registro e inserir o item pedido
                        $status = $this->model_item->validarCampos($item_atualizado);
                        if ($this->todosCamposValidos($status, 5)) {
                            $saida = $this->model_item->alterarItem();
                            if ($saida->statusOK()) {
                                $saida = $this->model->validarCampos($dados);
                                if ($this->todosCamposValidos($saida, 3)) {
                                    $saida = $this->model->adicionarItemPedido();
                                    if ($saida->statusOK()) {
                                        $this->model->commit();
                                        // redireciona para a tela de gerenciamento de itens de pedido, com o código de erro
                                        header("location: /public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido={$dados["idpedido"]}&status=0");
                                    }
                                }
                            }
                        }
                    }
                    else {
                        $this->model->rollback();
                        // redireciona para a tela de gerenciamento de itens de pedido, com o código de erro
                        header("location: /public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido={$dados["idpedido"]}&status=" . Status::QuantidadeIndisponivelParaVenda);
                    }
                }
            }
            else{
                $this->model->rollback();
                // redireciona para a tela de gerenciamento de itens de pedido, com o código de erro
                header("location: /public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido={$dados["idpedido"]}&status=" . Status::PedidoSomenteVisualizacao);
            }
        }
        $this->model->rollback();
        // Se erro, retorna o status
        return $status;
    }

    public function visualizarTodosItensPedido($dados) {
        $status = $this->model->validarCampos($dados);
        if ($this->todosCamposValidos($status, 1)) {
            $saida = $this->model->visualizarTodosItensPedido();
            if ($saida->statusOK()) {
                // Se for apenas um registro, nesse método, converto para vetor
                $saida->converterRegistroParaVetor();
                return $saida;
            }
        }
        // Se erro, retorna o status
        return $status;
    }

    public function alterarItemPedido($dados) {
        $this->model->beginTransaction();
        // Validando os dados de pedido
        $status = $this->model_pedido->validarCampos($dados);
        // Se dados ok, seleciona o pedido, para verificar o status
        if($this->todosCamposValidos($status, 2)) {
            $saida = $this->model_pedido->visualizarPedido();
            // Se o status do pedido for "Em Aberto", pode prosseguir com a ação.
            if ($saida->getRegistros()->idstatuspedido == Status::PedidoEmAberto) {
                // Instanciando o retorno e validando os campos de entrada
                $parametros = ["iditempedido" => $dados["iditempedido"]];
                $status = $this->model->validarCampos($parametros);

                // Se os campos forem válidos
                if ($this->todosCamposValidos($status, 1)) {
                    // Lendo o item pedido do banco de dados
                    $itempedido = $this->model->visualizarItemPedido();

                    // Se a saída está ok, buscar o item correspondente, utilizando o iditem do item pedido
                    if ($itempedido->statusOK()) {
                        // Repetindo o mesmo processo do item pedido, para o item
                        $parametros = ["iditem" => $itempedido->getRegistros()->idItem];
                        $status = $this->model_item->validarCampos($parametros);
                        if ($this->todosCamposValidos($status, 1)) {
                            $item = $this->model_item->visualizarItem();
                            if ($item->statusOK()) {
                                // Calculando a nova quantidade
                                $quantidade_estoque = $item->getRegistros()->quantidade;
                                $quantidade_atualizada = $quantidade_estoque - $dados["modificador"];
                                if ($quantidade_atualizada >= 0) {
                                    // Montando o novo item e alterando-o no banco de dados
                                    $item_atualizado = ["nome" => $item->getRegistros()->nome,
                                        "preco" => $item->getRegistros()->preco,
                                        "idcategoria" => $item->getRegistros()->idCategoria,
                                        "quantidade" => $quantidade_atualizada,
                                        "iditem" => $item->getRegistros()->idItem];

                                    $status = $this->model_item->validarCampos($item_atualizado);
                                    if ($this->todosCamposValidos($status, 5)) {
                                        $saida = $this->model_item->alterarItem();
                                        if ($saida->statusOK()) {
                                            if($itempedido->getRegistros()->quantidade + $dados["modificador"] >= 0){                                            
                                                // Repetindo o mesmo processo do item, para o item pedido
                                                $itempedido_atualizado = ["iditempedido" => $itempedido->getRegistros()->idItemPedido,
                                                    "iditem" => $itempedido->getRegistros()->idItem,
                                                    "quantidade" => $itempedido->getRegistros()->quantidade + $dados["modificador"],
                                                    "idpedido" => $itempedido->getRegistros()->idPedido];

                                                $status = $this->model->validarCampos($itempedido_atualizado);
                                                if ($this->todosCamposValidos($status, 4)) {
                                                    $saida = $this->model->alterarItemPedido();
                                                    if ($saida->statusOK()) {
                                                        $this->model->commit();
                                                        // redireciona para a tela de gerenciamento de itens de pedido
                                                        header("location: /public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido={$dados["idpedido"]}&status=0");
                                                    }
                                                }
                                            }
                                            else{
                                                $this->model->rollback();
                                                // redireciona para a tela de gerenciamento de itens de pedido, com o código de erro
                                                header("location: /public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido={$dados["idpedido"]}&status=" . Status::QuantidadeIndisponivelParaVenda);
                                            }
                                        }
                                    }
                                }
                                else {
                                    $this->model->rollback();
                                    // redireciona para a tela de gerenciamento de itens de pedido, com o código de erro
                                    header("location: /public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido={$dados["idpedido"]}&status=" . Status::QuantidadeIndisponivelParaVenda);
                                }
                            }
                        }
                    }
                }
            }
            else{
                $this->model->rollback();
                // redireciona para a tela de gerenciamento de itens de pedido, com o código de erro
                header("location: /public/pedido/gerenciar_itens_pedido.php?acao=visualizarTodosItensPedido&idpedido={$dados["idpedido"]}&status=" . Status::PedidoSomenteVisualizacao);
            }
        }
        $this->model->rollback();
        // Se erro, retorna o status
        return $status;
    }
}

