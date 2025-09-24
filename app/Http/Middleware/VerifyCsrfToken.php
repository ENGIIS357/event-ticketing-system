<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * المسارات المستثناة من التحقق بالـ CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',   // 👈 أي مسار يبدأ بـ api/ لا يحتاج CSRF
    ];
}
