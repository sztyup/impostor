<?php

namespace Sztyup\Impostor\Middleware;

use Closure;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Sztyup\Impostor\ImpersonationManager;

class Impersonate
{
    const SESSION_KEY = '_nexus_impersonate';

    /** @var Factory */
    protected $viewFactory;

    protected $manager;

    public function __construct(Factory $factory, ImpersonationManager $impersonationManager)
    {
        $this->viewFactory = $factory;
        $this->manager = $impersonationManager;
    }

    public function handle(Request $request, Closure $next)
    {
        $this->manager->handleRequest($request);

        /** @var Response $response */
        $response = $next($request);

        if ($this->manager->isImpersonating() && $this->shouldInject($response)) {
            $this->injectImpersonateBar($response);
        }

        return $response;
    }

    protected function injectImpersonateBar(Response $response)
    {
        $view = $this->viewFactory->make('impostor::impersonateBar', [
            'user' => $this->manager->getImpersonatedUser()
        ])->render();

        $content = preg_replace("/<body([^>])*>/", "\\0\n$view", $response->getContent());

        $response->setContent($content);
    }

    protected function shouldInject($response)
    {
        // Not a normal response, probably a redirect
        if (!$response instanceof Response) {
            return false;
        }

        // Explicit redirect response
        if ($response->isRedirection()) {
            return false;
        }

        // Only inject html responses
        if (!Str::contains($response->headers->get('Content-Type'), 'html')) {
            return false;
        }

        return true;
    }
}
