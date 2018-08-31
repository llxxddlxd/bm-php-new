<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response;

use src\model\response\BaseResponse;
class ContractCallResponse extends BaseResponse{

    private $result; //ContractCallResult

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
        // var_dump($result);exit;
        $resultOb = new \src\model\response\result\ContractCallResult();
        $resultOb->setLogs(isset($result->logs)?$result->logs:"");
        $resultOb->setQueryRets(isset($result->query_rets)?$result->query_rets:"");
        $resultOb->setStat(isset($result->stat)?$result->stat:"");
        $resultOb->setTxs(isset($result->txs)?$result->txs:"");

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
