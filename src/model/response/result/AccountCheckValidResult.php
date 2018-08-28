<?php
namespace src\model\response\result;
/**
 * 
 */
class AccountCheckValidResult{
    
    private $isValid;
    
    function __construct()
    {
        # code...
    }

    /**
     * @return mixed
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * @param mixed $isValid
     *
     * @return self
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }
}
?>