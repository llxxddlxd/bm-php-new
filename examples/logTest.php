<?php

/**
 * 用于测试log中的所有接口
 * test url:  http://127.0.0.1/bumo-sdk-PHP/examples/logTest.php?type={$type}
 */


include_once dirname(dirname(__FILE__)). "/src/autoload.php";

//声明单例模式
$baseUrl = "http://seed1.bumotest.io:26002";
use src\SDK;
$sdk = SDK::getInstance($baseUrl);

$type = isset($_GET['type'])?$_GET['type']:1;
switch ($type) {
    case 1: //在区块链上写日志信息
        $transaction = $sdk->getTransaction();
        $sourcePriKey = "privbUtxb6hnkmdEy4fhZNtKMKVHaS4VLzRsq2Ug4tQ5B4Yn7HDWkJeF";
        $sourceAddress = "buQjSYyZyv2J5Tk92nKfakECJuayyRZozfCt";
        //1获取nonce
        {
            $account = $sdk->getAccount();
            $AccountGetNonceRequest = new \src\model\request\AccountGetNonceRequest();
            $AccountGetNonceRequest->setAddress($sourceAddress);
            $retNonce = $account->getNonce($AccountGetNonceRequest);             
            $nonce = $retNonce->getResult()->getNonce();
        }
        //2transactionblob
        {
            //2.1构造基础的数据结构 激活帐户
            $log = $sdk->getLog();
            $LogCreateOperation = new \src\model\request\operation\LogCreateOperation();
            $LogCreateOperation->setSourceAddress($sourceAddress);
            $LogCreateOperation->setTopic("test topic");
            $LogCreateOperation->setDatas([0=>"test data"]);
            $operation = $log->create($LogCreateOperation);
            // var_dump($ret);exit;
            //2.2初始化基础数据+序列化
            $metaData = $opMetaData=bin2hex('metaData');
            $gasPrice = 1000;
            $feeLimit = 10000000; 

            $transactionblob = $transaction->buildBlob($nonce,$sourceAddress,$metaData,$gasPrice,$feeLimit,$opMetaData,$operation);
            if($transactionblob['status'] != 0){
                echo $transactionblob['status'];
                exit;
            }
        }
        //3sign
        {
            $signData = $transaction->sign($transactionblob['hash'],$sourcePriKey);
            if($signData['status'] != 0){
                echo $retNonce['status'];
                exit;
            }
        }
        //4发送
        {
            $retArr = $transaction->submit($signData['sourcePublicKey'],$transactionblob['transactionBlob'],$signData['signDataHex']);
            $ret = $retArr;
        }

       break;   
}
var_dump($ret);exit;

?>