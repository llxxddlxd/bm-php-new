<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class TransactionFees{   
  
  
     
 
    private $feeLimit; //long  fee_limit
    private $gasPrice; //long  gas_price
   
 

    /**
     * @return mixed
     */
    public function getFeeLimit()
    {
        return $this->feeLimit;
    }

    /**
     * @param mixed $feeLimit
     *
     * @return self
     */
    public function setFeeLimit($feeLimit)
    {
        $this->feeLimit = $feeLimit;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGasPrice()
    {
        return $this->gasPrice;
    }

    /**
     * @param mixed $gasPrice
     *
     * @return self
     */
    public function setGasPrice($gasPrice)
    {
        $this->gasPrice = $gasPrice;

        return $this;
    }
}
?>