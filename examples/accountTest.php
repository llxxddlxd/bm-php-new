<?php

/**
 * desc:用于测试account中的所有接口
 * test url:  http://127.0.0.1/bumo-sdk-PHP/examples/accountTest.php?type={$type}
 */

include_once dirname(dirname(__FILE__)). "/src/autoload.php";

//声明单例模式
use src\SDK;
$baseUrl = "http://seed1.bumotest.io:26002";
$sdk = SDK::getInstance($baseUrl);

//获取测试类型
$type = isset($_GET['type'])?$_GET['type']:1;

switch ($type) {
    case 1://创建账号
        $account = $sdk->getAccount();
        $ret = $account->create();
        echo $ret->getResult()->getAddress().'<br>';
        echo $ret->getResult()->getPublicKey().'<br>';
        echo $ret->getResult()->getPrivateKey().'<br>';
        exit;
        break;
    case 2://激活账号
        $transaction = $sdk->getTransaction();
        $sourcePriKey = "privbsQfZT2b5fDvgc1f6ghGVeZgxeGNrBrFTYN7xwg1UFvmoCbU2qUm";
        $sourceAddress = "buQecWYFHemdH8s9bTYsWuk6bvdswnJJaCT3";
        //0生成新的账户
        {
            $account = $sdk->getAccount();
            $retAddress = $account->create();   
        }
        //1获取nonce
        {
            $AccountGetNonceRequest = new \src\model\request\AccountGetNonceRequest();
            $AccountGetNonceRequest->setAddress($sourceAddress);
            $retNonce = $account->getNonce($AccountGetNonceRequest);             
            $nonce = $retNonce->getResult()->getNonce();
        }
        //2transactionblob
        {
            //2.1构造基础的数据结构 激活帐户
            $destAddress = $retAddress->getResult()->getAddress();
            $initBalance = 10000000; 
            $metadata = ('metaData');            
            $AccountActivateOperation = new \src\model\request\operation\AccountActivateOperation();
            $AccountActivateOperation->setDestAddress($destAddress);
            $AccountActivateOperation->setInitBalance($initBalance);
            $AccountActivateOperation->setSourceAddress($sourceAddress);
            $account = $sdk->getAccount();
            $operation = $account->activate($AccountActivateOperation);

            //2.2初始化基础数据+序列化
            $metaData = $opMetaData=('metaData');
            $gasPrice = 10000;
            $feeLimit = 10000000; 

            // $transactionblob = $transaction->buildBlob($nonce,$sourceAddress,$metaData,$gasPrice,$feeLimit,$opMetaData,$operation);
            $transactionBuildBlobRequest = new \src\model\request\TransactionBuildBlobRequest();
            $transactionBuildBlobRequest->setSourceAddress($sourceAddress);
            $transactionBuildBlobRequest->setNonce($nonce);
            $transactionBuildBlobRequest->setGasPrice($gasPrice);
            $transactionBuildBlobRequest->setFeeLimit($feeLimit);
            $transactionBuildBlobRequest->setOperations($operation);
            $transactionBuildBlobRequest->setCeilLedgerSeq('');
            $transactionBuildBlobRequest->setMetadata($metaData);
            
            $transactionblobresponse = $transaction->buildBlobObject($transactionBuildBlobRequest);
           
        }
        //3sign
        {
            $hash = $transactionblobresponse->getResult()->getHash();
            $transactionBlob = $transactionblobresponse->getResult()->getTransactionBlob();
            $TransactionSignRequest = new \src\model\request\TransactionSignRequest();
            $TransactionSignRequest->setBlob($hash);
            $tempsourkey[0]  =$sourcePriKey;
            $TransactionSignRequest->setPrivateKeys($tempsourkey);
            $signData = $transaction->signObject($TransactionSignRequest);
            
        }
        //4发送
        {
            $getSignatures = $signData->getResult()->getSignatures();
            // var_dump($getSignatures);
            $TransactionSubmitRequest = new \src\model\request\TransactionSubmitRequest();
            $TransactionSubmitRequest->setSignatures($getSignatures);
            $TransactionSubmitRequest->setTransactionBlob($transactionBlob);
            $retArr = $transaction->submitObject($TransactionSubmitRequest);
            echo "result:";
            print_r($retArr->getResult());
            echo ",errcode:";
            print_r($retArr->getErrorCode());
        }
        exit;
        break;
    
    case 3://设置账户metadata消息
        $transaction = $sdk->getTransaction();
        $account = $sdk->getAccount();
        $sourcePriKey = "privbz4GWB4kRbxHoZVGo5JY3AExg34338AT8s1f9aVXbZw3wC3dNDHB";
        $sourceAddress = "buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds";
        $destAddress = "buQjSYyZyv2J5Tk92nKfakECJuayyRZozfCt";
        
        //1获取nonce
        {
            $AccountGetNonceRequest = new \src\model\request\AccountGetNonceRequest();
            $AccountGetNonceRequest->setAddress($sourceAddress);
            $retNonce = $account->getNonce($AccountGetNonceRequest);             
            $nonce = $retNonce->getResult()->getNonce();
        }
        //2transactionblob
        {
            //2.1构造基础的数据结构 
            $metadata = ('metaData');
            $AccountSetMetadataOperation = new \src\model\request\operation\AccountSetMetadataOperation();
            $AccountSetMetadataOperation->setKey('key123');
            $AccountSetMetadataOperation->setSourceAddress($sourceAddress);
            $AccountSetMetadataOperation->setValue('value456');
            $AccountSetMetadataOperation->setVersion('1');
            $AccountSetMetadataOperation->setMetadata($metadata);
            $AccountSetMetadataOperation->setDeleteFlag(false);
            $account = $sdk->getAccount();
            $operation = $account->setMetadata($AccountSetMetadataOperation);

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
        
        break; 
    
    case 4://设置账户权限，包括设置账户权重，签名者权重，交易门限，指定交易门限
        $transaction = $sdk->getTransaction();
        $account = $sdk->getAccount();
        $sourcePriKey = "privbz4GWB4kRbxHoZVGo5JY3AExg34338AT8s1f9aVXbZw3wC3dNDHB";
        $sourceAddress = "buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds";
        $destAddress = "buQjSYyZyv2J5Tk92nKfakECJuayyRZozfCt";
        
        //1获取nonce
        {
            $AccountGetNonceRequest = new \src\model\request\AccountGetNonceRequest();
            $AccountGetNonceRequest->setAddress($sourceAddress);
            $retNonce = $account->getNonce($AccountGetNonceRequest);             
            $nonce = $retNonce->getResult()->getNonce();
        }
        //2transactionblob
        {
            //2.1构造基础的数据结构 
            $initBalance = 10000000; 
            $metadata = bin2hex('metaData');            
            $AccountSetMetadataOperation = new \src\model\request\operation\AccountSetPrivilegeOperation();
            $AccountSetMetadataOperation->setSourceAddress($sourceAddress);
            $AccountSetMetadataOperation->setMasterWeight(123);
            $AccountSetMetadataOperation->setTxThreshold(456);
            $Signer = new \src\model\response\result\data\Signer();
            $Signer->setAddress($destAddress);
            $Signer->setWeight(1000);       

            $TypeThreshold = new \src\model\response\result\data\TypeThreshold();
            $TypeThreshold->setType(11);
            $TypeThreshold->setThreshold(121);
            $AccountSetMetadataOperation->setSigners(["0"=>$Signer]);
            $AccountSetMetadataOperation->setTypeThresholds(["0"=>$TypeThreshold]);

            $account = $sdk->getAccount();
            $operation = $account->setPrivilege($AccountSetMetadataOperation);

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

    case 5: // 获取账户指定资产数量
        $account = $sdk->getAccount();
        $AccountGetAssetsRequest = new \src\model\request\AccountGetAssetsRequest();
        $AccountGetAssetsRequest->setAddress("buQecWYFHemdH8s9bTYsWuk6bvdswnJJaCT3");
        $ret = $account->getAssets($AccountGetAssetsRequest);
        var_dump($ret->getResult());exit;
        # code...
        break;
    case 6: //检测账户地址的有效性
        $account = $sdk->getAccount();
        $AccountCheckValidRequest = new \src\model\request\AccountCheckValidRequest();
        $AccountCheckValidRequest->setAddress("buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds");
        $ret = $account->checkValid($AccountCheckValidRequest);
        var_dump($ret);exit;
        # code...
        break;
    case 7: //获取账户信息，包括账户地址，账户余额，账户交易序列号，账户资产和账户权重        
        $account = $sdk->getAccount();
        $AccountGetInfoRequest = new \src\model\request\AccountGetInfoRequest();
        $AccountGetInfoRequest->setAddress("buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds");
        $ret = $account->getInfo($AccountGetInfoRequest);
        var_dump($ret);exit;
        # code...
        break;
    case 8: //查询账户交易序列号
        $account = $sdk->getAccount();
        $AccountGetNonceRequest = new \src\model\request\AccountGetNonceRequest();
        $AccountGetNonceRequest->setAddress("buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds");
        $ret = $account->getNonce($AccountGetNonceRequest);
        // var_dump($ret);
        var_dump($ret->getResult()->getNonce());exit;
        # code...
        break;  
    case 9: //获取账户余额
        $account = $sdk->getAccount();
        $AccountGetBalanceRequest = new \src\model\request\AccountGetBalanceRequest();
        $AccountGetBalanceRequest->setAddress("buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds");
        $ret = $account->getBalance($AccountGetBalanceRequest);
        var_dump($ret->getResult()->getBalance());exit;
        # code...
        break;
    case 10: // 获取账户的metadata信息
        $account = $sdk->getAccount();
        $AccountGetMetadataRequest = new \src\model\request\AccountGetMetadataRequest();
        $AccountGetMetadataRequest->setAddress("buQswSaKDACkrFsnP1wcVsLAUzXQsemauEjf");
        $AccountGetMetadataRequest->setKey("A");
        $ret = $account->getMetadata($AccountGetMetadataRequest);
        var_dump($ret->getResult());exit;
        # code...
    
    
    default:
        # code...
        break;
}
var_dump($ret);exit;

?>