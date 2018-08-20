<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: chain.proto

namespace Protocol;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>protocol.OperationPayAsset</code>
 */
class OperationPayAsset extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string dest_address = 1;</code>
     */
    private $dest_address = '';
    /**
     * Generated from protobuf field <code>.protocol.Asset asset = 2;</code>
     */
    private $asset = null;
    /**
     * Generated from protobuf field <code>string input = 3;</code>
     */
    private $input = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $dest_address
     *     @type \Protocol\Asset $asset
     *     @type string $input
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Chain::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string dest_address = 1;</code>
     * @return string
     */
    public function getDestAddress()
    {
        return $this->dest_address;
    }

    /**
     * Generated from protobuf field <code>string dest_address = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setDestAddress($var)
    {
        GPBUtil::checkString($var, True);
        $this->dest_address = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.protocol.Asset asset = 2;</code>
     * @return \Protocol\Asset
     */
    public function getAsset()
    {
        return $this->asset;
    }

    /**
     * Generated from protobuf field <code>.protocol.Asset asset = 2;</code>
     * @param \Protocol\Asset $var
     * @return $this
     */
    public function setAsset($var)
    {
        GPBUtil::checkMessage($var, \Protocol\Asset::class);
        $this->asset = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string input = 3;</code>
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Generated from protobuf field <code>string input = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setInput($var)
    {
        GPBUtil::checkString($var, True);
        $this->input = $var;

        return $this;
    }

}

