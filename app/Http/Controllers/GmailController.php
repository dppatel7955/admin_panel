<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Gmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GmailController extends Controller
{
    public function connect()
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(route('gmail.callback'));
        $client->addScope(Google_Service_Gmail::GMAIL_READONLY);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $authUrl = $client->createAuthUrl();
        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(route('gmail.callback'));

        $client->authenticate($request->code);
        $token = $client->getAccessToken();

        // Save token to DB for authenticated user
        if(!empty($token) && isset($token['access_token']))
        {
            Auth::user()->update(['gmail_token' => json_encode($token)]);
            return redirect()
                ->route('emails')
                ->with('sweet_alert', [
                    'type' => 'success',
                    'title' => 'Gmail Connected',
                    'text' => 'Your Gmail account has been connected successfully.'
                ]);
        }
        else{
            return redirect()
                ->route('emails')
                ->with('sweet_alert', [
                    'type' => 'error',
                    'title' => 'Connection Failed',
                    'text' => 'Unable to connect Gmail. Please try again.'
                ]);
        }        
    }
}

