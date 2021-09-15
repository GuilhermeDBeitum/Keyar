<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/ModelImports.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/pagamento/configuracao.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/src/base/TGerenciadorConexaoBD.php";

class MPagamento implements ModelBase {
    use GerenciadorConexaoBD;
    private $model;
    private $parametros; 
    private $senderName;
    private $senderCPF;
    private $senderAreaCode;
    private $senderPhone;
    private $senderEmail;
    private $shippingAddressRequired;
    private $shippingAddressStreet;
    private $shippingAddressNumber;
    private $shippingAddressComplement;
    private $shippingAddressPostalCode;
    private $shippingAddressDistrict;
    private $shippingAddressCity;
    private $shippingAddressState;
    private $shippingAddressCountry;
    private $shippingType;
    private $shippingCost;
    private $paymentMethod;
    private $bandeiraCartao;
    private $valorParcelas;
    private $tokenCartao;
    private $hashCartao;
    private $creditCardHolderName;
    private $creditCardHolderCPF;
    private $creditCardHolderBirthDate;
    private $numCartao;
    private $qntParcelas;
    private $mesValidade;  
    private $anoValidade;
    private $cvvCartao;
    private $billingAddressStreet;
    private $billingAddressNumber;
    private $billingAddressComplement;
    private $billingAddressPostalCode;
    private $billingAddressDistrict;
    private $billingAddressCity;
    private $billingAddressState;
    private $billingAddressCountry;
    private $itemId1;
    private $itemDescription1;
    private $itemAmount1;
    private $itemQuantity1;
    private $currency;
    private $btnComprar;




        public function getSenderName() {
            return $this->senderName;
        }

        public function setSenderName($senderName) {

            if(preg_match('/^\d+$/', $senderName)){
                $this->senderName = $senderName;
                return Status::Ok;
            }
            else{
              
                return Status::CampoSenderNameInvalido;
            }
        }

        public function getSenderCPF() {
            return $this->senderCPF;
        }

        public function setSenderCPF($senderCPF) {

            if(preg_match('/^\d+$/', $senderCPF)){
                $this->senderCPF = $senderCPF;
                return Status::Ok;
            }
            else{
             
                return Status::CampoSenderCPFInvalido;
            }
        }


        public function getSenderAreaCode() {
            return $this->senderAreaCode;
        }

        public function setSenderAreaCode($senderAreaCode) {
          
            if(preg_match('/^\d+$/', $senderAreaCode)){
                $this->senderAreaCode = $senderAreaCode;
                return Status::Ok;
            }
            else{
             
                return Status::CampoSenderAreaCodeInvalido;
            }
        }


        public function getSenderPhone() {
            return $this->getSenderPhone;
        }

        public function setSenderPhone($senderPhone) {

            if(preg_match('/^\d+$/', $senderPhone)){
                $this->senderPhone = $senderPhone;
                return Status::Ok;
            }
            else{
              
                return Status::CampoSenderPhoneInvalido;
            }
        }


        public function getSenderEmail() {
            return $this->setSenderEmail;
        }

        public function setSenderEmail($setSenderEmail) {

            if(preg_match('/^\d+$/', $setSenderEmail)){
                $this->setSenderEmail = $setSenderEmail;
                return Status::Ok;
            }
            else{
              
                return Status::CampoSenderEmailInvalido;
            }
        }


        public function getShippingAddressRequired() {
            return $this->shippingAddressRequired;
        }

        public function setShippingAddressRequired($shippingAddressRequired) {

            if(preg_match('/^\d+$/', $shippingAddressRequired)){
                $this->shippingAddressRequired = $shippingAddressRequired;
                return Status::Ok;
            }
            else{
            
                return Status::CampoShippingAddressRequiredInvalido;
            }
        }


        public function getShippingAddressStreet() {
            return $this->shippingAddressStreet;
        }

        public function setShippingAddressStreet($shippingAddressStreet) {

            if(preg_match('/^\d+$/', $shippingAddressStreet)){
                $this->shippingAddressStreet = $shippingAddressStreet;
                return Status::Ok;
            }
            else{
            
                return Status::CampoShippingAddressStreetInvalido;
            }
        }


        public function getShippingAddressNumber() {
            return $this->shippingAddressNumber;
        }

