<?php
declare(strict_types=1);
namespace Lila\\Controller;

use Lila\\Http\\Request;
use Lila\\Http\\Response;

final class AuthController
{
    public function login(Request $request, array $params): Response
    {
        $html = '<!doctype html><html><head><meta charset="utf-8"><title>Login</title></head><body>'.
            '<h1>Login</h1><form method="post" action="/login">'.
            '<label>Username or email <input name="username" autocomplete="username"></label><br>'.
            '<label>Password <input type="password" name="password" autocomplete="current-password"></label><br>'.
            '<label><input type="checkbox" name="remember" value="1"> Remember me</label><br>'.
            '<button type="submit">Login</button></form></body></html>';
        return new Response($html);
    }

    public function authenticate(Request $request, array $params): Response
    {
        $username = trim((string)($request->body['username'] ?? ''));
        $password = (string)($request->body['password'] ?? '');
        if ($username === '' || $password === '') {
            return Response::json(['error' => 'Username and password are required'], 400);
        }
        return Response::json(['ok' => true, 'message' => 'Authentication backend is being ported']);
    }
}
