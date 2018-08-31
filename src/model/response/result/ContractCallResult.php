<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class ContractCallResult{
    private $logs;//JSONObject logs
    private $queryRets;//JSONArray query_rets
    private $stat;//ContractStat stat
    private $txs=array();//TransactionEnvs[] txs
    

    /**
     * @return mixed
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * @param mixed $logs
     *
     * @return self
     */
    public function setLogs($logs)
    {
        if($logs)
            $this->logs = $logs;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQueryRets()
    {
        return $this->queryRets;
    }

    /**
     * @param mixed $queryRets
     *
     * @return self
     */
    public function setQueryRets($queryRets)
    {
        if($queryRets)
            $this->queryRets = $queryRets;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStat()
    {
        return $this->stat;
    }

    /**
     * @param mixed $stat
     *
     * @return self
     */
    public function setStat($stat)
    {
        $temp = new \src\model\response\result\data\ContractStat();
        $temp->setApplyTime($stat->apply_time);
        $temp->setMemoryUsage($stat->memory_usage);
        $temp->setStackUsage($stat->stack_usage);
        $temp->setStep($stat->stack_usage);
        $this->stat = $temp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxs()
    {
        return $this->txs;
    }

    /**
     * @param mixed $txs
     *
     * @return self
     */
    public function setTxs($txs)
    {
        if($txs){
            foreach ($txs as $key => $value) {
                $temp = new \src\model\response\result\data\TransactionEnvs();
                $temp->setTransactionEnv($value->transaction_env);
                array_push($this->txs, $temp);
                # code...
            }
        }
         
        return $this;
    }


}