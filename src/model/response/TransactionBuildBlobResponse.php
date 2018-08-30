<?php
    /**
     * @author zjl <[<email address>]>
     */
    namespace src\model\response;

    use src\model\response\BaseResponse;
    class TransactionBuildBlobResponse extends BaseResponse{

        private $result; //TransactionBuildBlobResult

        /**
         * @return mixed
         */
        public function getResult()
        {
            return $this->result;
        }

        /**
         * @param mixed $result
         *
         * @return self
         */
        public function setResult($result)
        {
            $resultOb = new \src\model\response\result\TransactionBuildBlobResult();
            $resultOb->setTransactionBlob(isset($result['transaction_blob'])?$result['transaction_blob']:"");
            $resultOb->setHash(isset($result['hash'])?$result['hash']:"");

            $this->result = $resultOb;

            return $this;
        }

        /**
         * [buildResponse description]
         * @param  [type] $errorCode [description]
         * @param  [type] $errorDesc [description]
         * @param  [type] $result    [description]
         * @return [type]            [description]
         */
        public function buildResponse($errorCode,$errorDesc,$result){
            $this->errorCode = $errorCode;
            $this->errorDesc = $errorDesc;
            $this->result = $result;

        }
    }
?>
