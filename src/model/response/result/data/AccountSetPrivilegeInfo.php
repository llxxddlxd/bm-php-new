<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;// //
class AccountSetPrivilegeInfo{ 
    private  $masterWeight;//String master_weight

    private  $signers=array();//Signer[] signers

    private  $txThreshold;//String tx_threshold

    private  $typeThresholds=array();//TypeThreshold[] type_thresholds

    /**
     * @return mixed
     */
    public function getMasterWeight()
    {
        return $this->masterWeight;
    }

    /**
     * @param mixed $masterWeight
     *
     * @return self
     */
    public function setMasterWeight($masterWeight)
    {
        $this->masterWeight = $masterWeight;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSigners()
    {
        return $this->signers;
    }

    /**
     * @param mixed $signers
     *
     * @return self
     */
    public function setSigners($signers)
    {
        if($signers){
            foreach ($signers as $key => $value) {
                $temp = new \src\model\response\result\data\Signer();
                $temp->setAddress(isset($value->address)?$value->address:"");
                $temp->setWeight(isset($value->weight)?$value->weight:"");
                array_push($this->signers ,$temp);
            }
        }
        

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxThreshold()
    {
        return $this->txThreshold;
    }

    /**
     * @param mixed $txThreshold
     *
     * @return self
     */
    public function setTxThreshold($txThreshold)
    {
        $this->txThreshold = $txThreshold;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeThresholds()
    {
        return $this->typeThresholds;
    }

    /**
     * @param mixed $typeThresholds
     *
     * @return self
     */
    public function setTypeThresholds($typeThresholds)
    {
        if($typeThresholds){
            foreach ($typeThresholds as $key => $value) {
                $temp = new \src\model\response\result\data\TypeThreshold();
                $temp->setType(isset($value->type)?$value->type:"");
                $temp->setThreshold(isset($value->threshold)?$value->threshold:"");
                array_push($this->typeThresholds ,$temp);
            }
        }

        return $this;
    }
}
?>