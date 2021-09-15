<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/ModelImports.php";

class MUsuario implements ModelBase {
	use GerenciadorConexaoBD;

	private $idUsuario;
	private $login;
	private $senha;
	private $idPerfil;

    // Validações de entrada em cada setter, usando Regex
	public function getidUsuario() {
		return $this->idUsuario;
	}

	public function setidUsuario($idUsuario) {
		if(preg_match('/^\d+$/', $idUsuario)) {
            $this->idUsuario = $idUsuario;
            return Status::Ok;
        }
        else{
            return Status::CampoIdUsuarioInvalido;
        }
	}

	public function getLogin() {
		return $this->login;
	}

	public function setLogin($login) {
		if(preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÂÊÎÔÛÃÕÀÈÌÒÙàèìòù\-_0-9]+$/', $login)) {
			$this->login = $login;
			return Status::Ok;
        }
        else{
			return Status::CampoLoginInvalido;
        }
	}

	public function getSenha() {
		return $this->senha;
	}

	public function setSenha($senha) {
		if(preg_match('/^.+$/', $senha)) {
			// criptografando a senha
            $this->senha = hash("sha256", $senha);
            return Status::Ok;
        }
        else{
			return Status::CampoSenhaInvalido;
        }
	}

	public function getidPerfil() {
		return $this->idPerfil;
	}

	public function setidPerfil($idPerfil) {
		if(preg_match('/^\d+$/', $idPerfil)) {
            $this->idPerfil = $idPerfil;
            return Status::Ok;
        }
        else{
            return Status::CampoIdPerfilInvalido;
        }
	}

    // Valida e seta os valores nos campos, se passado por parâmetros.
    // OBS: O status de cada setter é retornado e armazenado no objeto de retorno
    function validarCampos($dados) {
        $status = array();
        if(isset($dados["idusuario"])){
            $status[] = $this->setidUsuario($dados["idusuario"]);
        }
        if(isset($dados["login"])){
            $status[] = $this->setLogin($dados["login"]);
        }
        if(isset($dados["senha"])){
            $status[] = $this->setSenha($dados["senha"]);
        }
        if(isset($dados["idperfil"])){
            $status[] = $this->setidPerfil($dados["idperfil"]);
        }
        return new Retorno($status, null, null);
    }

    // Executam a operação no banco de dados e retornam:
    // - Status da operação;
    // - Número de registros;
    // - Dados do banco de dados (quando select apenas, nas demais operações, o retorno está vazio)
	public function efetuarLogin() {
		$query = "select senha, idperfil, idusuario from usuario where login = ?";
		$parametros = array($this->login);
		$resultado = $this->executarQuery($query, $parametros);
		return $resultado;
	}

    public function adicionarUsuario() {
        $query = "insert into usuario (login, senha, idperfil) values (?, ?, ?)";
        $parametros = array($this->login, $this->senha, $this->idPerfil);
        $status = $this->executarQuery($query, $parametros);
        return $status;
    }

    public function excluirUsuario() {
        $query = "delete from usuario where idusuario = ?";
        $parametros = array($this->idUsuario);
        $status = $this->executarQuery($query, $parametros);
        return $status;
    }

    public function visualizarUsuario() {
        $query = "select * from usuario where idusuario = ?";
        $parametros = array($this->idUsuario);
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
    }

    public function visualizarUltimoUsuario() {
        $query = "select * from usuario order by idusuario desc limit 1";
        $parametros = array();
        $saida = $this->executarQuery($query, $parametros);
        return $saida;
    }

    public function alterarUsuario() {
        $query = "update usuario set senha = ? where idusuario = ?";
        $parametros = array($this->senha, $this->idUsuario);
        $status = $this->executarQuery($query, $parametros);
        return $status;
    }
}