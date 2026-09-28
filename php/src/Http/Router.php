<?php
declare(strict_types=1);
namespace Lila\\Http;
final class Router {
    private array $routes = [];
    public function get(string $pattern, callable $handler): void { $this->add('GET', $pattern, $handler); }
    public function post(string $pattern, callable $handler): void { $this->add('POST', $pattern, $handler); }
    public function add(string $method, string $pattern, callable $handler): void {
        $this->routes[] = compact('method', 'pattern', 'handler');
    }
    public function dispatch(Request $request): Response {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $request->method) continue;
            $regex = preg_replace_callback(
                '#\\{([A-Za-z_][A-Za-z0-9_]*)\\}#',
                static fn(array $m): string => '(?P<' . $m[1] . '>[^/]+)',
                $route['pattern']
            );
            if ($regex !== null && preg_match('#^' . $regex . '/?$#', $request->path, $matches)) {
                $params = array_filter($matches, static fn($key): bool => is_string($key), ARRAY_FILTER_USE_KEY);
                return ($route['handler'])($request, $params);
            }
        }
        return new Response('Not Found', 404);
    }
}
