<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;// 
class BUSendInfo {

    private  $destAddress;//String  dest_address

    private  $amount;//Long amount

    private  $input;//String input


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
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param mixed $input
     *
     * @return self
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }
}
?>