<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class TransactionEvaluateFeeResult{

    private $txs;;//TestTx[]     txs
 

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
        $this->txs = $txs;

        return $this;
    }
}