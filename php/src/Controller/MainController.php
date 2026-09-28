<?php
declare(strict_types=1);
namespace Lila\\Controller;
use Lila\\Http\\Request;
use Lila\\Http\\Response;
final class MainController {
    public function home(Request $request, array $params): Response {
        return new Response('<!doctype html><html><head><meta charset="utf-8"><title>Lila PHP</title></head><body><h1>Lila PHP migration</h1><p>Original source tree is preserved.</p></body></html>');
    }
    public function manifest(Request $request, array $params): Response {
        return Response::json(['name'=>'Lila PHP','short_name'=>'Lila','start_url'=>'/','display'=>'standalone']);
    }
}
