<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class AccountGetBalanceResult {
    private $balance;


    

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param mixed $balance
     *
     * @return self
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }
}
?>