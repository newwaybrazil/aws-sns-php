<?php

namespace AwsSns;

use Aws\Sns\SnsClient;

class AwsSns
{
    private $snSclient;

    public function __construct(
        array $config
    ) {
        $config['version'] = $config['version'] ?? 'latest';
        $this->snSclient = new SnsClient($config);
    }

    public function sendMessage(
        string $message,
        string $phone,
        string $defaultSMSType = 'Transactional'
    ): bool {
        $this->snSclient->SetSMSAttributes([
            'attributes' => [
                'DefaultSMSType' => $defaultSMSType,
            ],
        ]);

        $publish = [
            'Message' => $message,
            'PhoneNumber' => $phone,
        ];

        $this->snSclient->publish($publish);

        return true;
    }
}
