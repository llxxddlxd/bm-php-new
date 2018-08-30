<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;//  
class AccountActiviateInfo{
   
    private $destAddress;// String  dest_address

   
    private $contract;//ContractInfo  contract

   
    private $priv;// Priv priv

   
    private $metadatas=array();//MetadataInfo[]  metadatas

   
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

        $temp = new \src\model\response\result\data\ContractInfo();
        $temp->setType(isset($contract->type)?$contract->type:0);
        $temp->setPayload(isset($contract->payload)?$contract->payload:"");
        $this->contract = $temp;

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
        $temp = new \src\model\response\result\data\Priv();
        $temp->setMasterWeight(isset($priv->master_weight)?$priv->master_weight:0);
        // var_dump($priv);
        $temp->setSigners(isset($priv->signers)?$priv->signers:"");
        // echo 3;exit;
        $temp->setThreshold(isset($priv->thresholds)?$priv->thresholds:"");
        $this->priv = $temp;

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
        if($metadatas){
            foreach ($metadatas as $key => $value) {
                $temp = new \src\model\response\result\data\MetadataInfo();
                $temp->setKey(isset($contract->key)?$contract->key:"");
                $temp->setValue(isset($contract->value)?$contract->value:"");
                $temp->setVersion(isset($contract->version)?$contract->version:0);
                array_push($this->metadatas , $temp);
        
            }
        }

        
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