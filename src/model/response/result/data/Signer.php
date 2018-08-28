<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class Signer{
    private $address;//String
    private $weight;//Long

    public function Signer($address,$weight){
        $this->address = $address;
        $this->weight = $weight;
        
    }

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
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     *
     * @return self
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }
}
?>