<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class ContractTrigger{   
  
    private $transaction; //TriggerTransaction  transaction

  

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
}
?>