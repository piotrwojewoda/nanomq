<?php

namespace Piotrwojewoda\Nanomq;

use Predis\Client;
use Redis;

class NanoMqClient
{
    public function sendMessage(Client $redisClient, string $queue, string $message)
    {
        $redisClient->rpush($queue, [$message]);
    }

    public function getMessage(Client $redisClient, string $queue)
    {
        return $redisClient->lpop($queue)[0];
    }
}
