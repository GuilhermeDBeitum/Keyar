<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/ModelImports.php";

class MItem implements ModelBase {
    use GerenciadorConexaoBD;

    private $idItem;
    private $nome;
    private $preco;
    private $quantidade;
    private $modificador;
    private $idCategoria;

    public function getIdItem() {
        return $this->idItem;
    }

    // Validações de entrada em cada setter, usando Regex
    public function setIdItem($idItem) {
        if(preg_match('/^\d+$/', $idItem)){
            $this->idItem = $idItem;
            return Status::Ok;
        }
        else{
            return Status::CampoIdItemInvalido;
        }
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        if(preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÂÊÎÔÛÃÕÀÈÌÒÙàèìòù\- ]+$/', $nome)) {
            $this->nome = $nome;
            return Status::Ok;
        }
        else{
            return Status::CampoNomeInvalido;
        }
    }

    public function getPreco() {
        return $this->preco;
    }

    public function setPreco($preco) {
        if (preg_match('/^\d+[.,]\d+$/', $preco)) {
            str_replace(",",".", $preco);
            $this->preco = $preco;
            return Status::Ok;
        }
        else{
            return Status::CampoPrecoInvalido;
        }
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade) {
        if($quantidade < 0 or $quantidade == ""){
            $quantidade = 0;
        }
        if (preg_match('/^\d+$/', $quantidade)) {
            $this->quantidade = $quantidade;
            return Status::Ok;
        }
        else{
            return Status::CampoQuantidadeInvalido;
        }
    }

    public function getModificador() {
        return $this->quantidade;
    }

    public function setModificador($modificador) {
        if (preg_match('/^-{0,1}\d+$/', $modificador)) {
            $this->modificador = $modificador;
            return Status::Ok;
        }
        else{
            return Status::CampoModificadorInvalido;
        }
    }

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function setIdCategoria($idCategoria) {
        if (preg_match('/^\d+$/', $idCategoria)) {
            $this->idCategoria = $idCategoria;
            return Status::Ok;
        }
        else{
            return Status::CampoIdCategoriaInvalido;
        }
    }

    // Valida e seta os valores nos campos, se passado por parâmetros.
    // OBS: O status de cada setter é retornado e armazenado no objeto de retorno
    function validarCampos($dados) {
        $status = array();
        if(isset($dados["iditem"])){
            $status[] = $this->setIdItem($dados["iditem"]);
        }
        if(isset($dados["nome"])){
            $status[] = $this->setNome($dados["nome"]);
        }
        if(isset($dados["preco"])){
            $status[] = $this->setPreco($dados["preco"]);
        }
        if(isset($dados["quantidade"])){
            $status[] = $this->setQuantidade($dados["quantidade"]);
        }
        if(isset($dados["modificador"])){
            $status[] = $this->setModificador($dados["modificador"]);
        }
        if(isset($dados["idcategoria"])){
            $status[] = $this->setIdCategoria($dados["idcategoria"]);
        }
        return new Retorno($status, null, null);
    }

    // Executam a operação no banco de dados e retornam:
    // - Status da operação;
    // - Número de registros;
    // - Dados do banco de dados (quando select apenas, nas demais operações, o retorno está vazio)
    public function adicionarItem() {
        $query = "insert into item (nome, preco, quantidade, idcategoria) values (?, ?, ?, ?)";
        $parametros = array($this->nome, $this->preco, $this->quantidade, $this->idCategoria);
        $status = $this->executarQuery($query, $parametros);
        return $status;
	}

	public function excluirItem() {
        $query = "delete from item where iditem = ?";
        $parametros = array($this->idItem);
        $status = $this->executarQuery($query, $parametros);
        return $status;
	}

	public function visualizarItem() {
        $query = "select * from item where iditem = ?";
        $parametros = array($this->idItem);
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
    }

    public function visualizarTodosItens() {
        $query = "select * from item";
        $parametros = array();
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
    }

	public function alterarItem() {
        $query = "update item set nome = ?, preco = ?, quantidade = ?, idcategoria = ? where iditem = ?";
        $parametros = array($this->nome, $this->preco, $this->quantidade, $this->idCategoria, $this->idItem);
        $status = $this->executarQuery($query, $parametros);
        return $status;
	}
}