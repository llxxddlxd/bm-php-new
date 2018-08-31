<?php
namespace src\exception;
class SDKException {
    private $errorCode;
    private $errorDesc;
    public function __construct($errCode,$message)
        $this->errorCode = $errCode;
        $this->errorDesc = $message;
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

  
    /**
     * @return mixed
     */
    public function getErrorDesc()
    {
        return $this->errorDesc;
    }

   
}
?>