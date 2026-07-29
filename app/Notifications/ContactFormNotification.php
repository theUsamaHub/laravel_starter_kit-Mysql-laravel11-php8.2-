<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactFormNotification extends Notification
{
    public function __construct(
        public string $name,
        public string $email,
        public string $subject,
        public string $message
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Contact Message: ' . $this->subject)
            ->greeting('New contact form submission')
            ->line('From: ' . $this->name . ' (' . $this->email . ')')
            ->line('Subject: ' . $this->subject)
            ->line('Message:')
            ->line($this->message)
            ->action('View Messages', route('admin.contacts.index'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => "New contact from {$this->name}",
            'body' => "Subject: {$this->subject}",
            'type' => 'contact_message',
            'action_url' => route('admin.contacts.index'),
        ];
    }
}
