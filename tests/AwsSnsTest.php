<?php

namespace AwsSns;

use Aws\Sns\SnsClient;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

class AwsSnsTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @covers \AwsSns\AwsSns::__construct
     */
    public function testAwsSnsCanBeInstantiated()
    {
        $config = ['version' => 'latest'];

        $snsClient = Mockery::spy('overload:'.SnsClient::class);

        $awsSns = new AwsSns($config);

        $this->assertInstanceOf(AwsSns::class, $awsSns);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @covers \AwsSns\AwsSns::sendMessage
     */
    public function testSendMessage()
    {
        $config = ['version' => 'latest'];
        $defaultSMSType = 'Transactional';
        $message = 'Test';
        $phone = '551199999999';

        $snsClient = Mockery::mock('overload:'.SnsClient::class)
            ->shouldReceive('SetSMSAttributes')
            ->with([
                'attributes' => [
                    'DefaultSMSType' => $defaultSMSType,
                ],
            ])
            ->once()
            ->andReturnSelf()
            ->shouldReceive('publish')
            ->with([
                'Message' => $message,
                'PhoneNumber' => $phone,
            ])
            ->once()
            ->andReturnSelf()
            ->getMock();

        $awsSns = new AwsSns($config);

        $sendMessage = $awsSns->sendMessage($message, $phone);

        $this->assertEquals(true, $sendMessage);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
