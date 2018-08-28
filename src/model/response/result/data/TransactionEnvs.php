<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class TransactionEnvs{   
  
  
     
 
    private $transactionEnv; //TransactionEnv  transaction_env
   

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