@extends('layouts.app')

@section('content')
    <div class="login">
        <div class="content">
            <div class="log-on">
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    <p>Sign up to see photos and videos from your friends.</p>
                </div>

                <form action="{{ route('register.store') }}" method="POST">
                    @csrf
                    <div>
                        <input type="text" name="name" placeholder="Full Name" required>
                    </div>
                    <div>
                        <input type="email" name="name" placeholder="Email" required>
                    </div>

                    <div style="margin-top: 15px;">
                        <label style="font-size: 12px; color: #8e8e8e; display: block; margin-bottom: 5px;">Payment
                            Preference</label>
                        <select name="payment_preference"
                            style="width: 100%; padding: 9px; border: 1px solid #dbdbdb; border-radius: 5px; background: #fafafa; font-size: 12px;"
                            required onchange="toggleWallet(this.value)">
                            <option value="bank">Bank Transfer (AED)</option>
                            <option value="usdt">USDT (Crypto)</option>
                        </select>
                    </div>

                    <div id="wallet_field" style="display: none; margin-top: 10px;">
                        <input type="text" name="usdt_wallet_address" placeholder="TRC20 Wallet Address">
                    </div>

                    <button type="submit" class="log_btn" style="margin-top: 20px;">Sign up</button>
                </form>

                <div class="sing-up">
                    <p>By signing up, you agree to our Terms, Data Policy and Cookies Policy.</p>
                </div>
            </div>

            <div class="sing-in">
                <p>Have an account? <a href="{{ route('access-code.show') }}">Log in</a></p>
            </div>
        </div>
    </div>

    <script>
        function toggleWallet(val) {
            document.getElementById('wallet_field').style.display = val === 'usdt' ? 'block' : 'none';
        }
    </script>
@endsection
