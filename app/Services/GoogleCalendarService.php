<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Gmail;

class GoogleCalendarService
{
    /**
     * Create and configure Google Client
     */
    public function client(): Client
    {
        $client = new Client();

        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(route('calender.callback'));

        // 🔹 Scopes (Email + Calendar)
        $client->addScope([
            Calendar::CALENDAR,
            Gmail::GMAIL_READONLY,
        ]);

        // 🔹 Important for refresh token
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        return $client;
    }

    /**
     * Calendar service instance
     */
    public function calendar(Client $client = null): Calendar
    {
        $client = $client ?: $this->client();
        return new Calendar($client);
    }
}
