<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram - Access Code</title>
    <link rel="stylesheet" href="{{ asset('sass/vender/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('sass/vender/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sass/main.css') }}">
</head>

<body>
    <div class="container">
        <div class="login">
            <div class="images d-none d-lg-block">
                <div class="frame">
                    <img src="{{ asset('images/home-phones.png') }}" alt="picutre frame">
                </div>
                <div class="sliders">
                    <div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/screenshot1.png') }}" class="d-block" alt="screenshot1">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/screenshot2.png') }}" class="d-block" alt="screenshot2">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/screenshot3.png') }}" class="d-block" alt="screenshot3">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/screenshot4.png') }}" class="d-block" alt="screenshot4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="log-on border_insc">
                    <div class="logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Instagram logo">
                    </div>
                    <div id="access-code-section">
                        <form action="{{ route('access-code.verify') }}" method="POST">
                            @csrf
                            <div>
                                <input type="text" name="code" id="code" placeholder="Enter Access Code"
                                    required autofocus>
                            </div>
                            @if ($errors->has('code'))
                                <div class="alert alert-danger" style="font-size: 0.8rem; margin-top: 10px;">
                                    {{ $errors->first('code') }}
                                </div>
                            @endif
                            <button type="submit" class="log_btn" style="width: 100%; border: none;">
                                Access Platform
                            </button>
                        </form>
                    </div>

                    <div id="login-section" style="display: none;">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div>
                                <input type="email" name="email" placeholder="Email Address" required>
                            </div>
                            <div style="margin-top: 10px;">
                                <input type="password" name="password" placeholder="Password" required>
                            </div>
                            @if ($errors->has('email'))
                                <div class="alert alert-danger" style="font-size: 0.8rem; margin-top: 10px;">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <button type="submit" class="log_btn" style="width: 100%; border: none; margin-top: 10px;">
                                Log In
                            </button>
                        </form>
                    </div>

                    <div class="other-ways">
                        <div class="seperator">
                            <span class="ligne"></span>
                            <span class="ou">OR</span>
                            <span class="ligne"></span>
                        </div>
                        <div class="facebook-connection">
                            <a href="javascript:void(0)" onclick="toggleAuthMode()" id="toggle-auth-btn">
                                <img src="{{ asset('images/facebook.png') }}" alt="icon"
                                    style="filter: grayscale(1);">
                                Sign in with Email/Password
                            </a>
                        </div>
                    </div>
                </div>
                <div class="sing-up border_insc">
                    <p id="auth-footer-text">
                        Need an access code?
                        <a href="#">Contact Admin</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleAuthMode() {
            const accessSection = document.getElementById('access-code-section');
            const loginSection = document.getElementById('login-section');
            const toggleBtn = document.getElementById('toggle-auth-btn');
            const footerText = document.getElementById('auth-footer-text');

            if (accessSection.style.display === 'none') {
                accessSection.style.display = 'block';
                loginSection.style.display = 'none';
                toggleBtn.innerHTML =
                    '<img src="{{ asset('images/facebook.png') }}" alt="icon" style="filter: grayscale(1);"> Sign in with Email/Password';
                footerText.innerHTML = 'Need an access code? <a href="#">Contact Admin</a>';
            } else {
                accessSection.style.display = 'none';
                loginSection.style.display = 'block';
                toggleBtn.innerHTML =
                    '<img src="{{ asset('images/facebook.png') }}" alt="icon" style="filter: grayscale(1);"> Enter Access Code instead';
                footerText.innerHTML =
                    'Don\'t have an account? <a href="javascript:void(0)" onclick="toggleAuthMode()">Enter Access Code</a>';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>

</html>
