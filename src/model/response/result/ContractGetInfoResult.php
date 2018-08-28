<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class ContractGetInfoResult{

    private $contract;//ContractInfo   contract
    
 

 

    /**
     * @return mixed
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * @param mixed $contract
     *
     * @return self
     */
    public function setContract($contract)
    {
        $this->contract = $contract;

        return $this;
    }
}