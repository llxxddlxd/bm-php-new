<?php
namespace src\model\response\result;
/**
 * 
 */
class AssetGetInfoResult{
    private  $assets=array();// AssetInfo[]  assets

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
        if($assets){
         
            foreach ($assets as $key => $value) {
                // var_dump($value);exit;
                $privOb = new \src\model\response\result\data\AssetInfo();
                $privOb->setKey(isset($value->key)?$value->key:"");
                $privOb->setAmount(isset($value->amount)?$value->amount:0);
                $this->assets[$key] = $privOb;

            }
   
        }
        return $this;
    }
}
?>