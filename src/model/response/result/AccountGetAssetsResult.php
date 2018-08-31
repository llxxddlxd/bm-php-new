<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class AccountGetAssetsResult {
    private $assets=array(); //AssetInfo[]   assets
   

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
                $temp = new \src\model\response\result\data\AssetInfo();
                $temp->setAmount(isset($value->amount)?$value->amount:"");
                $temp->setKey(isset($value->key)?$value->key:0);
                array_push($this->assets ,$temp);
            }   
        }
        
        return $this;
    }
}
?>