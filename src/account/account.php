<?php
/**
 * User: zjl
 * Date: 2018/08/08 10:00
 */
namespace src\account;

use src\base;


class account extends base{
    private $privateKey; //私钥
    private $publicKey;  //公钥
    private $address; //地址
    
    private $rawPrivateKey; //初始的私钥
    private $rawPublicKey; //初始的公钥
    /**
     * [__construct description]
     */
    function __construct(){
        parent::__construct();
        $this->logObject->addWarning("account construct");

    }

    /**
     * [activate 激活账户，指将未写在区块链上的账户记录在区块链上，通过getInfo接口可以查询到的账户。前提是待处理的账户必须是未激活账户
     * 注意：这里仅仅是生成交易，也就是获取protocolBuf]
     */
    function activate($sourceAddress,$destAddress,$initBalance,$nonce,$metadata=''){
        $this->logObject->addWarning("account activate,sourceAddress:$sourceAddress,destAddress:$destAddress,initBalance:$initBalance,metadata:$metadata,nonce:$nonce");
        //0初始化基础数据
        $metaData = $opMetaData=bin2hex($metadata);
        $gasPrice = 1000;
        $feeLimit = 10000000;
        $opMetaData = $metaData;
        
        //1构造基础的数据结构 
        $ret = $this->baseTraction($nonce,$sourceAddress,$metaData,$gasPrice,$feeLimit,$opMetaData,1);
        $tranasction = $ret['tranasction'];
        $operation = $ret['operation'];
        
        //2该数据结构用于创建账户
        $createAccount = new \Protocol\OperationCreateAccount();
        $createAccount->setDestAddress($destAddress);
        $createAccount->setInitBalance($initBalance);
        $accountThreshold = new \Protocol\AccountThreshold();
        $accountThreshold->setTxThreshold(1);
        $accountPrivilege = new \Protocol\AccountPrivilege();
        $accountPrivilege->setMasterWeight(1);
        $accountPrivilege->setThresholds($accountThreshold);
        $createAccount->setPriv($accountPrivilege);

        //3填充到operation中
        $operation->setCreateAccount($createAccount);
        $opers[] = $operation;
        $tranasction->setOperations($opers);

        //4序列化，转16进制
        $this->logObject->addNotice("account activate serializeToString start");
        $serialTran = $tranasction->serializeToString();
        $serialTranHex = bin2hex($serialTran);
        // echo bin2hex($serialTran);exit;
        $this->logObject->addNotice("account activate,serialTran:".($serialTranHex));
        //解析用
        // $tranParse = new \Protocol\Transaction();Parses a protocol buffer contained in a string.
        // $tranParse->mergeFromString($serialTran);
        // var_dump($tranParse->getOperations()[0]);
        $retNew['tbSerializeHex'] = $serialTranHex;
        $retNew['tbSerialize'] = $serialTran;
        $this->logObject->addNotice("account activate,transactionblob:".json_encode($retNew));
        return $retNew;


    }



     /**
      * [isAddresscheck description]
      * @return boolean [description]
      */
     function checkAddress($address){

        $this->logObject->addNotice("account,checkAddress:$address");
         //1：前2字节
        if(substr($address,0,2)!="bu")
            return false;
        //2：总长度
        if(strlen($address)!=36)
            return false;
        //3:检查
        $ret = $this->checkAddressEn($address);
        $this->logObject->addNotice("account,ret:$ret");

        if($ret==0){
            return true;
            
        }
        else{
            //fail
            return false;
        }
     } 

