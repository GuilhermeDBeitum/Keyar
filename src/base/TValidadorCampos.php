<?php
// Trait que implementa a verificação dos campos válidos
trait ValidadorCampos {
    function todosCamposValidos(Retorno $saida, $totalCampos){
        // Conta quantos campos estão ok
        $camposValidos = count(array_keys($saida->getStatus(), Status::Ok));

        // Retorna se o total de campos é igual aos de campos validos
        return $totalCampos == $camposValidos;
    }
}