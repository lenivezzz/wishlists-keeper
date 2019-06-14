<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Keeper\User\Repositories\UserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User registration';

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() : void
    {
        $email = $this->ask('Provide user email');
        $password = $this->secret('Provide password');

        $validator = Validator::make([
            'email' => $email,
            'password' => $password,
        ], [
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:3'],
        ]);
        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return;
        }

        event(new Registered($user = $this->userRepository->create($email, $password)));
        $this->info(sprintf('User %s created successfully', $email));
    }
}