        public function setShippingAddressNumber($shippingAddressNumber) {

            if(preg_match('/^\d+$/', $shippingAddressNumber)){
                $this->shippingAddressNumber = $shippingAddressNumber;
                return Status::Ok;
            }
            else{
              
                return Status::CampoShippingAddressNumberInvalido;
            }
        }


        public function getShippingAddressComplement() {
            return $this->shippingAddressComplement;
        }

        public function setShippingAddressComplement($shippingAddressComplement) {

            if(preg_match('/^\d+$/', $shippingAddressComplement)){
                $this->shippingAddressComplement = $shippingAddressComplement;
                return Status::Ok;
            }
            else{
              
                return Status::CampoShippingAddressComplementInvalido;
            }
        }


        public function getShippingAddressPostalCode() {
            return $this->shippingAddressPostalCode;
        }

        public function setShippingAddressPostalCode($shippingAddressPostalCode) {

            if(preg_match('/^\d+$/', $shippingAddressPostalCode)){
                $this->shippingAddressPostalCode = $shippingAddressPostalCode;
                return Status::Ok;
            }
            else{
             
                return Status::CampoShippingAddressPostalCodeInvalido;
            }
        }

        public function getShippingAddressCity() {
            return $this->shippingAddressCity;
        }

        public function setShippingAddressCity($shippingAddressCity) {

            if(preg_match('/^\d+$/', $shippingAddressCity)){
                $this->shippingAddressCity = $shippingAddressCity;
                return Status::Ok;
            }
            else{
             
                return Status::CampoShippingAddressCityInvalido;
            }
        }


        public function getShippingAddressState() {
            return $this->shippingAddressState;
        }

        public function setShippingAddressState($shippingAddressState) {

            if(preg_match('/^\d+$/', $shippingAddressState)){
                $this->shippingAddressState = $shippingAddressState;
                return Status::Ok;
            }
            else{
            
                return Status::CampoShippingAddressStateInvalido;
            }
        }


        public function getShippingAddressCountry() {
            return $this->shippingAddressCountry;
        }

        public function setShippingAddressCountry($shippingAddressCountry) {

            if(preg_match('/^\d+$/', $shippingAddressCountry)){
                $this->shippingAddressCountry = $shippingAddressCountry;
                return Status::Ok;
            }
            else{
            
                return Status::CampoShippingAddressCountryInvalido;
            }
        }


        public function getShippingType() {
            return $this->shippingType;
        }

        public function setShippingType($shippingType) {

            if(preg_match('/^\d+$/', $shippingType)){
                $this->shippingType = $shippingType;
                return Status::Ok;
            }
            else{
             
                return Status::CampoShippingTypeInvalido;
            }
        }


        public function getShippingCost() {
            return $this->shippingCost;
        }

        public function setIdItem($shippingCost) {

            if(preg_match('/^\d+$/', $shippingCost)){
                $this->shippingCost = $shippingCost;
                return Status::Ok;
            }
            else{
          
                return Status::CampoShippingCostInvalido;
            }
        }


        public function getPaymentMethod() {
            return $this->paymentMethod;
        }

        public function setPaymentMethod($paymentMethod) {

            if(preg_match('/^\d+$/', $paymentMethod)){
                $this->paymentMethod = $paymentMethod;
                return Status::Ok;
            }
            else{
             
                return Status::CampoPaymentMethodInvalido;
            }
        }


        public function getBandeiraCartao() {
            return $this->bandeiraCartao;
        }

        public function setBandeiraCartao($bandeiraCartao) {

            if(preg_match('/^\d+$/', $bandeiraCartao)){
                $this->bandeiraCartao = $bandeiraCartao;
                return Status::Ok;
            }
            else{
        
                return Status::CampoBandeiraCartaoInvalido;
            }
        }


        public function getValorParcelas() {
            return $this->valorParcelas;
        }

        public function setValorParcelas($valorParcelas) {

            if(preg_match('/^\d+$/', $valorParcelas)){
                $this->valorParcelas = $valorParcelas;
                return Status::Ok;
            }
            else{
      
                return Status::CampoValorParcelasInvalido;
            }
        }


        public function getTokenCartao() {
            return $this->tokenCartao;
        }

        public function setTokenCartao($tokenCartao) {

            if(preg_match('/^\d+$/', $tokenCartao)){
                $this->tokenCartao = $tokenCartao;
                return Status::Ok;
            }
            else{
    
                return Status::CampoTokenCartaoInvalido;
            }
        }

