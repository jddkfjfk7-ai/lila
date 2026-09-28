<?php
declare(strict_types=1);
namespace Lila;

use Lila\\Config\\Env;
use Lila\\Controller\\MainController;
use Lila\\Http\\Request;
use Lila\\Http\\Response;
use Lila\\Http\\Router;

final class Kernel
{
    private Router $router;

    public function __construct(private readonly Env $env)
    {
        $this->router = new Router();
        $main = new MainController();

        $this->router->get('/', [$main, 'home']);
        $this->router->get('/manifest.json', [$main, 'manifest']);
        $this->router->get('/robots.txt', [$main, 'robots']);
        $this->router->get('/lag', [$main, 'lag']);
        $this->router->get('/webmasters', [$main, 'webmasters']);
        $this->router->get('/faq', [$main, 'faq']);
        $this->router->get('/contact', [$main, 'contact']);
    }

    public function handle(Request $request): Response
    {
        return $this->router->dispatch($request);
    }
}
