<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessInsertNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $content;
    private $users;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $content, array $users=[])
    {
        $this->content = $content;
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($this->users)) {
            $users = User::all();
        } else {
            $users = $this->users;
        }
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'content' => $this->content
            ]);
        }
    }
}
