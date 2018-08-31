<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class Fees{
   private $baseReserve; //long base_reserve   
   private $gasPrice;  //long gas_price


    /**
     * @return mixed
     */
    public function getBaseReserve()
    {
        return $this->baseReserve;
    }

    /**
     * @param mixed $baseReserve
     *
     * @return self
     */
    public function setBaseReserve($baseReserve)
    {
        $this->baseReserve = $baseReserve;

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