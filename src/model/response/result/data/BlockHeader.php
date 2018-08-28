<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class BlockHeader{

    private $closeTime; //Long  close_time

    private $number; //Long  seq

    private $txCount; //long  tx_count

    private $version; //long version


    /**
     * @return mixed
     */
    public function getCloseTime()
    {
        return $this->closeTime;
    }

    /**
     * @param mixed $closeTime
     *
     * @return self
     */
    public function setCloseTime($closeTime)
    {
        $this->closeTime = $closeTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     *
     * @return self
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxCount()
    {
        return $this->txCount;
    }

    /**
     * @param mixed $txCount
     *
     * @return self
     */
    public function setTxCount($txCount)
    {
        $this->txCount = $txCount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     *
     * @return self
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }
}
?>