<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $contactMessage->reply_subject ?: 'Balasan dari Tim ' . config('app.name') }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #374151;
            line-height: 1.6;
        }

        .wrapper {
            width: 100%;
            padding: 32px 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #1e40af 0%, #06b6d4 100%);
            padding: 32px 40px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            font-size: 22px;
            margin: 0;
            font-weight: 700;
        }

        .header p {
            color: #bfdbfe;
            font-size: 14px;
            margin: 2px 0 0;
        }

        .body {
            padding: 32px 40px;
        }

        .greeting {
            font-size: 16px;
            color: #111827;
            margin-bottom: 20px;
        }

        .reply-content {
            font-size: 15px;
            color: #374151;
            line-height: 1.7;
            white-space: pre-line;
        }

        .original-message {
            margin-top: 32px;
            padding: 20px;
            background-color: #f9fafb;
            border-left: 4px solid #1e40af;
            border-radius: 0 8px 8px 0;
        }

        .original-message h4 {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 0 0 8px;
        }

        .original-message p {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
            white-space: pre-line;
        }

        .footer {
            padding: 24px 40px;
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        .footer p {
            font-size: 12px;
            color: #9ca3af;
            margin: 4px 0;
        }

        .footer a {
            color: #1e40af;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            {{-- Header --}}
            <div class="header">
                <h1>{{ config('app.name') }}</h1>
                <p>Terima kasih telah menghubungi kami</p>
            </div>

            {{-- Body --}}
            <div class="body">
                <p class="greeting">Halo <strong>{{ $contactMessage->name }}</strong>,</p>

                <div class="reply-content">{!! nl2br(e($replyBody)) !!}</div>

                {{-- Original Message --}}
                <div class="original-message">
                    <h4>Pesan asli Anda</h4>
                    <p>{{ $contactMessage->message }}</p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="footer">
                <p>Email ini dikirim sebagai balasan atas pesan yang Anda kirim melalui formulir kontak kami.</p>
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.</p>
            </div>
        </div>
    </div>
</body>

</html>
