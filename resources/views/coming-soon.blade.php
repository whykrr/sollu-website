<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Segera Hadir — {{ config('app.name', 'Sollu Indonesia') }}</title>
    <meta name="description"
        content="Sesuatu yang menarik sedang kami siapkan. Sollu POS — Platform Kasir Digital terbaik untuk UMKM Indonesia. Segera hadir!">
    <meta property="og:title" content="Segera Hadir — {{ config('app.name', 'Sollu Indonesia') }}">
    <meta property="og:description"
        content="Sesuatu yang menarik sedang kami siapkan. Sollu POS — Platform Kasir Digital terbaik untuk UMKM Indonesia.">
    <meta property="og:type" content="website">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/img/icon-trans.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --main: #1e40af;
            --main-light: #3b82f6;
            --main-lighter: #60a5fa;
            --main-dark: #1e3a8a;
            --main-darker: #172554;
            --secondary: #06b6d4;
            --secondary-light: #67e8f9;
            --secondary-lighter: #a5f3fc;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--main-darker);
            color: #fff;
            overflow: hidden;
            position: relative;
        }

        /* Animated gradient background */
        .bg-gradient {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, var(--main-darker) 0%, var(--main-dark) 30%, var(--main) 60%, #0e4a8a 100%);
            z-index: 0;
        }

        /* Floating orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: float 8s ease-in-out infinite;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: var(--secondary);
            top: -10%;
            right: -5%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 300px;
            height: 300px;
            background: var(--main-light);
            bottom: -10%;
            left: -5%;
            animation-delay: -3s;
        }

        .orb-3 {
            width: 200px;
            height: 200px;
            background: var(--secondary-light);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -5s;
            opacity: 0.15;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-30px) scale(1.05);
            }
        }

        /* Grid pattern overlay */
        .grid-pattern {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 1;
        }

        /* Content */
        .container {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 640px;
            padding: 2rem;
        }

        .logo {
            height: 48px;
            margin-bottom: 2.5rem;
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards;
        }

        /* Rocket icon */
        .icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            margin-bottom: 1rem;
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.1s forwards;
        }

        .rocket-icon {
            width: 48px;
            height: 48px;
            color: var(--secondary-light);
            animation: rocket-bounce 3s ease-in-out infinite;
        }

        @keyframes rocket-bounce {

            0%,
            100% {
                transform: translateY(0) rotate(-5deg);
            }

            50% {
                transform: translateY(-8px) rotate(5deg);
            }
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 9999px;
            background: rgba(6, 182, 212, 0.15);
            border: 1px solid rgba(6, 182, 212, 0.3);
            color: var(--secondary-light);
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1rem;
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.2s forwards;
        }

        .status-badge .sparkle {
            font-size: 1rem;
            animation: sparkle 2s ease-in-out infinite;
        }

        @keyframes sparkle {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.3);
                opacity: 0.7;
            }
        }

        h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ffffff 0%, var(--secondary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.3s forwards;
        }

        .description {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.7;
            margin-bottom: 2.5rem;
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.4s forwards;
        }

        /* Countdown section */
        .countdown-section {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2.5rem;
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.5s forwards;
        }

        .countdown-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            min-width: 72px;
        }

        .countdown-value {
            font-family: 'Outfit', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 16px 12px;
            width: 100%;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .countdown-value:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.12);
        }

        .countdown-label {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
        }

        .countdown-separator {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            padding-bottom: 20px;
            animation: blink 1.5s ease-in-out infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        /* Email subscribe */
        .subscribe-section {
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.6s forwards;
        }

        .subscribe-form {
            display: flex;
            gap: 0;
            max-width: 440px;
            margin: 0 auto 1.5rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
            overflow: hidden;
            transition: border-color 0.3s ease;
        }

        .subscribe-form:focus-within {
            border-color: rgba(6, 182, 212, 0.5);
        }

        .subscribe-form input {
            flex: 1;
            padding: 14px 20px;
            background: transparent;
            border: none;
            color: #fff;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            outline: none;
        }

        .subscribe-form input::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }

        .subscribe-form button {
            padding: 14px 28px;
            background: linear-gradient(135deg, var(--main-light), var(--secondary));
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .subscribe-form button:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        .subscribe-note {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.3);
        }

        .subscribe-message {
            margin-top: 1rem;
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
            display: none;
            animation: fadeInUp 0.4s ease forwards;
            width: 100%;
            text-align: center;
        }

        .subscribe-message.success {
            display: block;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
        }

        .subscribe-message.error {
            display: block;
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        /* Glassmorphism card */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Social links */
        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.7s forwards;
        }

        .social-link {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            transform: translateY(-2px);
        }

        .social-link svg {
            width: 20px;
            height: 20px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 640px) {
            h1 {
                font-size: 1.75rem;
            }

            .description {
                font-size: 1rem;
            }

            .glass-card {
                padding: 2rem 1.5rem;
            }

            .icon-wrapper {
                width: 80px;
                height: 80px;
                border-radius: 20px;
            }

            .rocket-icon {
                width: 36px;
                height: 36px;
            }

            .countdown-value {
                font-size: 1.6rem;
                padding: 12px 8px;
                border-radius: 12px;
            }

            .countdown-item {
                min-width: 56px;
            }

            .countdown-separator {
                font-size: 1.5rem;
            }

            .subscribe-form {
                flex-direction: column;
                border-radius: 16px;
            }

            .subscribe-form input {
                text-align: center;
            }

            .subscribe-form button {
                border-radius: 0 0 12px 12px;
                padding: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="bg-gradient"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="grid-pattern"></div>

    <div class="container">
        <img src="/img/logo-white.png" alt="{{ config('app.name', 'Sollu POS') }}" class="logo">

        <div class="glass-card">
            <div class="icon-wrapper">
                <!-- Rocket SVG Icon -->
                <svg class="rocket-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09Z" />
                    <path
                        d="M12 15l-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2Z" />
                    <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0" />
                    <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5" />
                </svg>
            </div>

            <div class="status-badge">
                <span class="sparkle">✨</span>
                Segera Hadir
            </div>

            <h1>Sesuatu yang Menarik Sedang Disiapkan</h1>

            <p class="description">
                Kami sedang menyiapkan sesuatu yang luar biasa untuk bisnis Anda.
                Pantau terus dan jadilah yang pertama tahu saat kami meluncurkan!
            </p>

            <!-- Countdown Timer -->
            <div class="countdown-section">
                <div class="countdown-item">
                    <div class="countdown-value" id="days">00</div>
                    <span class="countdown-label">Hari</span>
                </div>
                <span class="countdown-separator">:</span>
                <div class="countdown-item">
                    <div class="countdown-value" id="hours">00</div>
                    <span class="countdown-label">Jam</span>
                </div>
                <span class="countdown-separator">:</span>
                <div class="countdown-item">
                    <div class="countdown-value" id="minutes">00</div>
                    <span class="countdown-label">Menit</span>
                </div>
                <span class="countdown-separator">:</span>
                <div class="countdown-item">
                    <div class="countdown-value" id="seconds">00</div>
                    <span class="countdown-label">Detik</span>
                </div>
            </div>

            <!-- Email Subscribe -->
            <div class="subscribe-section">
                <form class="subscribe-form" id="subscribe-form" onsubmit="handleSubscribe(event)">
                    <input type="email" id="email-input" placeholder="Masukkan email Anda..." required>
                    <button type="submit" id="subscribe-btn">Beritahu Saya</button>
                </form>
                <p class="subscribe-note">Kami tidak akan mengirim spam. Hanya notifikasi peluncuran.</p>
                <div id="subscribe-message" class="subscribe-message"></div>
            </div>
        </div>

        <!-- Social Links -->
        <div class="social-links">
            <a href="#" class="social-link" aria-label="Instagram">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                    <circle cx="12" cy="12" r="4" />
                    <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                </svg>
            </a>
            <a href="#" class="social-link" aria-label="Twitter">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" />
                </svg>
            </a>
            <a href="#" class="social-link" aria-label="WhatsApp">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z" />
                </svg>
            </a>
        </div>
    </div>

    <script>
        // ==============================
        // Countdown Timer
        // Set target date to 1 May 2026
        // ==============================
        const launchDate = new Date();
        launchDate.setFullYear(2026, 4, 1); // Month is 0-indexed (0 = January, 4 = May)

        function updateCountdown() {
            const now = new Date();
            const diff = launchDate - now;

            if (diff <= 0) {
                document.getElementById('days').textContent = '00';
                document.getElementById('hours').textContent = '00';
                document.getElementById('minutes').textContent = '00';
                document.getElementById('seconds').textContent = '00';
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);

        // ==============================
        // Subscribe handler (AJAX)
        // ==============================
        async function handleSubscribe(e) {
            e.preventDefault();

            const btn = document.getElementById('subscribe-btn');
            const input = document.getElementById('email-input');
            const messageEl = document.getElementById('subscribe-message');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const originalText = btn.textContent;
            const email = input.value.trim();

            if (!email) return;

            // Loading state
            btn.textContent = 'Mengirim...';
            btn.style.pointerEvents = 'none';
            input.disabled = true;
            messageEl.className = 'subscribe-message';
            messageEl.style.display = 'none';

            try {
                const response = await fetch('{{ route('coming-soon.subscribe') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        email
                    }),
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    messageEl.textContent = data.message;
                    messageEl.className = 'subscribe-message success';
                    btn.textContent = 'Terdaftar! \u2705';
                    input.value = '';

                    setTimeout(() => {
                        btn.textContent = originalText;
                        btn.style.pointerEvents = 'auto';
                        input.disabled = false;
                    }, 4000);
                } else if (response.status === 422) {
                    const errors = data.errors;
                    const firstError = errors ? Object.values(errors)[0][0] : 'Format email tidak valid.';
                    messageEl.textContent = firstError;
                    messageEl.className = 'subscribe-message error';
                    btn.textContent = originalText;
                    btn.style.pointerEvents = 'auto';
                    input.disabled = false;
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan.');
                }
            } catch (error) {
                messageEl.textContent = 'Terjadi kesalahan. Silakan coba lagi nanti.';
                messageEl.className = 'subscribe-message error';
                btn.textContent = originalText;
                btn.style.pointerEvents = 'auto';
                input.disabled = false;
            }
        }
    </script>
</body>

</html>
