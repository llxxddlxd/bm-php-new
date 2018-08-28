<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response;

use src\model\response\BaseResponse;
class AccountGetAssetsResponse extends BaseResponse{
    private $result ;//AccountGetAssetsResult 
    

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
        // echo $result
        $AccountGetAssetsResult = new \src\model\response\result\AccountGetAssetsResult();
        if($result->assets)
            $AccountGetAssetsResult->setAssets($result->assets);
        $this->result = $AccountGetAssetsResult;

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