<?php

namespace Tests\Feature;

use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Redis\RedisManager;
use Tests\TestCase;

class RedisTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getRedisConnection(): PhpRedisConnection
    {
        /**
         * @var RedisManager $redisManager
         */
        $redisManager = $this->app->make("redis");

        /**
         * @var PhpRedisConnection $connection
         */
        $connection = $redisManager->connection("testing");

        return $connection;
    }

    public function test_redis_connection_works(): void
    {
        $connection = $this->getRedisConnection();

        $connection->flushdb();

        $connection->set("foo", "bar");
        $actual = $connection->get("foo");

        $expected = "bar";

        $this->assertEquals($expected, $actual);
    }
}
