<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sedang Dalam Pemeliharaan — {{ config('app.name', 'Sollu Indonesia') }}</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="/img/icon-trans.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --main: #1e40af;
            --main-light: #3b82f6;
            --main-lighter: #60a5fa;
            --main-dark: #1e3a8a;
            --main-darker: #172554;
            --secondary: #06b6d4;
            --secondary-light: #67e8f9;
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
            width: 400px; height: 400px;
            background: var(--secondary);
            top: -10%; right: -5%;
            animation-delay: 0s;
        }
        .orb-2 {
            width: 300px; height: 300px;
            background: var(--main-light);
            bottom: -10%; left: -5%;
            animation-delay: -3s;
        }
        .orb-3 {
            width: 200px; height: 200px;
            background: var(--secondary-light);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -5s;
            opacity: 0.15;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        /* Grid pattern overlay */
        .grid-pattern {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 1;
        }

        /* Content */
        .container {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 600px;
            padding: 2rem;
        }

        .logo {
            height: 48px;
            margin-bottom: 2.5rem;
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards;
        }

        /* Animated gear icon */
        .icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            border-radius: 24px;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.12);
            margin-bottom: 2rem;
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.1s forwards;
        }

        .gear-icon {
            width: 48px;
            height: 48px;
            color: var(--secondary-light);
            animation: spin 6s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
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
            margin-bottom: 1.5rem;
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.2s forwards;
        }

        .status-badge .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--secondary);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
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
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
            margin-bottom: 2.5rem;
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.4s forwards;
        }

        /* Progress bar */
        .progress-section {
            margin-bottom: 2.5rem;
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.5s forwards;
        }

        .progress-bar {
            width: 100%;
            height: 4px;
            background: rgba(255,255,255,0.1);
            border-radius: 9999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 60%;
            border-radius: 9999px;
            background: linear-gradient(90deg, var(--main-light), var(--secondary));
            animation: progress-anim 3s ease-in-out infinite;
        }

        @keyframes progress-anim {
            0% { width: 20%; opacity: 0.7; }
            50% { width: 80%; opacity: 1; }
            100% { width: 20%; opacity: 0.7; }
        }

        .progress-text {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.4);
            margin-top: 0.75rem;
        }

        /* Contact link */
        .contact-section {
            opacity: 0;
            animation: fadeInUp 0.8s ease 0.6s forwards;
        }

        .contact-section p {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.4);
        }

        .contact-section a {
            color: var(--secondary-light);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .contact-section a:hover {
            color: #fff;
        }

        /* Glassmorphism card */
        .glass-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 3rem 2.5rem;
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

        /* Responsive — Tablets */
        @media (max-width: 768px) {
            .container { padding: 1.5rem; }
            .orb-1 { width: 300px; height: 300px; }
            .orb-2 { width: 200px; height: 200px; }
            .orb-3 { width: 150px; height: 150px; }
        }

        /* Responsive — Mobile */
        @media (max-width: 640px) {
            .logo { height: 36px; margin-bottom: 1.5rem; }
            h1 { font-size: 1.75rem; }
            .description { font-size: 1rem; margin-bottom: 2rem; }
            .glass-card { padding: 2rem 1.5rem; }
            .icon-wrapper { width: 80px; height: 80px; border-radius: 20px; margin-bottom: 1rem; }
            .gear-icon { width: 36px; height: 36px; }
            .status-badge { font-size: 0.7rem; padding: 5px 12px; }
            .progress-section { margin-bottom: 2rem; }
            .contact-section p { font-size: 0.8rem; }
        }

        /* Responsive — Very small screens */
        @media (max-width: 380px) {
            .container { padding: 1rem; }
            .logo { height: 28px; margin-bottom: 1rem; }
            h1 { font-size: 1.5rem; }
            .description { font-size: 0.9rem; }
            .glass-card { padding: 1.5rem 1rem; border-radius: 16px; }
            .icon-wrapper { width: 64px; height: 64px; border-radius: 16px; }
            .gear-icon { width: 28px; height: 28px; }
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
                <!-- Gear SVG Icon -->
                <svg class="gear-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/>
                </svg>
            </div>

            <div class="status-badge">
                <span class="pulse-dot"></span>
                Sedang Dalam Pemeliharaan
            </div>

            <h1>Kami Sedang Meningkatkan Layanan</h1>

            <p class="description">
                Website sedang dalam proses pemeliharaan berkala untuk memberikan
                pengalaman yang lebih baik. Kami akan segera kembali!
            </p>

            <div class="progress-section">
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <p class="progress-text">Proses pemeliharaan sedang berjalan...</p>
            </div>

            <div class="contact-section">
                <p>Ada pertanyaan mendesak? Hubungi kami di <a href="mailto:{{ config('mail.from.address', 'hello@solluapp.com') }}">{{ config('mail.from.address', 'hello@solluapp.com') }}</a></p>
            </div>
        </div>
    </div>
</body>
</html>
