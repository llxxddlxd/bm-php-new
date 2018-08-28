<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class BlockGetLatestRewardResult{

    private $rewardResults=array();//ValidatorRewardInfo   validators_reward 
    private $blockReward;//long block_reward 

   

    /**
     * @return mixed
     */
    public function getRewardResults()
    {
        return $this->rewardResults;
    }

    /**
     * @param mixed $rewardResults
     *
     * @return self
     */
    public function setRewardResults($rewardResults)
    {
        foreach ($rewardResults as $key => $value) {
            
            $privOb = new \src\model\response\result\data\ValidatorRewardInfo();
            $privOb->setValidator($key);
            $privOb->setReward($value);
            array_push($this->rewardResults, $privOb);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBlockReward()
    {
        return $this->blockReward;
    }

    /**
     * @param mixed $blockReward
     *
     * @return self
     */
    public function setBlockReward($blockReward)
    {
        $this->blockReward = $blockReward;

        return $this;
    }
}