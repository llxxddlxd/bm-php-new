<?php
/**
 * User: zjl
 * Date: 2018/08/08 10:00
 * 组装所有的出参
 */
namespace src;
class operatorObject{
    /**
     * [operator description]
     * @param  [type] $type       [description]
     * @param  [type] $dataObject [description]
     * @return [type]             [description]
     */
    static public function operator($type,$response,$dataObject){
        switch($type){
            case 1: 
                $dataObject = self::changeObRule($dataObject);
                return self::operatorGetInfo($response,$dataObject);
                exit;
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * [operatorResult description]
     * @param  [type] $resultObject [description]
     * @return [type]               [description]
     */
    static private function operatorResult($result){
         foreach ($result as $key => $value) {
            if(is_object($value)){
                // $value = self::operatorResult($result);
            }

            if(is_string($key)){
                
            }
        }
    }
    /**
     * [operatorGetInfo description]
     * @param  [type] $dataObject [description]
     * @return [type]             [description]
     */
    static private function operatorGetInfo($responseObject,$dataObject){
        $responseObject->setErrorCode($dataObject->errorCode);
        $resultObject = self::operatorResult($dataObject->result);
        $responseObject->setResult($resultObject);
        return $responseObject;
    }
    
    /**
     * [changeObRule description]
     * @return [type] [description]
     */
    static private function changeObRule($dataObject){
        foreach ($dataObject as $key => $value) {
            if(is_object($value)){
                $value = self::changeObRule($value);
            }
            //下划线替换为驼峰
            if(is_string($key)){
                $tempArr = explode("_", $key);
                if(count($tempArr)>1){
                    $newKey = $tempArr[0]. ucfirst($tempArr[1]);
                    $dataObject->$newKey = $value;
                    unset($dataObject->$key);
                } 
            }

        }
        return $dataObject;
       
    }
}
?>