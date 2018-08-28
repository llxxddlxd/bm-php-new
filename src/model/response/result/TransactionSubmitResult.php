<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class TransactionSubmitResult{
     
    private $hash;;//String     hash
 

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     *
     * @return self
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }
}