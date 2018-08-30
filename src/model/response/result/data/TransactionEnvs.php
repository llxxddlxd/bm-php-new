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

        $temp = new \src\model\response\result\data\TransactionEnv();
        $temp->setTransaction(isset($transactionEnv->transaction_env)?$transactionEnv->transaction_env:"");
        $temp->setTrigger(isset($transactionEnv->trigger)?$transactionEnv->trigger:"");
        $this->transactionEnv = $temp;

        return $this;
    }
}
?>