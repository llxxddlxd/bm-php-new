<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class Signature{
    private  $signData; //String   sign_data

    private  $publicKey; //String    public_key
 

    /**
     * @return mixed
     */
    public function getSignData()
    {
        return $this->signData;
    }

    /**
     * @param mixed $signData
     *
     * @return self
     */
    public function setSignData($signData)
    {
        $this->signData = $signData;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param mixed $publicKey
     *
     * @return self
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;

        return $this;
    }
}
?>