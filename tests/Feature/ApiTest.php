<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function testFetchListOfUsers()
    {
        $response = $this->get('/users');
        $response->assertStatus(200);
    }
}
