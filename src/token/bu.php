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
class bu extends base{
    private $SdkError;

    function __construct($baseUrl=''){
        parent::__construct($baseUrl);
        $this->logObject->addWarning("bu construct");
        $this->SdkError = new \src\exception\SdkError();
    }

    /**
     * [send 该接口实现BU资产的发送
     * 注意：这里仅仅是生成交易，也就是获取protocolBuf]
     */
    function send($BUSendOperation){
         try{
            $buAmount =$BUSendOperation->getAmount();
            if($buAmount<0 || $buAmount>9223372036854775807){
                
                throw new \Exception($this->SdkError->errorDescArray['INVALID_BU_AMOUNT_ERROR']['errorDesc']);
            }

            $destAddress =$BUSendOperation->getDestAddress();
            $sdk = SDK::getInstance('');
            $account = $sdk->getAccount();            
            if(!$destAddress && !$account->checkAddress($destAddress)){
                throw new \Exception($this->SdkError->errorDescArray['INVALID_DESTADDRESS_ERROR']['errorDesc']);                
            }

            $sourceAddress =$BUSendOperation->getSourceAddress();

            $this->logObject->addWarning("bu send,destAddress:$destAddress,buAmount:$buAmount");
                
            //1该数据结构用于构建BU
            $createAccount = new \Protocol\OperationPayCoin();
            $createAccount->setDestAddress($destAddress);
            $createAccount->setAmount($buAmount); 

            $oper = new \Protocol\Operation();
            $oper->setSourceAddress($sourceAddress);
            $oper->setType(7);/*                      UNKNOWN = 0;             CREATE_ACCOUNT = 1;           ISSUE_ASSET = 2;           PAY_ASSE = 3;           SET_METADATA = 4;           SET_SIGNER_WEIGHT = 5;           SET_THRESHOLD = 6;           PAY_COIN = 7;           LOG = 8;           SET_PRIVILEGE = 9;  */
            $oper->setPayCoin($createAccount);
            return $oper;

        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }

    }



}
?>