        public function getHashCartao() {
            return $this->hashCartao;
        }

        public function setHashCartao($hashCartao) {

            if(preg_match('/^\d+$/', $hashCartao)){
                $this->hashCartao = $hashCartao;
                return Status::Ok;
            }
            else{
  
                return Status::CampoHashCartaoInvalido;
            }
        }

        public function getCreditCardHolderName() {
            return $this->creditCardHolderName;
        }

        public function setCreditCardHolderName($creditCardHolderName) {

            if(preg_match('/^\d+$/', $creditCardHolderName)){
                $this->creditCardHolderName = $creditCardHolderName;
                return Status::Ok;
            }
            else{

                return Status::CampoCreditCardHolderNameInvalido;
            }
        }

        public function getCreditCardHolderCPF() {
            return $this->creditCardHolderCPF;
        }

        public function setCreditCardHolderCPF($creditCardHolderCPF) {

            if(preg_match('/^\d+$/', $creditCardHolderCPF)){
                $this->creditCardHolderCPF = $creditCardHolderCPF;
                return Status::Ok;
            }
            else{
  
                return Status::CampoCreditCardHolderCPFInvalido;
            }
        }

        public function getCreditCardHolderBirthDate() {
            return $this->creditCardHolderBirthDate;
        }

        public function setCreditCardHolderBirthDate($creditCardHolderBirthDate) {

            if(preg_match('/^\d+$/', $creditCardHolderBirthDate)){
                $this->creditCardHolderBirthDate = $creditCardHolderBirthDate;
                return Status::Ok;
            }
            else{

                return Status::CampoCreditCardHolderBirthDateInvalido;
            }
        }

        public function getNumCartao() {
            return $this->numCartao;
        }

        public function setNumCartao($numCartao) {

            if(preg_match('/^\d+$/', $numCartao)){
                $this->numCartao = $numCartao;
                return Status::Ok;
            }
            else{
  
                return Status::CampoNumCartaoInvalido;
            }
        }

        public function getQntParcelas() {
            return $this->qntParcelas;
        }

        public function setQntParcelas($qntParcelas) {

            if(preg_match('/^\d+$/', $qntParcelas)){
                $this->qntParcelas = $qntParcelas;
                return Status::Ok;
            }
            else{
   
                return Status::CampoQntParcelasInvalido;
            }
        }

        public function getMesValidade  () {
            return $this->mesValidade;
        }

        public function setMesValidade  ($mesValidade) {

            if(preg_match('/^\d+$/', $mesValidade)){
                $this->mesValidade = $mesValidade;
                return Status::Ok;
            }
            else{
    
                return Status::CampomesValidadeInvalido;
            }
        }

        public function getAnoValidade() {
            return $this->anoValidade;
        }

        public function setAnoValidade($anoValidade) {

            if(preg_match('/^\d+$/', $anoValidade)){
                $this->anoValidade = $anoValidade;
                return Status::Ok;
            }
            else{
       
                return Status::CampoAnoValidadeInvalido;
            }
        }

        public function getCvvCartao() {
            return $this->cvvCartao;
        }

        public function setCvvCartao($cvvCartao) {

            if(preg_match('/^\d+$/', $cvvCartao)){
                $this->cvvCartao = $cvvCartao;
                return Status::Ok;
            }
            else{
   
                return Status::CampoCvvCartaoInvalido;
            }
        }

        public function getBillingAddressStreet() {
            return $this->billingAddressStreet;
        }

        public function setBillingAddressStreet($billingAddressStreet) {

            if(preg_match('/^\d+$/', $billingAddressStreet)){
                $this->billingAddressStreet = $billingAddressStreet;
                return Status::Ok;
            }
            else{
  
                return Status::CampoBillingAddressStreetInvalido;
            }
        }

        public function getBillingAddressNumber() {
            return $this->billingAddressNumber;
        }

        public function setBillingAddressNumber($billingAddressNumber) {

            if(preg_match('/^\d+$/', $billingAddressNumber)){
                $this->billingAddressNumber = $billingAddressNumber;
                return Status::Ok;
            }
            else{
   
                return Status::CampoBillingAddressNumberInvalido;
            }
        }

        public function getBillingAddressComplement() {
            return $this->billingAddressComplement;
        }

