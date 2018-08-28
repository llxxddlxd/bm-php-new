<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class AssetInfo{
   private $key; //AssetKey    key
   private $amount;  //long   amount

   

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     *
     * @return self
     */
    public function setKey($key)
    {
        $temp = new \src\model\response\result\data\AssetKey();
        $temp->setCode($key->code);
        $temp->setIssuer($key->issuer)
        $this->key = $temp;

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
}
?>