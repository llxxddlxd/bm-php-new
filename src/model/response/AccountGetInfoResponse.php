<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response;

use src\model\response\BaseResponse;
class AccountGetInfoResponse extends BaseResponse{

    
    private $result; //AccountGetInfoResult

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     *
     * @return self
     */
    public function setResult($result)
    {   
        $resultOb = new \src\model\response\result\AccountGetInfoResult();
        $resultOb->setAddress(isset($result->address)?$result->address:"");
        $resultOb->setBalance(isset($result->balance)?$result->balance:"");
        $resultOb->setNonce(isset($result->nonce)?$result->nonce:"");
        if(isset($result->priv))
            $resultOb->setPriv($result->priv);
        $this->result = $resultOb;

        return $this;
    }

    /**
     * [buildResponse description]
     * @param  [type] $errorCode [description]
     * @param  [type] $errorDesc [description]
     * @param  [type] $result    [description]
     * @return [type]            [description]
     */
    public function buildResponse($errorCode,$errorDesc,$result){
        $this->errorCode = $errorCode;
        $this->errorDesc = $errorDesc;
        $this->result = $result;

    }
}
?>