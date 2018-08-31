<?php
/**
 * User: zjl
 * Date: 2018/08/08 10:00
 */
namespace src\blockchain;


use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBType;
use src\base;
use src\common\General;
use src\common\Constant;
use src\SDK;

class transaction extends base{    
    private $SdkError;
  
    /**
     * [__construct description]
     */
    function __construct(){
        parent::__construct();
        $this->logObject->addWarning("transaction construct");
        $this->SdkError = new \src\exception\SdkError();

    }


    /**
      * [buildBlob 基础的结构
      * 此接口是多入参，单数组出参，同时实现了单object入参，单object出参的接口：buildBlobObject]
      * @param  [type] $nonce         [description]
      * @param  [type] $sourceAddress [description]
      * @param  [type] $metaData      [description]
      * @param  [type] $gasPrice      [description]
      * @param  [type] $feeLimit      [description]
      * @param  [type] $opMetaData    [description]
      * @param  [type] $opType        [description]
      * @return [type]                [description]
      */
     function buildBlob($nonce,$sourceAddress,$metaData,$gasPrice,$feeLimit,$opMetaData,$operation){

        //1 Transaction
        $this->logObject->addNotice("Transaction baseTraction Transaction start");
        $tran = new \Protocol\Transaction();
        $tran->setNonce(++$nonce);
        $tran->setSourceAddress($sourceAddress);
        $tran->setMetadata($metaData);
        $tran->setGasPrice($gasPrice);
        $tran->setFeeLimit($feeLimit);

        //2 Operation
        $this->logObject->addNotice("Transaction baseTraction opers start");
        $opers = new RepeatedField(GPBType::MESSAGE, \Protocol\Operation::class);
        $opers[] = $operation;
        $tran->setOperations($opers);

        //4序列化，转16进制
        $serialTran = $tran->serializeToString();
        $serialTranHex = bin2hex($serialTran);
        // echo bin2hex($serialTran);exit;
        $this->logObject->addNotice("transaction buildBlob,serialTran:".($serialTranHex));
        //解析用
        // $tranParse = new \Protocol\Transaction();Parses a protocol buffer contained in a string.
        // $tranParse->mergeFromString($serialTran);
        // var_dump($tranParse->getOperations()[0]);
        $retNew['transactionBlob'] = $serialTranHex;
        $retNew['hash'] = $serialTran;
        $retNew['status'] = 0;
        $this->logObject->addNotice("transaction buildBlob,transactionblob:".json_encode($retNew));

        return $retNew;
     }


