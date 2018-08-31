<?php
/**
 * User: zjl
 * Date: 2018/08/08 10:00
 */
namespace src\token;

use src\base;
use src\SDK;
use src\common\General;
use src\common\Constant;
class asset extends base{

    private $SdkError;
    function __construct(){
        parent::__construct();
        $this->logObject->addWarning("asset construct");
        $this->SdkError = new \src\exception\SdkError();
    }

    /**
     * [issue description]
     * @param  [type] $AssetIssueOperation [description]
     * @return [type]                      [description]
     */
    function issue($AssetIssueOperation){
         try{
            if(!$AssetIssueOperation){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $sourceAddress = $AssetIssueOperation->getSourceAddress();
            $sdk = SDK::getInstance('');
            $account = $sdk->getAccount();
            if($sourceAddress && !$account->checkAddress($sourceAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_SOURCEADDRESS_ERROR']['errorDesc']);
            }  

            $code = $AssetIssueOperation->getCode();
            if(!$code || strlen($code)> Constant::ASSET_CODE_MAX){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ASSET_CODE_ERROR']['errorDesc']);
            }  

            $amount = $AssetIssueOperation->getAmount();
            if(!$amount || $amount<0){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ISSUE_AMOUNT_ERROR']['errorDesc']);
            }

           
            $metadata = $AssetIssueOperation->getMetadata();
            
            // build operation
            //1该数据结构
            $OperationIssueAsset = new \Protocol\OperationIssueAsset();
            $OperationIssueAsset->setCode($code);
            $OperationIssueAsset->setAmount($amount);

            //2
            $oper = new \Protocol\Operation();
            if($sourceAddress)
                $oper->setSourceAddress($sourceAddress);
            if($metadata)
                $oper->setMetadata($metadata);
            $opertype = 2;/*$AccountSetMetadataOperation->getOperationType(); UNKNOWN = 0;
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
            $oper->setIssueAsset($OperationIssueAsset);
            return $oper;


        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }

    /**
     * [send description]
     * @param  [type] $AssetSendOperation [description]
     * @return [type]                     [description]
     */
    function send($AssetSendOperation){

         try{
            if(!$AssetSendOperation){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $sourceAddress = $AssetSendOperation->getSourceAddress();
            $sdk = SDK::getInstance('');
            $account = $sdk->getAccount();
            if($sourceAddress && !$account->checkAddress($sourceAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_SOURCEADDRESS_ERROR']['errorDesc']);
            }  

            $getDestAddress = $AssetSendOperation->getDestAddress();
            if(!$getDestAddress || !$account->checkAddress($getDestAddress) ){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_DESTADDRESS_ERROR']['errorDesc']);
            }   

            if( $getDestAddress==$sourceAddress){
                throw new \Exception($this->SdkError->errorDescArray['SOURCEADDRESS_EQUAL_DESTADDRESS_ERROR']['errorDesc']);
            }  

            $code = $AssetSendOperation->getCode();
            if(!$code || strlen($code)> Constant::ASSET_CODE_MAX){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ASSET_CODE_ERROR']['errorDesc']);
            }   

            $issusr = $AssetSendOperation->getIssuer();
            // echo $issusr;exit;
            if(!$issusr || !$account->checkAddress($issusr)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ISSUER_ADDRESS_ERROR']['errorDesc']);
            }
            $amount = $AssetSendOperation->getAmount();
            if(!$amount || $amount<1){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ASSET_AMOUNT_ERROR']['errorDesc']);
            }
           


            $metadata = $AssetSendOperation->getMetadata();
            
            // build operation
            //1该数据结构
            $OperationPayAsset = new \Protocol\OperationPayAsset();
            $OperationPayAsset->setDestAddress($getDestAddress);

            $Asset = new \Protocol\Asset();
            $AssetKey = new \Protocol\AssetKey();
            $AssetKey->setCode($code);
            $AssetKey->setIssuer($issusr);
            $Asset->setKey($AssetKey);
            $Asset->setAmount($amount);
            $OperationPayAsset->setAsset($Asset);

            //2
            $oper = new \Protocol\Operation();
            if($sourceAddress)
                $oper->setSourceAddress($sourceAddress);
            if($metadata)
                $oper->setMetadata($metadata);
            $opertype = 3;/*$AccountSetMetadataOperation->getOperationType(); UNKNOWN = 0;
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
            $oper->setPayAsset($OperationPayAsset);
            return $oper;


        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
        
    }

    /**
     * [getInfo description]
     * @param  [type] $AssetGetInfoRequest [description]
     * @return [type]                      [description]
     */
    function getInfo($AssetGetInfoRequest){
        $AssetGetInfoResponse = new \src\model\response\AssetGetInfoResponse();

        try{
            if(!$AssetGetInfoRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $address = $AssetGetInfoRequest->getAddress();
            $this->logObject->addWarning("asset getInfo,address:$address");
            //检测有效性
            $account = new \src\account\account();
            if(!$account->checkAddress($address)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ADDRESS_ERROR']['errorDesc']);
            }

            $code = $AssetGetInfoRequest->getCode();
            if(!$code){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ASSET_CODE_ERROR']['errorDesc']);
            } 

            $issuer = $AssetGetInfoRequest->getIssuer();  
            if(!$issuer){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ISSUER_ADDRESS_ERROR']['errorDesc']);
            }

            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }

            $baseUrl = General::assetGetUrl($address,$code,$issuer);
            $result = $this->request_get($baseUrl);
            // echo $result;exit;
            $this->logObject->addWarning("getInfo,result:$result");
            $resultObject = json_decode($result); //转对象
            if($resultObject->error_code ==4 ){
                throw new  \Exception( $baseUrl .' is not exist!', 1);
            } 
            // var_dump($AccountGetNonceResult->getNonce());exit;
            $AssetGetInfoResponse->setResult($resultObject->result);
            $AssetGetInfoResponse->setErrorCode($resultObject->error_code);

            return $AssetGetInfoResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }


}
?>