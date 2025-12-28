<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

        if (config('database.default') === 'mysql' && config('database.connections.mysql.database') === 'laravel') {
            throw new \RuntimeException('For security reasons, refusing to run tests on the dev database (mysql:laravel).');
        }

    }
}
