<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response;

use src\model\response\BaseResponse;
class BlockGetLatestRewardResponse extends BaseResponse{

    private $result; //BlockGetLatestRewardResult

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
        $resultOb = new \src\model\response\result\BlockGetLatestRewardResult();
        $resultOb->setRewardResults(isset($result->validators_reward)?$result->validators_reward:"");
        $resultOb->setBlockReward(isset($result->block_reward)?$result->block_reward:0);

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