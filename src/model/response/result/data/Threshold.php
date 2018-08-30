<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class Threshold{
    private $txThreshold;  //Long       tx_threshold
    private $typeThresholds=array(); //TypeThreshold[]      type_thresholds

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
    public function setTypeThresholds($typeThresholdsob)
    {
        foreach ($typeThresholdsob as $key => $value) {
            $signersOb = new \src\model\response\result\data\TypeThreshold();
            $signersOb->setType($value->type);
            $signersOb->setThreshold($value->threshold);
            array_push($this->typeThresholds,$signersOb);
        }
        return $this;
    }
}
?>