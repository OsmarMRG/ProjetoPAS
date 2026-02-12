// ==========================================
// 1. CONFIGURAÇÕES E VARIÁVEIS GLOBAIS
// ==========================================
let carrinhoItems = [];
let iti;        // Para o formulário do fundo da página
let itiModal;   // Para o formulário do Modal (NOVO)
const API_URL = 'http://localhost:3000/api';

document.addEventListener('DOMContentLoaded', () => {
    console.log("Site PAX Security carregado com sucesso!");
});

// ==========================================
// 2. LÓGICA DO CARRINHO DE COMPRAS
// ==========================================
function toggleCart() {
    const drawer = document.getElementById('cartDrawer');
    if (drawer) drawer.classList.toggle('open');
}

function adicionarAoCarrinho(nome, preco, imagem) {
    const itemExistente = carrinhoItems.find(item => item.nome === nome);
    if (itemExistente) {
        itemExistente.quantidade++;
    } else {
        carrinhoItems.push({
            nome,
            preco: parseFloat(preco),
            imagem: imagem || 'assets/no-image.png',
            quantidade: 1
        });
    }
    atualizarInterfaceCarrinho();
}

function alterarQuantidade(nome, delta) {
    const item = carrinhoItems.find(i => i.nome === nome);
    if (item) {
        item.quantidade += delta;
        if (item.quantidade <= 0) {
            carrinhoItems = carrinhoItems.filter(i => i.nome !== nome);
        }
    }
    atualizarInterfaceCarrinho();
}

function atualizarInterfaceCarrinho() {
    const container = document.getElementById('cartItems');
    const totalElement = document.getElementById('cartTotal');
    const countElement = document.getElementById('cartCount');

    if (!container) return;
    container.innerHTML = "";
    let somaTotal = 0;

    carrinhoItems.forEach(item => {
        const subtotal = item.preco * item.quantidade;
        somaTotal += subtotal;

        container.innerHTML += `
            <div class="cart-item-row" style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px; background: #1a1a1a; padding: 10px; border-radius: 8px; border: 1px solid #333;">
                <img src="${item.imagem}" onerror="this.src='assets/no-image.png'" style="width: 45px; height: 45px; border-radius: 6px; object-fit: cover;">
                <div style="flex-grow: 1;">
                    <div style="color: white; font-weight: bold; font-size: 14px;">${item.nome}</div>
                    <div style="color: #2980B9; font-size: 13px;">${item.preco.toFixed(2)}€</div>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <button onclick="alterarQuantidade('${item.nome}', -1)" style="background: #444; color: white; border: none; width: 26px; height: 26px; border-radius: 4px; cursor: pointer;">-</button>
                    <span style="color: white; font-weight: bold;">${item.quantidade}</span>
                    <button onclick="alterarQuantidade('${item.nome}', 1)" style="background: #2980B9; color: white; border: none; width: 26px; height: 26px; border-radius: 4px; cursor: pointer;">+</button>
                </div>
            </div>`;
    });

    if (totalElement) totalElement.innerText = somaTotal.toFixed(2) + "€";
    if (countElement) countElement.innerText = carrinhoItems.reduce((acc, cur) => acc + cur.quantidade, 0);
}

// ==========================================
// 3. SLIDER DE PRODUTOS
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.querySelector('.cards-wrapper');
    const nextBtn = document.querySelector('.slide-btn.next');
    const prevBtn = document.querySelector('.slide-btn.prev');

    if (wrapper && nextBtn && prevBtn) {
        nextBtn.onclick = () => wrapper.scrollBy({ left: 350, behavior: 'smooth' });
        prevBtn.onclick = () => wrapper.scrollBy({ left: -350, behavior: 'smooth' });
    }
});

// ==========================================
// 4. SISTEMA DE QUIZ / ORÇAMENTO
// ==========================================
function validarPasso4() {
    const zipField = document.getElementById('zipcode');
    const erroZip = document.getElementById('erro-zipcode');
    const cp = zipField.value.trim();
    const cpRegex = /^\d{4}-\d{3}$/;

    if (!cpRegex.test(cp)) {
        if (erroZip) erroZip.style.display = 'block';
        if (zipField) zipField.style.borderColor = '#ff4d4d';
    } else {
        if (erroZip) erroZip.style.display = 'none';
        if (zipField) zipField.style.borderColor = '#444';
        nextStep(5);
    }
}

function nextStep(step, value) {
    document.querySelectorAll('.quiz-step').forEach(s => s.classList.remove('active'));
    const nextEl = document.getElementById('step' + step);
    if (nextEl) nextEl.classList.add('active');

    const percent = (step - 1) * 25;
    if (document.getElementById('progress')) document.getElementById('progress').style.width = percent + "%";
    if (document.getElementById('progress-percent')) document.getElementById('progress-percent').innerText = percent + "%";

    if (step === 2) montarEtapa2(value);
}

