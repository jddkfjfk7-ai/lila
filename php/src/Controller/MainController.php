<?php
declare(strict_types=1);
namespace Lila\\Controller;

use Lila\\Http\\Request;
use Lila\\Http\\Response;

final class MainController
{
    public function home(Request $request, array $params): Response
    {
        return new Response('<!doctype html><html><head><meta charset="utf-8"><title>Lila</title></head><body><h1>Lila</h1></body></html>');
    }

    public function manifest(Request $request, array $params): Response
    {
        return Response::json(['name'=>'Lila','short_name'=>'Lila','start_url'=>'/','display'=>'standalone']);
    }

    public function robots(Request $request, array $params): Response
    {
        return new Response("User-agent: *\nDisallow: /", 200, ['Content-Type'=>'text/plain; charset=utf-8']);
    }

    public function lag(Request $request, array $params): Response
    {
        return new Response('<!doctype html><html><body><h1>Lag</h1></body></html>');
    }

    public function webmasters(Request $request, array $params): Response
    {
        return new Response('<!doctype html><html><body><h1>Webmasters</h1></body></html>');
    }

    public function faq(Request $request, array $params): Response
    {
        return new Response('<!doctype html><html><body><h1>FAQ</h1></body></html>');
    }

    public function contact(Request $request, array $params): Response
    {
        return new Response('<!doctype html><html><body><h1>Contact</h1></body></html>');
    }
}
