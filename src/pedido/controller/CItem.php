<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/model/MItem.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/TValidadorCampos.php";

class CItem implements ControllerBase {
    use ValidadorCampos;
    private $model;

    public function __construct() {
        $this->model = new MItem();
    }

    function executarAcao($acao, $dados) {
        $saida = new Retorno(null, null, null);
        switch ($acao) {
            case "adicionarItem":
                $saida = $this->adicionarItem($dados);
                break;

            case "excluirItem":
                $saida = $this->excluirItem($dados);
                break;

            case "visualizarItem":
                $saida = $this->visualizarItem($dados);
                break;

            case "visualizarTodosItens":
                $saida = $this->visualizarTodosItens();
                break;

            case "alterarItem":
                $saida = $this->alterarItem($dados);
                break;

            default:
                $saida = $this->visualizarTodosItens();
        }
        return $saida;
    }

    public function adicionarItem($dados) {
        $this->model->beginTransaction();
        // Validando os campos
        $saida = $this->model->validarCampos($dados);
        // Se todos OK
        if($this->todosCamposValidos($saida, 4)){
            // Chama o model
            $saida = $this->model->adicionarItem();
            // Se status da execução da ação, no model for OK
            if($saida->statusOK()){
                // redireciona para tela de gerenciamento
                $this->model->commit();
                header("location: /public/produto/gerenciar_itens.php?status=0");
            }
        }
        $this->model->rollback();
        return $saida;
	}

	public function excluirItem($dados) {
        $this->model->beginTransaction();
        // Mesmo que o adicionarItem()
        $saida = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($saida, 1)){
            $saida = $this->model->excluirItem();
            if($saida->statusOK()){
                $this->model->commit();
                header("location: /public/produto/gerenciar_itens.php?status=0");
            }
        }
        $this->model->rollback();
        return $saida;
	}

	public function visualizarItem($dados) {
        // Mesmo que o adicionarItem()
        $saida = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($saida, 1)){
            return $this->model->visualizarItem();
        }
        return $saida;
    }

    public function visualizarTodosItens() {
        // Mesmo que o adicionarItem()
        $saida = $this->model->visualizarTodosItens();
        // Se for apenas um registro, nesse método, converto para vetor
        $saida->converterRegistroParaVetor();
        return $saida;
    }

	public function alterarItem($dados) {
        $this->model->beginTransaction();
        // Mesmo que o adicionarItem()
        $status = $this->model->validarCampos($dados);
        if($this->todosCamposValidos($status, 5)){
            $item = $this->model->visualizarItem();
            // Calculando a nova quantidade
            $quantidade = $item->getRegistros()->quantidade;
            $this->model->setQuantidade($quantidade + $dados["modificador"]);
            $saida =  $this->model->alterarItem();
            if($saida->statusOK()){
                $this->model->commit();
                header("location: /public/produto/gerenciar_itens.php?status=0");
            }
        }
        $this->model->rollback();
        return $status;
	}
}