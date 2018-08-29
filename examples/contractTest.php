<?php
// http://127.0.0.1/bumo-sdk-PHP/examples/contractTest.php?type=
include_once dirname(dirname(__FILE__)). "/src/autoload.php";
//声明单例模式
$baseUrl = "http://seed1.bumotest.io:26002";
use src\SDK;
$sdk = SDK::getInstance($baseUrl);


//获取测试类型
$type = isset($_GET['type'])?$_GET['type']:1;
switch ($type) {
    case 1://该方法用于合约的创建
    //测试成功，如下
    // http://seed1.bumotest.io:26002/getTransactionHistory?hash=e05fe8103ed876d855fb83c14338dc57b0205269270bf019d2a181d88e28d431
        $transaction = $sdk->getTransaction();
        $account = $sdk->getAccount();
        $sourcePriKey = "privbsQfZT2b5fDvgc1f6ghGVeZgxeGNrBrFTYN7xwg1UFvmoCbU2qUm";
        $sourceAddress = "buQecWYFHemdH8s9bTYsWuk6bvdswnJJaCT3";
        //1获取nonce
        {
            $AccountGetNonceRequest = new \src\model\request\AccountGetNonceRequest();
            $AccountGetNonceRequest->setAddress($sourceAddress);
            $retNonce = $account->getNonce($AccountGetNonceRequest);             
            $nonce = $retNonce->getResult()->getNonce();
        }
        {
            //2.1构造基础的数据结构 激活帐户
            $contract = $sdk->getContract();
            $contractCreateOperation = new \src\model\request\operation\ContractCreateOperation();
            $initBalance = 10000000;
            $contractCreateOperation->setSourceAddress($sourceAddress);
            $contractCreateOperation->setInitBalance($initBalance);
            $contractCreateOperation->setType(0);
            $payload = "\n          \"use strict\";\n          function init(bar)\n          {\n            /*init whatever you want*/\n            return;\n          }\n          \n          function main(input)\n          {\n            let para = JSON.parse(input);\n            if (para.do_foo)\n            {\n              let x = {\n                \"hello\" : \"world\"\n              };\n            }\n          }\n          \n          function query(input)\n          { \n            return input;\n          }\n        ";

            $contractCreateOperation->setPayload($payload);
            $contractCreateOperation->setInitInput("");
            $contractCreateOperation->setMetaData("create contract");
            $operation = $contract->create($contractCreateOperation);


            $metadata = $opMetaData = bin2hex('metaData');   

            $gasPrice = 1000;
            $feeLimit = 1000764000;
            $metaData = $opMetaData='test';
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
    case 2://   该接口实现资产发行并触发合约，或仅触发合约
    
        $transaction = $sdk->getTransaction();
        $account = $sdk->getAccount();
        $sourcePriKey = "privbsQfZT2b5fDvgc1f6ghGVeZgxeGNrBrFTYN7xwg1UFvmoCbU2qUm";
        $sourceAddress = "buQecWYFHemdH8s9bTYsWuk6bvdswnJJaCT3";
        //1获取nonce
        {
            $AccountGetNonceRequest = new \src\model\request\AccountGetNonceRequest();
            $AccountGetNonceRequest->setAddress($sourceAddress);
            $retNonce = $account->getNonce($AccountGetNonceRequest);             
            $nonce = $retNonce->getResult()->getNonce();
        }
        {
            //2.1构造基础的数据结构  
            $contractCreateOperation = new \src\model\request\operation\ContractInvokeByAssetOperation();
            $initBalance = 10000000;
            $contractCreateOperation->setSourceAddress($sourceAddress);
            $contractCreateOperation->setContractAddress("buQd7e8E5XMa7Yg6FJe4BeLWfqpGmurxzZ5F");
            $contractCreateOperation->setCode("TST");
            $contractCreateOperation->setIssuer($sourceAddress);
            $contractCreateOperation->setAssetAmount($initBalance);//激活并实现资产发行，如果=0，仅激活
            $contractCreateOperation->setInput("");
            $contractCreateOperation->setMetadata("invoke");

            $contract = $sdk->getContract();
            $operation = $contract->invokeByAsset($contractCreateOperation);


            $metadata = $opMetaData = bin2hex('metaData');   

            $gasPrice = 1000;
            $feeLimit = 1000764000;
            $metaData = $opMetaData='test';
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
        var_dump($ret);exit;
    
        break;
 
    case 3: //该接口实现BU资产的发送和触发合约，或仅触发合约
        $transaction = $sdk->getTransaction();
        $account = $sdk->getAccount();
        $sourcePriKey = "privbsQfZT2b5fDvgc1f6ghGVeZgxeGNrBrFTYN7xwg1UFvmoCbU2qUm";
        $sourceAddress = "buQecWYFHemdH8s9bTYsWuk6bvdswnJJaCT3";
        //1获取nonce
        {
            $AccountGetNonceRequest = new \src\model\request\AccountGetNonceRequest();
            $AccountGetNonceRequest->setAddress($sourceAddress);
            $retNonce = $account->getNonce($AccountGetNonceRequest);             
            $nonce = $retNonce->getResult()->getNonce();
        }
        {
            //2.1构造基础的数据结构  
            $contractCreateOperation = new \src\model\request\operation\ContractInvokeByBUOperation();
            $initBalance = 10000000;
            $contractCreateOperation->setSourceAddress($sourceAddress);
            $contractCreateOperation->setContractAddress("buQd7e8E5XMa7Yg6FJe4BeLWfqpGmurxzZ5F");
            $contractCreateOperation->setBuAmount($initBalance);//激活并实现资产发行，如果=0，仅激活
            $contractCreateOperation->setInput("");

            $contract = $sdk->getContract();
            $operation = $contract->invokeByBU($contractCreateOperation);


            $metadata = $opMetaData = bin2hex('metaData');   

            $gasPrice = 1000;
            $feeLimit = 1000764000;
            $metaData = $opMetaData='test';
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
        var_dump($ret);exit;
    
        break;

   case 4: //该方法用于查询合约代码
        $contract = $sdk->getContract();
        $ContractGetInfoRequest = new \src\model\request\ContractGetInfoRequest();
        $ContractGetInfoRequest->setContractAddress("buQfnVYgXuMo3rvCEpKA6SfRrDpaz8D8A9Ea");
        $ret = $contract->getInfo($ContractGetInfoRequest);
        var_dump($ret);exit;
        # code...
        break;  
   case 5: //该方法用于查询合约代码
        $contract = $sdk->getContract();
        $ContractGetAddressRequest = new \src\model\request\ContractGetAddressRequest();
        $ContractGetAddressRequest->setHash("e05fe8103ed876d855fb83c14338dc57b0205269270bf019d2a181d88e28d431");
        $ret = $contract->getAddress($ContractGetAddressRequest);
        var_dump($ret->getResult()->getContractAddressInfos());exit;
        # code...
        break;  
   case 6: 
        $contract = $sdk->getContract();
        $ContractCheckValidRequest = new \src\model\request\ContractCheckValidRequest();
        $ContractCheckValidRequest->setContractAddress("buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds");
        $ret = $contract->checkValid($ContractCheckValidRequest);
        // var_dump($ret);
        var_dump($ret);exit;
        # code...
        break;  



    default:
        # code...
        break;
}
var_dump($ret);exit;

?>