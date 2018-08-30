<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class TransactionEvaluateFeeResult{

    private $txs=array();//TestTx[]     txs
 

    /**
     * @return mixed
     */
    public function getTxs()
    {
        return $this->txs;
    }

    /**
     * @param mixed $txs
     *
     * @return self
     */
    public function setTxs($txs)
    {
        if($txs){
            foreach ($txs as $key => $value) {

                $temp = new \src\model\response\result\data\TestTx();
                $temp->setTransactionEnv(isset($value->transaction_env)?$value->transaction_env:"");
                array_push($this->txs,$txs);        

                # code...
            }
        }

        return $this;
    }
}