<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Session;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // ✅ Enable session handling in tests
        Session::start();

        // ✅ Disable CSRF & Exception handling for testing
        $this->withoutMiddleware();
        $this->withoutExceptionHandling();
    }
}
