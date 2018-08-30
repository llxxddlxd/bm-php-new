<?php

/**
 * 用于测试asset类、bu类中的所有接口
 * test url:  http://127.0.0.1/bumo-sdk-PHP/examples/tokenTest.php?type={$type}
 */


include_once dirname(dirname(__FILE__)). "/src/autoload.php";

//声明单例模式
$baseUrl = "http://seed1.bumotest.io:26002";
use src\SDK;
$sdk = SDK::getInstance($baseUrl);



$type = isset($_GET['type'])?$_GET['type']:1;
switch ($type) {
    //asset相关
    case 1:  //该接口实现资产的发行
        $transaction = $sdk->getTransaction();
        $sourcePriKey = "privbz4GWB4kRbxHoZVGo5JY3AExg34338AT8s1f9aVXbZw3wC3dNDHB";
        $sourceAddress = "buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds";
      
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
            $initBalance = 10000000; 
            $metadata = bin2hex('metaData');            
 
            $AssetIssueOperation = new \src\model\request\operation\AssetIssueOperation();
            $AssetIssueOperation->setSourceAddress($sourceAddress);
            $AssetIssueOperation->setCode(1234);
            $AssetIssueOperation->setAmount(5678);
            $object = $sdk->getAsset(); 
            $operation = $object->issue($AssetIssueOperation);


            //2.2初始化基础数据+序列化
            $metaData = $opMetaData=('metaData');
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


        var_dump($ret);exit;
        break;
    case 2: //该接口实现资产的转移

        $transaction = $sdk->getTransaction();
        $sourcePriKey = "privbz4GWB4kRbxHoZVGo5JY3AExg34338AT8s1f9aVXbZw3wC3dNDHB";
        $sourceAddress = "buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds";
        $destAddress = "buQjSYyZyv2J5Tk92nKfakECJuayyRZozfCt";
      
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
            $initBalance = 10000000; 
            $metadata = bin2hex('metaData');            
 
            $AssetSendOperation = new \src\model\request\operation\AssetSendOperation();
            $AssetSendOperation->setSourceAddress($sourceAddress);
            $AssetSendOperation->setDestAddress($destAddress);
            $AssetSendOperation->setCode(1234);
            $AssetSendOperation->setIssuer($sourceAddress);
            $AssetSendOperation->setAmount(1111);
            $object = $sdk->getAsset(); 
            $operation = $object->send($AssetSendOperation);


            //2.2初始化基础数据+序列化
            $metaData = $opMetaData=('metaData');
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


        var_dump($ret);exit;
        break;

    case 3: // 获取账户指定资产信息
        $object = $sdk->getAsset(); 
        $AssetGetInfoRequest = new \src\model\request\AssetGetInfoRequest();
        $AssetGetInfoRequest->setAddress("buQswSaKDACkrFsnP1wcVsLAUzXQsemauEjf");
        $AssetGetInfoRequest->setCode(123);
        $AssetGetInfoRequest->setIssuer("buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds");
        $ret = $object->getInfo($AssetGetInfoRequest);
        var_dump($ret->getResult());exit;
        # code...
        break;

    //bu相关
    case 20: //   该接口实现BU资产的发送
        $transaction = $sdk->getTransaction();
        $account = $sdk->getAccount();
        $bu = $sdk->getBu();
        $sourcePriKey = "privbz4GWB4kRbxHoZVGo5JY3AExg34338AT8s1f9aVXbZw3wC3dNDHB";
        $sourceAddress = "buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds";

        //1获取nonce
        {
            $AccountGetNonceRequest = new \src\model\request\AccountGetNonceRequest();
            $AccountGetNonceRequest->setAddress($sourceAddress);
            $retNonce = $account->getNonce($AccountGetNonceRequest);             
            $nonce = $retNonce->getResult()->getNonce();
        }

        {

            //2transactionblob
            //2.1构造基础的数据结构 发币
            $destAddress = "buQjSYyZyv2J5Tk92nKfakECJuayyRZozfCt";
            $initBalance = 20000000;

            $BUSendOperation = new \src\model\request\operation\BUSendOperation();
            $BUSendOperation->setDestAddress($destAddress);
            $BUSendOperation->setSourceAddress($sourceAddress);
            $BUSendOperation->setAmount($initBalance);

            $operation = $bu->send($BUSendOperation);
            //2.2初始化基础数据+序列化
            $metaData = $opMetaData=bin2hex('metaData');
            $gasPrice = 1000;
            $feeLimit = 10000000;
            // echo 2;exit;
            $transactionblob = $transaction->buildBlob($nonce,$sourceAddress,$metaData,$gasPrice,$feeLimit,$opMetaData,$operation);
            if($transactionblob['status'] != 0){
                echo $transactionblob['status'];
                exit;
            }
        }

        //3sign
        $signData = $transaction->sign($transactionblob['hash'],$sourcePriKey);
        if($signData['status'] != 0){
                echo $retNonce['status'];
                exit;
        }
        //4发送
        $retArr = $transaction->submit($signData['sourcePublicKey'],$transactionblob['transactionBlob'],$signData['signDataHex']);

        //5解析结果
        $ret = $retArr;
        break;


    //ctp10Token 相关
    //ctp10Token指合约token，遵循CTP1.0协议，接口。该类包括所有与合约token相关的操作
    case 40: //   该接口用于发行合约token
        // $transaction = $sdk->getTransaction();
        // $account = $sdk->getAccount();
        // $ctp10Token = $sdk->ctp10Token();
        // $sourcePriKey = "privbz4GWB4kRbxHoZVGo5JY3AExg34338AT8s1f9aVXbZw3wC3dNDHB";
        // $sourceAddress = "buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds";

        // {
        //     //1获取nonce
        //     $AccountGetNonceRequest = new \src\model\request\AccountGetNonceRequest();
        //     $AccountGetNonceRequest->setAddress($sourceAddress);
        //     $retNonce = $account->getNonce($AccountGetNonceRequest);             
        //     $nonce = $retNonce->getResult()->getNonce();
        // }
        // {
        //     //2transactionblob
        //     //2.1构造基础的数据结构 发币
        //     $destAddress = "buQjSYyZyv2J5Tk92nKfakECJuayyRZozfCt";
        //     $initBalance = 20000000;

        //     $BUSendOperation = new \src\model\request\operation\Ctp10TokenIssueOperation();
        //     $BUSendOperation->setDestAddress($destAddress);
        //     $BUSendOperation->setSourceAddress($sourceAddress);
        //     $BUSendOperation->setAmount($initBalance);

        //     $operation = $ctp10Token->issue($BUSendOperation);
        //     //2.2初始化基础数据+序列化
        //     $metaData = $opMetaData=bin2hex('metaData');
        //     $gasPrice = 1000;
        //     $feeLimit = 10000000;
        //     // echo 2;exit;
        //     $transactionblob = $transaction->buildBlob($nonce,$sourceAddress,$metaData,$gasPrice,$feeLimit,$opMetaData,$operation);
        //     if($transactionblob['status'] != 0){
        //         echo $transactionblob['status'];
        //         exit;
        //     }
        // }

        // //3sign
        // $signData = $transaction->sign($transactionblob['hash'],$sourcePriKey);
        // if($signData['status'] != 0){
        //         echo $retNonce['status'];
        //         exit;
        // }
        // //4发送
        // $retArr = $transaction->submit($signData['sourcePublicKey'],$transactionblob['transactionBlob'],$signData['signDataHex']);

        // //5解析结果
        // $ret = $retArr;
        break;


    
    default:
        # code...
        break;
}
var_dump($ret);exit;

?>