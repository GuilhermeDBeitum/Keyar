pagamento();

function pagamento() {

    $.ajax({
        //URL completa do local do arquivo responsável em buscar o ID da sessão
        url: "/src/pagamento/SessaoPagamento.php",
        type: 'POST',
        dataType: 'json',
        success: function (retorno) {

            //ID da sessão retornada pelo PagSeguro
            PagSeguroDirectPayment.setSessionId(retorno.id);
        },
        complete: function () {
            pedido();
        }
    });
}

function pedido() {
    
    $.ajax({
        //URL completa do local do arquivo responsável em buscar o ID da sessão
        url: "/src/pagamento/view/VAuxiliarEfetuarPagamento.php",
        type: 'POST',
        dataType: 'json',

        success: function (data){
          this.amount = data.saida.valor_total
          this.dadosAPI = data.saida2
          this.status = data.saida
          
        },
        complete: function () {
            
            amount = this.amount
            dadosAPI = this.dadosAPI
            statusPedido = this.status
           
           
            $('#itemAmount1').val(amount);
            listarMeiosPag()
             
            $.each(dadosAPI, function(i, item){
                
            itemId1 = item.iditem;
            itemDescription1 = item.nome;
            itemAmount1 = item.preco;
            itemQuantity1 = '1'

          });
            $('#itemId1').val(itemId1)
            $('#itemDescription1').val(itemDescription1)
            $('#itemQuantity1').val(itemQuantity1)

        }
    });
    }

function listarMeiosPag() {
    PagSeguroDirectPayment.getPaymentMethods({
        amount: amount,
        success: function (retorno) {
         
            //Recuperar as bandeiras do cartão de crédito
            $('.meio-pag').append("<div>Cartão de Crédito</div>");
            $.each(retorno.paymentMethods.CREDIT_CARD.options, function (i, obj) {
                $('.meio-pag').append("<span class='img-band'><img src='https://stc.pagseguro.uol.com.br" + obj.images.SMALL.path + "'></span>");
            });
        },
        error: function () {
            // Callback para chamadas que falharam.
        },
        complete: function () {
            // Callback para todas chamadas.
            //recupTokemCartao();
        }
    });
}

//Ao carregar a tela de gerenciamento recupera bandeiras.

$(document).ready(function () {

    //Receber o número do cartão digitado pelo usuário
    var gerencia = $('#gerencia').val();

    //Instanciar a API do PagSeguro
    PagSeguroDirectPayment.getBrand({

        cardBin: gerencia,
        success: function (retorno) {
            $('#msg').empty();

            //Enviar para o index a imagem da bandeira
            var imgBand = retorno.brand.name;
            $('.bandeira-cartao').html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/" + imgBand + ".png'>");
            $('#bandeiraCartao').val(imgBand);

        },
        error: function () {
            //Enviar para o index a mensagem de erro
            $('.bandeira-cartao').empty();
            $('#msg').html("Cartão inválido !");
        }
    });
});


//Receber os dados do formulário, usando o evento "keyup" para receber sempre que tiver alguma alteração no campo do formulário
$('#numCartao').on('keyup', function () {

    //Receber o número do cartão digitado pelo usuário
    var numCartao = $(this).val();

    //Contar quantos números o usuário digitou
    var qntNumero = numCartao.length;

    //Validar o cartão quando o usuário digitar 6 digitos do cartão
    if (qntNumero == 6) {

        //Instanciar a API do PagSeguro para validar o cartão
        PagSeguroDirectPayment.getBrand({
            cardBin: numCartao,
            success: function (retorno) {
                $('#msg').empty();

                //Enviar para o index a imagem da bandeira
                var imgBand = retorno.brand.name;
                $('.bandeira-cartao').html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/" + imgBand + ".png'>");
                $('#bandeiraCartao').val(imgBand);
                recupParcelas(imgBand);
            },
            error: function () {

                //Enviar para o index a mensagem de erro
                $('.bandeira-cartao').empty();
                $('#msg').html("Cartão inválido !");
            }
        });
    }
});