        public function setBillingAddressComplement($billingAddressComplement) {

            if(preg_match('/^\d+$/', $billingAddressComplement)){
                $this->billingAddressComplement = $billingAddressComplement;
                return Status::Ok;
            }
            else{
    
                return Status::CampoBillingAddressComplementInvalido;
            }
        }

        public function getBillingAddressDistrict() {
            return $this->billingAddressDistrict;
        }

        public function setBillingAddressDistrict($billingAddressDistrict) {

            if(preg_match('/^\d+$/', $billingAddressDistrict)){
                $this->billingAddressDistrict = $billingAddressDistrict;
                return Status::Ok;
            }
            else{
   
                return Status::CampoBillingAddressDistrictInvalido;
            }
        }

        public function getBillingAddressCity() {
            return $this->billingAddressCity;
        }

        public function setBillingAddressCity($billingAddressCity) {

            if(preg_match('/^\d+$/', $billingAddressCity)){
                $this->billingAddressCity = $billingAddressCity;
                return Status::Ok;
            }
            else{
   
                return Status::CampoBillingAddressCityInvalido;
            }
        }

        public function getBillingAddressState() {
            return $this->billingAddressState;
        }

        public function setBillingAddressState($billingAddressState) {

            if(preg_match('/^\d+$/', $billingAddressState)){
                $this->billingAddressState = $billingAddressState;
                return Status::Ok;
            }
            else{

                return Status::CampoBillingAddressStateInvalido;
            }
        }

        public function getBillingAddressCountry() {
            return $this->billingAddressCountry;
        }

        public function setBillingAddressCountry($billingAddressCountry) {
  
            if(preg_match('/^\d+$/', $billingAddressCountry)){
                $this->billingAddressCountry = $billingAddressCountry;
                return Status::Ok;
            }
            else{
    
                return Status::CampoBillingAddressCountryInvalido;
            }
        }

        public function getItemId1() {
            return $this->itemId1;
        }

        public function setItemId1($itemId1) {
   
            if(preg_match('/^\d+$/', $itemId1)){
                $this->itemId1 = $itemId1;
                return Status::Ok;
            }
            else{

                return Status::CampoItemId1Invalido;
            }
        }

        public function getItemDescription1() {
            return $this->itemDescription1;
        }

        public function setItemDescription1($itemDescription1) {

            if(preg_match('/^\d+$/', $itemDescription1)){
                $this->itemDescription1 = $itemDescription1;
                return Status::Ok;
            }
            else{
           
                return Status::CampoItemDescription1Invalido;
            }
        }

        public function getItemQuantity1() {
            return $this->itemQuantity1;
        }

        public function setItemQuantity1($itemQuantity1) {

            if(preg_match('/^\d+$/', $itemQuantity1)){
                $this->itemQuantity1 = $itemQuantity1;
                return Status::Ok;
            }
            else{
          
                return Status::CampoItemQuantity1Invalido;
            }
        }


        public function getCurrency() {
            return $this->currency;
        }

        public function setCurrency($currency) {
         
            if(preg_match('/^\d+$/', $currency)){
                $this->currency = $currency;
                return Status::Ok;
            }
            else{
           
                return Status::CampoCurrencyInvalido;
            }
        }

    

