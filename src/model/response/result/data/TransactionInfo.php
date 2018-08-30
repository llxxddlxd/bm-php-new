<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class TransactionInfo{

    private  $sourceAddress; // String source_address


    private  $feeLimit; //Long fee_limit


    private  $gasPrice; //Long gas_price


    private  $nonce; //Long nonce


    private  $metadata; //String metadata


    private  $operations=array();//Operation[] operations
 

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
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     *
     * @return self
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

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
        if($operations){
            foreach ($operations as $key => $value) {
                $temp = new \src\model\response\result\data\Operation();
                $temp->setType(isset($value->type)?$value->type:0);
                $temp->setSourceAddress(isset($value->source_address)?$value->source_address:'');
                $temp->setMetadata(isset($value->metadata)?$value->metadata:'');
                $temp->setCreateAccount(isset($value->create_account)?$value->create_account:'');
                $temp->setIssueAsset(isset($value->issue_asset)?$value->issue_asset:'');
                $temp->setSendAsset(isset($value->pay_asset)?$value->pay_asset:'');
                $temp->setSendBU(isset($value->pay_coin)?$value->pay_coin:'');
                $temp->setMetadata(isset($value->set_metadata)?$value->set_metadata:'');
                $temp->setSetPrivilege(isset($value->set_privilege)?$value->set_privilege:'');
                $temp->setLog(isset($value->log)?$value->log:'');
                array_push($this->operations,$temp);
            }
        }
        

        return $this;
    }
}