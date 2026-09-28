<?php
declare(strict_types=1);
namespace Lila\\Http;
final class Request {
    public function __construct(
        public readonly string $method,
        public readonly string $path,
        public readonly array $query = [],
        public readonly array $body = [],
        public readonly array $headers = [],
    ) {}
    public static function fromGlobals(): self {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        return new self(
            strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET'),
            $path,
            $_GET,
            $_POST,
            function_exists('getallheaders') ? getallheaders() : []
        );
    }
}
