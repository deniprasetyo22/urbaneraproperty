<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log; // Opsional: untuk mencatat error jika file hilang

class BrochureMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $filePath;

    public function __construct($name, $filePath)
    {
        $this->name = $name;
        $this->filePath = $filePath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Property Brochure Info', // Sedikit disesuaikan
        );
    }

    public function content(): Content
    {
        // Cek dulu apakah file ada, agar View bisa menyesuaikan kata-kata
        $fullPath = storage_path('app/public/' . $this->filePath);
        $fileExists = !empty($this->filePath) && file_exists($fullPath);

        return new Content(
            view: 'emails.brochure',
            with: [
                'name' => $this->name,
                'hasAttachment' => $fileExists, // Kirim status ke blade
            ]
        );
    }

    public function attachments(): array
    {
        $fullPath = storage_path('app/public/' . $this->filePath);

        // LOGIKA PENGECEKAN:
        // Jika filePath ada isinya DAN file fisiknya ditemukan di storage
        if (!empty($this->filePath) && file_exists($fullPath)) {
            return [
                Attachment::fromPath($fullPath)
                    ->as(basename($this->filePath))
                    ->withMime('application/pdf'),
            ];
        }

        // Opsional: Log error agar developer tahu ada brosur yang hilang
        Log::warning("Brochure file not found for user {$this->name}: {$fullPath}");

        // Kembalikan array kosong (Email tetap terkirim tapi tanpa lampiran)
        return [];
    }
}