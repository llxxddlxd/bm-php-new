<?php
/**
 * User: zjl
 * Date: 2018/08/08 10:00
 */
namespace src\model\request\operation;
use src\model\request\operation\BaseOperation;
use src\common\OperationType;

class LogCreateOperation extends BaseOperation {
    private  $topic; //string
    private  $datas; //List<String>

    public function __construct() {
        $this->operationType = OperationType::LOG_CREATE;
    }

    /**
     * 
     */
    public function getOperationType() {
        return $this->operationType;
    }

      
}
