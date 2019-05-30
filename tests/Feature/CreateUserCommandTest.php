<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserCommandTest extends TestCase
{
    public function testCreated() : void
    {
        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', 'mail@email.com')
            ->expectsQuestion('Provide password', '123qwert')
            ->expectsOutput('User mail@email.com created successfully')
            ->assertExitCode(0);
    }

    public function testValidateEmail() : void
    {
        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', '')
            ->expectsQuestion('Provide password', '1q2w3e4r')
            ->expectsOutput('The email field is required.');

        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', 'mail@email.com')
            ->expectsQuestion('Provide password', '123qwert');

        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', 'mail@email.com')
            ->expectsQuestion('Provide password', '123qw')
            ->expectsOutput('The email has already been taken.');
    }

    public function testValidatePassword() : void
    {
        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', 'email@email.com')
            ->expectsQuestion('Provide password', '1')
            ->expectsOutput('The password must be at least 3 characters.');
    }
}
