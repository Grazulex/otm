<?php

namespace App\Notifications;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Notifications\Notification;
use RalphJSmit\Filament\Notifications\Concerns\StoresNotificationInDatabase;
use RalphJSmit\Filament\Notifications\Contracts\AsFilamentNotification;
use RalphJSmit\Filament\Notifications\FilamentNotification;

class ImportNotification extends Notification implements
    AsFilamentNotification {
    use StoresNotificationInDatabase;

    public function __construct(
        public string $type,
        public ?string $message = null,
    ) {
    }

    public static function toFilamentNotification(): FilamentNotification {
        return FilamentNotification::make()
            ->form([
                TextInput::make('type')
                    ->label('Type')
                    ->required()
                    ->columnSpan(2),
                Textarea::make('message')
                    ->label('Message')
                    ->columnSpan(2),
            ])
            ->message(fn(self $notification) => $notification->type)
            ->description(fn(self $notification) => $notification->message);
    }
}
