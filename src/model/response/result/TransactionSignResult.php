<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class TransactionSignResult{

    private $signatures=array();//Signature[]   signatures

    

    /**
     * @return mixed
     */
    public function getSignatures()
    {
        return $this->signatures;
    }

    /**
     * @param mixed $signatures
     *
     * @return self
     */
    public function setSignatures($signatures)
    {
        $this->signatures = $signatures;

        return $this;
    }
}