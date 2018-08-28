<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class BlockGetInfoResult{
    private $header; //BlockHeader header

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     *
     * @return self
     */
    public function setHeader($header)
    {
        
        $privOb = new \src\model\response\result\data\BlockHeader();
        $privOb->setCloseTime($header->close_time);
        $privOb->setNumber($header->seq);
        $privOb->setTxCount($header->tx_count);
        $privOb->setVersion($header->version);
        $this->header = $privOb;

        return $this;
    }
}
?>
