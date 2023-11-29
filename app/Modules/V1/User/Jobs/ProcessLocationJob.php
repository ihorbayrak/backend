<?php

namespace App\Modules\V1\User\Jobs;

use App\Models\User;
use App\Modules\V1\User\Actions\ProcessLocationAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLocationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private User $user, private string $ip)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ProcessLocationAction $processLocation): void
    {
        $processLocation->handle($this->user, $this->ip);
    }
}


