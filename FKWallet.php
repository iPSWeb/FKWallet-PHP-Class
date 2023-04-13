<?php

/**
 * FKWallet PHP Class
 * @version 1.0.0
 *
 * @link          https://psweb.ru/resources/fkwallet-php-class.920/
 * @author        pligin <i@psweb.ru>
 * @copyright     Copyright (c) 2023, PSWeb.ru
 * @site          https://psweb.ru
 */

class FKWallet {
    
    /**
     * @var string $_url Endpoint
     */
    private $_url = 'https://fkwallet.com/api_v1.php';
    /**
     * @var string $_wallet Wallet of FKWallet
     */
    private $_wallet = NULL;
    /**
     * @var string $_key API Access Key
     */
    private $_key = NULL;
    /**
     * @var bool $_json Return Type
     */
    private $_json = true;
    
    public function __construct($wallet,$apiKey,$json = true){
        $this->_wallet = $wallet;
        $this->_key = $apiKey;
        $this->_json = $json;
    }
    
    public function getBalance(){
        $data = array(
            'wallet_id'=>$this->_wallet,
            'sign'=> md5($this->_wallet.$this->_key),
            'action'=>'get_balance',
        );
        return $this->sendRequest($data);
    }
    
    public function getListSBP(){
        $data = array(
            'wallet_id'=>$this->_wallet,
            'sign'=> md5($this->_wallet.$this->_key),
            'action'=>'sbp_list',
        );
        return $this->sendRequest($data);
    }
    
    public function getPaymentStatus($paymentId){
        $data = array(
            'wallet_id'=>$this->_wallet,
            'payment_id'=>$paymentId,
            'sign'=>md5($this->_wallet.$paymentId.$this->_key),
            'action'=>'get_payment_status',
        );
        return $this->sendRequest($data);
    }
    
    public function getProviders(){
        $data = array(
            'wallet_id'=>$this->_wallet,
            'sign'=> md5($this->_wallet.$this->_key),
            'action'=>'providers',
        );
        return $this->sendRequest($data);
    }
    
    public function onlinePayment($serviceId,$account,$amount){
        $data = array(
            'wallet_id'=>$this->_wallet,
            'service_id'=>$serviceId,
            'account'=>$account,
            'amount'=>$amount,
            'sign'=>md5($this->_wallet.$amount.$account.$this->_key),
            'action'=>'online_payment',
        );
        return $this->sendRequest($data);
    }
    
    public function checkOnlinePayment($paymentId){
        $data = array(
            'wallet_id'=>$this->_wallet,
            'payment_id'=>'6532323',
            'sign'=>md5($this->_wallet.$paymentId.$this->_key),
            'action'=>'check_online_payment',
        );
        return $this->sendRequest($data);
    }
    
    //$type - btc,ltc,eth
    public function createCryptoAddress($type){
        $type = strtolower($type);
        $data = array(
            'wallet_id'=>$this->_wallet,
            'sign'=>md5($this->_wallet.$this->_key),
            'action'=>'create_'.$type.'_address',
        );
        return $this->sendRequest($data);
    }
    
    //$type - btc,ltc,eth
    public function getCryptoAddress($type){
        $type = strtolower($type);
        $data = array(
            'wallet_id'=>$this->_wallet,
            'sign'=>md5($this->_wallet.$this->_key),
            'action'=>'get_'.$type.'_address',
        );
        return $this->sendRequest($data);
    }
    
    //$type - btc,ltc,eth
    public function getCryptoTransaction($type,$transactionId){
        $type = strtolower($type);
        $data = array(
            'wallet_id'=>$this->_wallet,
            'transaction_id'=>$transactionId,
            'sign'=>md5($this->_wallet.$transactionId.$this->_key),
            'action'=>'get_'.$type.'_transaction',
        );
        return $this->sendRequest($data);
    }
    
    public function transfer($purse,$amount){
        $data = array(
            'wallet_id'=>$this->_wallet,
            'purse'=>$purse,
            'amount'=>$amount,
            'sign'=>md5($this->_wallet.$amount.$purse.$this->_key),
            'action'=>'transfer',
        );
        return $this->sendRequest($data);
    }
    
    public function cashout($purse,$currency,$amount,$description){
        $data = array(
            'wallet_id'=>$this->_wallet,
            'purse'=>$purse,
            'amount'=>$amount,
            'desc'=>$description,
            'currency'=>$currency,
            'sign'=>md5($this->_wallet.$currency.$amount.$purse.$this->_key),
            'action'=>'cashout',
        );
        return $this->sendRequest($data);
    }
    
    public function getErrors(){
        return $this->_errors;
    }
    
    private function sendRequest($data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = trim(curl_exec($ch));
        $c_errors = curl_error($ch);
        curl_close($ch);
        if(!$this->_json){
            return json_decode($result,1);
        }else{
            return $result;
        }
    }
}
