<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to NexGen Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #7C3AED;
            --secondary-color: #4F46E5;
            --accent-color: #EC4899;
            --dark-color: #1F2937;
            --light-color: #F3F4F6;
        }

        body {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            color: var(--light-color);
            overflow-x: hidden;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 100px 0;
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: slideInLeft 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            animation: slideInLeft 1s ease-out 0.3s backwards;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            margin: 1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.8s ease-out;
        }

        .feature-card:hover {
            transform: translateY(-10px) scale(1.02);
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-color);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cta-button {
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            animation: pulse 2s infinite;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(236, 72, 153, 0.3);
        }

        .nav-link {
            color: var(--light-color);
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(100px, 100px) rotate(360deg); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg glass-nav position-fixed w-100" style="z-index: 1000;">
        <div class="container">
            <a class="navbar-brand" href="#">NexGen Hub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Join Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="floating-shapes">
            <div class="shape" style="width: 300px; height: 300px; top: -150px; right: -100px;"></div>
            <div class="shape" style="width: 200px; height: 200px; bottom: -100px; left: -50px;"></div>
            <div class="shape" style="width: 150px; height: 150px; top: 50%; right: 10%;"></div>
        </div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Next-Gen Digital Experience</h1>
                    <p class="hero-subtitle">Unleash the power of innovation with our cutting-edge platform</p>
                    <a href="register.php" class="cta-button">Begin Your Journey</a>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/600x400" alt="Hero Image" class="img-fluid rounded-4 shadow-lg animate__animated animate__fadeInRight">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">⚡</div>
                        <h3>Lightning Speed</h3>
                        <p>Experience blazing-fast performance with our optimized infrastructure</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">🔒</div>
                        <h3>Fortress Security</h3>
                        <p>Bank-grade security protocols protecting your digital assets</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">🎯</div>
                        <h3>Smart Intelligence</h3>
                        <p>AI-powered features that adapt to your unique needs</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
