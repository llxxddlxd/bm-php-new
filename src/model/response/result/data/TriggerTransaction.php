<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class TriggerTransaction{   
  
  
     
 
    private $hash; //string  hash
    

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     *
     * @return self
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }
}
?>