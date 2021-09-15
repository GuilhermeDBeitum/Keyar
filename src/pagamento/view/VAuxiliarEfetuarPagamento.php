<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/controller/CPedido.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pedido/controller/CItemPedido.php";

    $sessao = new CUsuario();
    $sessao->executarAcao("verificarSessaoCliente", $_POST);

    $controller = new CPedido();
    $controller2 = new CItemPedido();

    $saida = $controller->executarAcao("visualizarPedido", ["idpedido" => $_SESSION["idpedido"], "idcliente" => $_SESSION["idcliente"]]);
    $saida2 = $controller2->executarAcao("visualizarTodosItensPedido", ["idpedido" => $_SESSION["idpedido"]]);
    
    $data = Array();
    $data['saida'] = $saida->getRegistros(); 
    $data['saida2'] = $saida2->getRegistros();

    echo json_encode($data);

    