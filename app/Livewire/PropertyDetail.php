<?php

namespace App\Livewire;

use App\Models\Bank;
use Livewire\Component;
use App\Models\Brochure;
use App\Models\Property;
use App\Mail\BrochureMail;
use App\Models\CustomerData;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

#[Title('Properties')]
class PropertyDetail extends Component
{
    public $property;
    public $showAll = false;
    public $showModal = false;
    public $activeImage = null;
    public $modalBrochure = false;

    // KPR fields
    public $price;
    public $bank_id;
    public $interest_rate;
    public $down_payment = 0;
    public $tenor; // years

    public $monthly_installment = 0;

    public $name;
    public $email;
    public $phone;

    public $toastSuccess = false;

    protected $listeners = [
        'close-toast' => 'closeToast',

    ];

    public function mount(Property $property)
    {
        $this->property = $property;
        $this->price = $property->price;
    }

    public function toggleShow()
    {
        $this->showAll = !$this->showAll;
    }

    public function openModal($img)
    {
        $this->activeImage = $img;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function updatedBankId($value)
    {
        $bank = Bank::find($value);

        if ($bank) {
            $this->interest_rate = $bank->interest_rate;
        }
    }

    public function toggleModalBrochure()
    {
        $this->modalBrochure = !$this->modalBrochure;
        if ($this->modalBrochure) {
            $this->dispatch('open-brochure-modal');
        }
    }

    protected $rules = [
        'bank_id'        => 'required|exists:banks,id',
        'interest_rate' => 'required|numeric|min:0',
        'price'         => 'required|numeric|min:1',
        'down_payment'  => 'nullable|numeric|min:0|lte:price',
        'tenor'         => 'required|integer|min:1',
    ];

    protected $messages = [
        'bank_id.required'       => 'Please choose a bank.',
        'price.required'        => 'Price is required.',
        'down_payment.required' => 'Down payment is required.',
        'down_payment.lte'      => 'Down payment cannot be greater than price.',
        'interest_rate.required'=> 'Interest rate is required.',
        'tenor.required'        => 'Please choose a tenor.',
    ];

    public function calculateKpr()
    {
        $this->validate();

        // 1️⃣ Hitung total pinjaman
        // Harga properti - uang muka
        // max(0, ...) untuk mencegah nilai minus jika DP > harga
        $loan = max(0, $this->price - $this->down_payment);

        // 2️⃣ Validasi dasar
        // Kalau belum ada pinjaman, bunga, atau tenor → cicilan = 0
        if (!$loan || !$this->interest_rate || !$this->tenor) {
            $this->monthly_installment = 0;
            return;
        }

        // 3️⃣ Konversi bunga tahunan ke bunga bulanan (desimal)
        // contoh: 3.6% → 0.036 / 12 = 0.003
        $r = ($this->interest_rate / 100) / 12;

        // 4️⃣ Total periode dalam bulan
        // contoh: 15 tahun → 15 × 12 = 180 bulan
        $n = $this->tenor * 12;

        // 5️⃣ Kalau bunga 0% (kasus khusus)
        // cicilan = total pinjaman / jumlah bulan
        if ($r == 0) {
            $this->monthly_installment = $loan / $n;
        }
        // 6️⃣ Kalau ada bunga → pakai rumus anuitas (standar KPR)
        else {
            $this->monthly_installment = $loan * (
                ($r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1)
            );
        }
    }

    public function sendRequestBrochure($token = null)
    {
        $this->validate([
            'name'  => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ], [
            'name.required'  => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email'    => 'Email is invalid.',
            'phone.required' => 'Phone is required.',
            'phone.numeric'  => 'Phone is invalid.',
        ]);

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

        // Jika lolos, simpan data
        CustomerData::create([
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $brochure = Brochure::where('residence_id', $this->property->residence_id)->first();

        if (! $brochure) {
            $this->addError('recaptcha_error', 'Brochure not available.');
            return;
        }

        Mail::to($this->email)->queue(
            new BrochureMail($this->name, $brochure->file)
        );

        $this->toastSuccess = true;

        $this->dispatch('toast-shown');

        $this->reset([
            'name',
            'email',
            'phone',
        ]);

        $this->modalBrochure = false;
    }

    public function closeToast()
    {
        $this->toastSuccess = false;
    }

    public function render()
    {
        return view('livewire.property-detail', [
            'banks' => Bank::all(),
        ]);
    }
}