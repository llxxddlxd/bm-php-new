<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class AccountGetNonceResult {
    private $nonce;


    /**
     * @return mixed
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * @param mixed $nonce
     *
     * @return self
     */
    public function setNonce($nonce)
    {
        $this->nonce = $nonce;

        return $this;
    }
}
?>