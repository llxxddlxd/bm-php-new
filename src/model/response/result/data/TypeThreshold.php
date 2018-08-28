<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result\data;
class TypeThreshold{
    private $type;  //Integer
    private $threshold; //Long

    public function TypeThreshold($type, $threshold) {
        $this->type = $type;
        $this->threshold = $threshold;
    }


    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getThreshold()
    {
        return $this->threshold;
    }

    /**
     * @param mixed $threshold
     *
     * @return self
     */
    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;

        return $this;
    }
}
?>