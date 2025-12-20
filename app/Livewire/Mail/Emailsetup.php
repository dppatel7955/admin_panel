<?php

namespace App\Livewire\Mail;

use App\Mail\OrderShipped;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('livewire.layout.app')]
#[Title('Email Setup')]
class Emailsetup extends Component
{
    public EmailTemplate $template;

    public function mount()
    {
        $this->template = new EmailTemplate();
    }

    public function save()
    {
        $this->validate([
            'template.key' => 'required',
            'template.name' => 'required',
            'template.subject' => 'required',
            'template.body' => 'required',
        ]);

        $this->template->save();

        session()->flash('success', 'Template saved');
    }

    public function sendmail()
    {
        $user = Auth::user();
        Mail::to($user->email)->send(new OrderShipped());
        dd($user);
    }
    public function render()
    {
        return view('livewire.mail.emailsetup');
    }
}
