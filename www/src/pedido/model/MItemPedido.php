<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/ModelImports.php";

class MItemPedido implements ModelBase{
    use GerenciadorConexaoBD;

    private $idItemPedido;
	private $idPedido;
	private $idItem;
	private $quantidade;
	private $modificador;

    // Validações de entrada em cada setter, usando Regex
    public function getIdItemPedido() {
        return $this->idItemPedido;
    }

    public function setIdItemPedido($idItemPedido) {
        if(preg_match('/^\d+$/', $idItemPedido)) {
            $this->idItemPedido = $idItemPedido;
            return Status::Ok;
        }
        else{
            return Status::CampoIdItemPedidoInvalido;
        }
    }

    public function getIdPedido() {
        return $this->idPedido;
    }

    public function setIdPedido($idPedido) {
        if(preg_match('/^\d+$/', $idPedido)) {
            $this->idPedido = $idPedido;
            return Status::Ok;
        }
        else{
            return Status::CampoIdPedidoInvalido;
        }
    }

    public function getIdItem() {
        return $this->idItem;
    }

    public function setIdItem($idItem) {
        if(preg_match('/^\d+$/', $idItem)) {
            $this->idItem = $idItem;
            return Status::Ok;
        }
        else{
            return Status::CampoIdItemInvalido;
        }
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade) {
        if(preg_match('/^-{0,1}\d+$/', $quantidade)) {
            $this->quantidade = $quantidade;
            return Status::Ok;
        }
        else{
            return Status::CampoQuantidadeInvalido;
        }
    }

    public function getModificador() {
        return $this->modificador;
    }

    public function setModificador($modificador) {
        if(preg_match('/^-{0,1}\d+$/', $modificador)) {
            $this->modificador = $modificador;
            return Status::Ok;
        }
        else{
            return Status::CampoModificadorInvalido;
        }
    }

    // Valida e seta os valores nos campos, se passado por parâmetros.
    // OBS: O status de cada setter é retornado e armazenado no objeto de retorno
    function validarCampos($dados) {
        $status = array();
        if(isset($dados["iditempedido"])){
            $status[] = $this->setIdItemPedido($dados["iditempedido"]);
        }
        if(isset($dados["idpedido"])){
            $status[] = $this->setIdPedido($dados["idpedido"]);
        }
        if(isset($dados["iditem"])){
            $status[] = $this->setIdItem($dados["iditem"]);
        }
        if(isset($dados["quantidade"])){
            $status[] = $this->setQuantidade($dados["quantidade"]);
        }
        if(isset($dados["modificador"])){
            $status[] = $this->setModificador($dados["modificador"]);
        }
        return new Retorno($status, null, null);
    }

    // Executam a operação no banco de dados e retornam:
    // - Status da operação;
    // - Número de registros;
    // - Dados do banco de dados (quando select apenas, nas demais operações, o retorno está vazio)
	public function adicionarItemPedido() {
        $query = "insert into itempedido (idpedido, iditem, quantidade) values (?, ?, ?)";
        $parametros = array($this->idPedido, $this->idItem, $this->modificador);
        $status = $this->executarQuery($query, $parametros);
        return $status;
	}

	public function visualizarItemPedido() {
        $query = "select * from itempedido where iditempedido = ?";
        $parametros = array($this->idItemPedido);
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
	}

    public function visualizarTodosItensPedido() {
        $query = "select item.iditem, item.nome, item.preco, item.quantidade as quantidade_estoque, 0 as quantidade_pedido, null as idpedido, null as iditempedido from item
                  where item.iditem not in (select item.iditem from item inner join itempedido on
                                            itempedido.iditem = item.iditem
                                            where itempedido.idpedido = ?)
                  union
                  select item.iditem, item.nome, item.preco, item.quantidade as quantidade_estoque, itempedido.quantidade as quantidade_pedido, itempedido.idpedido, itempedido.iditempedido from item inner join itempedido on
                  itempedido.iditem = item.iditem
                  where itempedido.idpedido = ?";
        $parametros = array($this->idPedido, $this->idPedido);
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
    }

	public function alterarItemPedido() {
        $query = "update itempedido set idpedido = ?, iditem = ?, quantidade = ? where iditempedido = ?";
        $parametros = array($this->idPedido, $this->idItem, $this->quantidade, $this->idItemPedido);
        $status = $this->executarQuery($query, $parametros);
        return $status;
	}
}