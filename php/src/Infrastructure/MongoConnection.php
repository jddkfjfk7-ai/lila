<?php
declare(strict_types=1);
namespace Lila\\Infrastructure;

final class MongoConnection
{
    private mixed $client = null;

    public function __construct(
        private readonly string $dsn,
        private readonly string $database,
    ) {}

    public function client(): mixed
    {
        if ($this->client !== null) return $this->client;
        if (!class_exists('MongoDB\\Client')) {
            throw new RuntimeException('ext-mongodb and mongodb/mongodb are required for the PHP MongoDB backend.');
        }
        $class = 'MongoDB\\Client';
        $this->client = new $class($this->dsn);
        return $this->client;
    }

    public function database(): mixed
    {
        return $this->client()->selectDatabase($this->database);
    }
}
