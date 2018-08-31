<?php
/**
 * User: zjl
 * Date: 2018/08/08 10:00
 */
namespace src\blockchain;

use src\base;
use src\common\General;
class block extends base{
    private $info;
    private $SdkError;
    function __construct(){
        parent::__construct();
        $this->SdkError = new \src\exception\SdkError();
    }
    /**
     * [getNumber 查询最新的区块高度]
     * @return [type] [description]
     */
    function getNumber(){
        $BlockGetNumberResponse = new \src\model\response\BlockGetNumberResponse();
        // $AccountGetNonceResult = new \src\model\response\result\AccountGetNonceResult();
        try{
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::blockGetNumberUrl();
            $result = $this->request_get($baseUrl);
            // echo $result;exit;
            $this->logObject->addWarning("getNumber,result:$result");
            $resultObject = json_decode($result); //转对象
            if($resultObject->error_code==4){
              throw new  \Exception($baseUrl .' is not exist!', 1);
            }
            
            $BlockGetNumberResponse->setErrorCode($resultObject->error_code);
            $BlockGetNumberResponse->setResult($resultObject->result);  
            return $BlockGetNumberResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
        
    }

    /**
     * [checkStatus description]
     * @return [type] [description]
     */
    public function checkStatus(){
         $BlockCheckStatusResponse = new \src\model\response\BlockCheckStatusResponse();
        // $AccountGetNonceResult = new \src\model\response\result\AccountGetNonceResult();
        try{
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::blockCheckStatusUrl();
            $result = $this->request_get($baseUrl);
            $this->logObject->addWarning("checkStatus,result:$result");
            $resultObject = json_decode($result); //转对象
            if(!$resultObject){
                throw new  \Exception($this->SdkError->errorDescArray['CONNECTNETWORK_ERROR']['errorDesc'], 1);

            }
            // var_dump($resultObject);exit;
            $BlockCheckStatusLedgerSeqResponse =new \src\model\response\BlockCheckStatusLedgerSeqResponse();
            $BlockCheckStatusLedgerSeqResponse->setLedgerSeq($resultObject->ledger_manager);
            $getLedgerSeq =  $BlockCheckStatusLedgerSeqResponse->getLedgerSeq();
            // var_dump($getLedgerSeq);exit;
            $BlockCheckStatusResponse->setErrorCode(0);
            if($getLedgerSeq->getLedgerSequence() < $getLedgerSeq->getChainMaxLedgerSeq()){
                $BlockCheckStatusResponse->setResult(false);  
            }
            else{
                $BlockCheckStatusResponse->setResult(true);  
            }
            return $BlockCheckStatusResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }

    
    /**
     * [getLatestInfo description]
     * @return [type] [description]
     */
    function getLatestInfo(){
         $BlockGetInfoResponse = new \src\model\response\BlockGetInfoResponse();
        // $AccountGetNonceResult = new \src\model\response\result\AccountGetNonceResult();
        try{
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::blockGetLatestInfoUrl();
            $result = $this->request_get($baseUrl);
            $this->logObject->addWarning("getLatestInfo,result:$result");
            $resultObject = json_decode($result); //转对象
            // var_dump($resultObject);exit;
            
            $BlockGetInfoResponse->setErrorCode($resultObject->error_code);
            $BlockGetInfoResponse->setResult($resultObject->result);  
            return $BlockGetInfoResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }
    
    /**
     * [getLatestValidators description]
     * @return [type] [description]
     */
    function getLatestValidators(){
        $BlockGetLatestValidatorsResponse = new \src\model\response\BlockGetLatestValidatorsResponse();
        // $AccountGetNonceResult = new \src\model\response\result\AccountGetNonceResult();
        try{
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::blockGetLatestValidatorsUrl();
            $result = $this->request_get($baseUrl);
            $this->logObject->addWarning("getLatestValidators,result:$result");
            $resultObject = json_decode($result); //转对象
            // var_dump($resultObject->result->validators);exit;
            
            $BlockGetLatestValidatorsResponse->setErrorCode($resultObject->error_code);
            $BlockGetLatestValidatorsResponse->setResult($resultObject->result);  
            return $BlockGetLatestValidatorsResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }
    /**
     * [getLatestReward    获取最新区块中的区块奖励和验证节点奖励]
     * @return [type] [description]
     */
    function getLatestReward(){
       $BlockGetLatestValidatorsResponse = new \src\model\response\BlockGetLatestRewardResponse();
        try{
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::blockGetLatestRewardUrl();
            $result = $this->request_get($baseUrl);
            $this->logObject->addWarning("getLatestReward,result:$result");
            $resultObject = json_decode($result); //转对象
            // var_dump($resultObject->result);exit;
            
            $BlockGetLatestValidatorsResponse->setErrorCode($resultObject->error_code);
            $BlockGetLatestValidatorsResponse->setResult($resultObject->result);  
            return $BlockGetLatestValidatorsResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }

    


    /**
     * [getTransactions    查询指定区块高度下的所有交易]
     * @param  [type] $BlockGetTransactionsRequest [description]
     * @return [type]                              [description]
     */
    function getTransactions($BlockGetTransactionsRequest){
        $BlockGetTransactionsResponse = new \src\model\response\BlockGetTransactionsResponse();
        try{

            if(!$BlockGetTransactionsRequest){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }

            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }

            if($BlockGetTransactionsRequest->getBlockNumber()<=0){
                throw new  \Exception($this->SdkError->errorDescArray['INVALID_BLOCKNUMBER_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::blockGetTransactionsUrl($BlockGetTransactionsRequest->getBlockNumber());
            // echo $baseUrl;exit;
            $result = $this->request_get($baseUrl);
            $this->logObject->addWarning("getTransactions,result:$result");
            $resultObject = json_decode($result); //转对象
            // var_dump($resultObject);exit;
            if($resultObject->error_code ==4 ){
                throw new  \Exception($baseUrl .' is error!', 1);
            } 
            // var_dump($resultObject->result);exit;
            $BlockGetTransactionsResponse->setErrorCode($resultObject->error_code);
            $BlockGetTransactionsResponse->setResult($resultObject->result);  
            return $BlockGetTransactionsResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }
    /**
     * [getInfo description]
     * @param  [type] $BlockGetInfoRequest [description]
     * @return [type]                      [description]
     */
    function getInfo($BlockGetInfoRequest){
        $BlockGetInfoResponse = new \src\model\response\BlockGetInfoResponse();
        try{
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            if($BlockGetInfoRequest->getBlockNumber()<=0){
                throw new  \Exception($this->SdkError->errorDescArray['INVALID_BLOCKNUMBER_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::blockGetInfoUrl($BlockGetInfoRequest->getBlockNumber());
            $result = $this->request_get($baseUrl);
            $this->logObject->addWarning("getInfo,result:$result");
            $resultObject = json_decode($result); //转对象
            // var_dump($resultObject->result->validators);exit;
            
            $BlockGetInfoResponse->setErrorCode($resultObject->error_code);
            $BlockGetInfoResponse->setResult($resultObject->result);  
            return $BlockGetInfoResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }

    /**
     * [getValidators description]
     * @param  [type] $BlockGetValidatorsRequest [description]
     * @return [type]                            [description]
     */
    function getValidators($BlockGetValidatorsRequest){
         $BlockGetLatestValidatorsResponse = new \src\model\response\BlockGetLatestValidatorsResponse();
        // $AccountGetNonceResult = new \src\model\response\result\AccountGetNonceResult();
        try{
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            if($BlockGetValidatorsRequest->getBlockNumber()<=0){
                throw new  \Exception($this->SdkError->errorDescArray['INVALID_BLOCKNUMBER_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::blockGetValidatorsUrl($BlockGetValidatorsRequest->getBlockNumber());
            $result = $this->request_get($baseUrl);
            $this->logObject->addWarning("getValidators,result:$result");
            $resultObject = json_decode($result); //转对象
            // var_dump($resultObject->result->validators);exit;
            
            $BlockGetLatestValidatorsResponse->setErrorCode($resultObject->error_code);
            $BlockGetLatestValidatorsResponse->setResult($resultObject->result);  
            return $BlockGetLatestValidatorsResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }
    /**
     * [getReward 获取指定区块中的区块奖励和验证节点奖励]
     * @param  [type] $BlockGetRewardRequest [description]
     * @return [type]                        [description]
     */
    function getReward($BlockGetRewardRequest){
        $BlockGetRewardResponse = new \src\model\response\BlockGetRewardResponse();
        // $AccountGetNonceResult = new \src\model\response\result\AccountGetNonceResult();
        try{
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            if($BlockGetRewardRequest->getBlockNumber()<=0){
                throw new  \Exception($this->SdkError->errorDescArray['INVALID_BLOCKNUMBER_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::blockGetRewardUrl($BlockGetRewardRequest->getBlockNumber());
            $result = $this->request_get($baseUrl);
            $this->logObject->addWarning("getReward,result:$result");
            $resultObject = json_decode($result); //转对象
            // var_dump($resultObject->result);exit;
            
            $BlockGetRewardResponse->setErrorCode($resultObject->error_code);
            $BlockGetRewardResponse->setResult($resultObject->result);  
            return $BlockGetRewardResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
        
    }
    /**
     * [getFees    获取指定区块中的账户最低资产限制和打包费用]
     * @param  [type] $BlockGetFeesRequest [description]
     * @return [type]                      [description]
     */
    function getFees($BlockGetFeesRequest){
        $BlockGetFeesResponse = new \src\model\response\BlockGetFeesResponse();
        // $AccountGetNonceResult = new \src\model\response\result\AccountGetNonceResult();
        try{
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            if($BlockGetFeesRequest->getBlockNumber()<=0){
                throw new  \Exception($this->SdkError->errorDescArray['INVALID_BLOCKNUMBER_ERROR']['errorDesc'], 1);
            }
            $baseUrl = General::blockGetFeesUrl($BlockGetFeesRequest->getBlockNumber());
            $result = $this->request_get($baseUrl);
            $this->logObject->addWarning("getFees,result:$result");
            $resultObject = json_decode($result); //转对象
            // var_dump($resultObject->result);exit;
            
            $BlockGetFeesResponse->setErrorCode($resultObject->error_code);
            $BlockGetFeesResponse->setResult($resultObject->result);  
            return $BlockGetFeesResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    } 

    /**
     * [getLatestFees      获取最新区块中的账户最低资产限制和打包费用]
     * @param  [type] $BlockGetFeesRequest [description]
     * @return [type]                      [description]
     */
    function getLatestFees(){
        $BlockGetLatestFeesResponse = new \src\model\response\BlockGetLatestFeesResponse();
        try{
            if(!General::$url){
                throw new  \Exception($this->SdkError->errorDescArray['URL_EMPTY_ERROR']['errorDesc'], 1);
            }
            
            $baseUrl = General::blockGetLatestFeeUrl();
            $result = $this->request_get($baseUrl);
            $this->logObject->addWarning("getLatestFees,result:$result");
            $resultObject = json_decode($result); //转对象
            // var_dump($resultObject->result);exit;
            
            $BlockGetLatestFeesResponse->setErrorCode($resultObject->error_code);
            $BlockGetLatestFeesResponse->setResult($resultObject->result);  
            return $BlockGetLatestFeesResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
    }


}
?>