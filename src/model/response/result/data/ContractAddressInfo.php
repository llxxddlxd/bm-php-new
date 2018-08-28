<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class ContractAddressInfo{   

    private $contractAddress; //Integer  contract_address

    private $operationIndex; //String  operation_index

   

    /**
     * @return mixed
     */
    public function getContractAddress()
    {
        return $this->contractAddress;
    }

    /**
     * @param mixed $contractAddress
     *
     * @return self
     */
    public function setContractAddress($contractAddress)
    {
        $this->contractAddress = $contractAddress;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperationIndex()
    {
        return $this->operationIndex;
    }

    /**
     * @param mixed $operationIndex
     *
     * @return self
     */
    public function setOperationIndex($operationIndex)
    {
        $this->operationIndex = $operationIndex;

        return $this;
    }
}
?>