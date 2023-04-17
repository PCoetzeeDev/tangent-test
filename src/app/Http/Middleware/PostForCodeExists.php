<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class PostForCodeExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator::make([
            'code' => $request->route()->parameters['code'],
        ], [
            'code' => 'required|exists:posts,code'
        ], [
            'code' => 'Invalid code for post'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $next($request);
    }
}
