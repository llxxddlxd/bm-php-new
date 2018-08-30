<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\common;

class General{
    static public $url; //static，赋值后全局可用

    static public function accountGetInfoUrl($address) {
        return self::$url . "/getAccountBase?address=" . urlencode($address);
    }

    static public function accountGetAssetsUrl($address) {
        return self::$url . "/getAccount?address=" . $address;
    }

    static public function accountGetMetadataUrl($address,$key) {
        if(!$key)
            return self::$url . "/getAccount?address=" . urlencode($address) ;
        else
            return self::$url . "/getAccount?address=" . urlencode($address) . "&key=" . urlencode($key);
    }

    static public function assetGetUrl($address,$code,$issuer) {
        return self::$url . "/getAccount?address=" . urlencode($address) . "&code=" .   urlencode($code) . "&issuer=" . urlencode($issuer);
    }

    static public function contractCallUrl() {
        return self::$url . "/callContract";
    }


    static public function transactionEvaluationFee() {
        return self::$url . "/testTransaction";
    }

    static public function transactionSubmitUrl() {
        return self::$url . "/submitTransaction";
    }

    static public function transactionGetInfoUrl($hash) {
        return self::$url . "/getTransactionHistory?hash=" . urlencode($hash);
    }


    static public function blockGetNumberUrl() {
        return self::$url . "/getLedger";
    }

    static public function blockCheckStatusUrl() {
        return self::$url . "/getModulesStatus";
    }

    static public function blockGetTransactionsUrl($blockNumber) {
        return self::$url . "/getTransactionHistory?ledger_seq=" . $blockNumber;
    }

    static public function blockGetInfoUrl($blockNumber) {
        return self::$url . "/getLedger?seq=" . $blockNumber;
    }

    static public function blockGetLatestInfoUrl() {
        return self::$url . "/getLedger";
    }

    static public function blockGetValidatorsUrl($blockNumber) {
        return self::$url . "/getLedger?seq=" . $blockNumber . "&with_validator=true";
    }

    static public function blockGetLatestValidatorsUrl() {
        return self::$url . "/getLedger?with_validator=true";
    }

    static public function blockGetRewardUrl($blockNumber) {
        return self::$url . "/getLedger?seq=" . $blockNumber . "&with_block_reward=true";
    }

    static public function blockGetLatestRewardUrl() {
        return self::$url . "/getLedger?with_block_reward=true";
    }

    static public function blockGetFeesUrl($blockNumber) {
        return self::$url . "/getLedger?seq=" . $blockNumber . "&with_fee=true";
    }

    static public function blockGetLatestFeeUrl() {
        return self::$url . "/getLedger?with_fee=true";
    }
}