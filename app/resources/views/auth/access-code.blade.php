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
                    <form action="{{ route('access-code.verify') }}" method="POST">
                        @csrf
                        <div>
                            <input type="text" name="code" id="code" placeholder="Enter Access Code" required autofocus>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger" style="font-size: 0.8rem; margin-top: 10px;">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <button type="submit" class="log_btn" style="width: 100%; border: none;">
                            Access Platform
                        </button>
                    </form>
                    
                    <div class="other-ways">
                        <div class="seperator">
                            <span class="ligne"></span>
                            <span class="ou">OR</span>
                            <span class="ligne"></span>
                        </div>
                        <div class="facebook-connection">
                            <a href="#">
                                <img src="{{ asset('images/facebook.png') }}" alt="facebook icon">
                                Sign in with Referral
                            </a>
                        </div>
                    </div>
                </div>
                <div class="sing-up border_insc">
                    <p>
                        Need an access code? 
                        <a href="#">Contact Admin</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>
</html>
