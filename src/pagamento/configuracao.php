<?php

//Necessário testar em dominio com SSL
define("URL", "https://guilhermedouglas.com/");

$sandbox = true;
if($sandbox){
    define("EMAIL_PAGSEGURO", "xpointersite@outlook.com");
    define("TOKEN_PAGSEGURO", "1748A0C66073450A84C43F0D8B118D31");
    define("URL_PAGSEGURO", "https://ws.sandbox.pagseguro.uol.com.br/v2/");
    define("SCRIPT_PAGSEGURO", "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js");
}else{
    define("EMAIL_PAGSEGURO", "Seu e-mail no PagSeguro");
    define("TOKEN_PAGSEGURO", "Seu token no PagSeguro");
    define("URL_PAGSEGURO", "https://ws.pagseguro.uol.com.br/v2/");
    define("SCRIPT_PAGSEGURO", "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js");
}