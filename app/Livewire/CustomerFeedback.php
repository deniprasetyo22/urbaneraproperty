<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerFeedbackNotificationMail;
use App\Models\CustomerFeedback as CustomerFeedbackModel;

#[Title('Customer Feedback')]
class CustomerFeedback extends Component
{
    public $name;
    public $email;
    public $phone;
    public $category;
    public $message;
    public $showToast = false;

    protected $listeners = [
        'close-toast' => 'closeToast',
    ];

    protected $rules = [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|max:255',
        'phone'    => 'required|string|max:50',
        'category' => 'required|string',
        'message'  => 'required|string',
    ];

    public function submit($token = null)
    {
        $this->validate();
        // sleep(3);

        // 1. Validasi reCAPTCHA v3 ke Google
        if (!$token) {
            $this->addError('recaptcha_error', 'Verification failed (No Token).');
            return;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret_key'),
            'response' => $token,
            'remoteip' => request()->ip(),
        ]);

        $recaptchaData = $response->json();

        // 2. Cek Success dan Score (0.0 bot, 1.0 human). Batas aman biasanya 0.5
        if (!($recaptchaData['success'] ?? false) || ($recaptchaData['score'] ?? 0) < 0.5) {
            $this->addError('recaptcha_error', 'Spam detected. Please try again.');
            return;
        }

        $data = CustomerFeedbackModel::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'phone'    => $this->phone,
            'category' => $this->category,
            'message'  => $this->message,
        ]);

        Mail::to(config('mail.from.address'))
            ->queue(new CustomerFeedbackNotificationMail($data));

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
        return view('livewire.customer-feedback');
    }
}