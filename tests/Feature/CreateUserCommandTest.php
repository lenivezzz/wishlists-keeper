<?php

namespace Tests\Feature;

use App\Keeper\User\Notifications\VerifyEmailQueued;
use App\Keeper\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserCommandTest extends TestCase
{
    use WithFaker;

    public function testCreated() : void
    {
        $email = $this->faker->email;
        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', $email)
            ->expectsQuestion('Provide password', $this->faker->password(8))
            ->expectsOutput(sprintf('User %s created successfully', $email))
            ->assertExitCode(0);
    }

    public function testValidateEmail() : void
    {
        $password = $this->faker->password(8);
        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', '')
            ->expectsQuestion('Provide password', $password)
            ->expectsOutput('The email field is required.');

        $email = $this->faker->email;
        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', $email)
            ->expectsQuestion('Provide password', $password);

        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', $email)
            ->expectsQuestion('Provide password', $password)
            ->expectsOutput('The email has already been taken.');
    }

    public function testValidatePassword() : void
    {
        $email = $this->faker->email;
        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', $email)
            ->expectsQuestion('Provide password', '1')
            ->expectsOutput('The password must be at least 3 characters.');

        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', $email)
            ->expectsQuestion('Provide password', $this->faker->password(3))
            ->expectsOutput(sprintf('User %s created successfully', $email))
            ->assertExitCode(0);

        $email = $this->faker->unique()->email;
        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', $email)
            ->expectsQuestion('Provide password', $this->faker->password(8))
            ->expectsOutput(sprintf('User %s created successfully', $email))
            ->assertExitCode(0);
    }

    public function testEmailSent() : void
    {
        Notification::fake();
        $email = $this->faker->email;
        $this->artisan('user:create')
            ->expectsQuestion('Provide user email', $email)
            ->expectsQuestion('Provide password', $this->faker->password)
            ->assertExitCode(0);

        Notification::assertSentTo(
            resolve(UserRepositoryInterface::class)->findByEmail($email),
            VerifyEmailQueued::class,
            function (VerifyEmailQueued $notification) {
                return true;
            }
        );
    }
}
