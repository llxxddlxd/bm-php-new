<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class ContractGetAddressResult{

    private $contractAddressInfos;//List<ContractAddressInfo>  contract_address_infos
    
 


    /**
     * @return mixed
     */
    public function getContractAddressInfos()
    {
        return $this->contractAddressInfos;
    }

    /**
     * @param mixed $contractAddressInfos
     *
     * @return self
     */
    public function setContractAddressInfos($contractAddressInfos)
    {
        $this->contractAddressInfos = $contractAddressInfos;

        return $this;
    }
}