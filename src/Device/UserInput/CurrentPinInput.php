<?php

declare(strict_types=1);

namespace BitWasp\Trezor\Device\UserInput;

class CurrentPinInput implements CurrentPinInputInterface
{
    /**
     * @var UserInputRequest
     */
    private $inputRequest;

    public function __construct(UserInputRequest $inputRequest)
    {
        $this->inputRequest = $inputRequest;
    }

    public function getPin(): string
    {
        return trim($this->inputRequest->getInput("It's your safe and trusted pin entry!\nEnter your pin to proceed: "));
    }
}
