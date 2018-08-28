<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class AccountGetAssetsResult {
    private $assets; //AssetInfo[]   assets
   

    /**
     * @return mixed
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * @param mixed $assets
     *
     * @return self
     */
    public function setAssets($assets)
    {
        foreach ($assets as $key => $value) {
            $temp = new \src\model\response\result\data\AssetInfo();
            $temp->setAmount($value->amount);
            $temp->setKey($value->key);
        }
        $this->assets = $assets;

        return $this;
    }
}
?>