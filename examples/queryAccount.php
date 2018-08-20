<?php
// http://127.0.0.1/bumo-sdk-PHP/examples/queryAccount.php?type=
include_once dirname(dirname(__FILE__)). "/src/autoload.php";
require(dirname(dirname(__FILE__)).'/src/account/account.php');
use src\account\account;
$account = new account();
$type = isset($_GET['type'])?$_GET['type']:1;
switch ($type) {
    case 1: 
        $ret = $account->checkValid("buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds");
        # code...
        break;
    case 2: 
        $ret = $account->getInfo("buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds");
        # code...
        break;
    case 3: 
        $ret = $account->getNonce("buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds");
        # code...
        break;  
    case 4: 
        $ret = $account->getBalance("buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds");
        # code...
        break;
    case 5: 
        $ret = $account->getAssets("buQnv2Ym4mCUyd4L9cvVAvBYaPF2Levt4Sds");
        # code...
        break;
    
    default:
        # code...
        break;
}
var_dump($ret);

?>