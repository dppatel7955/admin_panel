<?php

namespace App\Http\Controllers;

use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GoogleCalendarController extends Controller
{
    public function redirect(GoogleCalendarService $service)
    {
        $client = $service->client();
        return redirect($client->createAuthUrl());
    }

    public function callback(GoogleCalendarService $service)
    {
        $client = $service->client();
        if (request('code')) {
            $token = $client->fetchAccessTokenWithAuthCode(request('code'));
            Auth::user()->update(['gmail_token' => json_encode($token)]);
        }

        return redirect('/calendar');
    }
}
