<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response;

use src\model\response\BaseResponse;
class BlockGetTransactionsResponse extends BaseResponse{

    private $result; //BlockGetTransactionsResult

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
        $resultOb = new \src\model\response\result\BlockGetTransactionsResult();
        $resultOb->setTotalCount(isset($result->total_count)?$result->total_count:"");
        $resultOb->setTransactions(isset($result->transactions)?$result->transactions:"");

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