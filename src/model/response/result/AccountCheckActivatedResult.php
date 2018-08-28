<?php
namespace src\model\response\result;

/**
* 
*/
class AccountCheckActivatedResult
{
    private $isActivated;
    
    function __construct(argument)
    {
        # code...
    }

    /**
     * @return mixed
     */
    public function getIsActivated()
    {
        return $this->isActivated;
    }

    /**
     * @param mixed $isActivated
     *
     * @return self
     */
    public function setIsActivated($isActivated)
    {
        $this->isActivated = $isActivated;

        return $this;
    }
}
?>