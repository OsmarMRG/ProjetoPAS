<!DOCTYPE html>
<html lang="pt-PT">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PAX Security</title>

  <link rel="icon" type="image/jpeg" href="{{ asset('assets/logotipo_sem_slogan_fundo_branco-removebg-preview.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
</head>

<body id="navbar">

  <div id="cartDrawer" class="cart-drawer">
    <div class="cart-header">
      <h3>O teu Carrinho</h3>
      <span class="close-cart" onclick="toggleCart()">&times;</span>
    </div>

    <div id="cartItems" style="padding: 15px; max-height: 400px; overflow-y: auto;"></div>

    <div class="cart-footer" style="padding: 20px; border-top: 1px solid #333; margin-top: auto;">
      <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <span style="color: #aaa;">Total a pagar:</span>
        <span id="cartTotal" style="color: #2980B9; font-weight: bold; font-size: 1.2rem;">0.00€</span>
      </div>

      <button onclick="alert('Checkout em desenvolvimento')"
        style="width: 100%; background: #2980B9; color: white; border: none; padding: 12px; border-radius: 4px; cursor: pointer; font-weight: bold;">
        Ir para Payout
      </button>
    </div>
  </div>

  <header>
    <div style="display: flex; align-items: center; width: 100%;">
      <img class="img-l" src="{{ asset('assets/logotipo_sem_slogan_fundo_branco-removebg-preview.png') }}"
        style="width: 100px; height: 100px; margin-right: 10px;" alt="Logo">

      <h3 style="margin-right: 20px;">Pax Security</h3>

      <nav style="display: flex; align-items: center; flex-grow: 1;">
        <a href="#sobre" style="margin-left: 20px;">Sobre</a>
        <a href="#produtos" style="margin-left: 20px;">Produtos</a>
        <a href="#servicos" style="margin-left: 20px;">Serviços</a>
        <a href="{{ url('/aplicacao') }}" style="margin-left: 20px;">Aplicação</a>
        <a href="#contato" style="margin-left: 20px;">Contactos</a>

        <div class="auth-buttons" style="margin-left: auto; display: flex; gap: 10px;">
          <div class="nav-right-container">

            @auth
              <a class="btn-nav-outline" href="{{ route('area.camaras') }}">Área de Cliente</a>

              <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-nav-outline">Sair</button>
              </form>
            @else
              <button class="btn-nav-outline" type="button" onclick="abrirRegisto()">Registar</button>
              <a class="btn-nav-outline" href="{{ route('login.form') }}">Iniciar Sessão</a>
            @endauth

            <div class="cart-wrapper" onclick="toggleCart()" style="cursor: pointer;">
              <div class="cart-icon-bg">
                <i class="fas fa-shopping-cart" style="color: white; font-size: 18px;"></i>
                <span id="cartCount" class="cart-number">0</span>
              </div>
            </div>

          </div>
        </div>
      </nav>
    </div>
  </header>

  <section id="sobre" style="padding: 50px;">
    <h2 class="section-title" style="text-align: center;">Quem Somos</h2>

    <div style="display: flex; align-items: center; justify-content: space-between;">
      <div style="width: 45%; text-align: left;">
        <p class="text-p" style="justify-content: end;margin-left: 70px;">
          Somos alunos do curso de TWDM (Tecnologias Web e Dispositivos Móveis) e criámos a empresa PAX Security,
          especialistas em vigilância e proteção 24/7. Utilizamos tecnologia de ponta para garantir a segurança dos
          nossos clientes.Utilizamos tecnologia de ponta para garantir a segurança,
          tranquilidade e confiança dos nossos clientes, oferecendo soluções modernas e
          eficazes de monitorização residencial e comercial.
        </p>

        <button class="btn" onclick="mostrarMensagem()"
          style="margin-top: 20px; margin-left: 65%; width: 125px; height: 40px ;">
          Saiba mais
        </button>
      </div>

      <div style="width: 50%; text-align: center;">
        <img src="{{ asset('assets/amigos.jpg') }}" style="max-width: 100%; height: auto; margin-right: 70px;" alt="amigos1">
      </div>
    </div>
  </section>

  <section id="produtos" class="produtos">
    <h2 class="section-title">Produtos</h2>

    <div class="slider-container">
      <button class="slide-btn prev">&#10094;</button>

      <div class="cards-wrapper">
        <div class="card">
          <img src="{{ asset('assets/camara1.png') }}" style="height: 150px; width: 150px;" alt="Produto 1">
          <h3 style="color: black;">Camara Ihua</h3>
          <p>Descrição curta do produto.</p>
          <span class="preco">€39.99</span>
          <button class="btn-comprar"
            onclick="adicionarAoCarrinho('Camara Ihua', 39.99,'{{ asset('assets/camara1.png') }}')">
            Adicionar ao Carrinho
          </button>
        </div>

        <div class="card">
          <img src="{{ asset('assets/sensor1.png') }}" alt="Produto 2">
          <h3 style="color: black ;">Sensor de Movimento B.E.G</h3>
          <p>Mais um ótimo produto para segurança.</p>
          <span class="preco">€29.99</span>
          <button class="btn-comprar"
            onclick="adicionarAoCarrinho('Sensor de Movimento B.E.G', 29.99, '{{ asset('assets/sensor1.png') }}')">
            Adicionar ao Carrinho
          </button>
        </div>

        <div class="card">
          <img src="{{ asset('assets/camara2.png') }}" style="height: 150px; width: 150px;" alt="Produto 2">
          <h3 style="color: black;">Camara Foscam</h3>
          <p>Mais um ótimo produto para segurança.</p>
          <span class="preco">€59.99</span>
          <button class="btn-comprar"
            onclick="adicionarAoCarrinho('Camara Foscam', 59.99,'{{ asset('assets/camara2.png') }}')">
            Adicionar ao Carrinho
          </button>
        </div>

        <div class="card">
          <img src="{{ asset('assets/conjunto1.png') }}" style="height: 150px; width: 300px;" alt="Conjunto 1">
          <h3 style="color:black ;">Conjunto UF</h3>
          <p>Mais um ótimo produto para segurança.</p>
          <span class="preco">€129.99</span>
          <button class="btn-comprar"
            onclick="adicionarAoCarrinho('Conjunto UF', 129.99, '{{ asset('assets/conjunto1.png') }}')">
            Adicionar ao Carrinho
          </button>
        </div>

        <div class="card">
          <img src="{{ asset('assets/camara3.png') }}" style="height: 150px; width: 150px;" alt="Produto 3">
          <h3 style="color: black;">Camara TP-Link</h3>
          <p>Mais um ótimo produto para segurança.</p>
          <span class="preco">€49.99</span>
          <button class="btn-comprar"
            onclick="adicionarAoCarrinho('Camara TP-Link', 49.99, '{{ asset('assets/camara3.png') }}')">
            Adicionar ao Carrinho
          </button>
        </div>

        <div class="card">
          <img src="{{ asset('assets/sensor2.jpg') }}" alt="Produto 2">
          <h3 style="color: black;">Sensor de Movimento TP-Link</h3>
          <p>Mais um ótimo produto para segurança.</p>
          <span class="preco">€39.99</span>
          <button class="btn-comprar"
            onclick="adicionarAoCarrinho('Sensor de Movimento TP-Link', 39.99,'{{ asset('assets/sensor2.jpg') }}')">
            Adicionar ao Carrinho
          </button>
        </div>
      </div>

      <button class="slide-btn next">&#10095;</button>
    </div>
  </section>

  <section id="servicos">
    <h2 class="section-title" style="margin-bottom: 50px;">Nossos Serviços</h2>

    <div class="images-grid">
      <div>
        <img src="{{ asset('assets/Monitoramento-24h.png') }}" alt="Imagem 1">
      </div>
      <div>
        <img src="{{ asset('assets/servico-de-vigia-2000x1200.jpg') }}" style="height: 320px ; width: 475px;" alt="Imagem 2">
      </div>
      <div>
        <img src="{{ asset('assets/standard-quality-control-collage-concept-1-scaled.jpg') }}" alt="Imagem 3">
      </div>
    </div>

    <div style="display: flex; justify-content: space-between;">
      <h3 style="margin-left: 140px;">Monitoramento 24h</h3>
      <h3>Segurança Patrimonial</h3>
      <h3 style="margin-right: 140px;">Soluções Personalizadas</h3>
    </div>
  </section>

  <section class="quiz-section">
    <div class="quiz-container">
      <div class="quiz-main">
        <div class="quiz-header">
          <div class="progress-labels">
            <span id="label-step">Sobre a Instalação</span>
          </div>
          <div class="progress-bar">
            <div class="progress" id="progress"></div>
          </div>
          <span id="progress-percent">0%</span>
        </div>

        <form id="quizForm">
          <div class="quiz-step active" id="step1">
            <h3>O alarme é para casa ou empresa?</h3>
            <div class="quiz-options">
              <button type="button" class="opt-btn" onclick="nextStep(2, 'Casa')">Casa</button>
              <button type="button" class="opt-btn" onclick="nextStep(2, 'Empresa')">Empresa</button>
            </div>
          </div>

          <div class="quiz-step" id="step2">
            <h3 id="title-step2">Qual o tipo de imóvel?</h3>
            <div class="quiz-options" id="options-step2"></div>
            <button type="button" class="back-btn" onclick="prevStep(1)">← Voltar</button>
          </div>

          <div class="quiz-step" id="step3">
            <h3>É a sua residência principal ou secundária?</h3>
            <div class="quiz-options">
              <button type="button" class="opt-btn" onclick="nextStep(4, 'Principal')">Principal</button>
              <button type="button" class="opt-btn" onclick="nextStep(4, 'Secundária')">Secundária</button>
            </div>
            <button type="button" class="back-btn" onclick="prevStep(2)">← Voltar</button>
          </div>

          <div class="quiz-step" id="step4">
            <h3>Qual o código postal da residência?</h3>
            <div class="input-group-custom">
              <input type="text" id="zipcode" placeholder="ex. 0000-000" maxlength="8">

              <div id="erro-zipcode"
                style="color: #ff4d4d; font-size: 13px; display: none; margin-top: 5px; font-weight: bold; text-align: left;">
                Código postal inválido (use 0000-000).
              </div>

              <button type="button" class="btn-next-blue" onclick="validarPasso4()">Continuar <span>→</span></button>
            </div>
            <button type="button" class="back-btn" onclick="prevStep(3)">← Voltar</button>
          </div>

          <div class="quiz-step" id="step5">
            <h3>Onde enviamos o seu estudo de segurança?</h3>
            <div class="input-group-custom">
              <input type="email" id="quizEmail" placeholder="Teu melhor email" required>
              <button type="submit" class="btn-next-blue">Submeter <span>→</span></button>
            </div>
            <button type="button" class="back-btn" onclick="prevStep(4)">← Voltar</button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <section id="contato">
    <h2 class="section-title">Fale Connosco</h2>

    <div class="contact-container">
      <div class="contact-map">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3143.324267909384!2d-7.880223503210425!3d38.01621920000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd1a7487076244d7%3A0xa61299486a3e9763!2sInstituto%20Polit%C3%A9cnico%20de%20Beja%20-%20Escola%20Superior%20de%20Tecnologia%20e%20Gest%C3%A3o!5e0!3m2!1spt-PT!2spt!4v1750271329469!5m2!1spt-PT!2spt"
          allowfullscreen loading="lazy">
        </iframe>
      </div>

      <div class="contact-form">
        <h2 class="form-register-title">Registe-se</h2>
        <form id="registerForm">
          <div class="contact-field">
            <label>Nome Completo</label>
            <input type="text" id="nome" placeholder="Introduza o seu nome" required>
          </div>

          <div class="contact-field">
            <label>Endereço de e-mail</label>
            <input type="email" id="email" placeholder="Introduza o seu email" required>
          </div>

          <div class="contact-field">
            <label>Telemóvel</label>
            <input type="tel" id="telemovel" required>
            <div id="erro-telemovel"
              style="color: #ff4d4d; font-size: 13px; display: none; margin-top: 5px; font-weight: bold;">
              Número de telemóvel inválido.
            </div>
          </div>

          <button type="submit" class="contact-btn">Registar</button>
        </form>
      </div>
    </div>
  </section>

  <footer class="footer-compact">
    <div class="footer-container">
      <div class="footer-section">
        <h4>Contactos</h4>
        <div class="contact-item">
          <i class="fas fa-envelope"></i>
          <a>contactos@paxsecurity.com</a>
        </div>
        <div class="contact-item">
          <i class="fas fa-phone-alt"></i>
          <span>210 293 739 | 7800-295</span>
        </div>
      </div>

      <div class="footer-section">
        <h4>Desenvolvido por</h4>
        <div class="insta-links">
          <a href="https://www.instagram.com/_.diogosilva21_/" target="_blank">
            <i class="fab fa-instagram"></i> Diogo Silva
          </a>
          <a href="https://www.instagram.com/osmarmgoncalves/" target="_blank">
            <i class="fab fa-instagram"></i> Osmar Gonçalves
          </a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 <span>PAX Security</span>. Todos os direitos reservados.</p>
    </div>
  </footer>

  <script src="{{ asset('assets/js/script.js') }}"></script>

  <div id="registerOverlay" class="login-overlay">
    <div class="login-container">
      <button class="close-login" onclick="fecharRegisto()">×</button>
      <h2>Crie a sua conta PAX</h2>

      <form id="registerFormModal" class="login-form">
        <div class="input-group-login">
          <label>Nome Completo</label>
          <input type="text" id="nomeModal" placeholder="O seu nome" class="login-input" required>
        </div>

        <div class="input-group-login">
          <label>Endereço de e-mail</label>
          <input type="email" id="emailModal" placeholder="nome@exemplo.com" class="login-input" required>
        </div>

        <div class="input-group-login">
          <label>Telemóvel</label>
          <input type="tel" id="telemovelModal" class="login-input" style="width: 100%;" required>
        </div>

        <button type="submit" class="btn-primary-login">Criar Conta</button>
      </form>

      <p class="signup-text">Já tem conta? <a href="#" onclick="fecharRegisto();">Fechar</a></p>
    </div>
  </div>

  <div id="loginOverlay" class="login-overlay">
    <div class="login-container">
      <button class="close-login" onclick="fecharLogin()">&times;</button>
      <h2>Bem-vindo(a) de volta</h2>

      <div style="color:#aaa; font-size:14px; margin-bottom:12px;">
        O login real agora é na página do Laravel. Este pop up é só decoração. Tipo planta falsa.
      </div>

      <a href="{{ route('login.form') }}" class="btn-primary-login" style="display:block; text-align:center; text-decoration:none;">
        Ir para Login
      </a>

      <div class="login-footer" style="margin-top:14px;">
        <a>Termos de Utilização</a> | <a>Política de Privacidade</a>
      </div>
    </div>
  </div>

</body>
</html>
