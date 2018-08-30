<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;// 
class AssetSendInfo{ 

    private  $destAddress;//String dest_address

    private  $asset;//AssetInfo token

    private  $input;//String input

    /**
     * @return mixed
     */
    public function getDestAddress()
    {
        return $this->destAddress;
    }

    /**
     * @param mixed $destAddress
     *
     * @return self
     */
    public function setDestAddress($destAddress)
    {
        $this->destAddress = $destAddress;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAsset()
    {
        return $this->asset;
    }

    /**
     * @param mixed $asset
     *
     * @return self
     */
    public function setAsset($asset)
    {

        $temp = new \src\model\response\result\data\AssetInfo();
        $temp->setKey(isset($asset->key)?$asset->key:"");
        $temp->setAmount(isset($asset->amount)?$asset->amount:0);
        $this->asset = $asset;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param mixed $input
     *
     * @return self
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }
}
?>