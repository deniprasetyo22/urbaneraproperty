<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Property Brochure</title>
    </head>

    <body>
        <p>Hi {{ $name }},</p>

        <p>Thank you for your interest in our property.</p>

        {{-- Logika Blade untuk mengubah teks --}}
        @if (isset($hasAttachment) && $hasAttachment)
            <p>This is our property brochure.</p>
        @else
            <p>
                We apologize, but the brochure is currently unavailable for download.
                Our team will contact you shortly with more details.
            </p>
        @endif

        <p>Best regards,<br>
            {{ config('app.name') }}</p>
    </body>

</html>
