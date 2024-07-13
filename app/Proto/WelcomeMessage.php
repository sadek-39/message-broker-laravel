<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: welcome.proto

namespace App\Proto;

use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>WelcomeMessage</code>
 */
class WelcomeMessage extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string type = 1;</code>
     */
    protected $type = '';
    /**
     * Generated from protobuf field <code>string payload = 2;</code>
     */
    protected $payload = '';
    /**
     * Generated from protobuf field <code>string uuid = 3;</code>
     */
    protected $uuid = '';
    /**
     * Generated from protobuf field <code>string queue = 4;</code>
     */
    protected $queue = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $type
     *     @type string $payload
     *     @type string $uuid
     *     @type string $queue
     * }
     */
    public function __construct($data = NULL) {
        GPBMetadata\Welcome::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string type = 1;</code>
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Generated from protobuf field <code>string type = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkString($var, True);
        $this->type = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string payload = 2;</code>
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Generated from protobuf field <code>string payload = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setPayload($var)
    {
        GPBUtil::checkString($var, True);
        $this->payload = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string uuid = 3;</code>
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Generated from protobuf field <code>string uuid = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setUuid($var)
    {
        GPBUtil::checkString($var, True);
        $this->uuid = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string queue = 4;</code>
     * @return string
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * Generated from protobuf field <code>string queue = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setQueue($var)
    {
        GPBUtil::checkString($var, True);
        $this->queue = $var;

        return $this;
    }

}

