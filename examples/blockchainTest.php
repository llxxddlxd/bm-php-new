<?php
/**
 * desc:用于测试block、transaction中的所有接口
 * test url:  http://127.0.0.1/bumo-sdk-PHP/examples/blockchainTest.php?type={$type}
 */


include_once dirname(dirname(__FILE__)). "/src/autoload.php";
//声明单例模式
$baseUrl = "http://seed1.bumotest.io:26002";
use src\SDK;
$sdk = SDK::getInstance($baseUrl);

//获取测试类型
$type = isset($_GET['type'])?$_GET['type']:1;
switch ($type) {
    //block
    case 1://查询最新的区块高度
        $object = $sdk->getBlock();
        $ret = $object->getNumber();
        var_dump($ret->getresult());
        exit;
        break;
    case 2: //检查本地节点区块是否同步完成
        $object = $sdk->getBlock();
        $ret = $object->checkStatus();
        var_dump($ret);exit;
        # code...
        break;  
    case 3: //   查询指定区块高度下的所有交易
        $object = $sdk->getBlock();
        $BlockGetTransactionRequest = new \src\model\request\BlockGetTransactionRequest();
        $BlockGetTransactionRequest->setBlockNumber(1046036);
        $ret = $object->getTransactions($BlockGetTransactionRequest);
        var_dump($ret->getresult());exit;
        # code...
        break;  
    case 4: //   获取区块信息
        $object = $sdk->getBlock();
        $BlockGetInfoRequest = new \src\model\request\BlockGetInfoRequest();
        $BlockGetInfoRequest->setBlockNumber(1001849);
        $ret = $object->getInfo($BlockGetInfoRequest);
        var_dump($ret->getresult());exit;
        # code...
        break;   
    case 5: //获取最新区块信息
        $object = $sdk->getBlock();
        $ret = $object->getLatestInfo();
        var_dump($ret->getresult());exit;
        # code...
        break;  
    case 6: //      获取指定区块中所有验证节点数
        $object = $sdk->getBlock();
        $BlockGetValidatorsRequest = new \src\model\request\BlockGetValidatorsRequest();
        $BlockGetValidatorsRequest->setBlockNumber(1001849);
        $ret = $object->getValidators($BlockGetValidatorsRequest);
        var_dump($ret->getresult());exit;
        # code...
        break;  

    case 7: //      获取最新区块中所有验证节点数
        $object = $sdk->getBlock();
        $ret = $object->getLatestValidators();
        var_dump($ret->getresult());exit;
        # code...
        break;

    case 8:   //获取指定区块中的区块奖励和验证节点奖励
        $object = $sdk->getBlock();
        $BlockGetRewardRequest = new \src\model\request\BlockGetRewardRequest();
        $BlockGetRewardRequest->setBlockNumber(1001849);
        $ret = $object->getReward($BlockGetRewardRequest);
        var_dump($ret->getresult());exit;
        # code...
        break;  
    case 9: //      获取最新区块中的区块奖励和验证节点奖励
        $object = $sdk->getBlock();
        $ret = $object->getLatestReward();
        var_dump($ret->getresult());exit;
        # code...
        break;    
    case 10: //      获取指定区块中的账户最低资产限制和打包费用
        $object = $sdk->getBlock();
        $BlockGetFeesRequest = new \src\model\request\BlockGetFeesRequest();
        $BlockGetFeesRequest->setBlockNumber(1046036);
        $ret = $object->getFees($BlockGetFeesRequest);
        var_dump($ret->getresult());exit;
        # code...
        break;   
    case 11://       获取最新区块中的账户最低资产限制和打包费用
        $object = $sdk->getBlock();
        $ret = $object->getLatestFees();
        var_dump($ret->getresult());exit;
        # code...
        break;  


    //tranasction
    case 23:  //  该接口实现交易的费用评估
        $sourcePriKey = "privbsQfZT2b5fDvgc1f6ghGVeZgxeGNrBrFTYN7xwg1UFvmoCbU2qUm";
        $sourceAddress = "buQecWYFHemdH8s9bTYsWuk6bvdswnJJaCT3";
        $destAddress = "buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds";
        $account = $sdk->getAccount();
        //1获取nonce
        {
            $AccountGetNonceRequest = new \src\model\request\AccountGetNonceRequest();
            $AccountGetNonceRequest->setAddress($sourceAddress);
            $retNonce = $account->getNonce($AccountGetNonceRequest);             
            $nonce = $retNonce->getResult()->getNonce();
        }


        $object = $sdk->getTransaction();
        $BlockGetFeesRequest = new \src\model\request\TransactionEvaluateFeeRequest();
        $BlockGetFeesRequest->setSourceAddress($sourceAddress);
        $BlockGetFeesRequest->setNonce($nonce);

        {

            $createAccount = new \Protocol\OperationPayCoin();
            $createAccount->setDestAddress($destAddress);
            $createAccount->setAmount(1000000); 

            $oper = new \Protocol\Operation();
            // $oper->setSourceAddress($sourceAddress);
            $oper->setType(7);/*                      UNKNOWN = 0;             CREATE_ACCOUNT = 1;           ISSUE_ASSET = 2;           PAY_ASSE = 3;           SET_METADATA = 4;           SET_SIGNER_WEIGHT = 5;           SET_THRESHOLD = 6;           PAY_COIN = 7;           LOG = 8;           SET_PRIVILEGE = 9;  */
            $oper->setPayCoin($createAccount);
            $opers[0] = $oper;
   
        }
        $BlockGetFeesRequest->setOperations($opers);

        // $BlockGetFeesRequest->setCeilLedgerSeq(1001849);
        // $BlockGetFeesRequest->setMetadata("1001849");
        // $BlockGetFeesRequest->setSignatureNumber(1);
        $ret = $object->evaluateFee($BlockGetFeesRequest);
        var_dump($ret->getresult());exit;
        # code...
        break;  
    case 26: //   该接口实现根据交易hash查询交易
        $object = $sdk->getTransaction();
        $TransactionGetInfoRequest = new \src\model\request\TransactionGetInfoRequest();
        $TransactionGetInfoRequest->setHash("8acea38df0fd4f6c4acaab639d6b090255a2b09a63c7e2a631c04ca8740cdbac");
        $ret = $object->getInfo($TransactionGetInfoRequest);
        print_r($ret->getresult()->getTransactions()[0]->getTransaction()->getOperations()[0]->getCreateAccount());exit;
        # code...
        break;      
    
    default:
        # code...
        $ret = array();
        break;
}
var_dump($ret);exit;

?>

?>