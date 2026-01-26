<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use App\Mail\MessageNotificationMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;

#[Title('Contact')]
class Contact extends Component
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $message;
    public $showToast = false;
    protected $listeners = [
        'close-toast' => 'closeToast',
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required|string',
        'message' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        $data = Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'message' => $this->message,
        ]);

        // kirim email notifikasi
        Mail::to(config('mail.from.address'))
            ->queue(new MessageNotificationMail($data));

        // reset form
        $this->reset();

        $this->showToast = true;

        $this->dispatch('toast-shown');
    }

    public function closeToast()
    {
        $this->showToast = false;
    }

    public function render()
    {
        return view('livewire.contact');
    }
}