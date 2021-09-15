<?php

// Interface para implementar a função executarAcao(), nos controllers
interface ControllerBase {
    function executarAcao($acao, $dados);
}