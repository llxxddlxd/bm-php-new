<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response;

use src\model\response\BaseResponse;
class BlockCheckStatusLedgerSeqResponse extends BaseResponse{

    private $ledgerSeq; //LedgerSeq ledger_manager

    

    /**
     * @return mixed
     */
    public function getLedgerSeq()
    {
        return $this->ledgerSeq;
    }

    /**
     * @param mixed $ledgerSeq
     *
     * @return self
     */
    public function setLedgerSeq($ledgerSeq)
    {

        $temp =   new \src\model\response\result\data\LedgerSeq();
        $temp->setChainMaxLedgerSeq($ledgerSeq->chain_max_ledger_seq);
        $temp->setLedgerSequence($ledgerSeq->ledger_sequence);
        $this->ledgerSeq = $temp;

        return $this;
    }
}
?>