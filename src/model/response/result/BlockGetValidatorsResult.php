<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class BlockGetValidatorsResult{

    private $validators;//ValidatorInfo[] 

    /**
     * @return mixed
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * @param mixed $validators
     *
     * @return self
     */
    public function setValidators($validators)
    {
        if($validators){
         
            foreach ($validators as $key => $value) {
                // var_dump($value);exit;
                $privOb = new \src\model\response\result\data\ValidatorInfo();
                $privOb->setAddress(isset($value->address)?$value->address:"");
                $privOb->setPledgeCoinAmount(isset($value->pledge_coin_amount)?$value->pledge_coin_amount:0);
                $this->validators[$key] = $privOb;

            }   
        }

        return $this;
    }
}