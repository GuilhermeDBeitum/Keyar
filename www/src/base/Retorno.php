<?php

// Classe que implementa o Retorno, usado na comunicação entre view, controller e model
class Retorno {
    private $status;
    private $registros;
    private $totalRegistros;

    public function __construct($status, $registros, $totalRegistros) {
        // Se parâmetros forem diferentes de null, armazena os dados no atributo;
        $this->status = is_null($status) ? array(Status::ErroPadrao) : $status;
        $this->registros = is_null($registros) ? array() : $registros;
        $this->totalRegistros = is_null($totalRegistros) ? 0 : $totalRegistros;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getRegistros() {
        return $this->registros;
    }

    public function setRegistros($registros) {
        $this->registros = $registros;
    }

    public function getTotalRegistros() {
        return $this->totalRegistros;
    }

    public function setTotalRegistros($totalRegistros) {
        $this->totalRegistros = $totalRegistros;
    }

    public function converterRegistroParaVetor(){
        // Método que converte a saída de registro para vetor de registros, quando necessário
        if($this->totalRegistros == 1){
            $this->registros = array($this->registros);
        }
    }

    public function statusOK(){
        // Retorna true, se todos os elementos do vetor de status de validações forem 0
        return array_sum($this->status) == 0;
    }
    // Retorna true se o erro passado foi disparado
    public function statusErro($erro){
        return in_array($erro, $this->getStatus());
    }
}