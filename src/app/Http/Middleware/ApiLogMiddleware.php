<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $logger = Log::channel('docker');

        $info = [
            'action' => 'API request received',
            'headers' => $request->header(),
            'uri' => $request->getUri(),
            'params' => $request->route()->parameters(),
            'input' => $request->input(),
        ];

        $logger->debug($info);

        return $next($request);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function terminate(Request $request, Response $response) : void
    {
        $logger = Log::channel('docker');

        $info = [
            'action' => 'API response sent',
            'headers' => $response->headers,
            'status' => $response->getStatusCode(),
            'content' => $response->getContent(), // Might be worth enforcing a limit on the size of this written to the logs
        ];

        $logger->debug($info);
    }
}
