<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;//  
class AccountActiviateInfo{
   
    private $destAddress;// String  dest_address

   
    private $contract;//ContractInfo  contract

   
    private $priv;// Priv priv

   
    private $metadatas;//MetadataInfo[]  metadatas

   
    private $initBalance;// Long init_balance

   
    private $initInput;//String  init_input

    

    /**
     * @return mixed
     */
    public function getDestAddress()
    {
        return $this->destAddress;
    }

    /**
     * @param mixed $destAddress
     *
     * @return self
     */
    public function setDestAddress($destAddress)
    {
        $this->destAddress = $destAddress;

        return $this;
    }

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

    /**
     * @return mixed
     */
    public function getPriv()
    {
        return $this->priv;
    }

    /**
     * @param mixed $priv
     *
     * @return self
     */
    public function setPriv($priv)
    {
        $this->priv = $priv;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetadatas()
    {
        return $this->metadatas;
    }

    /**
     * @param mixed $metadatas
     *
     * @return self
     */
    public function setMetadatas($metadatas)
    {
        $this->metadatas = $metadatas;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInitBalance()
    {
        return $this->initBalance;
    }

    /**
     * @param mixed $initBalance
     *
     * @return self
     */
    public function setInitBalance($initBalance)
    {
        $this->initBalance = $initBalance;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInitInput()
    {
        return $this->initInput;
    }

    /**
     * @param mixed $initInput
     *
     * @return self
     */
    public function setInitInput($initInput)
    {
        $this->initInput = $initInput;

        return $this;
    }
}
?>