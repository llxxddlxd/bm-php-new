<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class ContractGetAddressResult{

   
    private $contractAddressInfos=array();//List<ContractAddressInfo>  contract_address_infos
    
 
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
        if($contractAddressInfos){
            foreach ($contractAddressInfos as $key => $value) {
                $temp = new \src\model\response\result\data\ContractAddressInfo();
                $temp->setContractAddress($value->contract_address);
                $temp->setOperationIndex($value->operation_index);
                array_push($this->contractAddressInfos, $temp);
                # code...
            }
        }
         

        return $this;
    }


}