<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Event;
use App\Services\GoogleCalendarService;
use Carbon\Carbon;

#[Layout('livewire.layout.app')]
#[Title('Calendar')]
class Calendar extends Component
{
    protected $listeners = [
        'eventAdded' => '$refresh',
        'updateEventDate',
    ];

    public function mount()
    {
        if (auth()->user()->gmail_token) {
            $this->syncGoogleEvents(app(GoogleCalendarService::class));
        }
    }

    /* ================= GOOGLE SYNC ================= */

    public function syncGoogleEvents(GoogleCalendarService $service)
    {
        $client = $service->client();
        $client->setAccessToken(json_decode(auth()->user()->gmail_token, true));

        if ($client->isAccessTokenExpired()) {
            $token = $client->fetchAccessTokenWithRefreshToken(
                $client->getRefreshToken()
            );

            auth()->user()->update([
                'gmail_token' => json_encode($token)
            ]);
        }

        $calendarService = new \Google\Service\Calendar($client);
        $googleEvents = $calendarService->events->listEvents('primary');

        foreach ($googleEvents->getItems() as $event) {

            if (!$event->start->dateTime) continue;

            Event::updateOrCreate(
                ['google_event_id' => $event->id],
                [
                    'user_id' => auth()->id(),
                    'title' => $event->getSummary() ?? 'No title',
                    'start' => Carbon::parse($event->start->dateTime),
                    'end' => Carbon::parse($event->end->dateTime),
                ]
            );
        }
    }

    /* ================= DRAG / RESIZE ================= */

    public function updateEventDate($data)
    {
        $event = Event::where('id', $data['id'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $event->update([
            'start' => Carbon::parse($data['start']),
            'end' => $data['end'] ? Carbon::parse($data['end']) : null,
        ]);

        /* Google update (optional) */
        if ($event->google_event_id && auth()->user()->gmail_token) {

            $service = app(GoogleCalendarService::class);
            $client = $service->client();
            $client->setAccessToken(json_decode(auth()->user()->gmail_token, true));

            $calendarService = new \Google\Service\Calendar($client);

            $googleEvent = $calendarService->events->get(
                'primary',
                $event->google_event_id
            );

            $googleEvent->setStart([
                'dateTime' => $event->start->toRfc3339String()
            ]);

            $googleEvent->setEnd([
                'dateTime' => $event->end?->toRfc3339String()
            ]);

            $calendarService->events->update(
                'primary',
                $event->google_event_id,
                $googleEvent
            );
        }

        $this->dispatch('eventAdded');
    }

    public function render()
    {
        return view('livewire.calendar', [
            'events' => Event::where('user_id', auth()->id())
                ->get()
                ->map(fn ($event) => [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start->toIso8601String(),
                    'end' => $event->end?->toIso8601String(),
                ]),
        ]);
    }
}
