<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class TransactionParseBlobResult{
    private $sourceAddress;;//String     source_address
    private $feeLimit;;//Long     fee_limit
    private $gasPrice;;//    Long gas_price
    private $nonce;;//    Long nonce
    private $operations;;//    OperationFormat[] operations
 
  

    /**
     * @return mixed
     */
    public function getSourceAddress()
    {
        return $this->sourceAddress;
    }

    /**
     * @param mixed $sourceAddress
     *
     * @return self
     */
    public function setSourceAddress($sourceAddress)
    {
        $this->sourceAddress = $sourceAddress;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFeeLimit()
    {
        return $this->feeLimit;
    }

    /**
     * @param mixed $feeLimit
     *
     * @return self
     */
    public function setFeeLimit($feeLimit)
    {
        $this->feeLimit = $feeLimit;

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

    /**
     * @return mixed
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * @param mixed $nonce
     *
     * @return self
     */
    public function setNonce($nonce)
    {
        $this->nonce = $nonce;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * @param mixed $operations
     *
     * @return self
     */
    public function setOperations($operations)
    {
        $this->operations = $operations;

        return $this;
    }
}