//Recuperar a quantidade de parcelas e o valor das parcelas no PagSeguro
function recupParcelas(bandeira) {
    var noIntInstalQuantity = $('#noIntInstalQuantity').val();
    $('#qntParcelas').html('<option value="">Selecione</option>');
    PagSeguroDirectPayment.getInstallments({

        //Valor do produto
        amount: amount,

        //Quantidade de parcelas sem juro        
        maxInstallmentNoInterest: noIntInstalQuantity,

        //Tipo da bandeira
        brand: bandeira,
        success: function (retorno) {
            $.each(retorno.installments, function (ia, obja) {
                $.each(obja, function (ib, objb) {

                    //Converter o preço para o formato real com JavaScript
                    var valorParcela = objb.installmentAmount.toFixed(2).replace(".", ",");

                    //Acrecentar duas casas decimais apos o ponto
                    var valorParcelaDouble = objb.installmentAmount.toFixed(2);
                    //Apresentar quantidade de parcelas e o valor das parcelas para o usuário no campo SELECT
                    $('#qntParcelas').show().append("<option value='" + objb.quantity + "' data-parcelas='" + valorParcelaDouble + "'>" + objb.quantity + " parcelas de R$ " + valorParcela + "</option>");
                });
            });
        },
        error: function () {
            // callback para chamadas que falharam.
        },
        complete: function () {
            // Callback para todas chamadas.
        }
    });
}

//Enviar o valor parcela para o formulário
$('#qntParcelas').change(function () {
    $('#valorParcelas').val($('#qntParcelas').find(':selected').attr('data-parcelas'));
});

//Recuperar o token do cartão de crédito
$("#formPagamento").on("submit", function (event) {
    event.preventDefault();

    PagSeguroDirectPayment.createCardToken({
        cardNumber: $('#numCartao').val(), // Número do cartão de crédito
        brand: $('#bandeiraCartao').val(), // Bandeira do cartão
        cvv: $('#cvvCartao').val(), // CVV do cartão
        expirationMonth: $('#mesValidade').val(), // Mês da expiração do cartão
        expirationYear: $('#anoValidade').val(), // Ano da expiração do cartão, é necessário os 4 dígitos.
        success: function (retorno) {
            $('#tokenCartao').val(retorno.card.token);
            recupHashCartao();
        },
        error: function () {
            $("#msg").html('<p style="color: red; ">Corrija os dados do cartão. </p>');
            // Callback para chamadas que falharam.
        },
        complete: function () {
            // Callback para todas chamadas.  

        }
    });
});



//Recuperar o hash do cartão
function recupHashCartao() {

    $(".loader").show();
    $("#preloder").show();


    PagSeguroDirectPayment.onSenderHashReady(function (retorno) {
        if (retorno.status == 'error') {

            return false;
        } else {
            $("#hashCartao").val(retorno.senderHash);
            var dados = $("#formPagamento").serialize();

            $.ajax({
                method: "POST",
                url: "/src/pagamento/model/MPagamento.php",
                data: dados,
                dataType: 'json',
                success: function () {

                    $("#msg").html('<p style="color: green; ">Transação realizada com sucesso!</p>');
                    $(".loader").hide();
                    $("#preloder").hide();
                    alteraStatusPedido();
                  
                },
                error: function () {
                    $("#msg").html('<p style="color: #FF0000">Erro ao realizar a transação.</p>')
                    $(".loader").hide();
                    $("#preloder").hide();
                }
            });
        }
    });
}


function alteraStatusPedido(){
    
    $.ajax({
        //URL completa do local do arquivo responsável por alterar o Status do pedido.
        url: "/src/pedido/controller/CPedido.php",
        type: 'POST',
        dataType: 'json',
        data: { dados: statusPedido.idstatuspedido ,statusPedido },
        success: function () {
         statusPedido.idstatuspedido = "4";
         statusPedido;
         window.setTimeout("location.href='/public/pedido/visualizar_pedido.php'",4000);

        },
   }); 
}