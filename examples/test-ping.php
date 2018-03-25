<?php

declare(strict_types=1);

use BitWasp\Trezor\Device\Command\InitializeService;
use BitWasp\Trezor\Device\Command\PingService;
use BitWasp\Trezor\Device\PinInput\CurrentPassphraseInput;
use BitWasp\Trezor\Device\RequestFactory;
use BitWasp\Trezor\Device\Util;

require __DIR__ . "/../vendor/autoload.php";

$useNetwork = "BTC";
$trezor = \BitWasp\Trezor\Bridge\Client::fromUri("http://localhost:21325");

$hardened = pow(2, 31)-1;
echo "list devices\n";
$devices = $trezor->listDevices();
if (empty($devices)) {
    throw new \Exception("Error! No devices connected!");
}

echo "first device\n";
$firstDevice = $devices->devices()[0];

print_r($firstDevice);

echo "acquire device!\n";
$session = $trezor->acquire($firstDevice);
$reqFactory = new RequestFactory();

$initializeCmd = new InitializeService();
$features = $initializeCmd->call($session, $reqFactory->initialize());

if (!($btcNetwork = Util::networkByCoinShortcut($useNetwork, $features))) {
    throw new \RuntimeException("Failed to find requested network ({$useNetwork})");
}

$pingService = new PingService();
$pinInput = new CurrentPassphraseInput();
$passInput = new CurrentPassphraseInput();

$nonce = random_bytes(16);

// the false flags here determine what the user should be challenged with
$ping = $reqFactory->ping($nonce, false, false, false);

$success = $pingService->call($session, $ping, $pinInput, $passInput);
var_dump($success);
$session->release();
