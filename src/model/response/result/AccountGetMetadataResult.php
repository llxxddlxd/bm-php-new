<?php
/**
 * @author zjl <[<email address>]>
 */
namespace src\model\response\result;
class AccountGetMetadataResult {
    private $metadatas;//MetadataInfo[] metadatas

    /**
     * @return mixed
     */
    public function getMetadatas()
    {
        return $this->metadatas;
    }

    /**
     * @param mixed $metadatas
     *
     * @return self
     */
    public function setMetadatas($metadatas)
    {
        foreach ($metadatas as $key => $value) {
            $temp =   new \src\model\response\result\data\MetadataInfo();
            $temp->setKey($value->key);
            $temp->setValue($value->value);
            $temp->setVersion($value->version);
            array_push($this->metadatas,$temp);
        }

        return $this;
    }
}
?>