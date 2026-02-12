<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PAX Security</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body style="min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px;">

    <div style="max-width:420px; width:100%; background:#111; padding:24px; border-radius:12px; border:1px solid #222;">
        <h2 style="margin-bottom:16px; color:#fff;">Iniciar Sessão</h2>

        @if ($errors->any())
            <div style="background:#2a0000; border:1px solid #ff4d4d; color:#ffb3b3; padding:10px; border-radius:8px; margin-bottom:14px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div style="margin-bottom:12px;">
                <label style="display:block; margin-bottom:6px; color:#ddd;">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required
                       style="width:100%; padding:10px; border-radius:8px; border:1px solid #333; background:#0b0b0b; color:#fff;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block; margin-bottom:6px; color:#ddd;">Password</label>
                <input name="password" type="password" required
                       style="width:100%; padding:10px; border-radius:8px; border:1px solid #333; background:#0b0b0b; color:#fff;">
            </div>

            <button type="submit"
                    style="width:100%; padding:12px; border:none; border-radius:8px; background:#2980B9; color:white; font-weight:bold; cursor:pointer;">
                Entrar
            </button>
        </form>

        <div style="margin-top:14px;">
            <a href="http://127.0.0.1:8000" style="color:#aaa; text-decoration:none;">← Voltar ao site</a>
        </div>
    </div>

</body>
</html>
