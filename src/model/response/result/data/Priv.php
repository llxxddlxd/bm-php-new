<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class Priv{
   private $masterWeight; //String  master_weight
   private $signers=array();  //Signer[]   signers
   private $threshold; //Threshold   thresholds

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
    public function setSigners($signersob)
    {   
        // var_dump($signersob);exit;
        if($signersob){
            foreach ($signersob as $key => $value) {
                $signersOb = new \src\model\response\result\data\Signer();
                $signersOb->setAddress($value->address);
                $signersOb->setWeight($value->weight);
                array_push($this->signers,$signersOb);
            }   
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getThreshold()
    {
        return $this->threshold;
    }

    /**
     * @param mixed $threshold
     *
     * @return self
     */
    public function setThreshold($threshold)
    {

        $thresholdOb = new \src\model\response\result\data\Threshold();
        $thresholdOb->setTxThreshold(isset($threshold->tx_threshold)?$threshold->tx_threshold:'');
        if(isset($threshold->type_thresholds))
            $thresholdOb->setTypeThresholds($threshold->type_thresholds);

        $this->threshold = $thresholdOb;

        return $this;
    }
}
?>