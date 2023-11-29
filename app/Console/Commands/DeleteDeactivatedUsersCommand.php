<?php

namespace App\Console\Commands;

use App\Modules\V1\User\Repositories\UserRepositoryInterface;
use Illuminate\Console\Command;

class DeleteDeactivatedUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:deactivated-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete deactivated users';

    /**
     * Execute the console command.
     */
    public function handle(UserRepositoryInterface $userRepository)
    {
        $userRepository->deleteExpiredAccount();
    }
}
