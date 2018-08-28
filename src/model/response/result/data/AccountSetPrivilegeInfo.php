<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;// //
class AccountSetPrivilegeInfo{ 
    private  $masterWeight;//String master_weight

    private  $signers;//Signer[] signers

    private  $txThreshold;//String tx_threshold

    private  $typeThresholds;//TypeThreshold[] type_thresholds

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
        $this->signers = $signers;

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
        $this->typeThresholds = $typeThresholds;

        return $this;
    }
}
?>