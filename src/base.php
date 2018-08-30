<?php
/**
 * User: zjl
 * Date: 2018/08/08 10:00
 */
namespace src;

//probuf需要的
require "crypto/protobuf/vendor/autoload.php";
require "crypto/protobuf/GPBMetadata/Common.php";
require "crypto/protobuf/GPBMetadata/Chain.php";
require "crypto/protobuf/Protocol/Transaction.php";
require "crypto/protobuf/Protocol/Operation.php";
require "crypto/protobuf/Protocol/OperationCreateAccount.php";
require "crypto/protobuf/Protocol/AccountThreshold.php";
require "crypto/protobuf/Protocol/AccountPrivilege.php";
require "crypto/protobuf/Protocol/OperationSetMetadata.php";
require "crypto/protobuf/Protocol/OperationPayCoin.php";
require "crypto/protobuf/Protocol/Contract.php";
require "crypto/protobuf/Protocol/OperationSetPrivilege.php";
require "crypto/protobuf/Protocol/Signer.php";
require "crypto/protobuf/Protocol/OperationTypeThreshold.php";
require "crypto/protobuf/Protocol/OperationIssueAsset.php";
require "crypto/protobuf/Protocol/OperationPayAsset.php";
require "crypto/protobuf/Protocol/Asset.php";
require "crypto/protobuf/Protocol/AssetKey.php";
require "crypto/protobuf/Protocol/OperationLog.php";


use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBType;

class base{

    private $alphabet;
    public $logObject;

    function __construct(){
        //bumo 特殊
        $this->alphabet = '123456789AbCDEFGHJKLMNPQRSTuVWXYZaBcdefghijkmnopqrstUvwxyz';

        //服务器 日志模块        
        $log = new Logger('name');
        $date = date("Ymd");
        $filepath= dirname(__DIR__).'/src/loginfo/'.$date.'.log';
        // echo $filepath;exit;
        $log->pushHandler(new StreamHandler( $filepath, Logger::DEBUG));
        $this->logObject = $log;
    }

    function getAlphabet(){
        return $this->alphabet;
    }
 



    /**
     * [ED25519 description]
     */
    function ED25519($byteStr){
        //进来是32位字节 字符串，返回也是32位字符串
        return ed25519_publickey($byteStr);
        return $byteStr;
    }

    /**
     * [ED25519Sign description]
     */
    function ED25519Sign($message, $mySecret, $myPublic){
        $signature = ed25519_sign($message, $mySecret, $myPublic);
        return $signature;
    } 

    /**
     * [ED25519Check description]
     */
    function ED25519Check($byteStr){
        // $status = ed25519_sign_open($message,  $myPublic, $signature);
        // if($status==TRUE){
        // success
        // }
        // else{
        // fail
        // }
    }

      /**
     * [sha256Hex description]
     * @param [type] $str [description]
     */
    function sha256Hex($str){
        $hashInfo=hash('sha256', $str, true);
        return bin2hex($hashInfo);
    }

    /**
     * [sha256 description]
     * @param [type] $str [description]
     */
    function sha256($str){
        $hashInfo=hash('sha256', $str,true);
        return $hashInfo;
    }
      /**
     * [base58Encode 网上搜的base56加密]
     * @param  [type] $string [description]
     * @return [type]         [description]
     */
    function base58Encode($string)
    {
        $base = strlen($this->alphabet);
        if (is_string($string) === false) {
            return false;
        }
        if (strlen($string) === 0) {
            return '';
        }
        $bytes = array_values(unpack('C*', $string));
        // var_dump($bytes);exit;
        $decimal = $bytes[0];
        for ($i = 1, $l = count($bytes); $i < $l; $i++) {
            $decimal = bcmul($decimal, 256);
            $decimal = bcadd($decimal, $bytes[$i]);
        }

        $output = '';
        while ($decimal >= $base) {
            $div = bcdiv($decimal, $base, 0);
            $mod = bcmod($decimal, $base);
            $output .= $this->alphabet[$mod];
            $decimal = $div;
        }
        
        if ($decimal > 0) {
            $output .= $this->alphabet[$decimal];
        }
        $output = strrev($output);
        foreach ($bytes as $byte) {
            if ($byte === 0) {
                $output = $this->alphabet[0] . $output;
                continue;
            }
            break;
        }
        return (string) $output;
    }

