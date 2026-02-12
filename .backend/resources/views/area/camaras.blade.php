<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de Cliente - Câmaras</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body style="padding:20px; background:#0b0b0b; color:#fff;">

    <div style="max-width:900px; margin:0 auto;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:18px;">
            <h2 style="margin:0;">As minhas câmaras</h2>
            <div style="display:flex; gap:10px; align-items:center;">
                <span style="color:#bbb;">Olá {{ auth()->user()->username ?? auth()->user()->email }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button style="padding:10px 12px; background:#222; color:#fff; border:1px solid #333; border-radius:8px; cursor:pointer;">
                        Sair
                    </button>
                </form>
            </div>
        </div>

        @if (session('ok'))
            <div style="background:#0f2a12; border:1px solid #2ecc71; color:#bff5cf; padding:10px; border-radius:10px; margin-bottom:14px;">
                {{ session('ok') }}
            </div>
        @endif

        <form method="POST" action="{{ route('area.camaras.guardar') }}">
            @csrf

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:12px;">
                @foreach ($camaras as $c)
                    <label style="display:block; padding:14px; background:#111; border:1px solid #222; border-radius:12px; cursor:pointer;">
                        <div style="display:flex; gap:10px; align-items:flex-start;">
                            <input type="checkbox" name="camaras[]" value="{{ $c->id }}"
                                   {{ in_array($c->id, $selecionadas) ? 'checked' : '' }}
                                   style="margin-top:4px;">
                            <div>
                                <div style="font-weight:bold; margin-bottom:6px;">{{ $c->name }}</div>
                                <div style="color:#aaa; font-size:14px;">{{ $c->location }}</div>
                                @if($c->stream_url)
                                    <div style="color:#666; font-size:12px; margin-top:6px; word-break:break-all;">
                                        {{ $c->stream_url }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            <button type="submit"
                    style="margin-top:16px; width:100%; padding:12px; border:none; border-radius:10px; background:#2980B9; color:white; font-weight:bold; cursor:pointer;">
                Guardar selecção
            </button>
        </form>
    </div>

</body>
</html>
