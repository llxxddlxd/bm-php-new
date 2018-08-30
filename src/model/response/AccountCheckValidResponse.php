<?php
namespace src\model\response;

use src\model\response\BaseResponse; 
/**
* 
*/
class AccountCheckValidResponse extends BaseResponse
{
   private $result; //AccountCheckValidResult

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
        $this->result = $result;

        return $this;
    }
}
?>