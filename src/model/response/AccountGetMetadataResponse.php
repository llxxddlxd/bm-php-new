<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response;

use src\model\response\BaseResponse;
class AccountGetMetadataResponse extends BaseResponse{

    private $result ;//AccountGetMetadataResult 
    

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
 
        $AccountGetMetadataResult = new \src\model\response\result\AccountGetMetadataResult();
        if($result->metadatas)
            $AccountGetMetadataResult->setMetadatas($result->metadatas);
        $this->result = $AccountGetMetadataResult;

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