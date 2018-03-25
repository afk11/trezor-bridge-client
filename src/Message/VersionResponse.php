<?php

declare(strict_types=1);

namespace BitWasp\Trezor\Message;

class VersionResponse
{
    /**
     * @var \stdClass
     */
    private $msg;

    public function __construct(\stdClass $version)
    {
        $this->msg = $version;
    }

    public function __get($name)
    {
        return $this->msg->$$name;
    }

    public function version()
    {
        return $this->msg->version;
    }

    public function getObject(): \stdClass
    {
        return $this->msg;
    }
}
