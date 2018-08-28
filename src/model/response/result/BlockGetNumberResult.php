<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class BlockGetNumberResult {
    private $header; //BlockNumber


    

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

        $privOb = new \src\model\response\result\data\BlockNumber();
        $privOb->setBlockNumber($header->seq);
        $this->header = $privOb;  //BlockNumber

        return $this;
    }
}
?>