<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class BlockCheckStatusResult {
    private $isSynchronous; //bool


    
 

    /**
     * @return mixed
     */
    public function getIsSynchronous()
    {
        return $this->isSynchronous;
    }

    /**
     * @param mixed $isSynchronous
     *
     * @return self
     */
    public function setIsSynchronous($isSynchronous)
    {
        $this->isSynchronous = $isSynchronous;

        return $this;
    }
}
?>