<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/ModelImports.php";

class MPedido implements ModelBase {
    use GerenciadorConexaoBD;

	private $idPedido;
    private $idCliente;
	private $idStatusPedido;
    private $idFormaPagamento;
    private $cpf;

    // Validações de entrada em cada setter, usando Regex
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

    public function getIdCliente() {
        return $this->idCliente;
    }

    public function setIdCliente($idCliente) {
        if(preg_match('/^\d+$/', $idCliente)) {
            $this->idCliente = $idCliente;
            return Status::Ok;
        }
        else{
            return Status::CampoIdClienteInvalido;
        }
    }

    public function getIdStatusPedido() {
        return $this->idStatusPedido;
    }

    public function setIdStatusPedido($idStatusPedido) {
        if(preg_match('/^\d+$/', $idStatusPedido)) {
            $this->idStatusPedido = $idStatusPedido;
            return Status::Ok;
        }
        else{
            return Status::CampoIdStatusPedidoInvalido;
        }
    }

    public function getIdFormaPagamento() {
        return $this->idFormaPagamento;
    }

    public function setIdFormaPagamento($idFormaPagamento) {
        if(preg_match('/^\d+$/', $idFormaPagamento)) {
            $this->idFormaPagamento = $idFormaPagamento;
            return Status::Ok;
        }
        else{
            return Status::CampoIdFormaPagamentoInvalido;
        }
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        if (preg_match('/^\d{9}-{0,1}\d{2}$/', $cpf)) {
            $this->cpf = $cpf;
            return Status::Ok;
        }
        else{
            return Status::CampoCpfInvalido;
        }
    }

    // Valida e seta os valores nos campos, se passado por parâmetros.
    // OBS: O status de cada setter é retornado e armazenado no objeto de retorno
    function validarCampos($dados) {
        $status = array();
        if(isset($dados["idpedido"])){
            $status[] = $this->setIdPedido($dados["idpedido"]);
        }
        if(isset($dados["idcliente"])){
            $status[] = $this->setIdCliente($dados["idcliente"]);
        }
        if(isset($dados["idstatuspedido"])){
            $status[] = $this->setIdStatusPedido($dados["idstatuspedido"]);
        }
        if(isset($dados["idformapagamento"])){
            $status[] = $this->setIdFormaPagamento($dados["idformapagamento"]);
        }
        if(isset($dados["cpf"])){
            $status[] = $this->setCpf($dados["cpf"]);
        }
        return new Retorno($status, null, null);
    }

    // Executam a operação no banco de dados e retornam:
    // - Status da operação;
    // - Número de registros;
    // - Dados do banco de dados (quando select apenas, nas demais operações, o retorno está vazio)
    public function adicionarPedido() {
        $query = "insert into pedido (idcliente, idstatuspedido, idformapagamento) values (?, ?, ?)";
        $parametros = array($this->idCliente, $this->idStatusPedido, $this->idFormaPagamento);
        $resultado = $this->executarQuery($query, $parametros);
        return $resultado;
	}

	public function excluirPedido() {
        $query = "update pedido set idstatuspedido = ? where idpedido = ?";
        $parametros = array($this->idStatusPedido, $this->idPedido);
        $resultado = $this->executarQuery($query, $parametros);
        return $resultado;
	}

	public function visualizarPedido() {
        $query = "select cpf, idcliente, idpedido, idstatuspedido, idformapagamento, ifnull(sum(valor_total_produto), 0) as valor_total, status_pedido from
	                (select cpf, idcliente, idpedido, idstatuspedido, idformapagamento, quantidade * preco as valor_total_produto, status_pedido from 
		                (select cliente.cpf, pedido.idcliente, pedido.idpedido, pedido.idstatuspedido, pedido.idformapagamento, itempedido.quantidade, item.preco, statuspedido.nome as status_pedido from
                         pedido inner join statuspedido on pedido.idstatuspedido = statuspedido.idstatuspedido inner join cliente on
                         cliente.idcliente = pedido.idcliente left join 
                         itempedido on pedido.idpedido = itempedido.idpedido left join 
                         item on itempedido.iditem = item.iditem) as r) as s
                  where idcliente = ?
                  group by idpedido
                  having idpedido = ?";
        $parametros = array($this->idCliente, $this->idPedido);
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
	}

    public function visualizarPedidosCliente() {
        $query = "select idcliente, idpedido, idstatuspedido, idformapagamento, ifnull(sum(valor_total_produto), 0) as valor_total, status_pedido from
	                (select idcliente, idpedido, idstatuspedido, idformapagamento, quantidade * preco as valor_total_produto, status_pedido from 
		                (select pedido.idcliente, pedido.idpedido, pedido.idstatuspedido, pedido.idformapagamento, itempedido.quantidade, item.preco, statuspedido.nome as status_pedido from
                         pedido inner join statuspedido on pedido.idstatuspedido = statuspedido.idstatuspedido left join 
                         itempedido on pedido.idpedido = itempedido.idpedido left join 
                         item on itempedido.iditem = item.iditem) as r) as s
                  where idcliente = ?
                  group by idpedido";

        $parametros = array($this->idCliente);
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
    }

    public function visualizarTodosPedidos() {
        $query = "select cpf, idcliente, idpedido, idstatuspedido, idformapagamento, ifnull(sum(valor_total_produto), 0) as valor_total, status_pedido from
	                (select cpf, idcliente, idpedido, idstatuspedido, idformapagamento, quantidade * preco as valor_total_produto, status_pedido from 
		                (select cliente.cpf, pedido.idcliente, pedido.idpedido, pedido.idstatuspedido, pedido.idformapagamento, itempedido.quantidade, item.preco, statuspedido.nome as status_pedido from
                         pedido inner join statuspedido on pedido.idstatuspedido = statuspedido.idstatuspedido inner join cliente on
                         cliente.idcliente = pedido.idcliente left join 
                         itempedido on pedido.idpedido = itempedido.idpedido left join 
                         item on itempedido.iditem = item.iditem) as r) as s
                  where idstatuspedido = ?
                  group by idpedido;";

        $parametros = array($this->idStatusPedido);
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
    }

    public function visualizarUltimoPedidoCliente() {
        $query = "select * from pedido where idcliente = ? order by idpedido desc limit 1";
        $parametros = array($this->idCliente);
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
    }

	public function alterarPedido() {
        $query = "update pedido set idcliente = ?, idstatuspedido = ?, idformapagamento = ? where idpedido = ?";
        $parametros = array($this->idCliente, $this->idStatusPedido, $this->idFormaPagamento, $this->idPedido);
        $status = $this->executarQuery($query, $parametros);
        return $status;
	}

    public function confirmarRetiradaPedido() {
        $query = "update pedido set idstatuspedido = ? where idpedido = ?";
        $parametros = array($this->idStatusPedido, $this->idPedido);
        $status = $this->executarQuery($query, $parametros);
        return $status;
    }
}