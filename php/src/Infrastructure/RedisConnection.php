<?php
declare(strict_types=1);
namespace Lila\\Infrastructure;

final class RedisConnection
{
    private mixed $client = null;

    public function __construct(private readonly string $dsn) {}

    public function client(): mixed
    {
        if ($this->client !== null) return $this->client;
        if (class_exists('Redis')) {
            $this->client = new Redis();
            $parts = parse_url($this->dsn);
            $host = $parts['host'] ?? '127.0.0.1';
            $port = (int)($parts['port'] ?? 6379);
            $this->client->connect($host, $port);
            return $this->client;
        }
        throw new RuntimeException('Redis PHP extension is required for the Redis backend.');
    }
}
