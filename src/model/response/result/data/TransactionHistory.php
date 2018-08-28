<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class TransactionHistory{
    
    private $actualFee;//String  actual_fee

    
    private $closeTime;//Long  close_time

    
    private $errorCode;//Integer  error_code

    
    private $errorDesc;//String  error_desc

    
    private $hash;//String  hash

    
    private $ledgerSeq;//Long  ledger_seq

    
    private $signatures;//Signature[]  signatures

    
    private $transaction;//TransactionInfo  transaction

    
    private $txSize;//Long  tx_size

  

    /**
     * @return mixed
     */
    public function getActualFee()
    {
        return $this->actualFee;
    }

    /**
     * @param mixed $actualFee
     *
     * @return self
     */
    public function setActualFee($actualFee)
    {
        $this->actualFee = $actualFee;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCloseTime()
    {
        return $this->closeTime;
    }

    /**
     * @param mixed $closeTime
     *
     * @return self
     */
    public function setCloseTime($closeTime)
    {
        $this->closeTime = $closeTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param mixed $errorCode
     *
     * @return self
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrorDesc()
    {
        return $this->errorDesc;
    }

    /**
     * @param mixed $errorDesc
     *
     * @return self
     */
    public function setErrorDesc($errorDesc)
    {
        $this->errorDesc = $errorDesc;

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

    /**
     * @return mixed
     */
    public function getLedgerSeq()
    {
        return $this->ledgerSeq;
    }

    /**
     * @param mixed $ledgerSeq
     *
     * @return self
     */
    public function setLedgerSeq($ledgerSeq)
    {
        $this->ledgerSeq = $ledgerSeq;

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

    /**
     * @return mixed
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param mixed $transaction
     *
     * @return self
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxSize()
    {
        return $this->txSize;
    }

    /**
     * @param mixed $txSize
     *
     * @return self
     */
    public function setTxSize($txSize)
    {
        $this->txSize = $txSize;

        return $this;
    }
}
?>