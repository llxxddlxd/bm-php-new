<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class BlockNumber{
   private $blockNumber;  //long   seq

   

    /**
     * @return mixed
     */
    public function getBlockNumber()
    {
        return $this->blockNumber;
    }

    /**
     * @param mixed $blockNumber
     *
     * @return self
     */
    public function setBlockNumber($blockNumber)
    {
        $this->blockNumber = $blockNumber;

        return $this;
    }
}
?>