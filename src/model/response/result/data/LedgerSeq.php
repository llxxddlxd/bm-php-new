<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class LedgerSeq{   
  
    private $chainMaxLedgerSeq; //long  chain_max_ledger_seq
    private $ledgerSequence; //long  ledger_sequence

  
 

    /**
     * @return mixed
     */
    public function getChainMaxLedgerSeq()
    {
        return $this->chainMaxLedgerSeq;
    }

    /**
     * @param mixed $chainMaxLedgerSeq
     *
     * @return self
     */
    public function setChainMaxLedgerSeq($chainMaxLedgerSeq)
    {
        $this->chainMaxLedgerSeq = $chainMaxLedgerSeq;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLedgerSequence()
    {
        return $this->ledgerSequence;
    }

    /**
     * @param mixed $ledgerSequence
     *
     * @return self
     */
    public function setLedgerSequence($ledgerSequence)
    {
        $this->ledgerSequence = $ledgerSequence;

        return $this;
    }
}
?>