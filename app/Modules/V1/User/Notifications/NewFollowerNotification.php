<?php

namespace App\Modules\V1\User\Notifications;

use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewFollowerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Profile $profile, private Profile $follower)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $profileUrl = route('profiles.get', [
            'profile' => $this->follower->username
        ]);

        return (new MailMessage())
            ->greeting('Hello, '.$this->profile->username)
            ->line($this->follower->username.' now following you!')
            ->action('Check his profile', $profileUrl)
            ->line('Thank you for using '.config('app.name').'!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