    /**
     * [base58_decode 网上搜的base56解码]
     * @param  [type] $base58 [description]
     * @return [type]         [description]
     */
    function base58Decode($base58)
    {
        if (is_string($base58) === false) {
            return false;
        }
        if (strlen($base58) === 0) {
            return '';
        }
        $indexes = array_flip(str_split($this->alphabet));
        $chars = str_split($base58);
        foreach ($chars as $char) {
            if (isset($indexes[$char]) === false) {
                return false;
            }
        }
        $decimal = $indexes[$chars[0]];
        for ($i = 1, $l = count($chars); $i < $l; $i++) {
            $decimal = bcmul($decimal, 58);
            $decimal = bcadd($decimal, $indexes[$chars[$i]]);
        }
        $output = '';
        while ($decimal > 0) {
            $byte = bcmod($decimal, 256);
            $output = pack('C', $byte) . $output;
            $decimal = bcdiv($decimal, 256, 0);
        }
        foreach ($chars as $char) {
            if ($indexes[$char] === 0) {
                $output = "\x00" . $output;
                continue;
            }
            break;
        }
        return $output;
    }


    /**
     * [hexEncode description]
     * @param  [type] $string [description]
     * @return [type]         [description]
     */
    function hexEncode($string){
        $s = ''; 
        for ($i=0; $i<strlen($string); $i++) { 
            $temp = base_convert(ord($string[$i]), 10, 16); 
            if(strlen($temp)<2){
                $temp = "0".$temp;
            }
            $s .= $temp;
        } 
        return $s; 
    }


      /**
     * 模拟post进行url请求
     * @param string $url
     * @param string $param
     */
    function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        $param = json_encode($param);
  
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json")); 
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl

        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE); 
        curl_close($ch);
        $this->logObject->addWarning("request_post,code:".$httpCode);
        return $data;
    }

    /**
     * [request_get description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    function request_get($url){
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
        $tmpInfo = curl_exec($curl);     //返回api的json对象
        //关闭URL请求
        curl_close($curl);
        return $tmpInfo;    //返回json对象
    }


   
    
    

     /**
     * [hexDecode description]
     * @param  [type] $string [description]
     * @return [type]         [description]
     */
    function hexDecode($string){
        $s = ''; 
        for ($i=0; $i<strlen($string); $i=$i+2) {
            $temp = substr($string, $i,2);
            $temp1 = chr(hexdec($temp));
            $s .= $temp1;
        } 

        return $s; 
    }



    /** 
    * 转换一个String字符串为byte数组 
    * @param $str 需要转换的字符串 
    * @param $bytes 目标byte数组 
    * @author Zikie 
    */
    static function getBytes($string) { 
        $bytes = array(); 
        for($i = 0; $i < strlen($string); $i++){ 
             $bytes[] = ord($string[$i]); 
        } 
        return $bytes; 
    } 
      
        
    /** 
    * 将字节数组转化为String类型的数据 
    * @param $bytes 字节数组 
    * @param $str 目标字符串 
    * @return 一个String类型的数据 
    */
    static function toStr($bytes) { 
        $str = ''; 
        foreach($bytes as $ch) { 
            $str .= chr($ch); 
        } 

        return $str; 
    } 
      
        
    /** 
    * 转换一个int为byte数组 
    * @param $byt 目标byte数组 
    * @param $val 需要转换的字符串 
    * 
    */
    static function integerToBytes($val) { 
        $byt = array(); 
        $byt[0] = ($val & 0xff); 
        $byt[1] = ($val >> 8 & 0xff); 
        $byt[2] = ($val >> 16 & 0xff); 
        $byt[3] = ($val >> 24 & 0xff); 
        return $byt; 
    } 
      
        
    /** 
    * 从字节数组中指定的位置读取一个Integer类型的数据 
    * @param $bytes 字节数组 
    * @param $position 指定的开始位置 
    * @return 一个Integer类型的数据 
    */
    static function bytesToInteger($bytes, $position) { 
        $val = 0; 
        $val = $bytes[$position + 3] & 0xff; 
        $val <<= 8; 
        $val |= $bytes[$position + 2] & 0xff; 
        $val <<= 8; 
        $val |= $bytes[$position + 1] & 0xff; 
        $val <<= 8; 
        $val |= $bytes[$position] & 0xff; 
        return $val; 
    } 
      
        
    /** 
    * 转换一个short字符串为byte数组 
    * @param $byt 目标byte数组 
    * @param $val 需要转换的字符串 
    * 
    */
    static function shortToBytes($val) { 
        $byt = array(); 
        $byt[0] = ($val & 0xff); 
        $byt[1] = ($val >> 8 & 0xff); 
        return $byt; 
    } 
      
        
    /** 
    * 从字节数组中指定的位置读取一个Short类型的数据。 
    * @param $bytes 字节数组 
    * @param $position 指定的开始位置 
    * @return 一个Short类型的数据 
    */
    static function bytesToShort($bytes, $position) { 
        $val = 0; 
        $val = $bytes[$position + 1] & 0xFF; 
        $val = $val << 8; 
        $val |= $bytes[$position] & 0xFF; 
        return $val; 
    } 


      
}

?>