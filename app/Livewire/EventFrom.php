<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class EventForm extends Component
{
    public $eventId;
    public $title;
    public $description;
    public $start;
    public $end;

    protected $listeners = [
        'openCreateModal',
        'openEditModal',
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'start' => 'required|date',
        'end' => 'nullable|date|after_or_equal:start',
    ];

    public function openCreateModal($data)
    {
        $this->reset();
        $this->start = $data['date'] . ' 09:00';
        $this->end   = $data['date'] . ' 10:00';

        $this->dispatchBrowserEvent('show-event-modal');
    }

    public function openEditModal($data)
    {
        $event = Event::findOrFail($data['id']);

        $this->eventId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->start = $event->start->format('Y-m-d\TH:i');
        $this->end = $event->end?->format('Y-m-d\TH:i');

        $this->dispatchBrowserEvent('show-event-modal');
    }

    public function save()
    {
        $this->validate();

        Event::updateOrCreate(
            ['id' => $this->eventId],
            [
                'user_id' => auth()->id(),
                'title' => $this->title,
                'description' => $this->description,
                'start' => Carbon::parse($this->start),
                'end' => $this->end ? Carbon::parse($this->end) : null,
            ]
        );

        $this->dispatchBrowserEvent('hide-event-modal');
        $this->dispatch('eventAdded');
    }

    public function render()
    {
        return view('livewire.event-from');
    }
}
