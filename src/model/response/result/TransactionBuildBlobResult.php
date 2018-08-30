<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class TransactionBuildBlobResult{

    private $transactionBlob;//String    transaction_blob
    private $hash;//String   hash
    
 
    

    /**
     * @return mixed
     */
    public function getTransactionBlob()
    {
        return $this->transactionBlob;
    }

    /**
     * @param mixed $transactionBlob
     *
     * @return self
     */
    public function setTransactionBlob($transactionBlob)
    {
        $this->transactionBlob = $transactionBlob;

        return $this;
    }

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