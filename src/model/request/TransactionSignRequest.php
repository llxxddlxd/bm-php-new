<?php
/**
 * User: zjl
 * Date: 2018/08/08 10:00
 */
namespace src\model\request;
class TransactionSignRequest{
    private $blob;
    private $privateKeys; //string[]

  


    /**
     * @return mixed
     */
    public function getBlob()
    {
        return $this->blob;
    }

    /**
     * @param mixed $blob
     *
     * @return self
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrivateKeys()
    {
        return $this->privateKeys;
    }

    /**
     * @param mixed $privateKeys
     *
     * @return self
     */
    public function setPrivateKeys($privateKeys)
    {
        $this->privateKeys = $privateKeys;

        return $this;
    }
} 
?>