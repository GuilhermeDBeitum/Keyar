<?php
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/autenticacao/controller/CUsuario.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pagamento/configuracao.php";
	require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/TGerenciadorConexaoBD.php";
    require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/Status.php";

    $controller = new CUsuario();
    $controller->executarAcao("verificarSessaoCliente", $_POST);

    $parametros = ["idcliente" => $_SESSION["idcliente"]];
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>KeyAr</title>
        <meta charset="UTF-8">
        <meta name="description" content=" Divisima | eCommerce Template">
        <meta name="keywords" content="divisima, eCommerce, creative, html">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Stylesheets -->
        <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/css_files_main.php"; ?>
	</head>
	<body>
		<!-- Page Preloder -->
		<div id="preloder">
			<div class="loader"></div>
		</div>

        <!-- Header -->
        <header class="header-section">
            <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/header.php"; ?>
        </header>
    <section class="checkout-section">
            <div class="container">
            <div class="tamanho">
              <div class="spad">
				<div class="cart-table">
	
                    <h2 class="mb-3">Finalizar Compra</h2>
                        
                    <span class="endereco" data-endereco="<?php echo URL; ?>"></span>
    
                     <form name="formPagamento" action="" id="formPagamento">

                        <h4 class="mb-3">Dados do Comprador</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                            <label>Nome</label>                            
                            <input type="text" name="senderName" id="senderName" placeholder="Nome completo" value="Guilherme Douglas" class="form-control" required>                        
                        </div>

                          <div class="col-md-6 mb-3">
                            <label>CPF</label>                            
                            <input type="number" name="senderCPF" id="senderCPF" placeholder="CPF sem traço" value="22111944785" class="form-control" required>                       
                        </div>
                     </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label>DDD</label>
                                <input type="number" name="senderAreaCode" id="senderAreaCode" placeholder="DDD" value="41" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Telefone</label>
                                <input type="number" name="senderPhone" id="senderPhone" placeholder="Somente número" value="56273440" class="form-control" required>
                            </div>
                            
                        <div class="col-md-6 mb-3">
                            <label>E-mail</label>  
                            <input type="email" name="senderEmail" id="senderEmail" placeholder="E-mail do comprador" value="xpointersite@sandbox.pagseguro.com.br" class="form-control" required>                                                
                        </div>
                        </div>

                        <h4 class="mb-3">Endereço de Entrega</h4>

                        <input type="hidden" name="shippingAddressRequired" id="shippingAddressRequired" value="true">

                        <div>
                            <div class="col-md-13 mb-3">
                                <label>Logradouro</label>
                                <input type="text" name="shippingAddressStreet" class="form-control" id="shippingAddressStreet" placeholder="Av. Rua" value="R. João Gbur" required>
                            </div>
                              <div class="row">
                            <div class="col-md-3 mb-3">
                                <label>Número</label>
                                <input type="number" name="shippingAddressNumber" class="form-control" id="shippingAddressNumber" placeholder="Número" value="1384" required>
                            </div>
                  
                        <div class="col-md-5 mb-3">
                            <label>Complemento</label>
                            <input type="text" name="shippingAddressComplement" class="form-control" id="shippingAddressComplement" placeholder="Complemento" value="2o andar">
                        </div>
                        
                          <div class="col-md-4 mb-3">
                            <label>CEP</label>
                            <input type="number" name="shippingAddressPostalCode" class="form-control" id="shippingAddressPostalCode" placeholder="CEP sem traço" value="01452002" required>
                         </div>
                     </div>
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label>Bairro</label>
                                <input type="text" name="shippingAddressDistrict" class="form-control" id="shippingAddressDistrict" placeholder="Bairro" value="Centro" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label>Cidade</label>
                                <input type="text" name="shippingAddressCity" class="form-control" id="shippingAddressCity" placeholder="Cidade" value="Curitiba" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Estado</label>
                                <select name="shippingAddressState" class="custom-select d-block w-100" id="shippingAddressState" required>
                                    <option value="">Selecione</option>
                                    <option value="AC">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AP">AP</option>
                                    <option value="AM">AM</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MT">MT</option>
                                    <option value="MS">MS</option>
                                    <option value="MG">MG</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PR" selected>PR</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RS">RS</option>
                                    <option value="RO">RO</option>
                                    <option value="RR">RR</option>
                                    <option value="SC">SC</option>
                                    <option value="SP">SP</option>
                                    <option value="SE">SE</option>
                                    <option value="TO">TO</option>
                                </select>
                            </div>
                        </div>


                        <!-- Moeda utilizada para pagamento -->
                        <input type="hidden" name="shippingAddressCountry" id="shippingAddressCountry" value="BRL">
                        <!-- 1 - PAC / 2 - SEDEX / 3 - Sem frete -->
                        <input type="hidden" name="shippingType" value="3">
                        <!-- Valor do frete -->
                        <input type="hidden" name="shippingCost" value="0.00">

                        <!-- Pagamento com cartão de crédito -->
                        <input type="hidden" name="bandeiraCartao" id="bandeiraCartao">
                        <input type="hidden" name="valorParcelas" id="valorParcelas">
                        <input type="hidden" name="tokenCartao" id="tokenCartao">
                        <input type="hidden" name="hashCartao" id="hashCartao">
                       
                       <br>
                       <h4 class="mb-3">Dados do Cartão </h4>
                
                        <div class="mb-3">
                            <label >Nome do titular</label>
                            <input type="text" name="creditCardHolderName" class="form-control" id="creditCardHolderName" placeholder="Nome igual ao escrito no cartão" value="Guilherme D. Beitum">
                            <small id="creditCardHolderName" class="form-text text-muted">
                                Como está gravado no cartão
                            </small>
                        </div>
                     
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>CPF do titular</label>
                                <input type="number" name="creditCardHolderCPF" id="creditCardHolderCPF" placeholder="CPF sem traço" value="22111944785" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Nascimento</label>
                                <input type="text" name="creditCardHolderBirthDate" id="creditCardHolderBirthDate" placeholder="Data de Nascimento." value="27/10/1987" class="form-control">
                            </div>
   
                       
                          <div class="col-md-5 mb-3">
                            <label>Número do cartão</label>
                            <div class="input-group">
                                <input type="number"  name="numCartao" maxlength="16" class="form-control" id="numCartao" value="41111">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bandeira-cartao">   </span>
                            </div>
                        </div>
                    </div>
               </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Mês de Validade</label>
                                <input type="number" name="mesValidade" id="mesValidade" maxlength="2" value="12"  class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Ano de Validade</label>
                                <input type="number" name="anoValidade" id="anoValidade" maxlength="4" value="2030" class="form-control">
                            </div>
                       

                        <div class="col-md-3 mb-3 creditCard">                            
                            <label>CVV</label>
                            <input type="number" name="numCartao" class="form-control" id="cvvCartao" maxlength="3" value="123">
                            <small id="cvvCartao" class="form-text text-muted">
                             3 digitos no verso do cartão.
                            </small>
                        </div>
                    </div>
                          </div>
                     

                        <h4 class="col-md-13 mb-3">Endereço do titular do cartão</h4>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Logradouro</label>
                                <input type="text" name="billingAddressStreet" id="billingAddressStreet" placeholder="Av. Rua" value="R. João Gbur" class="form-control">
                            </div>                            
                     
                        </div>
                        
                              <div class="row">
                                  
                           <div class="col-md-3 mb-3">
                                <label>Número</label>
                                <input type="number" name="billingAddressNumber" id="billingAddressNumber" placeholder="Número" value="1384" class="form-control">
                            </div>
                                  
                             <div class="col-md-5 mb-3">
                        
                            <label>Complemento</label>
                            <input type="text" name="billingAddressComplement" id="billingAddressComplement" placeholder="Complemento" value="5o andar" class=" form-control">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label>CEP</label>
                            <input type="number" name="billingAddressPostalCode" class="form-control" id="billingAddressPostalCode" placeholder="CEP sem traço" value="01452002">
                        </div>
                        
                       </div>
                        
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label>Bairro</label>
                                <input type="text" name="billingAddressDistrict" id="billingAddressDistrict" placeholder="Bairro" value="Santa Cândida" class="form-control">
                            </div>
                            <div class="col-md-5 mb-3">
                                <label>Cidade</label>
                                <input type="text" name="billingAddressCity" id="billingAddressCity" placeholder="Cidade" value="Curitiba" class="form-control">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Estado</label>
                                <select name="billingAddressState" class="custom-select d-block w-100" id="billingAddressState">
                                    <option value="">Selecione</option>
                                    <option value="AC">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AP">AP</option>
                                    <option value="AM">AM</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MT">MT</option>
                                    <option value="MS">MS</option>
                                    <option value="MG">MG</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PR" selected>PR</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RS">RS</option>
                                    <option value="RO">RO</option>
                                    <option value="RR">RR</option>
                                    <option value="SC">SC</option>
                                    <option value="SP">SP</option>
                                    <option value="SE">SE</option>
                                    <option value="TO">TO</option>
                                </select>
                            </div>
                        </div>                  

                        <input type="hidden" name="paymentMethod"  id="creditCard" value="creditCard">

                        <input type="hidden" name="billingAddressCountry" id="billingAddressCountry" value="BRL">
                       
                        <input type="hidden" name="itemId1" id="itemId1" value="0001">

                        <input type="hidden" name="itemDescription1" id="itemDescription1" value="laranja">
                        
                        <input type="hidden" name="paymentMethod" id="paymentMethod" value="creditCard">
                        
                          <input type="hidden" name="itemQuantity1" id="" value="1">
                          
                          <input type="hidden" name="Quantity" id="Quantity" value="1">
                        
                        <input type="hidden" name="amount" id="amount" value="600.00">
                        
                         <input type="hidden" name="itemAmount1" id="itemAmount1" value="500.00">
                        
                        <input type="hidden" name="reference" id="reference" value="1001">
                        
                         <input type="hidden" name="installmentValue" id="installmentValue" value="2">
            
                     <input type="hidden" name="noIntInstalQuantity" id="noIntInstalQuantity" value="2">
                      
                        <input type="hidden" name="currency" id="currency" value="BRL">

                        <!--<input type="hidden" name="hashCartao" id="hashCartao">-->
                        <br>
                           <span id="msg"></span>
                        <br>
                        
                     <button type="submit"  name="btnComprar" id="btnComprar"class="site-btn">FINALIZAR</button>
                     <a href="/public/pagamento/gerenciar_forma_pagamento.php" class="site-btn sb-dark">VOLTAR</a>
                    </form>
                    
                </div>
               <div class="container">
             <br>

               </div>
            </div>
          </div>
        </div>


         <!-- Scripts -->
         <?php include "{$_SERVER['DOCUMENT_ROOT']}/public/assets/layout/script_files_main.php"; ?>
        <script type="text/javascript" src="<?php echo SCRIPT_PAGSEGURO; ?>"></script>
        <script src="/src/pagamento/controller/CPagamento.js"> </script>
     
        
    </body>
</html>
