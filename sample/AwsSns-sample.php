<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AwsSns\AwsSns;

$config = [
    'region' => '',
    'version' => 'latest',
    'credentials' =>  [
        'key' => '',
        'secret' => '',
    ],
];

$AwsSns = new AwsSns(
    $config
);

//Send Message
$sendMessage = $AwsSns->sendMessage('message', 'phone');
print("Send Message: ".$sendMessage);
echo PHP_EOL;
