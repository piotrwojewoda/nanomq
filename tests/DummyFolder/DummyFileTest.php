<?php

namespace Tests\DummyFolder;

use M6Web\Component\RedisMock\RedisMockFactory;
use PHPUnit\Framework\TestCase;
use Piotrwojewoda\Nanomq\NanoMqClient;

class DummyFileTest extends TestCase
{
    public function testDummy()
    {
        $nanoMqClient = new NanoMqClient();
        $factory     = new RedisMockFactory();
        $myRedisMock = $factory->getAdapter('Predis\Client');

        $nanoMqClient->sendMessage($myRedisMock, 'dummy-queue', 'message dummy 1');
        $nanoMqClient->sendMessage($myRedisMock, 'dummy-queue', 'message dummy 2');
        $nanoMqClient->sendMessage($myRedisMock, 'other-queue', 'message other 1');
        $nanoMqClient->sendMessage($myRedisMock, 'dummy-queue', 'message dummy 3');
        $nanoMqClient->sendMessage($myRedisMock, 'other-queue', 'message other 2');
        $nanoMqClient->sendMessage($myRedisMock, 'other-queue', 'message other 3');

        $result = $nanoMqClient->getMessage($myRedisMock, 'dummy-queue');
        $this->assertEquals('message dummy 1', $result);
        $result = $nanoMqClient->getMessage($myRedisMock, 'dummy-queue');
        $this->assertEquals('message dummy 2', $result);
        $result = $nanoMqClient->getMessage($myRedisMock, 'dummy-queue');
        $this->assertEquals('message dummy 3', $result);
        $result = $nanoMqClient->getMessage($myRedisMock, 'other-queue');
        $this->assertEquals('message other 1', $result);
        $result = $nanoMqClient->getMessage($myRedisMock, 'other-queue');
        $this->assertEquals('message other 2', $result);
        $result = $nanoMqClient->getMessage($myRedisMock, 'other-queue');
        $this->assertEquals('message other 3', $result);
    }
}
