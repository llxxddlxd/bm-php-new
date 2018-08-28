<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class ContractCheckValidResult{

    private $isValid;//Boolean  is_valid
    
 

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