     /**
      * [isAddresscheck description]
      * @return boolean [description]
      */
     function checkPublicKey($publicKey){
        $this->logObject->addNotice("Account,checkPublicKey:$publicKey");
        $ret = $this->checkPublicKeyEn($publicKey);
        if($ret==0){
            //success
            return true;
        }
        else{
            //fail
            return false;
        }
      
     }
     /**
     * [setMetadata description]
     * @return [type] [description]
     */
    function setMetadata(){
          //1获取nonce
        // $nonceRet = $this->getNonceInfo($sourceAddress);        
        // if($nonceRet['status']!=0){
        //     $ret['status']  = 3004;
        //     return $ret;
        // }
        // $nonce = $nonceRet['data']['nonce'];
        // $this->logger->addNotice("setMetadata,start,nonce:$nonce");

        // //2生成blob
        // $Transaction = new Transaction();
        // $gasPrice = 1000;
        // $feeLimit = 10000000;
        // $transactionBlob = $Transaction->setMetadataTB($nonce,$sourceAddress,$gasPrice,$feeLimit,$metadataArray);
        // $this->logger->addNotice("activateAddress,transactionblob:".json_encode($transactionBlob));
       
        // //3签名
        // $transactionSerializeHex = $transactionBlob['transactionSerializeHex'];
        // $transactionSerialize = $transactionBlob['transactionSerialize'];
        // $signInfo = $Transaction->transagtionBlobSign($transactionSerializeHex,$transactionSerialize,$sourcePrivateKey);
        // $signDataHex = $signInfo['signDataHex'];
        // $sourcePubKey = $signInfo['sourcePubKey'];

        // //4发送
        // $retPost = $Transaction->submitTransaction($sourcePubKey,$transactionSerializeHex,$signDataHex);
        // $retArr = json_decode($retPost,true);
        // if($retArr['success_count']==1){
        //     $ret['status'] = 0;
        // }
        // else{
        //     $ret['status'] = 3004;
        // }
        // return $ret;           

    }
   /**
     * [setPrivilege description]
     * @return [type] [description]
     */
    function setPrivilege(){

    }

    /**
     * [getPrivateKey description]
     * @return [type] [description]
     */
    function getPrivateKey(){
        return $this->privateKey;
    }
    /**
     * [getPublicKey description]
     * @return [type] [description]
     */
    function getPublicKey(){
        return $this->publicKey;
    }  
    /**
     * [getPublicKey description]
     * @return [type] [description]
     */
    function setRawPublicKey($rawPubKey){
        $this->rawPublicKey = $rawPubKey;
    }
    /**
     * [getAddress description]
     * @return [type] [description]
     */
    function getAddress(){
        return $this->address;
    }

    /**
     * [检测地址是否有效]
     * @return [type] [description]
     */
    function checkValid($address){
        $this->logObject->addWarning("account checkValid,address:$address");
        $baseUrl = $this->getRequestBaseUrl();
        $baseUrl .= "getAccount?address=" . $address;
        $result = $this->request_get($baseUrl);
        // echo $baseUrl;exit;
        $this->logObject->addWarning("account checkValid,result:$result");
        $ret = array();
        $ret['status'] = 10002;
        if($result){
            $resultArr = json_decode($result);
            $error_code = isset($resultArr->error_code)?$resultArr->error_code:"";
            if($error_code===0){
                $ret['status'] = 0;
            } 
        }
        return $ret;

    }

    /**
     * [生成基础信息，包括私钥、公钥、地址]
     * @return [type] [description]
     */
    function create(){
        $this->logObject->addWarning("account create");
        //0 生成初始数据
        $this->genRawPairKey();
        //1 先生成private
        $this->privateKey = $this->createPirvateKey();
        //2 再生成地址
        $this->address = $this->createAddress();
        //3 最后生成public
        $this->publicKey = $this->createPublicKey();
        

        //4 检查地址的合法性  目前只有地址检测
        if($this->checkAddress($this->address)){
            $ret['status'] = 0;
            $ret['privateKey'] = $this->privateKey;
            $ret['publicKey'] = $this->publicKey;
            $ret['address'] = $this->address;   
        }
        else{
            $ret['status'] = 10001;
        }
        return $ret;
    }

    /**
     * [ 获取账户信息，包括账户地址，账户余额，账户交易序列号，账户资产和账户权重]
     * @return [type] [description]
     */
    function getInfo($address){
        $this->logObject->addWarning("account getInfo,address:$address");
        $baseUrl = $this->getRequestBaseUrl();
        $baseUrl .= "getAccount?address=" . $address;
        $result = $this->request_get($baseUrl);
        // echo $baseUrl;exit;
        $this->logObject->addWarning("account getInfo,result:$result");
        $ret = array();
        $ret['status'] = 10002;
        if($result){
            $resultArr = json_decode($result,true);
            $error_code = isset($resultArr['error_code'])?$resultArr['error_code']:"";
            if($error_code===0){
                $ret = $resultArr['result'];
                $ret['status'] = 0;
            } 
        }
        return $ret;

    }    

