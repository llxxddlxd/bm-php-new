<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class ContractStat{   
  
    private $applyTime; //Integer  apply_time

    private $memoryUsage; //String  memory_usage
    private $stackUsage; //String  stack_usage
    private $step; //String  stack_usage

   


    /**
     * @return mixed
     */
    public function getApplyTime()
    {
        return $this->applyTime;
    }

    /**
     * @param mixed $applyTime
     *
     * @return self
     */
    public function setApplyTime($applyTime)
    {
        $this->applyTime = $applyTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMemoryUsage()
    {
        return $this->memoryUsage;
    }

    /**
     * @param mixed $memoryUsage
     *
     * @return self
     */
    public function setMemoryUsage($memoryUsage)
    {
        $this->memoryUsage = $memoryUsage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStackUsage()
    {
        return $this->stackUsage;
    }

    /**
     * @param mixed $stackUsage
     *
     * @return self
     */
    public function setStackUsage($stackUsage)
    {
        $this->stackUsage = $stackUsage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param mixed $step
     *
     * @return self
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }
}
?>