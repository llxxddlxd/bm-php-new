<?php
// http://127.0.0.1/bumo-sdk-PHP/examples/blockchainTest.php?type=
include_once dirname(dirname(__FILE__)). "/src/autoload.php";
//声明单例模式
$baseUrl = "http://seed1.bumotest.io:26002";
use src\SDK;
$sdk = SDK::getInstance($baseUrl);

//获取测试类型
$type = isset($_GET['type'])?$_GET['type']:1;
switch ($type) {
    case 1://查询最新的区块高度
        $object = $sdk->getBlock();
        $ret = $object->getNumber();
        var_dump($ret->getresult()->getHeader());exit;
        break;
    case 2: //检查本地节点区块是否同步完成
        $object = $sdk->getBlock();
        $ret = $object->checkStatus();
        var_dump($ret);exit;
        # code...
        break;  
    case 3: //获取最新区块信息
        $object = $sdk->getBlock();
        $ret = $object->getLatestInfo();
        var_dump($ret->getresult());exit;
        # code...
        break;  
    case 4:
        $object = $sdk->getBlock();
        $BlockGetValidatorsRequest = new \src\model\request\BlockGetValidatorsRequest();
        $BlockGetValidatorsRequest->setBlockNumber(1001849);
        $ret = $object->getValidators($BlockGetValidatorsRequest);
        var_dump($ret->getresult());exit;
        # code...
        break;  
    case 5:
        $object = $sdk->getBlock();
        $ret = $object->getLatestReward();
        var_dump($ret->getresult());exit;
        # code...
        break;  

    case 6:
        $object = $sdk->getBlock();
        $ret = $object->getLatestValidators();
        var_dump($ret->getresult());exit;
        # code...
        break;  
    case 7:
        $object = $sdk->getBlock();
        $BlockGetFeesRequest = new \src\model\request\BlockGetFeesRequest();
        $BlockGetFeesRequest->setBlockNumber(1001849);
        $ret = $object->getFees($BlockGetFeesRequest);
        var_dump($ret->getresult());exit;
        # code...
        break;   
    case 8:
        $object = $sdk->getBlock();
        $ret = $object->getLatestFees();
        var_dump($ret->getresult());exit;
        # code...
        break;  
    case 9:
        $object = $sdk->getBlock();
        $BlockGetTransactionRequest = new \src\model\request\BlockGetTransactionRequest();
        $BlockGetTransactionRequest->setBlockNumber(1036684);
        $ret = $object->getTransactions($BlockGetTransactionRequest);
        var_dump($ret->getresult());exit;
        # code...
        break;  
    case 10:
        $object = $sdk->getBlock();
        $BlockGetInfoRequest = new \src\model\request\BlockGetInfoRequest();
        $BlockGetInfoRequest->setBlockNumber(1001849);
        $ret = $object->getInfo($BlockGetInfoRequest);
        var_dump($ret->getresult());exit;
        # code...
        break;   
    case 11:
        $object = $sdk->getBlock();
        $BlockGetRewardRequest = new \src\model\request\BlockGetRewardRequest();
        $BlockGetRewardRequest->setBlockNumber(1001849);
        $ret = $object->getReward($BlockGetRewardRequest);
        var_dump($ret->getresult());exit;
        # code...
        break;  
    case 12:
        $object = $sdk->getTransaction();
        $TransactionGetInfoRequest = new \src\model\request\TransactionGetInfoRequest();
        $TransactionGetInfoRequest->setHash("8acea38df0fd4f6c4acaab639d6b090255a2b09a63c7e2a631c04ca8740cdbac");
        $ret = $object->getInfo($TransactionGetInfoRequest);
        print_r($ret->getresult()->getTransactions()[0]->getTransaction()->getOperations()[0]->getCreateAccount());exit;
        # code...
        break;  
    
    
    
    default:
        # code...
        break;
}
var_dump($ret);exit;

?>

?>