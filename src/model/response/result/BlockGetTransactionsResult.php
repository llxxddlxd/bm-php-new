<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class BlockGetTransactionsResult {
    private $totalCount;//Long  total_count

    private $transactions=array();//TransactionHistory[]   transactions
 

    /**
     * @return mixed
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @param mixed $totalCount
     *
     * @return self
     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param mixed $transactions
     *
     * @return self
     */
    public function setTransactions($transactions)
    {
        if($transactions){
            foreach ($transactions as $key => $value) {
                $temp = new \src\model\response\result\data\TransactionHistory();
                $temp->setActualFee(isset($value->actual_fee)?$value->actual_fee:"");
                $temp->setCloseTime(isset($value->close_time)?$value->close_time:"");
                $temp->setErrorCode(isset($value->error_code)?$value->error_code:"");
                $temp->setErrorDesc(isset($value->error_desc)?$value->error_desc:"");
                $temp->setHash(isset($value->hash)?$value->hash:"");
                $temp->setLedgerSeq(isset($value->ledger_seq)?$value->ledger_seq:"");
                $temp->setSignatures(isset($value->signatures)?$value->signatures:"");
                $temp->setTransaction(isset($value->transaction)?$value->transaction:"");
                $temp->setTxSize(isset($value->tx_size)?$value->tx_size:"");
                array_push($this->transactions , $temp);
            }   
        }

        return $this;
    }
}
?>