        function validarCampos($dados) {
            $status = array();
            // TODO: Efetuar validação para cada campo
            if(isset($dados["senderName"])){
                $status[] = $this->setSenderName($dados["senderName"]);
            }
            if(isset($dados["senderCPF"])){
                $status[] = $this->setSenderCPF($dados["senderCPF"]);
            }
            if(isset($dados["senderAreaCode"])){
                $status[] = $this->setSenderAreaCode($dados["senderAreaCode"]);
            }
            if(isset($dados["senderPhone"])){
                $status[] = $this->setSenderPhone($dados["senderPhone"]);
            }
            if(isset($dados["senderEmail"])){
                $status[] = $this->setSenderEmail($dados["senderEmail"]);
            }
            if(isset($dados["shippingAddressRequired"])){
                $status[] = $this->setShippingAddressRequired($dados["shippingAddressRequired"]);
            }
            if(isset($dados["shippingAddressStreet"])){
                $status[] = $this->setShippingAddressStreet($dados["shippingAddressStreet"]);
            }
            if(isset($dados["shippingAddressNumber"])){
                $status[] = $this->setShippingAddressNumber($dados["shippingAddressNumber"]);
            }
            if(isset($dados["shippingAddressComplement"])){
                $status[] = $this->setShippingAddressComplement($dados["shippingAddressComplement"]);
            }
            if(isset($dados["shippingAddressPostalCode"])){
                $status[] = $this->setShippingAddressPostalCode($dados["shippingAddressPostalCode"]);
            }
            if(isset($dados["shippingAddressDistrict"])){
                $status[] = $this->setShippingAddressDistrict($dados["shippingAddressDistrict"]);
            }
            if(isset($dados["shippingAddressCity"])){
                $status[] = $this->setShippingAddressCity($dados["shippingAddressCity"]);
            }
            if(isset($dados["shippingAddressState"])){
                $status[] = $this->setShippingAddressState($dados["shippingAddressState"]);
            }
            if(isset($dados["shippingAddressCountry"])){
                $status[] = $this->setShippingAddressCountry($dados["shippingAddressCountry"]);
            }
            if(isset($dados["shippingType"])){
                $status[] = $this->setShippingType($dados["shippingType"]);
            }
            if(isset($dados["shippingCost"])){
                $status[] = $this->setShippingCost($dados["shippingCost"]);
            }
            if(isset($dados["paymentMethod"])){
                $status[] = $this->setPaymentMethod($dados["paymentMethod"]);
            }
            if(isset($dados["bandeiraCartao"])){
                $status[] = $this->setBandeiraCartao($dados["bandeiraCartao"]);
            }
            if(isset($dados["valorParcelas"])){
                $status[] = $this->setValorParcelas($dados["valorParcelas"]);
            }
            if(isset($dados["tokenCartao"])){
                $status[] = $this->setTokenCartao($dados["tokenCartao"]);
            }
            if(isset($dados["hashCartao"])){
                $status[] = $this->setHashCartao($dados["hashCartao"]);
            }
            if(isset($dados["creditCardHolderName"])){
                $status[] = $this->setCreditCardHolderName($dados["creditCardHolderName"]);
            }
            if(isset($dados["creditCardHolderCPF"])){
                $status[] = $this->setCreditCardHolderCPF($dados["creditCardHolderCPF"]);
            }
            if(isset($dados["creditCardHolderBirthDate"])){
                $status[] = $this->setCreditCardHolderBirthDate($dados["creditCardHolderBirthDate"]);
            }
            if(isset($dados["numCartao"])){
                $status[] = $this->setNumCartao($dados["numCartao"]);
            }
            if(isset($dados["qntParcelas"])){
                $status[] = $this->setQntParcelas($dados["qntParcelas"]);
            }
            if(isset($dados["mesValidade"])){
                $status[] = $this->setMesValidade($dados["mesValidade"]);
            }
            if(isset($dados["anoValidade"])){
                $status[] = $this->setAnoValidade($dados["anoValidade"]);
            }
            if(isset($dados["cvvCartao"])){
                $status[] = $this->setCvvCartao($dados["cvvCartao"]);
            }
            if(isset($dados["billingAddressStreet"])){
                $status[] = $this->setBillingAddressStreet($dados["billingAddressStreet"]);
            }
            if(isset($dados["billingAddressComplement"])){
                $status[] = $this->setBillingAddressComplement($dados["billingAddressComplement"]);
            }
            if(isset($dados["billingAddressPostalCode"])){
                $status[] = $this->setBillingAddressPostalCode($dados["billingAddressPostalCode"]);
            }
            if(isset($dados["billingAddressDistrict"])){
                $status[] = $this->setBillingAddressDistrict($dados["billingAddressDistrict"]);
            }
            if(isset($dados["billingAddressCity"])){
                $status[] = $this->setBillingAddressCity($dados["billingAddressCity"]);
            }
            if(isset($dados["billingAddressState"])){
                $status[] = $this->setBillingAddressState($dados["billingAddressState"]); 
            }
            if(isset($dados["billingAddressCountry"])){
                $status[] = $this->setBillingAddressCountry($dados["billingAddressCountry"]);
            }
            if(isset($dados["itemId1"])){
                $status[] = $this->setItemId1($dados["itemId1"]);
            }
            if(isset($dados["itemDescription1"])){
                $status[] = $this->setItemDescription1($dados["itemDescription1"]);
            }
            if(isset($dados["amount"])){
                $status[] = $this->setItemAmount1($dados["amount"]);
            }
            if(isset($dados["itemQuantity1"])){
                $status[] = $this->setItemQuantity1($dados["itemQuantity1"]);
            }
            if(isset($dados["currency"])){
                $status[] = $this->setCurrency($dados["currency"]);           
            }
                     
            return new Retorno($status, null, null);
        }
}

    // public function efetuarPagamento() {

        $Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $DadosArray["email"]=EMAIL_PAGSEGURO;
        $DadosArray["token"]=TOKEN_PAGSEGURO;
        
        $DadosArray['creditCardToken'] = $Dados['tokenCartao'];
        $DadosArray['installmentQuantity'] = $Dados['qntParcelas'];
        $DadosArray['installmentValue'] = $Dados['valorParcelas'];
        $DadosArray['noInterestInstallmentQuantity'] = $Dados['noIntInstalQuantity'];
        $DadosArray['creditCardHolderName'] = $Dados['creditCardHolderName'];
        $DadosArray['creditCardHolderCPF'] = $Dados['creditCardHolderCPF'];
        $DadosArray['creditCardHolderBirthDate'] = $Dados['creditCardHolderBirthDate'];
        $DadosArray['creditCardHolderAreaCode'] = $Dados['senderAreaCode'];
        $DadosArray['creditCardHolderPhone'] = $Dados['senderPhone'];
        $DadosArray['billingAddressStreet'] = $Dados['billingAddressStreet'];
        $DadosArray['billingAddressNumber'] = $Dados['billingAddressNumber'];
        $DadosArray['billingAddressComplement'] = $Dados['billingAddressComplement'];
        $DadosArray['billingAddressDistrict'] = $Dados['billingAddressDistrict'];
        $DadosArray['billingAddressPostalCode'] = $Dados['billingAddressPostalCode'];
        $DadosArray['billingAddressCity'] = $Dados['billingAddressCity'];
        $DadosArray['billingAddressState'] = $Dados['billingAddressState'];
        $DadosArray['billingAddressCountry'] = $Dados['billingAddressCountry'];
        $DadosArray['itemId1'] = $Dados['itemId1'];
        $DadosArray['itemAmount1'] = $Dados['itemAmount1'];
        $DadosArray['itemQuantity1'] = $Dados['itemQuantity1'];
        $DadosArray['itemDescription1'] = $Dados['itemDescription1'];
        $DadosArray['currency'] = $Dados['currency'];
        $DadosArray['reference'] = $Dados['reference'];
        $DadosArray['senderName'] = $Dados['senderName'];
        $DadosArray['senderCPF'] = $Dados['senderCPF'];
        $DadosArray['senderAreaCode'] = $Dados['senderAreaCode'];
        $DadosArray['senderPhone'] = $Dados['senderPhone'];
        $DadosArray['senderEmail'] = $Dados['senderEmail'];
        $DadosArray['senderHash'] = $Dados['hashCartao'];
        $DadosArray['shippingAddressRequired'] = $Dados['shippingAddressRequired'];
        $DadosArray['shippingAddressStreet'] = $Dados['shippingAddressStreet'];
        $DadosArray['shippingAddressNumber'] = $Dados['shippingAddressNumber'];
        $DadosArray['shippingAddressComplement'] = $Dados['shippingAddressComplement'];
        $DadosArray['shippingAddressDistrict'] = $Dados['shippingAddressDistrict'];
        $DadosArray['shippingAddressPostalCode'] = $Dados['shippingAddressPostalCode'];
        $DadosArray['shippingAddressCity'] = $Dados['shippingAddressCity'];
        $DadosArray['shippingAddressState'] = $Dados['shippingAddressState'];
        $DadosArray['shippingAddressCountry'] = $Dados['shippingAddressCountry'];
        $DadosArray['shippingType'] = $Dados['shippingType'];
        $DadosArray['shippingCost'] = $Dados['shippingCost'];

       $buildQuery = http_build_query($DadosArray);
        $url = URL_PAGSEGURO . "transactions";
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
        $retorno = curl_exec($curl);
        curl_close($curl);
        $xml = simplexml_load_string($retorno);

        $retorna = ['error' => false, 'dados' => $xml, 'DadosArray' => $DadosArray];
        header('Content-Type: application/json');
        echo json_encode($retorna);
        return $retorna;

