<?php

namespace App\Livewire;

use Google_Client;
use Google_Service_Gmail;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('livewire.layout.app')]
#[Title('Permission Management')]
class GmailInbox extends Component
{
    public $messages = [];
    public $nextPageToken = null;
    public $loading = false;

    protected $client;
    protected $gmail;

    public function mount()
    {
        $this->initGmail();
        $this->loadMessages();
    }

    private function initGmail()
    {
        $user = Auth::user();
        if (!$user->gmail_token) return;

        $this->client = new Google_Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect'));

        $token = json_decode($user->gmail_token, true);
        $this->client->setAccessToken($token);

        if ($this->client->isAccessTokenExpired()) {
            $newToken = $this->client->fetchAccessTokenWithRefreshToken(
                $this->client->getRefreshToken()
            );
            $newToken['refresh_token'] = $this->client->getRefreshToken();
            $user->update(['gmail_token' => json_encode($newToken)]);
            $this->client->setAccessToken($newToken);
        }

        $this->gmail = new Google_Service_Gmail($this->client);
    }

    public function loadMessages()
    {
        $this->loading = true;

        $params = ['maxResults' => 10];
        if ($this->nextPageToken) {
            $params['pageToken'] = $this->nextPageToken;
        }

        $list = $this->gmail->users_messages->listUsersMessages('me', $params);
        $this->nextPageToken = $list->getNextPageToken();
        foreach ($list->getMessages() as $message) {
            $msg = $this->gmail->users_messages->get('me', $message->getId());
            $headers = collect($msg->getPayload()->getHeaders());

            $this->messages[] = [
                'id' => $message->getId(),
                'subject' => $headers->firstWhere('name', 'Subject')?->getValue() ?? '(No subject)',
                'from' => $headers->firstWhere('name', 'From')?->getValue(),
                'snippet' => $msg->getSnippet(),
                'date' => date('d M Y', $msg->getInternalDate() / 1000),
            ];
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.gmail-inbox');
    }
}

