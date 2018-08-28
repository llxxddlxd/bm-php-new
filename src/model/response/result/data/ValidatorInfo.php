<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class ValidatorInfo{
    private $address;//String address

    private  $pledgeCoinAmount; //Long   pledge_coin_amount


    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPledgeCoinAmount()
    {
        return $this->pledgeCoinAmount;
    }

    /**
     * @param mixed $pledgeCoinAmount
     *
     * @return self
     */
    public function setPledgeCoinAmount($pledgeCoinAmount)
    {
        $this->pledgeCoinAmount = $pledgeCoinAmount;

        return $this;
    }
}