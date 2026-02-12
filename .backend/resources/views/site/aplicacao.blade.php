<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAX Security - Aplicação</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        .content-wrapper {
            padding: 120px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 60px;
        }

        .media-section {
            width: 100%;
            max-width: 1000px;
            text-align: center;
        }

        .media-section h2 {
            margin-bottom: 30px;
            color: #2980B9;
            font-family: sans-serif;
        }

        .app-image {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
            transition: transform 0.3s ease;
        }

        .app-image:hover {
            transform: scale(1.02);
        }

        .video-container video {
            width: 100%;
            border-radius: 12px;
            border: 1px solid #333;
            background: #000;
        }

        .back-btn {
            margin-top: 20px;
            padding: 10px 25px;
            background: transparent;
            border: 1px solid #2980B9;
            color: #2980B9;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: #2980B9;
            color: white;
        }
    </style>
</head>

<body>

<header>
    <div style="display: flex; align-items: center; width: 100%;">
        <img class="img-l"
             src="{{ asset('assets/logotipo_sem_slogan_fundo_branco-removebg-preview.png') }}"
             style="width: 100px; height: 100px; margin-right: 10px;"
             alt="Logo">

        <h3 style="margin-right: 20px;">Pax Security</h3>

        <nav style="display: flex; align-items: center; flex-grow: 1;">
            <a href="{{ url('/') }}#sobre" style="margin-left: 20px;">Sobre</a>
            <a href="{{ url('/') }}#produtos" style="margin-left: 20px;">Produtos</a>
            <a href="{{ url('/') }}#servicos" style="margin-left: 20px;">Serviços</a>
            <a href="{{ url('/aplicacao') }}" style="margin-left: 20px;">Aplicação</a>
            <a href="{{ url('/') }}#contato" style="margin-left: 20px;">Contactos</a>

            <div class="auth-buttons" style="margin-left: auto; display: flex; gap: 10px;">
                <button class="btn-nav">Registe-se</button>
                <button class="btn-nav login">Iniciar Sessão</button>
            </div>
        </nav>
    </div>
</header>

<nav class="navbar">
    <div class="logo">PAX Security</div>
    <ul class="nav-links">
        <li><a href="{{ url('/') }}">Início</a></li>
        <li><a href="{{ url('/aplicacao') }}">Aplicação</a></li>
    </ul>
</nav>

<section id="aplicacao">
    <h2 class="section-title" style="margin-bottom: 80px;">Aplicação Android</h2>

    <div style="display: flex; justify-content: space-between;">
        <h2 style="margin-left: 115px;">Página Login</h2>
        <h2 style="margin-left: 5px;">Página Notificações</h2>
        <h2 style="text-align: center;">Página Câmaras</h2>
        <h2 style="margin-right: 80px;">Página Definições</h2>
    </div>

    <div class="images-grid">
        <div>
            <img src="{{ asset('assets/pag_login.png') }}" style="width: 315px;" height="619px" alt="Página Login">
        </div>
        <div>
            <img src="{{ asset('assets/pag_notificacoes.png') }}" style="width: 315px;" height="619px" alt="Página Notificações">
        </div>
        <div>
            <img src="{{ asset('assets/pag_camaras.png') }}" style="width: 315px;" height="619px" alt="Página Câmaras">
        </div>
        <div>
            <img src="{{ asset('assets/pag_definicoes.png') }}" style="width: 315px;" height="619px" alt="Página Definições">
        </div>
    </div>
</section>

<section id="video">
    <h2 class="section-title" style="margin-bottom: 30px;">Vídeo da Aplicação</h2>

    <div>
        <video width="700px" height="420px" controls>
            <source src="{{ asset('assets/videoaplicacao.mp4') }}">
        </video>
    </div>
</section>

</body>
</html>
