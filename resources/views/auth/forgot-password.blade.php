<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Sandi - SIMLOG</title>

    <style>
        * { box-sizing: border-box; }

        body {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            background: #f5f3f2;
            color: #263445;
            font-family: Arial, Helvetica, sans-serif;
        }

        .auth-card {
            width: 100%;
            max-width: 430px;
            padding: 32px;
            border: 1px solid #e2e5e9;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(25, 30, 40, .07);
        }

        .brand {
            color: #762735;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
        }

        h1 {
            margin: 24px 0 8px;
            color: #1e293b;
            font-size: 20px;
            text-align: center;
        }

        .intro {
            margin: 0 0 24px;
            color: #526174;
            font-size: 14px;
            line-height: 1.6;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #334155;
            font-size: 14px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            color: #1e293b;
            font-size: 14px;
        }

        input:focus {
            outline: 2px solid rgba(118, 39, 53, .15);
            border-color: #762735;
        }

        .form-group { margin-bottom: 18px; }

        .button {
            width: 100%;
            min-height: 44px;
            border: 1px solid #762735;
            border-radius: 7px;
            background: #762735;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .button:hover { background: #5f1e2a; }

        .message {
            margin-bottom: 18px;
            padding: 12px;
            border-radius: 7px;
            font-size: 14px;
            line-height: 1.5;
        }

        .message--status {
            background: #f0fdf4;
            color: #166534;
        }

        .message--error {
            background: #fef2f2;
            color: #991b1b;
        }

        .back-link {
            display: block;
            margin-top: 18px;
            color: #762735;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
        }

        .back-link:hover { text-decoration: underline; }
    </style>
</head>

<body>
    <main class="auth-card">
        <div class="brand">SIMLOG</div>
        <h1>Lupa sandi?</h1>
        <p class="intro">Masukkan email akun Anda. Jika terdaftar, kami akan mengirimkan tautan untuk mengatur ulang sandi.</p>

        @if (session('status'))
            <div class="message message--status" role="status">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="message message--error" role="alert">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                    autofocus
                >
            </div>

            <button type="submit" class="button">Kirim tautan reset</button>
        </form>

        <a href="{{ route('login') }}" class="back-link">Kembali ke login</a>
    </main>
</body>

</html>
