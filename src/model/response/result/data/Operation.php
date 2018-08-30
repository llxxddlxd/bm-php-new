<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;//
class Operation{ 
    
    private $type;// //int type

    
    private $sourceAddress;// String//source_address

    
    private $metadata;//String metadata

    
    private $createAccount;//AccountActiviateInfo create_account

    
    private $issueAsset;//AssetIssueInfo issue_asset

    
    private $sendAsset;//AssetSendInfo pay_asset

    
    private $sendBU;//BUSendInfo pay_coin

    
    private $setMetadata;//AccountSetMetadataInfo set_metadata

    
    private $setPrivilege;//AccountSetPrivilegeInfo set_privilege

    
    private $log;//LogInfo log

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSourceAddress()
    {
        return $this->sourceAddress;
    }

    /**
     * @param mixed $sourceAddress
     *
     * @return self
     */
    public function setSourceAddress($sourceAddress)
    {
        $this->sourceAddress = $sourceAddress;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     *
     * @return self
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreateAccount()
    {
        return $this->createAccount;
    }

    /**
     * @param mixed $createAccount
     *
     * @return self
     */
    public function setCreateAccount($createAccount)
    {

        $temp = new \src\model\response\result\data\AccountActiviateInfo();
        $temp->setDestAddress(isset($createAccount->dest_address)?$createAccount->dest_address:"");
        $temp->setContract(isset($createAccount->contract)?$createAccount->contract:"");
        $temp->setPriv(isset($createAccount->priv)?$createAccount->priv:"");
        $temp->setMetadatas(isset($createAccount->metadatas)?$createAccount->metadatas:"");
        $temp->setInitBalance(isset($createAccount->init_balance)?$createAccount->init_balance:0);
        $temp->setInitInput(isset($createAccount->init_input)?$createAccount->init_input:"");
        $this->createAccount = $temp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIssueAsset()
    {
        return $this->issueAsset;
    }

    /**
     * @param mixed $issueAsset
     *
     * @return self
     */
    public function setIssueAsset($issueAsset)
    {
        $temp = new \src\model\response\result\data\AssetIssueInfo();
        $temp->setCode(isset($createAccount->code)?$createAccount->code:"");
        $temp->setAmount(isset($createAccount->amount)?$createAccount->amount:0);

        $this->issueAsset = $temp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSendAsset()
    {
        return $this->sendAsset;
    }

    /**
     * @param mixed $sendAsset
     *
     * @return self
     */
    public function setSendAsset($sendAsset)
    {
        $temp = new \src\model\response\result\data\AssetSendInfo();
        $temp->setDestAddress(isset($sendAsset->dest_address)?$sendAsset->dest_address:"");
        $temp->setAsset(isset($sendAsset->token)?$sendAsset->token:"");
        $temp->setInput(isset($sendAsset->input)?$sendAsset->input:"");
        $this->sendAsset = $sendAsset;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSendBU()
    {
        return $this->sendBU;
    }

    /**
     * @param mixed $sendBU
     *
     * @return self
     */
    public function setSendBU($sendBU)
    {
        
        $temp = new \src\model\response\result\data\BUSendInfo();
        $temp->setDestAddress(isset($createAccount->dest_address)?$createAccount->dest_address:"");
        $temp->setAmount(isset($createAccount->amount)?$createAccount->amount:"");
        $temp->setInput(isset($createAccount->input)?$createAccount->input:"");
        $this->sendBU = $temp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSetMetadata()
    {
        return $this->setMetadata;
    }

    /**
     * @param mixed $setMetadata
     *
     * @return self
     */
    public function setSetMetadata($setMetadata)
    {
        $temp = new \src\model\response\result\data\AccountSetMetadataInfo();
        $temp->setKey(isset($createAccount->key)?$createAccount->key:"");
        $temp->setValue(isset($createAccount->value)?$createAccount->value:"");
        $temp->setVersion(isset($createAccount->version)?$createAccount->version:0);
        $temp->setDeleteFlag(isset($createAccount->delete_flag)?$createAccount->delete_flag:false);

        $this->setMetadata = $temp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSetPrivilege()
    {
        return $this->setPrivilege;
    }

    /**
     * @param mixed $setPrivilege
     *
     * @return self
     */
    public function setSetPrivilege($setPrivilege)
    {
        $temp = new \src\model\response\result\data\AccountSetPrivilegeInfo();
        $temp->setMasterWeight(isset($createAccount->master_weight)?$createAccount->master_weight:"");
        $temp->setSigners(isset($createAccount->signers)?$createAccount->signers:"");
        $temp->setTxThreshold(isset($createAccount->tx_threshold)?$createAccount->tx_threshold:"");
        $temp->setTypeThresholds(isset($createAccount->type_thresholds)?$createAccount->type_thresholds:"");

        $this->setPrivilege = $temp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param mixed $log
     *
     * @return self
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }
}
?>