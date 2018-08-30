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

        $resultOb = new \src\model\response\result\data\ContractInfo();
        $resultOb->setType(isset($contract->type)?$contract->type:"");
        $resultOb->setPayload(isset($contract->payload)?$contract->payload:"");
        $this->contract = $resultOb;

        return $this;
    }
}