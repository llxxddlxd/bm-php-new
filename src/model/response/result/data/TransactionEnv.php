<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class TransactionEnv{       
 
    private $transaction; //TransactionInfo  transaction
    private $trigger; //ContractTrigger  trigger
   

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
        $temp = new \src\model\response\result\data\TransactionInfo();
        $temp->setSourceAddress(isset($transaction->source_address)?$transaction->source_address:"");
        $temp->setFeeLimit(isset($transaction->fee_limit)?$transaction->fee_limit:"");
        $temp->setGasPrice(isset($transaction->gas_price)?$transaction->gas_price:"");
        $temp->setNonce(isset($transaction->nonce)?$transaction->nonce:"");
        $temp->setMetadata(isset($transaction->metadata)?$transaction->metadata:"");
        $temp->setOperations(isset($transaction->operations)?$transaction->operations:"");
        $this->transaction = $temp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * @param mixed $trigger
     *
     * @return self
     */
    public function setTrigger($trigger)
    {
        $temp = new \src\model\response\result\data\ContractTrigger();
        $temp->setTransaction(isset($trigger->transaction)?$trigger->transaction:"");
        $this->trigger = $temp;
        return $this;
    }
}
?>