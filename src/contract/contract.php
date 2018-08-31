<?php
/**
 * User: zjl
 * Date: 2018/08/08 10:00
 */
namespace src\contract;

use src\base;
use src\common\General;
use src\common\Constant;
use src\SDK;
class contract extends base{
 private $SdkError;
    /**
     * [__construct description]
     */
    function __construct(){
        parent::__construct();
        $this->logObject->addWarning("contract construct");
        $this->SdkError = new \src\exception\SdkError();
    }
    /**
     * [create description]
     * @param  [type] $ContractCreateOperation [description]
     * @return [type]                          [description]
     */
    function create($ContractCreateOperation){
         try{
             if(!$ContractCreateOperation){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }

            $sdk = SDK::getInstance('');
            $account = $sdk->getAccount();
            $getSourceAddress = $ContractCreateOperation->getSourceAddress();
            if($getSourceAddress && !$account->checkAddress($getSourceAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_SOURCEADDRESS_ERROR']['errorDesc']);

            }
            $getInitBalance = $ContractCreateOperation->getInitBalance();
            if($getInitBalance<0){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_INITBALANCE_ERROR']['errorDesc']);
                
            }
            $getType = $ContractCreateOperation->getType();

            if($getType<0){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_CONTRACT_TYPE_ERROR']['errorDesc']);
                
            } 

            $getPayload = $ContractCreateOperation->getPayload();

            if(!$getPayload){
                throw new \Exception($this->SdkError->errorDescArray['PAYLOAD_EMPTY_ERROR']['errorDesc']);
                
            }

            $metadata = $ContractCreateOperation->getMetadata();
            $initInput = $ContractCreateOperation->getInitInput();
            
            //1该数据结构用于创建账户
            
            $createAccount = new \Protocol\OperationCreateAccount();
            $createAccount->setInitBalance($getInitBalance);
            if($initInput)
                $createAccount->setInitInput($initInput);
            $accountThreshold = new \Protocol\AccountThreshold();
            $accountThreshold->setTxThreshold(1);
            $accountPrivilege = new \Protocol\AccountPrivilege();
            $accountPrivilege->setMasterWeight(0);
            $accountPrivilege->setThresholds($accountThreshold);
            $createAccount->setPriv($accountPrivilege);

            $contractinfo = new \Protocol\Contract();
            $contractinfo->setPayload($getPayload);
            $createAccount->setContract($contractinfo);

            //2
            $oper = new \Protocol\Operation();
            $oper->setSourceAddress($getSourceAddress);
            $oper->setMetadata($metadata);
            $opertype = 1;//$ContractCreateOperation->getOperationType();
            $oper->setType($opertype); 
            $oper->setCreateAccount($createAccount);
            return $oper;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    } 
    /**
     * [invokeByAsset description]
     * @param  [type] $contractCreateOperation [description]
     * @return [type]                          [description]
     */
    function invokeByAsset($contractCreateOperation){
        try{
             if(!$contractCreateOperation){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }

            $sdk = SDK::getInstance('');
            $account = $sdk->getAccount();
            $getSourceAddress = $contractCreateOperation->getSourceAddress();
            if($getSourceAddress && !$account->checkAddress($getSourceAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_SOURCEADDRESS_ERROR']['errorDesc']);

            }

            $getContractAddress = $contractCreateOperation->getContractAddress();
            if(!$getContractAddress || !$account->checkAddress($getContractAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_CONTRACTADDRESS_ERROR']['errorDesc']);

            }

            if($getSourceAddress && $getSourceAddress==$getContractAddress){
                throw new \Exception($this->SdkError->errorDescArray['SOURCEADDRESS_EQUAL_CONTRACTADDRESS_ERROR']['errorDesc']);

            }


            $getCode = $contractCreateOperation->getCode();
            if($getCode  && (strlen($getCode)<1 || strlen($getCode)>Constant::ASSET_CODE_MAX)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ASSET_CODE_ERROR']['errorDesc']);
            }

            $getIssuer = $contractCreateOperation->getIssuer();
            if($getIssuer && !$account->checkAddress($getIssuer)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ISSUER_ADDRESS_ERROR']['errorDesc']);
                
            } 

            $getAssetAmount = $contractCreateOperation->getAssetAmount();
            if($getAssetAmount && $getAssetAmount<0){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ASSET_AMOUNT_ERROR']['errorDesc']);
            }


            $metadata = $contractCreateOperation->getMetadata();
            $initInput = $contractCreateOperation->getInput();
            
            //1数据结构
            $OperationPayAsset = new \Protocol\OperationPayAsset();
            $OperationPayAsset->setDestAddress($getContractAddress);
            if($initInput)
                $OperationPayAsset->setInput($initInput);

            if($getCode && $getIssuer && $getAssetAmount && $getAssetAmount>0){
                $Asset = new \Protocol\Asset();
                $AssetKey = new \Protocol\AssetKey();
                $AssetKey->setCode($getCode);
                $AssetKey->setIssuer($getIssuer);
                $Asset->setAmount($getAssetAmount);
                $Asset->setKey($AssetKey);
                $OperationPayAsset->setAsset($Asset);
            }
// echo 2;exit;
            //2
            $oper = new \Protocol\Operation();
            $oper->setSourceAddress($getSourceAddress);
            $oper->setMetadata($metadata);
            $opertype = 3;//PAY_ASSE 
            $oper->setType($opertype); 
            $oper->setPayAsset($OperationPayAsset);
            return $oper;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
        
    } 
    /**
     * [invokeByBU description]
     * @param  [type] $ContractInvokeByBUOperation [description]
     * @return [type]                              [description]
     */
    function invokeByBU($ContractInvokeByBUOperation){
         try{
             if(!$ContractInvokeByBUOperation){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }

            $sdk = SDK::getInstance('');
            $account = $sdk->getAccount();
            $getSourceAddress = $ContractInvokeByBUOperation->getSourceAddress();
            if($getSourceAddress && !$account->checkAddress($getSourceAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_SOURCEADDRESS_ERROR']['errorDesc']);

            }

            $getContractAddress = $ContractInvokeByBUOperation->getContractAddress();
            if(!$getContractAddress || !$account->checkAddress($getContractAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_CONTRACTADDRESS_ERROR']['errorDesc']);

            }

            if($getSourceAddress && $getSourceAddress==$getContractAddress){
                throw new \Exception($this->SdkError->errorDescArray['SOURCEADDRESS_EQUAL_CONTRACTADDRESS_ERROR']['errorDesc']);

            }


            $getBuAmount = $ContractInvokeByBUOperation->getBuAmount();
            if(!$getBuAmount  || $getBuAmount<0){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_ASSET_CODE_ERROR']['errorDesc']);
            }

           
            $metadata = $ContractInvokeByBUOperation->getMetadata();
            $initInput = $ContractInvokeByBUOperation->getInput();
            
            //1数据结构
            $OperationPayCoin = new \Protocol\OperationPayCoin();
            $OperationPayCoin->setDestAddress($getContractAddress);
            $OperationPayCoin->setAmount($getBuAmount);
            if($initInput)
                $OperationPayCoin->setInput($initInput);

            //2
            $oper = new \Protocol\Operation();
            $oper->setSourceAddress($getSourceAddress);
            $oper->setMetadata($metadata);
            $opertype = 7;//pay_coin  
            $oper->setType($opertype); 
            $oper->setPayCoin($OperationPayCoin);
            return $oper;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    } 
    /**
     * [ 该方法用于查询合约代码]
     * @return [type] [description]
     */
    function getInfo($ContractGetInfoRequest){
        $ContractGetInfoResponse = new \src\model\response\ContractGetInfoResponse();
        try{
            if(!$ContractGetInfoRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $contractAddress = $ContractGetInfoRequest->getContractAddress();
            if(!$contractAddress){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_CONTRACTADDRESS_ERROR']['errorDesc']);
            }
           
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }

            $contractGetInfoUrl = General::accountGetInfoUrl($contractAddress);
            $result = $this->request_get($contractGetInfoUrl);
            // echo $result;exit;
            $this->logObject->addWarning("getNonce,result:$result");
            $resultObject = json_decode($result); //转对象
            if($resultObject->error_code == 4){
                throw new  \Exception($contractAddress . " doest not exist!", 1);
            }
            $ContractGetInfoResponse->setErrorCode($resultObject->error_code);
            $ContractGetInfoResponse->setResult($resultObject->result);


            return $ContractGetInfoResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }

    }    
    /**
     * [getAddress description]
     * @param  [type] $ContractGetAddressRequest [description]
     * @return [type]                            [description]
     */
    function getAddress($ContractGetAddressRequest){
        $ContractGetAddressResponse = new \src\model\response\ContractGetAddressResponse();
        try{
            if(!$ContractGetAddressRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $hash = $ContractGetAddressRequest->getHash();
            if(!$hash || strlen($hash) !=Constant::HASH_HEX_LENGTH){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_HASH_ERROR']['errorDesc']);
            }

            //通过hash，获取信息
            $TransactionServiceImpl = new \src\blockchain\transaction();
            $result = $TransactionServiceImpl->getTransactionInfo($hash);
            // echo $result;exit;
            $resultObject = json_decode($result); //转对象    
             if($resultObject->error_code ==4 ){
                throw new  \Exception($hash .' is error!', 1);
            } 

            $TransactionGetInfoResponse = new \src\model\response\TransactionGetInfoResponse();
            $TransactionGetInfoResponse->setErrorCode($resultObject->error_code);
            $TransactionGetInfoResponse->setResult($resultObject->result);
            // var_dump($TransactionGetInfoResponse->getResult()->getTransactions()[0]);exit;
            $transactionHistory = $TransactionGetInfoResponse->getResult()->getTransactions()[0];
            $contractAddress = $transactionHistory->getErrorDesc();
            $contractAddressOb = json_decode($contractAddress);
            // foreach ($$contractAddressOb as $key => $value) {
            //     $temp = new \src\model\response\result\data\ContractAddressInfo();
            //     $temp
            // }
            // $resultOb = new \src\model\response\result\ContractGetAddressResult();
            $result=array();
            $result['contract_address_infos'] = $contractAddressOb;
            // var_dump(json_decode(json_encode($result)));exit;
            $ContractGetAddressResponse->setErrorCode($resultObject->error_code);
            $ContractGetAddressResponse->setResult(json_decode(json_encode($result)));

            return $ContractGetAddressResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    } 
    /**
     * [call description]
     * @param  [type] $contractCallRequest [description]
     * @return [type]                      [description]
     */
    function call($contractCallRequest){

        $ContractCallResponse = new \src\model\response\ContractCallResponse();
        try{
            if(!$contractCallRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }

            $sdk = SDK::getInstance('');
            $account = $sdk->getAccount();
            $getSourceAddress = $contractCallRequest->getSourceAddress();
            if($getSourceAddress && !$account->checkAddress($getSourceAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_CONTRACTADDRESS_ERROR']['errorDesc']);
            }   

            $getContractAddress = $contractCallRequest->getContractAddress();
            if($getContractAddress && !$account->checkAddress($getContractAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_CONTRACTADDRESS_ERROR']['errorDesc']);
            }


            if ($getSourceAddress && $getContractAddress && $getContractAddress==$getSourceAddress) {
                throw new \Exception($this->SdkError->errorDescArray['SOURCEADDRESS_EQUAL_CONTRACTADDRESS_ERROR']['errorDesc']);
            }


            $code = $contractCallRequest->getCode();
            if(!$code && !$getContractAddress){
                throw new \Exception($this->SdkError->errorDescArray['CONTRACTADDRESS_CODE_BOTH_NULL_ERROR']['errorDesc']);
            }

            $feeLimit = $contractCallRequest->getFeeLimit();
            if(!$feeLimit || $feeLimit<Constant::FEE_LIMIT_MIN){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_FEELIMIT_ERROR']['errorDesc']);
            }


            $optType = $contractCallRequest->getOptType();
            if(is_null($optType) || $optType<Constant::OPT_TYPE_MIN || $optType>Constant::OPT_TYPE_MAX){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_OPTTYPE_ERROR']['errorDesc']);
            }

            $input = $contractCallRequest->getInput();
            $contractBalance = $contractCallRequest->getContractBalance();
            $gasPrice = $contractCallRequest->getGasPrice();

           
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }

            $param = array();
            $param['opt_type'] = $optType;
            $param['fee_limit'] = $feeLimit;
            // echo $getContractAddress;exit;
            if($getSourceAddress)
                $param['source_address'] = $getSourceAddress;
            if($getContractAddress)
                $param['contract_address'] = $getContractAddress;
            if($code)
                $param['code'] = $code;
            if($input)
                $param['input'] = $input;
            if($contractBalance)
                $param['contract_balance'] = $contractBalance;
            if($gasPrice)
                $param['gas_price'] = $gasPrice;

// var_dump($param);exit;
            $contractGetInfoUrl = General::contractCallUrl();
            $result = $this->request_post($contractGetInfoUrl,$param);
            $resultObject = json_decode($result); //转对象
            if($resultObject->error_code==4){
                 throw new  \Exception( "contract call error" );
            }
            $this->logObject->addWarning("call,result:$result");
            // var_dump($resultObject);exit;

            $ContractCallResponse->setErrorCode($resultObject->error_code);
            $ContractCallResponse->setResult($resultObject->result);
            return $ContractCallResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
        
    } 
    /**
     * [checkValid description]
     * @param  [type] $ContractCheckValidRequest [description]
     * @return [type]                            [description]
     */
    function checkValid($ContractCheckValidRequest){

        $ContractCheckValidResponse = new \src\model\response\ContractCheckValidResponse();
        try{
            if(!$ContractCheckValidRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $getContractAddress = $ContractCheckValidRequest->getContractAddress();
            if(!$getContractAddress){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_CONTRACTADDRESS_ERROR']['errorDesc']);
            }

           
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }

            $contractGetInfoUrl = General::accountGetInfoUrl($getContractAddress);
            $result = $this->request_get($contractGetInfoUrl);
            // echo $contractGetInfoUrl;exit;
            // echo $result;exit;
            $this->logObject->addWarning("getNonce,result:$result");
            $resultObject = json_decode($result); //转对象
            // var_dump($resultObject);exit;
            if($resultObject->error_code==4){
                 throw new  \Exception( "contract account ($getContractAddress) doest not exist" );
            }

            $ContractCheckValidResponse->setErrorCode($resultObject->error_code);
            $ContractCheckValidResponse->setResult($resultObject->result);


            return $ContractCheckValidResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
        
    }  



}
?>