    /**
     * [ 查询账户交易序列号 ]
     * @return [type] [description]
     */
    function getNonce($address){
        $this->logObject->addWarning("account getNonce,address:$address");
        $baseUrl = $this->getRequestBaseUrl();
        $baseUrl .= "getAccount?address=" . $address;
        $result = $this->request_get($baseUrl);
        // echo $baseUrl;exit;
        $this->logObject->addWarning("getNonce,result:$result");
        $ret = array();
        $ret['status'] = 10003;
        if($result){
            $resultArr = json_decode($result,true);
            $error_code = isset($resultArr['error_code'])?$resultArr['error_code']:"";
            if($error_code===0){
                $nonce = isset($resultArr['result']['nonce'])?$resultArr['result']['nonce']:0;
                $ret['status'] = 0;
                $ret['nonce'] = $nonce;
            } 
        }
        return $ret;

    } 

    /**
     * [ 查询账户交易序列号 ]
     * @return [type] [description]
     */
    function getBalance($address){
        $this->logObject->addWarning("account getNonce,address:$address");
        $baseUrl = $this->getRequestBaseUrl();
        $baseUrl .= "getAccount?address=" . $address;
        $result = $this->request_get($baseUrl);
        // echo $baseUrl;exit;
        $this->logObject->addWarning("getNonce,result:$result");
        $ret = array();
        $ret['status'] = 10003;
        if($result){
            $resultArr = json_decode($result,true);
            $error_code = isset($resultArr['error_code'])?$resultArr['error_code']:"";
            if($error_code===0){
                $nonce = isset($resultArr['result']['balance'])?$resultArr['result']['balance']:0;
                $ret['status'] = 0;
                $ret['balance'] = $nonce;
            } 
        }
        return $ret;

    }
    
    /**
     * [ 获取账户指定资产数量 ]
     * @return [type] [description]
     */
    function getAssets($address){
        $this->logObject->addWarning("account getAssets,address:$address");
        $baseUrl = $this->getRequestBaseUrl();
        $baseUrl .= "getAccount?address=" . $address;
        $result = $this->request_get($baseUrl);
        // echo $baseUrl;exit;
        $this->logObject->addWarning("getAssets,result:$result");
        $ret = array();
        $ret['status'] = 10003;
        if($result){
            $resultArr = json_decode($result,true);
            $error_code = isset($resultArr['error_code'])?$resultArr['error_code']:"";
            if($error_code===0){
                $nonce = isset($resultArr['result']['assets'])?$resultArr['result']['assets']:"";
                $ret['status'] = 0;
                $ret['assets'] = $nonce;
            } 
        }
        return $ret;

    }

    /**
     * [getRawPubKeyByRawPriKey description]
     * @param  [type] $rawPriKey [description]
     * @return [type]            [description]
     */
    function getRawPubKeyByRawPriKey($rawPriKey){
        $this->logObject->addWarning("account getRawPubKeyByRawPriKey,rawPriKey:$rawPriKey,len:".strlen($rawPriKey));
        $this->rawPrivateKey = $rawPriKey;
        return $this->ED25519($this->rawPrivateKey);

    }

 
    /**
     * [genRawPairKey description]
     * @return [type] [description]
     */
    private function genRawPairKey(){
        // PHP 7
        // $mySecret = random_bytes(32);
        // <= PHP 5.6  
        //test data
        // $t = [17,236,24,183,207,250,207,180,108,87,224,39,189,99,246,85,138,120,236,78,228,233,41,192,124,109,156,104,235,66,194,24];
        // $this->rawPrivateKey = $this->toStr($t);
        $this->rawPrivateKey = openssl_random_pseudo_bytes(32);
        // 按照文档要求，进行ed25519 生成公钥 
        // test data
        // $f = [21,118,76,208,23,224,218,117,50,113,250,38,205,82,148,81,162,27,130,83,208,1,240,212,54,18,225,158,198,50,87,10];
        // $this->rawPublicKey = $this->toStr($f);
        $this->rawPublicKey  = $this->ED25519($this->rawPrivateKey);

    }



    /**
     * [createPirvateKey description]
     * @return [type] [description]
     */
    public function createPirvateKey(){
        $this->logObject->addWarning("account createPirvateKey start");
        //1生成初始数据
        $firstString = $this->rawPrivateKey;
        //2加上版本号 固定为1
        $secondString = chr(1) . $firstString;
        //3加上prefix 固定为218、55、159
        $thirdString = chr(218) . chr(55) .chr(159) .$secondString;
        //4根据群里说的，在末尾加上0
        $fourthString = $thirdString . chr(0);
        //5两次hash256
        $fifthString_1 = $this->sha256($fourthString); //字符串
        $fifthString_2 = $this->sha256($fifthString_1); //字符串
        $fifthString = $fourthString . substr($fifthString_2, 0,4);//文档说后四位
        //6通过base58，生成私钥
        $lastString = $this->base58Encode($fifthString);
        $this->logObject->addWarning("account createPirvateKey end,key:".$lastString);
        return $lastString;
    }

