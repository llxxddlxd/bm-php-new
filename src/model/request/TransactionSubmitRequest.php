<?php
/**
 * User: zjl
 * Date: 2018/08/08 10:00
 */
namespace src\model\request;
class TransactionSubmitRequest{
    private $transactionBlob;
    private $signatures; //Signature[]

  



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
    public function getSignatures()
    {
        return $this->signatures;
    }

    /**
     * @param mixed $signatures
     *
     * @return self
     */
    public function setSignatures($signatures)
    {
        $this->signatures = $signatures;

        return $this;
    }
} 
?>