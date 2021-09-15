<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/ModelImports.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/model/MUsuario.php";

class MCliente extends MUsuario implements ModelBase {
    private $idCliente;
	private $cpf;
	private $nome;
	private $sobrenome;
	private $email;
	private $telefone;
    private $cep;
	private $logradouro;
	private $numero;
    private $complemento;
    private $idUsuario;

    // Validações de entrada em cada setter, usando Regex
	public function getIdCliente() {
        return $this->idCliente;
    }

    public function setIdCliente($idCliente) {
        if(preg_match('/^\d+$/', $idCliente)){
            $this->idCliente = $idCliente;
            return Status::Ok;
        }
        else{
            return Status::CampoIdClienteInvalido;
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

	public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        if(preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÂÊÎÔÛÃÕÀÈÌÒÙàèìòù ]+$/', $nome)) {
            $this->nome = $nome;
            return Status::Ok;
        }
        else{
            return Status::CampoNomeInvalido;
        }
	}
	
	public function getSobrenome() {
        return $this->sobrenome;
    }

    public function setSobrenome($sobrenome) {
        if(preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÂÊÎÔÛÃÕÀÈÌÒÙàèìòù ]+$/', $sobrenome)) {
            $this->sobrenome = $sobrenome;
            return Status::Ok;
        }
        else{
            return Status::CampoSobrenomeInvalido;
        }
	}
	
	public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if(preg_match('/^[A-Za-z_.]+@[A-Za-z]+\.[A-Za-z]+(?:\.[A-Za-z]+)*$/', $email)) {
            $this->email = $email;
            return Status::Ok;
        }
        else{
            return Status::CampoEmailInvalido;
        }
	}

	public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        if(preg_match('/^\({0,1}\d{2}\){0,1}\d{4,5}\-{0,1}\d{4}$/', $telefone)) {
            $this->telefone = $telefone;
            return Status::Ok;
        }
        else{
            return Status::CampoTelefoneInvalido;
        }
    }

    public function getCep() {
        return $this->cep;
    }
    
    public function setCep($cep) {
        if(preg_match('/^\d{5}-{0,1}\d{3}$/', $cep)) {
            $this->cep = $cep;
            return Status::Ok;
        }
        else{
            return Status::CampoCepInvalido;
        }
    }
    
    public function getLogradouro() {
        return $this->logradouro;
    }

    public function setLogradouro($logradouro) {
        if(preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÂÊÎÔÛÃÕÀÈÌÒÙàèìòù ]+$/', $logradouro)) {
            $this->logradouro = $logradouro;
            return Status::Ok;
        }
        else{
            return Status::CampoLogradouroInvalido;
        }
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        if(preg_match('/^\d+$/', $numero)) {
            $this->numero = $numero;
            return Status::Ok;
        }
        else{
            return Status::CampoNumeroInvalido;
        }
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function setComplemento($complemento) {
        if(preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÂÊÎÔÛÃÕÀÈÌÒÙàèìòù ]+$/', $complemento)) {
            $this->complemento = $complemento;
            return Status::Ok;
        }
        else {
            return Status::CampoComplementoInvalido;
        }
    }
    
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        if(preg_match('/^\d+$/', $idUsuario)){
            $this->idUsuario = $idUsuario;
            return Status::Ok;
        }
        else{
            return Status::CampoIdUsuarioInvalido;
        }
    }

    // Valida e seta os valores nos campos, se passado por parâmetros.
    // OBS: O status de cada setter é retornado e armazenado no objeto de retorno
	function validarCampos($dados) {
        $status = array();
        if(isset($dados["idcliente"])){
            $status[] = $this->setIdCliente($dados["idcliente"]);
		}
		if(isset($dados["cpf"])){
            $status[] = $this->setCpf($dados["cpf"]);
        }
        if(isset($dados["nome"])){
            $status[] = $this->setNome($dados["nome"]);
        }
        if(isset($dados["sobrenome"])){
            $status[] = $this->setSobrenome($dados["sobrenome"]);
        }
        if(isset($dados["email"])){
            $status[] = $this->setEmail($dados["email"]);
        }
        if(isset($dados["telefone"])){
            $status[] = $this->setTelefone($dados["telefone"]);
        }
        if(isset($dados["cep"])){
            $status[] = $this->setCep($dados["cep"]);
        }
        if(isset($dados["logradouro"])){
            $status[] = $this->setLogradouro($dados["logradouro"]);
        }
        if(isset($dados["numero"])){
            $status[] = $this->setNumero($dados["numero"]);
        }
        if(isset($dados["complemento"])){
            $status[] = $this->setComplemento($dados["complemento"]);
        }
        if(isset($dados["idusuario"])){
            $status[] = $this->setIdUsuario($dados["idusuario"]);
        }
        return new Retorno($status, null, null);
    }

    // Executam a operação no banco de dados e retornam:
    // - Status da operação;
    // - Número de registros;
    // - Dados do banco de dados (quando select apenas, nas demais operações, o retorno está vazio)
	public function adicionarCliente() {
		$query = "insert into cliente (cpf, nome, sobrenome, email, telefone, cep, logradouro, numero, complemento, idusuario) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $parametros = array($this->cpf, $this->nome, $this->sobrenome, $this->email, $this->telefone, $this->cep, $this->logradouro, $this->numero, $this->complemento, $this->idUsuario);
        $status = $this->executarQuery($query, $parametros);
        return $status;
	}

	public function excluirCliente() {
		$query = "delete from cliente where idcliente = ?";
        $parametros = array($this->idCliente);
        $status = $this->executarQuery($query, $parametros);
        return $status;
	}

	public function visualizarCliente() {
		$query = "select * from cliente where idcliente = ?";
        $parametros = array($this->idCliente);
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
	}

    public function visualizarClienteByCpf() {
        $query = "select * from cliente where cpf = ?";
        $parametros = array($this->cpf);
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
    }

    public function visualizarClienteByIdUsuario() {
        $query = "select * from cliente where idusuario = ?";
        $parametros = array($this->idUsuario);
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
    }

	public function alterarCliente() {
		$query = "update cliente set email = ?, telefone = ?, cep = ?, logradouro = ?, numero = ?, complemento = ? where idcliente = ?";
        $parametros = array($this->email, $this->telefone, $this->cep, $this->logradouro, $this->numero, $this->complemento, $this->idCliente);
        $status = $this->executarQuery($query, $parametros);
        return $status;
	}
}