<?php
// http://127.0.0.1/bumo-sdk-PHP/examples/generateKey.php?type=
include_once dirname(dirname(__FILE__)). "/src/autoload.php";
require(dirname(dirname(__FILE__)).'/src/account/account.php');
use src\account\account;
$account = new account();
$type = isset($_GET['type'])?$_GET['type']:1;
switch ($type) {
    case 1:
        $ret = $account->create();
        break;
    case 2:
        $ret = $account->activate();
        break;
    
    default:
        # code...
        break;
}
var_dump($ret);

?>