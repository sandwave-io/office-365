<?php declare(strict_types=1);

use Kpn\Office\OfficeClient;

require "vendor/autoload.php";

$client = new OfficeClient();
$customer = $client->customer->create('test');

echo $customer->getHeader()->getPartnerReference();
