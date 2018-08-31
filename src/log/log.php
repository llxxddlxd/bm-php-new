<?php
/**
 * User: zjl
 * Date: 2018/08/08 10:00
 */
namespace src\log;

use src\base;
use src\common\General;
use src\common\Constant;
use src\SDK;

class log extends base{
 private $SdkError;
    /**
     * [__construct description]
     */
    function __construct(){
        parent::__construct();
        $this->logObject->addWarning("log construct");
        $this->SdkError = new \src\exception\SdkError();
    } 
   

    /**
     * [在区块链上写日志信息]
     */
    function create($LogCreateOperation){
        try{
            if(!$LogCreateOperation){
                throw new \Exception($this->SdkError->errorDescArray['REQUEST_NULL_ERROR']['errorDesc']);
            }
            $sourceAddress = $LogCreateOperation->getSourceAddress();
            $sdk = SDK::getInstance('');
            $account = $sdk->getAccount();
            if(!$sourceAddress && !$account->checkAddress($sourceAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_SOURCEADDRESS_ERROR']['errorDesc']);
            }  

            $topic = $LogCreateOperation->getTopic();
            if(!$topic || strlen($topic)< Constant::LOG_TOPIC_MIN || strlen($topic)>Constant::LOG_TOPIC_MAX){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_LOG_TOPIC_ERROR']['errorDesc']);
            }
            
            $getDatas = $LogCreateOperation->getDatas();
            if(!$getDatas){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_LOG_DATA_ERROR']['errorDesc']);                
            }

            foreach ($getDatas as $key => $value) {
                if(strlen($value)< Constant::LOG_TOPIC_MIN || strlen($value)>Constant::LOG_TOPIC_MAX){
                    throw new \Exception($this->SdkError->errorDescArray['INVALID_LOG_DATA_ERROR']['errorDesc']);
                }
            }

            $metadata = $LogCreateOperation->getMetadata();
            // build operation
            //1该数据结构用于创建日志
            $OperationLog = new \Protocol\OperationLog();
            $OperationLog->setTopic($topic);
            $OperationLog->setDatas($getDatas);
            
            //2
            $oper = new \Protocol\Operation();
            if($sourceAddress)
                $oper->setSourceAddress($sourceAddress);
            if($metadata)
                $oper->setMetadata($metadata);
            $oper->setType(8); //log=8
            $oper->setLog($OperationLog);
            return $oper;

        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
      
    }


}
?>