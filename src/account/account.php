<?php
/**
 * User: zjl
 * Date: 2018/08/08 10:00
 * desc：接口包括所有与账户相关的操作，查询和验证接口。
 */
namespace src\account;

use src\base;
use src\common\General;
use src\common\Constant;
use src\SDK;

class account extends base{
    private $privateKey; //私钥
    private $publicKey;  //公钥
    private $address; //地址
    
    private $rawPrivateKey; //初始的私钥
    private $rawPublicKey; //初始的公钥

    private $SdkError;
    /**
     * [__construct description]
     */
    function __construct(){
        parent::__construct();
        $this->logObject->addWarning("account construct");
        $this->SdkError = new \src\exception\SdkError();
    }

    /**
     * [activate 激活账户，指将未写在区块链上的账户记录在区块链上，通过getInfo接口可以查询到的账户。前提是待处理的账户必须是未激活账户
     * 注意：这里仅仅是生成交易，也就是获取protocolBuf]
     */
    function activate($AccountActivateOperation){
        try{
            if(!$AccountActivateOperation){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }

            $sourceAddress = $AccountActivateOperation->getSourceAddress();
            $sdk = SDK::getInstance('');
            $account = $sdk->getAccount();
            if($sourceAddress && !$account->checkAddress($sourceAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_SOURCEADDRESS_ERROR']['errorDesc']);
            }  

            $destAddress = $AccountActivateOperation->getDestAddress();
            if(!$destAddress || $destAddress==$sourceAddress){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_DESTADDRESS_ERROR']['errorDesc']);
            }

            if($sourceAddress && $sourceAddress==$destAddress){
                throw new \Exception($this->SdkError->errorDescArray['SOURCEADDRESS_EQUAL_DESTADDRESS_ERROR']['errorDesc']);                
            }

            $initBalance = $AccountActivateOperation->getInitBalance();
            if(!$initBalance || $initBalance<=0){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_INITBALANCE_ERROR']['errorDesc']);
            }
            
            $this->logObject->addWarning("account activate,destAddress:$destAddress,initBalance:$initBalance");

            $metadata = $AccountActivateOperation->getMetadata();

            // build operation
            //1该数据结构用于创建账户
            $createAccount = new \Protocol\OperationCreateAccount();
            $createAccount->setDestAddress($destAddress);
            $createAccount->setInitBalance($initBalance);
            $accountThreshold = new \Protocol\AccountThreshold();
            $accountThreshold->setTxThreshold(1);
            $accountPrivilege = new \Protocol\AccountPrivilege();
            $accountPrivilege->setMasterWeight(1);
            $accountPrivilege->setThresholds($accountThreshold);
            $createAccount->setPriv($accountPrivilege);
            //2operation 
            $oper = new \Protocol\Operation();
            if(!$sourceAddress)
                $oper->setSourceAddress($sourceAddress);
            if(!$metadata)
                $oper->setMetadata($metadata);
            $oper->setType(1); //CREATE_ACCOUNT
            $oper->setCreateAccount($createAccount);
            return $oper;

        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
      
    }



     /**
     * [setMetadata description]
     * @return [type] [description]
     */
    function setMetadata($AccountSetMetadataOperation){
         try{
            if(!$AccountSetMetadataOperation){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $sourceAddress = $AccountSetMetadataOperation->getSourceAddress();
            $sdk = SDK::getInstance('');
            $account = $sdk->getAccount();
            if($sourceAddress && !$account->checkAddress($sourceAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_SOURCEADDRESS_ERROR']['errorDesc']);
            }  

            $key = $AccountSetMetadataOperation->getKey();
            if(!$key || strlen($key)> Constant::METADATA_KEY_MAX){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_DATAKEY_ERROR']['errorDesc']);
            }  

            $value = $AccountSetMetadataOperation->getValue();
            if(!$value || strlen($value)> Constant::METADATA_KEY_MAX){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_DATAVALUE_ERROR']['errorDesc']);
            }

            $version = $AccountSetMetadataOperation->getVersion();
            if($version && $version<0){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_DATAVERSION_ERROR']['errorDesc']);
            }


            $deleteFlag = $AccountSetMetadataOperation->getDeleteFlag();
            $metadata = $AccountSetMetadataOperation->getMetadata();
            $sourceAddress = $AccountSetMetadataOperation->getSourceAddress();
            
            // build operation
            //1该数据结构
            $OperationSetMetadata = new \Protocol\OperationSetMetadata();
            $OperationSetMetadata->setKey($key);
            $OperationSetMetadata->setValue($value);
            if($version)
                $OperationSetMetadata->setVersion($version);
            if($deleteFlag)
                $OperationSetMetadata->setDeleteFlag($deleteFlag);

            //2
            $oper = new \Protocol\Operation();
            $oper->setSourceAddress($sourceAddress);
            $oper->setMetadata($metadata);
            $opertype = 4;/*$AccountSetMetadataOperation->getOperationType(); UNKNOWN = 0;
                       CREATE_ACCOUNT = 1;
                       ISSUE_ASSET = 2;
                       PAY_ASSE = 3;
                       SET_METADATA = 4;
                       SET_SIGNER_WEIGHT = 5;
                       SET_THRESHOLD = 6;
                       PAY_COIN = 7;
                       LOG = 8;
                       SET_PRIVILEGE = 9;*/
            $oper->setType($opertype);
            $oper->setSetMetadata($OperationSetMetadata);
            return $oper;


        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }


    }
   /**
     * [setPrivilege description]
     * @return [type] [description]
     */
    function setPrivilege($AccountSetMetadataOperation){
        try{
            if(!$AccountSetMetadataOperation){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $sourceAddress = $AccountSetMetadataOperation->getSourceAddress();
            $sdk = SDK::getInstance('');
            $account = $sdk->getAccount();
            if($sourceAddress && !$account->checkAddress($sourceAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_SOURCEADDRESS_ERROR']['errorDesc']);
            }  
            $getMasterWeight = $AccountSetMetadataOperation->getMasterWeight();
            if(!$getMasterWeight){
                if(!preg_match("^[-\\+]?[\\d]*$",$getMasterWeight))
                throw new \Exception($this->SdkError->errorDescArray['INVALID_MASTERWEIGHT_ERROR']['errorDesc']);

            }
            $getTxThreshold = $AccountSetMetadataOperation->getTxThreshold();
            if(!$getTxThreshold){
                 if(!preg_match("^[-\\+]?[\\d]*$",$getTxThreshold))
                throw new \Exception($this->SdkError->errorDescArray['INVALID_TX_THRESHOLD_ERROR']['errorDesc']);
            }

            $metadata = $AccountSetMetadataOperation->getMetadata();
            $getSigners = $AccountSetMetadataOperation->getSigners();
            $typeThresholds = $AccountSetMetadataOperation->getTypeThresholds();

            // build operation
            //1该数据结构
            $OperationSetPrivilege = new \Protocol\OperationSetPrivilege();
            $OperationSetPrivilege->setMasterWeight($getMasterWeight);
            $OperationSetPrivilege->setTxThreshold($getTxThreshold);
            $protocolSignarr = array();
            if($getSigners){
                foreach ($getSigners as $key => $value) {
                    $signer = $value;
                    $tempadderss = $signer->getAddress();
                    if(!$account->checkAddress($tempadderss)){
                         throw new \Exception($this->SdkError->errorDescArray['INVALID_SIGNER_ADDRESS_ERROR']['errorDesc']);
                    }
                    $tempweight = $signer->getWeight();
                    if($tempweight<0){
                        throw new \Exception($this->SdkError->errorDescArray['INVALID_SIGNER_WEIGHT_ERROR']['errorDesc']);
                    }


                    $SignerPro = new \Protocol\Signer();
                    $SignerPro->setAddress($value->getAddress());
                    $SignerPro->setWeight($value->getWeight());
                    array_push($protocolSignarr,$SignerPro);
                }
            }

            $OperationSetPrivilege->setSigners($protocolSignarr);


            $protocolThresholds = array();
            if($typeThresholds){
                foreach ($typeThresholds as $key => $value) {
                    $typethreshold = $value;
                    $temptype = $typethreshold->getType();
                    if($temptype<1){
                         throw new \Exception($this->SdkError->errorDescArray['INVALID_TYPETHRESHOLD_TYPE_ERROR']['errorDesc']);
                    }
                    $tempholod = $typethreshold->getThreshold();
                    if($tempholod<0){
                        throw new \Exception($this->SdkError->errorDescArray['INVALID_TYPE_THRESHOLD_ERROR']['errorDesc']);
                    }

                    $SignerPro = new \Protocol\OperationTypeThreshold();
                    $SignerPro->setType($value->getType());
                    $SignerPro->setThreshold($value->getThreshold());
                    array_push($protocolThresholds,$SignerPro);
                }
            }
            $OperationSetPrivilege->setTypeThresholds($protocolThresholds);

            //2
            $oper = new \Protocol\Operation();
            $oper->setSourceAddress($sourceAddress);
            $oper->setMetadata($metadata);
            // $opertype = $OperationSetPrivilege->getOperationType();
            $oper->setType(9);/*$AccountSetMetadataOperation->getOperationType(); UNKNOWN = 0;
                       CREATE_ACCOUNT = 1;
                       ISSUE_ASSET = 2;
                       PAY_ASSE = 3;
                       SET_METADATA = 4;
                       SET_SIGNER_WEIGHT = 5;
                       SET_THRESHOLD = 6;
                       PAY_COIN = 7;
                       LOG = 8;
                       SET_PRIVILEGE = 9;*/
            $oper->setSetPrivilege($OperationSetPrivilege);
            return $oper;


        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }

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
    function checkValid($AccountCheckValidRequest){
        $AccountCheckValidResponse = new \src\model\response\AccountCheckValidResponse();
        $AccountCheckValidResult = new \src\model\response\result\AccountCheckValidResult();
        try{
            if(!$AccountCheckValidRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $address = $AccountCheckValidRequest->getAddress();
            $this->logObject->addWarning("account checkValid,address:$address");
            //检测有效性
            $isvalid = $this->checkAddress($address);
            $AccountCheckValidResult->setIsValid($isvalid);
            $AccountCheckValidResponse->setResult($AccountCheckValidResult);
            $AccountCheckValidResponse->setErrorCode(0);
            return $AccountCheckValidResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }

    }

    /**
     * [生成基础信息，包括私钥、公钥、地址]
     * @return [type] [description]
     */
    public function create(){
        try{
            $this->logObject->addWarning("account create");
            $AccountCreateResponse = new \src\model\response\AccountCreateResponse();
            $AccountCreateResult = new \src\model\response\result\AccountCreateResult();
            //0 生成初始数据
            $this->genRawPairKey();
            //1 先生成private
            $this->privateKey = $this->createPirvateKey();
            $AccountCreateResult->setPrivateKey($this->privateKey);
            //2 再生成地址
            $this->address = $this->createAddress();
            $AccountCreateResult->setAddress($this->address);
            //3 最后生成public
            $this->publicKey = $this->createPublicKey();
            $AccountCreateResult->setPublicKey($this->publicKey);
            

            //4 检查地址的合法性  目前只有地址检测
            if($this->checkAddress($this->address)){
                //构造出参
                $AccountCreateResponse->buildResponse(0,'',$AccountCreateResult);
            }
            else{
                throw new \Exception($this->SdkError->errorDescArray['ACCOUNT_CREATE_ERROR']['errorDesc']);
            }
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
        return $AccountCreateResponse;
    }

    /**
     * [ 获取账户信息，包括账户地址，账户余额，账户交易序列号，账户资产和账户权重]
     * @return [type] [description]
     */
    function getInfo($AccountGetInfoRequest){
        $AccountGetInfoResponse = new \src\model\response\AccountGetInfoResponse();
        // $AccountGetInfoResult = new \src\model\response\result\AccountGetInfoResult();
        try{
            if(!$AccountGetInfoRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $address = $AccountGetInfoRequest->getAddress();
            $this->logObject->addWarning("account getInfo,address:$address");
            //检测有效性
            if(!$this->checkAddress($address)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ADDRESS_ERROR']['errorDesc']);
            }
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::accountGetInfoUrl($address);
            $result = $this->request_get($baseUrl);
            // echo $result;exit;
            $this->logObject->addWarning("getInfo,result:$result");
       
            //方案3
            $resultObject = json_decode($result); //转对象    
            // var_dump($resultObject);
            if($resultObject->error_code ==4 ){
                throw new  \Exception(is_null($errorDesc)?$address .' is not exist!':$errorDesc, 1);
            } 
            $AccountGetInfoResponse->setErrorCode($resultObject->error_code);
            // var_dump($resultObject->result);exit;
            $AccountGetInfoResponse->setResult($resultObject->result);
            // var_dump($AccountGetInfoResponse);exit;
            // //方案1
            // $resultObject = json_decode($result); //转对象    
            // if($resultObject->error_code ==4 ){
            //     throw new  \Exception(is_null($errorDesc)?$address .' is not exist!':$errorDesc, 1);
            // }
            // // var_dump($resultObject);exit;
            // $AccountGetInfoResult->setAddress($resultObject->result->address);
            // $AccountGetInfoResult->setBalance($resultObject->result->balance);
            // $AccountGetInfoResult->setNonce($resultObject->result->nonce);
            // $AccountGetInfoResult->setPriv($resultObject->result->priv);
            // $AccountGetInfoResponse->setResult($AccountGetInfoResult);
            // $AccountGetInfoResponse->setErrorCode($resultObject->error_code);

            // $errorCode = $AccountGetInfoResponse->getErrorCode();
            // $errorDesc = $AccountGetInfoResponse->getErrorDesc();
               // //方案2：
            // //操作对象
            // $resultArray = json_decode($result); //转对象
            // $ret = \src\operatorObject::operator(1,$AccountGetInfoResponse,$resultArray);
            // var_dump($ret);
            // exit;
            // 

            return $AccountGetInfoResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }    
    
    /**
     * [ 查询账户交易序列号 ]
     * @return [type] [description]
     */
    function getNonce($AccountGetNonceRequest){
        $AccountGetNonceResponse = new \src\model\response\AccountGetNonceResponse();
        $AccountGetNonceResult = new \src\model\response\result\AccountGetNonceResult();
        try{
            if(!$AccountGetNonceRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $address = $AccountGetNonceRequest->getAddress();
            $this->logObject->addWarning("account getNonce,address:$address");
            //检测有效性
            if(!$this->checkAddress($address)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ADDRESS_ERROR']['errorDesc']);
            }
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::accountGetInfoUrl($address);
            $result = $this->request_get($baseUrl);
            // echo $result;exit;
            $this->logObject->addWarning("getNonce,result:$result");
            $resultObject = json_decode($result); //转对象
            if(isset($resultObject->result->nonce))
                $AccountGetNonceResult->setNonce($resultObject->result->nonce);
            else
                $AccountGetNonceResult->setNonce(0);
            // var_dump($AccountGetNonceResult->getNonce());exit;
            $AccountGetNonceResponse->setResult($AccountGetNonceResult);
            $AccountGetNonceResponse->setErrorCode($resultObject->error_code);

            $errorCode = $AccountGetNonceResponse->getErrorCode();
            $errorDesc = $AccountGetNonceResponse->getErrorDesc();
            if($errorCode ==4 ){
                throw new  \Exception(is_null($errorDesc)?$address .' is not exist!':$errorDesc, 1);
            }

            return $AccountGetNonceResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }

    }   


    /**
     * [ 获取账户余额 ]
     * @return [type] [description]
     */
    function getBalance($AccountGetBalanceRequest){
        $AccountGetBalanceResponse = new \src\model\response\AccountGetBalanceResponse();
        $AccountGetBalanceResult = new \src\model\response\result\AccountGetBalanceResult();
        try{
            if(!$AccountGetBalanceRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $address = $AccountGetBalanceRequest->getAddress();
            $this->logObject->addWarning("account getBalance,address:$address");
            //检测有效性
            if(!$this->checkAddress($address)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ADDRESS_ERROR']['errorDesc']);
            }
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::accountGetInfoUrl($address);
            $result = $this->request_get($baseUrl);
            // echo $result;exit;
            $this->logObject->addWarning("getBalance,result:$result");
            $resultObject = json_decode($result); //转对象
            if(isset($resultObject->result->balance))
                $AccountGetBalanceResult->setBalance($resultObject->result->balance);
            else
                $AccountGetBalanceResult->setBalance(0);
            // var_dump($AccountGetNonceResult->getNonce());exit;
            $AccountGetBalanceResponse->setResult($AccountGetBalanceResult);
            $AccountGetBalanceResponse->setErrorCode($resultObject->error_code);

            $errorCode = $AccountGetBalanceResponse->getErrorCode();
            $errorDesc = $AccountGetBalanceResponse->getErrorDesc();
            if($errorCode ==4 ){
                throw new  \Exception(is_null($errorDesc)?$address .' is not exist!':$errorDesc, 1);
            }

            return $AccountGetBalanceResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }

    } 

    
    
    /**
     * [ 获取账户指定资产数量 ]
     * @return [type] [description]
     */
    function getAssets($AccountGetAssetsRequest){
        $AccountGetAssetsResponse = new \src\model\response\AccountGetAssetsResponse();
        $AccountGetAssetsResult = new \src\model\response\result\AccountGetAssetsResult();
        try{
            if(!$AccountGetAssetsRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $address = $AccountGetAssetsRequest->getAddress();
            $this->logObject->addWarning("account getAssets,address:$address");
            //检测有效性
            if(!$this->checkAddress($address)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ADDRESS_ERROR']['errorDesc']);
            }
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::accountGetAssetsUrl($address);
            $result = $this->request_get($baseUrl);
            // echo $result;exit;
            $this->logObject->addWarning("getAssets,result:$result");
            $resultObject = json_decode($result); //转对象
            
            if($resultObject->error_code ==4 ){
                throw new  \Exception(is_null($errorDesc)?$address .' is not exist!':$errorDesc, 1);
            }
            // var_dump($resultObject->result);exit;
            $AccountGetAssetsResponse->setErrorCode($resultObject->error_code);
            $AccountGetAssetsResponse->setResult($resultObject->result);
            return $AccountGetAssetsResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }


    /**
     * [ 获取账户的metadata信息 ]
     * @return [type] [description]
     */
    function getMetadata($AccountGetMetadataRequest){
        $AccountGetMetadataResponse = new \src\model\response\AccountGetMetadataResponse();
        $AccountGetMetadataResult = new \src\model\response\result\AccountGetMetadataResult();
        try{
            if(!$AccountGetMetadataRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $address = $AccountGetMetadataRequest->getAddress();
            $this->logObject->addWarning("account getMetadata,address:$address");
            //检测有效性
            if(!$this->checkAddress($address)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ADDRESS_ERROR']['errorDesc']);
            }
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }

            $key = $AccountGetMetadataRequest->getKey();

            $baseUrl = General::accountGetMetadataUrl($address,$key);
            $result = $this->request_get($baseUrl);
            $this->logObject->addWarning("getMetadata,result:$result");
            $resultObject = json_decode($result); //转对象
            // var_dump($resultObject);exit;
            if($resultObject->error_code ==4 ){
                throw new  \Exception(is_null($errorDesc)?$address .' is not exist!':$errorDesc, 1);
            }
            //
            $AccountGetMetadataResponse->setErrorCode($resultObject->error_code);
            $AccountGetMetadataResponse->setResult($resultObject->result);
            return $AccountGetMetadataResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
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