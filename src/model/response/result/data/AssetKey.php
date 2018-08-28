<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class AssetKey{
    private $code;  //Integer   code
    private $issuer; //Long   issuer

    
 
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     *
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param mixed $issuer
     *
     * @return self
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;

        return $this;
    }
}
?>