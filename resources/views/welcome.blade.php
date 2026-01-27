<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        /* ================= GLOBAL RESET ================= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #f5f7fb;
            color: #1f2937;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }

        /* ================= HEADER / NAVBAR ================= */
        header {
            background: #ffffff;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 22px;
            font-weight: 700;
            color: #111827;
        }

        .nav a {
            text-decoration: none;
            margin-left: 15px;
        }

        /* ================= BUTTON STYLES ================= */
        .btn {
            background: #ff2d20;
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 6px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #e02417;
        }

        .btn-outline {
            border: 2px solid #ff2d20;
            padding: 8px 16px;
            border-radius: 6px;
            color: #ff2d20;
        }

        .btn-outline:hover {
            background: #ff2d20;
            color: #ffffff;
        }

        /* ================= HERO SECTION ================= */
        .hero {
            padding: 90px 0;
            background: linear-gradient(135deg, #ffffff, #ffecec);
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 40px;
        }

        .hero-text h1 {
            font-size: 44px;
            margin-bottom: 20px;
        }

        .hero-text p {
            font-size: 18px;
            margin-bottom: 25px;
            color: #555;
        }

        .hero img {
            width: 360px;
        }

        /* ================= FEATURES SECTION ================= */
        .features {
            padding: 70px 0;
            text-align: center;
        }

        .features h2 {
            margin-bottom: 40px;
            font-size: 32px;
        }

        .cards {
            display: flex;
            gap: 30px;
            justify-content: center;
        }

        .card {
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.06);
        }

        /* ================= FOOTER ================= */
        .footer {
            margin-top: 60px;
            background: #111827;
            color: #ffffff;
            text-align: center;
            padding: 30px 0;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 900px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
            }

            .cards {
                flex-direction: column;
                align-items: center;
            }

            .hero img {
                width: 250px;
            }
        }
    </style>
</head>
<body>

<!-- ================= HEADER ================= -->
<header>
    <div class="container nav">
        <!-- Logo / App Name -->
        <div class="logo">
            {{ config('app.name', 'Laravel') }}
        </div>

        <!-- Navigation Buttons -->
        <div>
            <a href="{{ route('login') }}" class="btn-outline">Login</a>
            <!-- <a href="#" class="btn">Get Started</a> -->
        </div>
    </div>
</header>

<!-- ================= HERO SECTION ================= -->
<section class="hero">
    <div class="container hero-content">
        <div class="hero-text">
            <h1>Build Modern Web Applications with Laravel</h1>
            <p>
                Clean architecture, powerful tools, and elegant syntax to build scalable applications faster than ever.
            </p>
            <a href="{{ route('login') }}" class="btn">Start Your Project</a>
        </div>

        <!-- Laravel Logo Image -->
        <div>
            <img src="https://laravel.com/img/logotype.min.svg" alt="Laravel Logo">
        </div>
    </div>
</section>

<!-- ================= FEATURES SECTION ================= -->
<section class="features">
    <div class="container">
        <h2>Why Choose Laravel?</h2>

        <div class="cards">
            <div class="card">
                <h3>MVC Structure</h3>
                <p>Organized code that is easy to scale and maintain for large applications.</p>
            </div>

            <div class="card">
                <h3>Authentication Ready</h3>
                <p>Pre-built authentication system saves development time.</p>
            </div>

            <div class="card">
                <h3>Rich Ecosystem</h3>
                <p>Queues, APIs, Testing, Caching and more built-in features.</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="footer">
    © {{ date('Y') }} {{ config('app.name') }} — Built with Laravel
</footer>

</body>
</html>
