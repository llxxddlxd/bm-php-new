<?php
//单例模式
//引用所有的类
namespace src;

use src\account\account;
use src\blockchain\transaction;
use src\blockchain\block;
use src\token\bu;
use src\token\asset;
use src\common\General;
use src\contract\contract;
use src\log\log;

class SDK{
    //创建静态私有的变量保存该类对象
    static private $instance;
    //防止直接创建对象
    private function __construct($baseUrl){
        General::$url = $baseUrl;
        // echo General::$url;exit;
    }
    //防止克隆对象
    private function __clone(){

    }
    //唯一的成员函数，实例化自己
    static public function getInstance($baseUrl){
        if(!self::$instance instanceof self){
            self::$instance = new self($baseUrl);
        }
        return self::$instance;
    }

    public function getBaseUrl(){
        return General::$url;
    }

    public function getAccount(){
        return new account();
    }  

    public function getTransaction(){
        return new transaction();
    }
    public function getBu(){
        return new bu();
    }
    public function getBlock(){
        return new block();
    }
    public function getAsset(){
        return new asset();
    }
    public function getContract(){
        return new contract();
    }
    public function getLog(){
        return new log();
    }

}

// $s = SDK::getInstance("http://seed1.bumotest.io:26002/");
// echo $s->getBaseUrl();

?>