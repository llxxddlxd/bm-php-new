<?php
namespace src\exception;

/**
*  
*/
class SdkError 
{

    private $code;
    private $description;
    public $errorDescArray=
        array(
       "SUCCESS"=>["errorCode"=> 0, "errorDesc" => ""],
       "ACCOUNT_CREATE_ERROR"=>["errorCode" => 11001, "errorDesc" => "Create account failed."],
       "INVALID_SOURCEADDRESS_ERROR"=>["errorCode" => 11002, "errorDesc" => "Invalid sourceAddress."],
       "INVALID_DESTADDRESS_ERROR"=>["errorCode" => 11003, "errorDesc" => "Invalid destAddress."],
       "INVALID_INITBALANCE_ERROR"=>["errorCode" => 11004, "errorDesc" => "InitBalance must be between 1 and max(int64)."],
       "SOURCEADDRESS_EQUAL_DESTADDRESS_ERROR"=>["errorCode" => 11005, "errorDesc" => "SourceAddress cannot be equal to destAddress."],
       "INVALID_ADDRESS_ERROR"=>["errorCode" => 11006, "errorDesc" => "Invalid address."],
       "CONNECTNETWORK_ERROR"=>["errorCode" => 11007, "errorDesc" => "Fail to connect network."],
       "INVALID_ISSUE_AMMOUNT_ERROR"=>["errorCode" => 11008, "errorDesc" => "AssetAmount this will be issued must between 1 and max(int64)."],
       "NO_ASSET_ERROR"=>["errorCode" => 11009, "errorDesc" => "The account does not have this asset."],
       "NO_METADATA_ERROR"=>["errorCode" => 11010, "errorDesc" => "The account does not have this metadata."],
       "INVALID_DATAKEY_ERROR"=>["errorCode" => 11011, "errorDesc" => "The length of key must be between 1 and 1024."],
       "INVALID_DATAVALUE_ERROR"=>["errorCode" => 11012, "errorDesc" => "The length of value must be between 0 and 256k."],
       "INVALID_DATAVERSION_ERROR"=>["errorCode" => 11013, "errorDesc" => "The version must be bigger than and equal to 0."],
       "INVALID_MASTERWEIGHT_ERROR"=>["errorCode" => 11015, "errorDesc" => "MasterWeight must be between 0 and max(uint32)."],
       "INVALID_SIGNER_ADDRESS_ERROR"=>["errorCode" => 11016, "errorDesc" => "Invalid signer address."],
       "INVALID_SIGNER_WEIGHT_ERROR"=>["errorCode" => 11017, "errorDesc" => "Signer weight must be between 0 and max(uint32)."],
       "INVALID_TX_THRESHOLD_ERROR"=>["errorCode" => 11018, "errorDesc" => "TxThreshold must be between 0 and max(int64)."],
       "INVALID_TYPETHRESHOLD_TYPE_ERROR"=>["errorCode" => 11019, "errorDesc" => "Type of TypeThreshold is invalid."],
       "INVALID_TYPE_THRESHOLD_ERROR"=>["errorCode" => 11020, "errorDesc" => "TypeThreshold must be between 0 and max(int64)."],
       "INVALID_ASSET_CODE_ERROR"=>["errorCode" => 11023, "errorDesc" => "The length of code must be between 1 and 64."],
       "INVALID_ASSET_AMOUNT_ERROR"=>["errorCode" => 11024, "errorDesc" => "AssetAmount must be between 0 and max(int64)."],
       "INVALID_BU_AMOUNT_ERROR"=>["errorCode" => 11026, "errorDesc" => "BuAmount must be between 0 and max(int64)."],
       "INVALID_ISSUER_ADDRESS_ERROR"=>["errorCode" => 11027, "errorDesc" => "Invalid issuer address."],
       "NO_SUCH_TOKEN_ERROR"=>["errorCode" => 11030, "errorDesc" => "The length of ctp must be between 1 and 64."],
       "INVALID_TOKEN_NAME_ERROR"=>["errorCode" => 11031, "errorDesc" => "The length of token name must be between 1 and 1024."],
       "INVALID_TOKEN_SIMBOL_ERROR"=>["errorCode" => 11032, "errorDesc" => "The length of symbol must be between 1 and 1024."],
       "INVALID_TOKEN_DECIMALS_ERROR"=>["errorCode" => 11033, "errorDesc" => "Decimals must be between 0 and 8."],
       "INVALID_TOKEN_TOTALSUPPLY_ERROR"=>["errorCode" => 11034, "errorDesc" => "TotalSupply must be between 1 and max(int64)."],
       "INVALID_TOKENOWNER_ERROR"=>["errorCode" => 11035, "errorDesc" => "Invalid token owner."],
       "INVALID_TOKEN_SUPPLY_ERROR"=>["errorCode" => 11036, "errorDesc" => "Supply * decimals must be between 1 and max(int64)."],
       "INVALID_CONTRACTADDRESS_ERROR"=>["errorCode" => 11037, "errorDesc" => "Invalid contract address."],
       "CONTRACTADDRESS_NOT_CONTRACTACCOUNT_ERROR"=>["errorCode" => 11038, "errorDesc" => "contractAddress is not a contract account."],
       "INVALID_TOKEN_AMOUNT_ERROR"=>["errorCode" => 11039, "errorDesc" => "Amount must be between 1 and max(int64)."],
       "SOURCEADDRESS_EQUAL_CONTRACTADDRESS_ERROR"=>["errorCode" => 11040, "errorDesc" => "SourceAddress cannot be equal to contractAddress."],
       "INVALID_FROMADDRESS_ERROR"=>["errorCode" => 11041, "errorDesc" => "Invalid fromAddress."],
       "FROMADDRESS_EQUAL_DESTADDRESS_ERROR"=>["errorCode" => 11042, "errorDesc" => "FromAddress cannot be equal to destAddress"],
       "INVALID_SPENDER_ERROR"=>["errorCode" => 11043, "errorDesc" => "Invalid spender."],
       "INVALID_LOG_TOPIC_ERROR"=>["errorCode" => 11045, "errorDesc" => "The length of log topic must be between 1 and 128."],
       "INVALID_LOG_DATA_ERROR"=>["errorCode" => 11046, "errorDesc" => "The length of one of log data must be between 1 and 1024."],
       "INVALID_NONCE_ERROR"=>["errorCode" => 11048, "errorDesc" => "Nonce must be between 1 and max(int64)."],
       "INVALID_GASPRICE_ERROR"=>["errorCode" => 11049, "errorDesc" => "GasPrice must be between 1000 and max(int64)."],
       "INVALID_FEELIMIT_ERROR"=>["errorCode" => 11050, "errorDesc" => "FeeLimit must be between 1 and max(int64)."],
       "OPERATIONS_EMPTY_ERROR"=>["errorCode" => 11051, "errorDesc" => "Operations cannot be empty."],
       "INVALID_CEILLEDGERSEQ_ERROR"=>["errorCode" => 11052, "errorDesc" => "CeilLedgerSeq must be equal or bigger than 0."],
       "OPERATIONS_ONE_ERROR"=>["errorCode" => 11053, "errorDesc" => "One of operations cannot be resolved."],
       "INVALID_SIGNATURENUMBER_ERROR"=>["errorCode" => 11054, "errorDesc" => "SignatureNumber must be between 1 and max(int32)."],
       "INVALID_HASH_ERROR"=>["errorCode" => 11055, "errorDesc" => "Invalid transaction hash."],
       "INVALID_BLOB_ERROR"=>["errorCode" => 11056, "errorDesc" => "Invalid blob."],
       "PRIVATEKEY_NULL_ERROR"=>["errorCode" => 11057, "errorDesc" => "PrivateKeys cannot be empty."],
       "PRIVATEKEY_ONE_ERROR"=>["errorCode" => 11058, "errorDesc" => "One of privateKeys is invalid."],
       "INVALID_BLOCKNUMBER_ERROR"=>["errorCode" => 11060, "errorDesc" => "BlockNumber must be bigger than 0."],
       "URL_EMPTY_ERROR"=>["errorCode" => 11062, "errorDesc" => "Url cannot be empty."],
       "CONTRACTADDRESS_CODE_BOTH_NULL_ERROR"=>["errorCode" => 11063, "errorDesc" => "ContractAddress and code cannot be empty at the same time."],
       "INVALID_OPTTYPE_ERROR"=>["errorCode" => 11064, "errorDesc" => "OptType must be between 0 and 2."],
       "GET_ALLOWANCE_ERROR"=>["errorCode" => 11065, "errorDesc" => "Get allowance failed"],
       "GET_TOKEN_INFO_ERROR"=>["errorCode" => 11066, "errorDesc" => "Fail to get token info"],
       "SIGNATURE_EMPTY_ERROR"=>["errorCode" => 11067, "errorDesc" => "The signatures cannot be empty."],
       "SYSTEM_ERROR"=>["errorCode" => 20000, "errorDesc" => "System error."],
       "GET_ENCPUBLICKEY_ERROR"=>["errorCode" => 14000, "errorDesc" => "The function 'GetEncPublicKey' failed."],
       "SIGN_ERROR"=>["errorCode" => 14001, "errorDesc" => "The function 'Sign' failed."],
       "INVALID_PAYLOAD_ERROR"=>["errorCode" => 14002, "errorDesc" => "The parameter 'payload' is invalid."],
       "THE_QUERY_FAILED"=>["errorCode" => 14003, "errorDesc" => "The query failed."],
       "QUERY_NO_RESULTS"=>["errorCode" => 14005, "errorDesc" => "Query no results"],
       "REQUEST_NULL_ERROR"=>["errorCode" => 14006, "errorDesc" => "REQUEST NULL ERROR"],
        ); 

    
    function __construct() {

    }

    function SdkError($code,$description)
    {
        $this->code = $code;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    
    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * [checkErrorCode description]
     * @param  [type] $baseResponse [description]
     * @return [type]               [description]
     */
    public static function checkErrorCode($baseResponse){
        $errorCode = $baseResponse->getErrorCode();
        try{
            if(!$errCode){
                throw new \Exception("errCode is error", 1);
            }
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }
        $errorDesc = $baseResponse->getErrorDesc();
        try{
            if(is_null($errorDesc)){
                throw new \Exception("errorDesc is error", 1);
                
            }
        }
        catch(\Exception $e){
            echo $e->getMessage();exit;
        }

    }

     
}
?>