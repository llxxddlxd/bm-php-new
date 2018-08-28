<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class BlockGetFeesResult{
    private $fees; //Fees fees

   

    /**
     * @return mixed
     */
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * @param mixed $fees
     *
     * @return self
     */
    public function setFees($fees)
    {
        $temp =   new \src\model\response\result\data\Fees();
        $temp->setBaseReserve(isset($fees->base_reserve)?$fees->base_reserve:0);
        $temp->setGasPrice(isset($fees->gas_price)?$fees->gas_price:0);
        $this->fees = $temp;

        return $this;
    }
}
?>