    /**
     * [createAddress description]
     * @return [type] [description]
     */
    public function createAddress(){
        $this->logObject->addWarning("account createAddress start");
        //1生成初始数据
        $firstString = $this->rawPublicKey;
        //2看java代码，是1次hash,后20个字符
        $second_1 = $this->sha256($firstString); //字符串
        $secondString = substr($second_1, 12);

        //3加上版本号 固定为1
        $thirdString = chr(1) . $secondString;
        //4加上prefix 固定为1、86
        $fourthString = chr(1) . chr(86) .$thirdString;
        //5两次hash256
        $fifthString_1 = $this->sha256($fourthString); //字符串
        $fifthString_2 = $this->sha256($fifthString_1); //字符串
        $fifthString = $fourthString . substr($fifthString_2, 0,4);//文档说后四位
        //6通过base58，生成地址
        $lastString = $this->base58Encode($fifthString);
        $this->logObject->addWarning("account createAddress end,key:".$lastString);
        return $lastString;
    }
  


    /**
     * [createPublicKey description]
     * @return [type] [description]
     */
    public function createPublicKey(){
        $this->logObject->addWarning("account createPublicKey start");
        //1生成初始数据
        $firstString = $this->rawPublicKey;
        //2加上版本号 固定为1
        $secondString = chr(1) . $firstString;
        //3加上prefix 固定为176
        $thirdString = chr(176) .$secondString;
        //4两次hash256
        $thirdString_1 = $this->sha256($thirdString); //字符串
        $thirdString_2 = $this->sha256($thirdString_1); //字符串
        $fourthString = $thirdString . substr($thirdString_2, 0,4);//文档说后四位
        //6通过hex，生成公钥
        $lastString = $this->hexEncode($fourthString);
        $this->logObject->addWarning("account createPublicKey end,key:".$lastString);
        return $lastString;
    }


     /**
     * [checkPublicKey description]
     * @param  [type] $publicKey [description]
     * @return [type]            [description]
     */
    private function checkPublicKeyEn($publicKey){
        //1 not null
        if(!$publicKey)
            return -1;
        // if (!HexFormat.isHexString($publicKey)) {
        //     throw new EncException("Invalid publicKey");
        // }
        //2 prefix
        $buffString = $this->hexDecode($publicKey);
        $buffStringArray = $this->getBytes($buffString);
        // var_dump($buffStringArray);exit;
        if (strlen($buffString) < 6 || $buffStringArray[0] != 176 || $buffStringArray[1] != 1) {
            return -2;
        }
        //3区分checksum
        $len = strlen($buffString);
        $checkSum  = substr($buffString, $len-4);
        $buff = substr($buffString, 0,$len - 4);
        //4
        $firstHash = $this->SHA256($buff);
        $secondHash = $this->SHA256($firstHash); 
        //5
        $hash2 = substr($secondHash,0,4);
        if($checkSum== $hash2){
            return 0;
        }
        else{
            return -3;
        }

    }  

    /**
     * [checkPublicKey description]
     * @param  [type] $publicKey [description]
     * @return [type]            [description]
     */
    private function checkAddressEn($address){
        if(!$address){
            return -1;
        }
        //1解密
        $addressRet = $this->base58Decode($address);
        // var_dump(strlen($addressRet));exit;
        $addressByteArr = $this->getBytes($addressRet);
        // var_dump($addressByteArr);exit;
        //2基本验证
        if (strlen($addressRet) != 27 || $addressByteArr[0] != 1 || $addressByteArr[1] != 86
            || $addressByteArr[2] != 1) {
            return -2;
        }
        //3
        $len = strlen($addressRet);
        $checkSum = substr($addressRet,$len-4);
        $newBuff = substr($addressRet,0,$len-4);
        // echo $len.'  '.strlen($checkSum).'  '.strlen($newBuff);exit;
        $firstHash = $this->SHA256($newBuff);
        $secondHash = $this->SHA256($firstHash);
        $hashData = substr($secondHash, 0,4);
        if($checkSum==$hashData){
            return 0;
        }
        else{
            return -3;
        }

    }


  
}

?>