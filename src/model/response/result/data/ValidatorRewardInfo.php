<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class ValidatorRewardInfo{
    private $validator;//String validator

    private  $reward; //Long   reward

 

    /**
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param mixed $validator
     *
     * @return self
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReward()
    {
        return $this->reward;
    }

    /**
     * @param mixed $reward
     *
     * @return self
     */
    public function setReward($reward)
    {
        $this->reward = $reward;

        return $this;
    }
}