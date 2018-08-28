<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class TestTx{   
  
  
     
 
    private $transactionEnv; //TransactionFees  transaction_env
  


    /**
     * @return mixed
     */
    public function getTransactionEnv()
    {
        return $this->transactionEnv;
    }

    /**
     * @param mixed $transactionEnv
     *
     * @return self
     */
    public function setTransactionEnv($transactionEnv)
    {
        $this->transactionEnv = $transactionEnv;

        return $this;
    }
}
?>