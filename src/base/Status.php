<?php

// Constantes de Status
abstract class Status {
    // Padroes
    const ErroPadrao = -3;
    const ErroAcessoBD = -2;
    const ErroExecucaoQuery = -1;
    const Ok = 0;

    // Modulo Autenticacao
    const CampoLoginInvalido = 1;
    const CampoSenhaInvalido = 2;
    const CampoIdUsuarioInvalido = 3;
    const CampoIdPerfilInvalido = 4;
    const SenhaIncorreta = 5;

    // Modulo Pedido
    const CampoNomeInvalido = 6;
    const CampoPrecoInvalido = 7;
    const CampoQuantidadeInvalido = 8;
    const CampoIdCategoriaInvalido = 9;
    const CampoIdItemInvalido = 10;
    const CampoIdPedidoInvalido = 11;
    const CampoIdStatusPedidoInvalido = 12;
    const CampoIdFormaPagamentoInvalido = 13;
    const CampoIdClienteInvalido = 14;
    const CampoIdItemPedidoInvalido = 15;
    const CampoModificadorInvalido = 16;
    const QuantidadeIndisponivelParaVenda = 17;
    const PedidoSomenteVisualizacao = 18;
    const CpfDiferentePedido = 19;

    // Cliente
    const CampoCpfInvalido = 20;
    const CampoSobrenomeInvalido = 21;
    const CampoEmailInvalido = 22;
    const CampoTelefoneInvalido = 23;
    const CampoCepInvalido = 24;
    const CampoLogradouroInvalido = 25;
    const CampoNumeroInvalido = 26;
    const CampoComplementoInvalido = 27;

    // Status do Pedido
    const PedidoEmAberto = 1;
    const PedidoAguardandoPagamento = 2;
    const PedidoPagamentoConfirmado = 3;
    const PedidoProntoRetirada = 4;
    const PedidoRetirado = 5;
    const PedidoCancelado = 6;
}