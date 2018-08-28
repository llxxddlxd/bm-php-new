<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class BlockGetTransactionsResult {
    private $totalCount;//Long  total_count

    private $transactions;//TransactionHistory[]   transactions
 

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
        foreach ($transactions as $key => $value) {
            
        }
        $this->transactions = $transactions;

        return $this;
    }
}
?>