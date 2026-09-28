<?php
declare(strict_types=1);
namespace Lila\\Config;

final class Env
{
    public function __construct(
        public readonly string $appEnv = 'dev',
        public readonly string $baseUrl = 'http://127.0.0.1:8080',
        public readonly string $mongoDsn = 'mongodb://127.0.0.1:27017',
        public readonly string $mongoDatabase = 'lila',
        public readonly string $redisDsn = 'redis://127.0.0.1:6379',
    ) {}

    public static function fromEnvironment(): self
    {
        return new self(
            getenv('APP_ENV') ?: 'dev',
            getenv('APP_URL') ?: 'http://127.0.0.1:8080',
            getenv('MONGODB_DSN') ?: 'mongodb://127.0.0.1:27017',
            getenv('MONGODB_DATABASE') ?: 'lila',
            getenv('REDIS_DSN') ?: 'redis://127.0.0.1:6379',
        );
    }
}