     /**
      * [buildBlob 基础的结构]
      * @param  [type] $nonce         [description]
      * @param  [type] $sourceAddress [description]
      * @param  [type] $metaData      [description]
      * @param  [type] $gasPrice      [description]
      * @param  [type] $feeLimit      [description]
      * @param  [type] $opMetaData    [description]
      * @param  [type] $opType        [description]
      * @return [type]                [description]
      */
     function buildBlobObject($transactionBuildBlobRequest){
        $this->logObject->addNotice("Transaction buildBlobObject Transaction start");
        $TransactionBuildBlobResponse = new \src\model\response\TransactionBuildBlobResponse();
         try{
            if(!$transactionBuildBlobRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }

            $sourceAddress = $transactionBuildBlobRequest->getSourceAddress();
            $sdk = SDK::getInstance('');
            $account = $sdk->getAccount();
            if(!$account->checkAddress($sourceAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_SOURCEADDRESS_ERROR']['errorDesc']);
            }  

            $nonce = $transactionBuildBlobRequest->getNonce();
            if(!$nonce || $nonce<1){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_NONCE_ERROR']['errorDesc']);
            }
 

            $gasPrice = $transactionBuildBlobRequest->getGasPrice();
            if(!$gasPrice || $gasPrice<Constant::GAS_PRICE_MIN){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_GASPRICE_ERROR']['errorDesc']);
            }

            $feeLimit = $transactionBuildBlobRequest->getFeeLimit();
            if(!$feeLimit || $feeLimit<Constant::FEE_LIMIT_MIN){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_FEELIMIT_ERROR']['errorDesc']);
            }
            
            $ceilLedgerSeq = $transactionBuildBlobRequest->getCeilLedgerSeq();
            if($ceilLedgerSeq && $ceilLedgerSeq<0){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_CEILLEDGERSEQ_ERROR']['errorDesc']);
            }

            $metaData = $transactionBuildBlobRequest->getMetadata();

            //1 Transaction
            $tran = new \Protocol\Transaction();
            if($metaData)
              $tran->setMetadata($metaData);
            $tran->setSourceAddress($sourceAddress);
            $tran->setNonce(++$nonce);
            $tran->setFeeLimit($feeLimit);
            $tran->setGasPrice($gasPrice);
            //2 Operation
            $this->logObject->addNotice("Transaction baseTraction opers start");
            $opers = new RepeatedField(GPBType::MESSAGE, \Protocol\Operation::class);
            $operation = $transactionBuildBlobRequest->getOperations();
            $opers[] = $operation;
            $tran->setOperations($opers);

            //选填，区块高度限制，大于等于0，是0时不限制
            if($ceilLedgerSeq){
                 $block = $sdk->getBlock();
                 $blockResponse = $block->getNumber();
                 if($blockResponse){
                    if($blockResponse->getErrorCode()!=0){
                      throw new \Exception("get block number error");
                    }
                 }
                 else{
                    throw new \Exception($this->SdkError->errorDescArray['SYSTEM_ERROR']['errorDesc']);
                 }

                $blockNumber = $blockResponse->getResult()->getHeader()->getBlockNumber();
                $tran->setCeilLedgerSeq($ceilLedgerSeq + $blockNumber);
            }

            //3序列化，转16进制
            $serialTran = $tran->serializeToString();
            $serialTranHex = bin2hex($serialTran);
            $this->logObject->addNotice("transaction buildBlob,serialTran:".($serialTranHex));
            //解析用
            // $tranParse = new \Protocol\Transaction();Parses a protocol buffer contained in a string.
            // $tranParse->mergeFromString($serialTran);
            // var_dump($tranParse->getOperations()[0]);
            // $retNew['transactionBlob'] = $serialTranHex;
            // $retNew['hash'] = $serialTran;
            $this->logObject->addNotice("transaction hash:$serialTran,transactionblob:$serialTranHex");
            $tempinfo['transaction_blob'] = $serialTranHex;
            $tempinfo['hash'] = $serialTran;
            $TransactionBuildBlobResponse->setResult($tempinfo);


        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }

        return $TransactionBuildBlobResponse;
     }

     /**
      * [evaluateFee description]
      * @param  [type] $transactionEvaluateFeeRequest [description]
      * @return [type]                                [description]
      */
     function evaluateFee($transactionEvaluateFeeRequest){
        $TransactionEvaluateFeeResponse = new \src\model\response\TransactionEvaluateFeeResponse();
        try{
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            if(!$transactionEvaluateFeeRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $sourceAddress = $transactionEvaluateFeeRequest->getSourceAddress();
            if(!$sourceAddress){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_SOURCEADDRESS_ERROR']['errorDesc']);
            }

            $nonce = $transactionEvaluateFeeRequest->getNonce();
            if(!$nonce || $nonce<1){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_NONCE_ERROR']['errorDesc']);
            }

            $signatureNumber = $transactionEvaluateFeeRequest->getSignatureNumber();
            if($signatureNumber && $signatureNumber<1){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_SIGNATURENUMBER_ERROR']['errorDesc']);
            }

            $ceilLedgerSeq = $transactionEvaluateFeeRequest->getCeilLedgerSeq();
            if($ceilLedgerSeq && $ceilLedgerSeq<0){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_CEILLEDGERSEQ_ERROR']['errorDesc']);
            }

            $metaData = $transactionEvaluateFeeRequest->getMetadata();

            // build transaction
            $baseOperations = $transactionEvaluateFeeRequest->getOperations(); //BaseOperation[]
            if(!$baseOperations ){
                throw new \Exception($this->SdkError->errorDescArray['OPERATIONS_EMPTY_ERROR']['errorDesc']);
            }

// var_dump($baseOperations);exit;
            //1 Transaction
            $tran = new \Protocol\Transaction();
            $tran->setSourceAddress($sourceAddress);
            $tran->setNonce(++$nonce);
            if($metaData)
              $tran->setMetadata($metaData);
            if($ceilLedgerSeq)
              $tran->setCeilLedgerSeq($ceilLedgerSeq);
  
            //2 Operation 
            $opers = new RepeatedField(GPBType::MESSAGE, \Protocol\Operation::class);
            $opers = $baseOperations; //本身就是数组
            $tran->setOperations($opers);

            $serialTran = $tran->serializeToString();
            $transactionItem['transaction_json'] = ($tran);
            $transactionItems[0] = $transactionItem;
            $testTransactionRequest['items'] = $transactionItems;
            // var_dump($testTransactionRequest);exit;
            $evaluationFeeUrl = General::transactionEvaluationFee();
            $result = $this->request_post($evaluationFeeUrl,$testTransactionRequest);
            // echo($result);exit;
            $resultObject = json_decode($result); //转对象
            if(isset($resultObject->error_code) ){
              if($resultObject->error_code==4)
                throw new \Exception($evaluationFeeUrl .' is error!', 1);
            }
            else{
              throw new \Exception($evaluationFeeUrl .' is not exist!', 1);
            }
            $TransactionEvaluateFeeResponse->setErrorCode($resultObject->error_code);
            $TransactionEvaluateFeeResponse->setResult($resultObject->result);  
            return $TransactionEvaluateFeeResponse;
             
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
     }
      
      /**
       * [getInfo description]
       * @param  [type] $transactionGetInfoRequest [description]
       * @return [type]                            [description]
       */
     function getInfo($transactionGetInfoRequest){

        $TransactionGetInfoResponse = new \src\model\response\TransactionGetInfoResponse();
        try{
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            if(!$transactionGetInfoRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $hash = $transactionGetInfoRequest->getHash();
            $this->logObject->addWarning("account getInfo,hash:$hash");
            //检测有效性
            if(!$hash || strlen($hash)!= Constant::HASH_HEX_LENGTH){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_HASH_ERROR']['errorDesc']);
            }
            $baseUrl = General::transactionGetInfoUrl($hash);
            $result = $this->request_get($baseUrl);
            // echo $result;exit;
            $this->logObject->addWarning("getInfo,result:$result");
       
            //方案3
            $resultObject = json_decode($result); //转对象    
            // var_dump($resultObject);exit;
            if($resultObject->error_code == 4 ){
                throw new  \Exception($hash .' is error!', 1);
            } 
            $TransactionGetInfoResponse->setErrorCode($resultObject->error_code);
            $TransactionGetInfoResponse->setResult($resultObject->result);
            return $TransactionGetInfoResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }    
 

     /**
      * [sign  该接口实现交易的签名
      * 
      * 此接口是多入参，单数组出参，同时实现了单object入参，单object出参的接口：signObject]
      * @param  [type] $tranBlob    [description]
      * @param  [type] $privateKey              [description]
      * @return [type]                          [description]
      */
     function sign($hash,$privateKey){
        $this->logObject->addNotice("sign start,hash:$hash,privateKey:$privateKey");
        //0解析私钥
        $ret = $this->getRawByPrivateKey($privateKey);
        //1通过私钥对交易（transaction_blob）签名。
        $sourceRawPubKeyString = $ret['sourceRawPubKeyString'];
        $sourceRawPriKeyString = $ret['sourceRawPriKeyString'];
        
        $signData = $this->ED25519Sign($hash,$sourceRawPriKeyString,$sourceRawPubKeyString);
        $signDataHex = bin2hex($signData);
        $this->logObject->addNotice("sign,signData:$signDataHex");
        // $ret['signData'] = $signData;
        $ret['signDataHex'] = $signDataHex;
        $ret['sourcePublicKey'] = $ret['sourcePubKey'];
        $ret['status'] = 0;
        return $ret;
     }

       /**
      * [sign  该接口实现交易的签名]
      * @param  [type] $tranBlob    [description]
      * @param  [type] $privateKey              [description]
      * @return [type]                          [description]
      */
     function signObject($TransactionSignRequest){
          $TransactionSignResponse = new \src\model\response\TransactionSignResponse();
          try{
            if(!$TransactionSignRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }

            $hash = $TransactionSignRequest->getBlob();
            if(!$hash){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_BLOB_ERROR']['errorDesc']);
            }  

            $privateKey = $TransactionSignRequest->getPrivateKeys();
            if(!$privateKey || !is_array($privateKey)){
                throw new \Exception($this->SdkError->errorDescArray['PRIVATEKEY_NULL_ERROR']['errorDesc']);
            }  
            $this->logObject->addNotice("sign start,hash:$hash,privateKey:".json_encode($privateKey));

            $resultInfo = array();
            foreach ($privateKey as $key => $value) {
              $temp = array();
              //0解析私钥
              $ret = $this->getRawByPrivateKey($value);
              //1通过私钥对交易（transaction_blob）签名。
              $sourceRawPubKeyString = $ret['sourceRawPubKeyString'];
              $sourceRawPriKeyString = $ret['sourceRawPriKeyString'];
              
              $signData = $this->ED25519Sign($hash,$sourceRawPriKeyString,$sourceRawPubKeyString);
              $signDataHex = bin2hex($signData);
              $this->logObject->addNotice("sign,key:$key,signData:$signDataHex");
              $temp['sign_data'] = $signDataHex;
              $temp['public_key'] = $ret['sourcePubKey'];
              array_push($resultInfo,$temp);
            }
            $resultObject['signatures'] = $resultInfo;
            $resultObject = json_decode(json_encode($resultObject));
            // var_dump($resultObject);
            $TransactionSignResponse->setResult($resultObject);
            
          }
          catch(\Exception $e){
              echo $e->getMessage();exit;
          }


       
        return $TransactionSignResponse;


       
     }

      /**
      * [getRawByPrivateKey 
      * 入参为私钥，出参为原数组以及公钥]
      * @return [type] [description]
      */
    function getRawByPrivateKey($privateKey){
        $this->logObject->addNotice("getRawByPrivateKey,privateKey:$privateKey");
        $sourceRawPriKeyRet = $this->getRawPrivateKey($privateKey);
        $sourceRawPriKeyString = $sourceRawPriKeyRet['rawKeyString'];
        $sourceRawPriBytes = $sourceRawPriKeyRet['rawKeyBytes'];
        $this->logObject->addNotice("getRawByPrivateKey,sourceRawPriKeyRet:".json_encode($sourceRawPriKeyRet));
        
        $pub = new \src\account\account("");
        $sourceRawPubKeyString =$pub->getRawPubKeyByRawPriKey($sourceRawPriKeyString);   
        $pub->setRawPublicKey($sourceRawPubKeyString);   
        $sourcePubKey = $pub->createPublicKey(); 

        $this->logObject->addNotice("getRawByPrivateKey,sourcePubKey:".($sourcePubKey));
        $ret['sourceRawPubKeyString'] = $sourceRawPubKeyString;
        $ret['sourcePubKey'] = $sourcePubKey;
        $ret['sourceRawPriKeyString'] = $sourceRawPriKeyString;
        return $ret;
     }



       /**
     * [getRawPrivateKey 通过私钥，获取rawkey]
     * @return [type] [description]
     */
    public function getRawPrivateKey($privateKey){
        $de58 = $this->base58Decode($privateKey);
        $rawKey = substr($de58,4,32);
        $rawKeyBytes = $this->getBytes($rawKey);
        $ret['rawKeyString'] = $rawKey;
        $ret['rawKeyBytes'] = $rawKeyBytes;
        return $ret;

    }


     /**
      * [submit description
      * 此接口是多入参，单数组出参，同时实现了单object入参，单object出参的接口：submitObject]
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
        $requestBaseUrl = General::$url;
        $transactionUrl = $requestBaseUrl . "/submitTransaction";
        $this->logObject->addNotice("submit,transactionUrl:$transactionUrl");
        $realData['items'] = array();
        array_push($realData['items'],$fill_data);
        $ret = $this->request_post($transactionUrl,$realData);
        $this->logObject->addNotice("submit,ret_end:".$ret);
        
        $retArr = json_decode($ret,true);
        if($retArr['success_count']==1){
            $retNew['status'] = 0;
            $retNew['hash'] = $retArr["results"][0]['hash'];
        }
        else{
            $retNew['status'] = $retArr["results"][0]['error_code'];
            $retNew['error_desc'] = $retArr["results"][0]['error_desc'];
            $retNew['hash'] = isset($retArr["results"][0]['hash'])?$retArr["results"][0]['hash']:"";
        }
        return $retNew;
     }

       /**
      * [submit description]
      * @param  [type] $sourcePubKey  [description]
      * @param  [type] $serialTranHex [description]
      * @param  [type] $signDataHex   [description]
      * @return [type]                [description]
      */
     function submitObject($transactionSubmitRequest){
          $TransactionSubmitResponse = new \src\model\response\TransactionSubmitResponse();
          try{
            if(!$transactionSubmitRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }

            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }

            $blob = $transactionSubmitRequest->getTransactionBlob();
            if(!$blob){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_BLOB_ERROR']['errorDesc']);
            }  

            $getSignatures = $transactionSubmitRequest->getSignatures();
            if(!$getSignatures || !is_array($getSignatures)){
                throw new \Exception($this->SdkError->errorDescArray['SIGNATURE_EMPTY_ERROR']['errorDesc']);
            }  
             
            $signatureItems = array();
            //数组
            foreach ($getSignatures as $key => $value) {
                $tempItem = array();
                $getSignData = $value->getSignData();
                if(!$getSignData){
                  throw new \Exception($this->SdkError->errorDescArray['SIGNDATA_NULL_ERROR']['errorDesc']);
                }
                $getPublicKey = $value->getPublicKey();
                if(!$getPublicKey){
                  throw new \Exception($this->SdkError->errorDescArray['PUBLICKEY_NULL_ERROR']['errorDesc']);
                }
                $tempItem['sign_data'] = $getSignData;
                $tempItem['public_key'] = $getPublicKey;
                array_push($signatureItems, $tempItem);
            }
            $transactionItem['signatures'] = $signatureItems;
            $transactionItem['transaction_blob'] = $blob;
            $transactionItems[0] = $transactionItem;
            $realData['items'] = $transactionItems;
            //2发送 
            $requestBaseUrl = General::$url;
            $transactionUrl = $requestBaseUrl . "/submitTransaction";
            $this->logObject->addNotice("submit,transactionUrl:$transactionUrl");
            $ret = $this->request_post($transactionUrl,$realData);
            $this->logObject->addNotice("submit,ret_end:".$ret);
            
            $retArr = json_decode($ret,true);
            if($retArr['success_count']==1){
                $retNew['hash'] = $retArr["results"][0]['hash'];
                $TransactionSubmitResponse->setErrorCode(0);
                $TransactionSubmitResponse->setResult(json_decode(json_encode($retNew)));
            }
            else{
                throw new \Exception($retArr["results"][0]['error_desc'].',hash:'.$retArr["results"][0]['hash']);
            }
            
          }
          catch(\Exception $e){
              echo $e->getMessage();exit;
          }

       
          return $TransactionSubmitResponse;
     }

      /**
      * [fillData description]
      * @param  [type] $transaction_blob [description]
      * @param  [type] $sign_data        [description]
      * @param  [type] $public_key       [description]
      * @return [type]                   [description]
      */
    function fillData($transaction_blob,$sign_data,$public_key){
        $temp['sign_data'] = $sign_data;
        $temp['public_key'] = $public_key;
        $ret["signatures"] = array();
        array_push($ret["signatures"], $temp);
        $ret['transaction_blob'] = $transaction_blob;
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
      * [getTransactionInfo description]
      * @param  [type] $hash [description]
      * @return [type]       [description]
      */
     function getTransactionInfo($hash){
        if(!General::$url){
            throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
        }
        $baseUrl = General::transactionGetInfoUrl($hash);
        $result = $this->request_get($baseUrl);
        return $result;
     }



     
  
    
}
?>