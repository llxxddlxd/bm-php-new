<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: overlay.proto

namespace Protocol;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *for key value db storage
 *
 * Generated from protobuf message <code>protocol.EntryList</code>
 */
class EntryList extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated bytes entry = 1;</code>
     */
    private $entry;

    public function __construct() {
        \GPBMetadata\Overlay::initOnce();
        parent::__construct();
    }

    /**
     * Generated from protobuf field <code>repeated bytes entry = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Generated from protobuf field <code>repeated bytes entry = 1;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setEntry($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::BYTES);
        $this->entry = $arr;

        return $this;
    }

}

