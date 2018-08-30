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
        if($signatures){
            foreach ($signatures as $key => $value) {
                $resultOb = new \src\model\response\result\data\Signature();
                $resultOb->setSignData($value->sign_data);
                $resultOb->setPublicKey($value->public_key);
                array_push($this->signatures , $resultOb);
            }
        }
        

        return $this;
    }
}