<?php

require_once "Retorno.php";

// Trait que implementa a interação de todos os models, com o banco de dados
trait GerenciadorConexaoBD {
    private $tipoBancoDados;
    private $host;
    private $nomeBancoDados;
    private $usuario;
    private $senha_banco;

    private static $conexao;

    public function __construct() {
        $this->tipoBancoDados = "mysql";
        $this->host = "localhost";
        $this->nomeBancoDados = "u208484937_keyar";
        $this->usuario = "u208484937_keyar";
        $this->senha_banco = "keyar_keyar@123";

        // montando string com os parametros da conexao
        $parametros = "{$this->tipoBancoDados}:host={$this->host};dbname={$this->nomeBancoDados}";

        // criando conexao
        self::$conexao = new PDO($parametros, $this->usuario, $this->senha_banco);
    }

    public function executarQuery($comando, $parametros){
        // preparando a query
        $query = self::$conexao->prepare($comando);

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
        // retornando a saida (objeto do tipo Retorno), com os dados resultantes da query
        return new Retorno($status, $registros, $totalRegistros);
    }

    // As três funcoes abaixo servem para ter o controle da transacao no banco de dados
    // beginTrasaction(): Inicia a transação
    // commit(): Confirma a operação no banco de dados
    // rollback(): Desfaz a transação
    // OBS: Devem ser usada sempre no mesmo model

    public function beginTransaction(){
        $status = self::$conexao->beginTransaction();
        return new Retorno($status, null, null);
    }

    public function commit(){
        $status = self::$conexao->commit();
        return new Retorno($status, null, null);
    }

    public function rollback(){
        $status = self::$conexao->rollBack();
        return new Retorno($status, null, null);
    }
}
