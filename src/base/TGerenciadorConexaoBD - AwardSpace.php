<?php

require_once "Retorno.php";

trait GerenciadorConexaoBD {
    private $tipoBancoDados;
    private $host;
    private $nomeBancoDados;
    private $usuario;
    private $senha_banco;

    private $conexao;

    public function __construct() {
        $this->tipoBancoDados = "mysql";
        $this->host = "fdb23.awardspace.net";
        $this->nomeBancoDados = "3371835_sistemacontrolepedidos";
        $this->usuario = "3371835_sistemacontrolepedidos";
        $this->senha_banco = "cOFdSkPK7Jgq-";

        // montando string com os parametros da conexao
        $parametros = "{$this->tipoBancoDados}:host={$this->host};dbname={$this->nomeBancoDados}";

        // criando conexao
        $this->conexao = new PDO($parametros, $this->usuario, $this->senha_banco);
    }

    public function getConexao() {
        return $this->conexao;
    }

    public function executarQuery($comando, $parametros){
        // preparando a query
        $query = $this->conexao->prepare($comando);

        // executando a query e capturando a saida
        $status = $query->execute($parametros) ? array(Status::Ok) : array(Status::ErroExecucaoQuery);
        $registros = null;
        $totalRegistros = $query->rowCount();

        // Se select
        if(preg_match('/^select/', $comando)) {
            // fetchAll => Retorna um vetor de registros, fetch => Retorna apenas um registro por vez
            if($query->rowCount() > 1){
                $registros = $query->fetchAll(PDO::FETCH_OBJ);
            }
            elseif ($query->rowCount() == 1){
                $registros = $query->fetch(PDO::FETCH_OBJ);
            }
        }
        // retornando a saida (objeto do tipo Retorno)
        return new Retorno($status, $registros, $totalRegistros);
    }
}