function montarEtapa2(tipo) {
    const container = document.getElementById('options-step2');
    const titulo = document.getElementById('title-step2');
    if (!container || !titulo) return;
    container.innerHTML = "";
    const opcoes = (tipo === 'Casa') ? ['Apartamento', 'Moradia', 'Outro'] : ['Loja', 'Armazém', 'Escritório'];
    titulo.innerText = (tipo === 'Casa') ? "Qual o tipo de residência?" : "Qual o tipo de negócio?";
    opcoes.forEach(opt => {
        container.innerHTML += `<button type="button" class="opt-btn" onclick="nextStep(3, '${opt}')">${opt}</button>`;
    });
}

// ==========================================
// 5. API E SUBMISSÕES
// ==========================================
async function enviarRegistoParaAPI(dados) {
    mostrarAlerta("Registo concluído com sucesso!", "");
    try {
        await fetch(`${API_URL}/register`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dados)
        });
    } catch (erro) {
        console.warn("API Offline");
    }
}

// Inicialização de Eventos
document.addEventListener('DOMContentLoaded', () => {
    // Formulário do Fundo da Página
    const telInput = document.getElementById('telemovel');
    if (telInput) {
        iti = window.intlTelInput(telInput, {
            initialCountry: "pt",
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    }

    const regForm = document.getElementById('registerForm');
    if (regForm) {
        regForm.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!iti.isValidNumber()) {
                document.getElementById('erro-telemovel').style.display = 'block';
                return;
            }
            mostrarAlerta("Registo concluído com sucesso!", "");
            regForm.reset();
        });
    }

    // Formulário do MODAL (Novo)
    const regFormModal = document.getElementById('registerFormModal');
    if (regFormModal) {
        regFormModal.addEventListener('submit', (e) => {
            e.preventDefault();
            mostrarAlerta("Registo concluído com sucesso!", "");
            fecharRegisto();
            regFormModal.reset();
        });
    }

    // Quiz
    const quizForm = document.getElementById('quizForm');
    if (quizForm) {
        quizForm.addEventListener('submit', (e) => {
            e.preventDefault();
            mostrarAlerta("Enviado com Sucesso!", "Entraremos em contacto brevemente.");
            quizForm.reset();
            setTimeout(() => { nextStep(1); }, 4500);
        });
    }

    // Máscara CP
    const inputCP = document.getElementById('zipcode');
    if (inputCP) {
        inputCP.addEventListener('input', (e) => {
            let val = e.target.value.replace(/\D/g, "");
            if (val.length > 4) val = val.slice(0, 4) + "-" + val.slice(4, 7);
            e.target.value = val;
        });
    }
});

// ==========================================
// 6. UI: MODAIS E ALERTAS
// ==========================================

// --- LOGIN ---
function abrirLogin() {
    document.getElementById('loginOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function fecharLogin() {
    document.getElementById('loginOverlay').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// --- REGISTO (MODAL) ---
function abrirRegisto() {
    document.getElementById('registerOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    const telModal = document.getElementById('telemovelModal');
    if (telModal && !itiModal) {
        itiModal = window.intlTelInput(telModal, {
            initialCountry: "pt",
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    }

    // Aplica o espaçamento largo APENAS ao campo de telemóvel
    setTimeout(() => {
        if (telModal) {
            telModal.style.setProperty('padding-left', '95px', 'important');
        }
    }, 10);
}

function fecharRegisto() {
    document.getElementById('registerOverlay').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// --- ALERTAS ---
function mostrarAlerta(titulo, subtitulo) {
    const alertaAntigo = document.querySelector('.pax-alerta');
    if (alertaAntigo) alertaAntigo.remove();

    const toast = document.createElement('div');
    toast.className = 'pax-alerta';
    toast.innerHTML = `
        <i class="fas fa-check-circle" style="font-size: 24px; margin-right: 15px; color: white;"></i>
        <div style="display: flex; flex-direction: column;">
            <span style="font-size: 16px; font-weight: bold; color: white;">${titulo}</span>
            ${subtitulo ? `<span style="font-size: 13px; color: rgba(255,255,255,0.9);">${subtitulo}</span>` : ''}
        </div>
    `;

    toast.style.cssText = `
        position: fixed; top: 120px; right: 25px; 
        background-color: #2980B9; padding: 16px 28px; 
        border-radius: 12px; z-index: 10001; 
        display: flex; align-items: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.4);
        transition: 0.5s; transform: translateX(100px); opacity: 0;
    `;

    document.body.appendChild(toast);
    setTimeout(() => { toast.style.opacity = "1"; toast.style.transform = "translateX(0)"; }, 100);
    setTimeout(() => {
        toast.style.opacity = "0";
        toast.style.transform = "translateX(100px)";
        setTimeout(() => toast.remove(), 500);
    }, 4500);
}

// Fecha modais ao clicar no fundo escuro
window.onclick = (e) => {
    if (e.target == document.getElementById('loginOverlay')) fecharLogin();
    if (e.target == document.getElementById('registerOverlay')) fecharRegisto();
};