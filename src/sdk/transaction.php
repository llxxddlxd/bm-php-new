<?php
namespace src\sdk;


use src\base;
class transaction extends base{    /**
     * [__construct description]
     */
    function __construct(){
        parent::__construct();
        $this->logObject->addWarning("transaction construct");

    }




     /**
      * [sign  该接口实现交易的签名]
      * @param  [type] $tranBlobHex [description]
      * @param  [type] $tranBlob    [description]
      * @param  [type] $privateKey              [description]
      * @return [type]                          [description]
      */
     function sign($tranBlobHex,$tranBlob,$privateKey){
        $this->logObject->addNotice("sign start,tranBlobHex:$tranBlobHex,tranBlob:$tranBlob,privateKey:$privateKey");
        //0解析私钥
        $ret = $this->getRawByPrivateKey($privateKey);
        //1通过私钥对交易（transaction_blob）签名。
        $sourceRawPubKeyString = $ret['sourceRawPubKeyString'];
        $sourceRawPriKeyString = $ret['sourceRawPriKeyString'];
        
        $signData = $this->ED25519Sign($tranBlob,$sourceRawPriKeyString,$sourceRawPubKeyString);
        $signDataHex = bin2hex($signData);
        $this->logObject->addNotice("sign,signData:$signDataHex");
        $ret['signData'] = $signData;
        $ret['signDataHex'] = $signDataHex;
        $ret['sourcePubKey'] = $ret['sourcePubKey'];
        return $ret;
     }
     /**
      * [submit description]
      * @param  [type] $sourcePubKey  [description]
      * @param  [type] $serialTranHex [description]
      * @param  [type] $signDataHex   [description]
      * @return [type]                [description]
      */
     function submit($sourcePubKey,$serialTranHex,$signDataHex){
        //1填充数据
        $fill_data = $this->fillData($serialTranHex,$signDataHex,$sourcePubKey);
        $this->logObject->addNotice("submit,fill_data,info".json_encode($fill_data));

        //2发送 
        $requestBaseUrl = $this->getRequestBaseUrl();
        $transactionUrl = $requestBaseUrl . "submitTransaction";
        $this->logObject->addNotice("submit,transactionUrl:$transactionUrl");
        $realData['items'] = array();
        array_push($realData['items'],$fill_data);
        $ret = $this->request_post($transactionUrl,$realData);
        $this->logObject->addNotice("submit,ret_end:".$ret);
        return $ret;
     }


        /**
      * [getInfo description]
      * @param  [type] $address [description]
      * @return [type]          [description]
      */
     function checkHash($hash){
        $this->logObject->addNotice("transction,checkHash:$hash");
        $url = $this->baseBumoUrl."getTransactionHistory?hash=".$hash;
        $ret = $this->request_get($url);
        $this->logObject->addNotice("transction,checkHash:".json_encode($ret));
        $retObject = json_decode($ret);
        // var_dump($retObject);exit;
        if($retObject->error_code==0){
          $retData['status'] = 0;
          $retData['data'] = $retObject->result;
        }
        else{
          $retData['status'] = 0;
          $retData['data'] = $retObject->result;
        }
        return $retData;

     }


         /**
      * [setMetadataTB description]
      * @return [type] [description]
      */
     public function setMetadataTB($nonce,$sourceAddress,$gasPrice,$feeLimit,$metadataArray){
        // //0构造基础的数据结构
        // $metaData = $opMetaData = bin2hex("setMetadataTB");
        // $ret = $this->baseTraction($nonce,$sourceAddress,$metaData,$gasPrice,$feeLimit,$opMetaData,4);
        // $tran = $ret['tran'];
        // $oper = $ret['oper'];

        // //1该数据结构用于setMedata
        // $this->logger->addNotice("Transaction setMetadataTB start,nonce:$nonce,s:$sourceAddress,gasPrice:$gasPrice,f:$feeLimit");
        // $createAccount = new \Protocol\OperationSetMetadata();
        // $createAccount->setKey($metadataArray['metadataKey']);
        // $createAccount->setValue($metadataArray['metadataValue']);
        // if($metadataArray['metadataVersion'])
        //     $createAccount->setVersion($metadataArray['metadataVersion']);
       
        // //2填充到operation中
        // $oper->getSetMetadata($createAccount);
        // $opers[] = $oper;
        // $tran->setOperations($opers);
        // //3序列化，转16进制
        // $this->logger->addNotice("Transaction serializeToString start");
        // $serialTran = $tran->serializeToString();
        // $serialTranHex = bin2hex($serialTran);
        // // echo bin2hex($serialTran);exit;
        // $this->logger->addNotice("Transaction，serialize,serialTran:".($serialTranHex));
        // //解析用
        // // $tranParse = new \Protocol\Transaction();Parses a protocol buffer contained in a string.
        // // $tranParse->mergeFromString($serialTran);
        // // var_dump($tranParse->getOperations()[0]);
        // $ret['transactionSerializeHex'] = $serialTranHex;
        // $ret['transactionSerialize'] = $serialTran;
        // return $ret;
     }


      /**
     * [getRawPrivateKey 通过私钥，获取rawkey]
     * @return [type] [description]
     */
    private function getRawPrivateKey($privateKey){
        $de58 = $this->base58Decode($privateKey);
        $rawKey = substr($de58,4,32);
        $rawKeyBytes = $this->getBytes($rawKey);
        $ret['rawKeyString'] = $rawKey;
        $ret['rawKeyBytes'] = $rawKeyBytes;
        return $ret;

    }

      /**
      * [getRawByPrivateKey 
      * 入参为私钥，出参为原数组以及公钥]
      * @return [type] [description]
      */
    private function getRawByPrivateKey($privateKey){
        $this->logObject->addNotice("getRawByPrivateKey,privateKey:$privateKey");
        $sourceRawPriKeyRet = $this->getRawPrivateKey($privateKey);
        $sourceRawPriKeyString = $sourceRawPriKeyRet['rawKeyString'];
        $sourceRawPriBytes = $sourceRawPriKeyRet['rawKeyBytes'];
        $this->logObject->addNotice("getRawByPrivateKey,sourceRawPriKeyRet:".json_encode($sourceRawPriKeyRet));
        
        $pub = new \src\account\account();
        $sourceRawPubKeyString =$pub->getRawPubKeyByRawPriKey($sourceRawPriKeyString);   
        $pub->setRawPublicKey($sourceRawPubKeyString);   
        $sourcePubKey = $pub->createPublicKey(); 

        $this->logObject->addNotice("getRawByPrivateKey,sourcePubKey:".($sourcePubKey));
        $ret['sourceRawPubKeyString'] = $sourceRawPubKeyString;
        $ret['sourcePubKey'] = $sourcePubKey;
        $ret['sourceRawPriKeyString'] = $sourceRawPriKeyString;
        return $ret;
     }





    
}
?>