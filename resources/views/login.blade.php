<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quién Quiere Ser Millonario</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { height: 100%; overflow: hidden; }

    body {
      height: 100vh;
      background: radial-gradient(ellipse at 50% 30%, #1a1200 0%, #0a0a08 60%, #050505 100%);
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      font-family: 'Georgia', serif;
    }

    .bill {
      position: fixed; width: 56px; height: 28px;
      background: #1a5c2a; border-radius: 4px;
      border: 1.5px solid #2d8a40; opacity: 0;
      animation: fall linear infinite; pointer-events: none; z-index: 0;
    }
    .bill::after {
      content: '$'; position: absolute; top: 50%; left: 50%;
      transform: translate(-50%,-50%);
      color: #2d8a40; font-size: 14px; font-weight: bold; opacity: 0.6;
    }
    @keyframes fall {
      0%   { transform: translateY(-60px) rotate(var(--r)); opacity: 0; }
      10%  { opacity: 0.7; }
      90%  { opacity: 0.5; }
      100% { transform: translateY(110vh) rotate(calc(var(--r) + 180deg)) translateX(var(--dx)); opacity: 0; }
    }

    /* TÍTULO */
    .title-area { text-align: center; margin-bottom: 0.8rem; z-index: 10; position: relative; }
    .crown-row { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 2px; }
    .crown-icon { color: #d4a017; font-size: 20px; }
    .title-top { color: #d4a017; font-size: 11px; letter-spacing: 4px; text-transform: uppercase; }
    .title-main { color: #fff; font-size: 28px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; }
    .title-divider { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 4px; }
    .title-divider .line { width: 36px; height: 1px; background: #d4a017; opacity: 0.5; }
    .title-divider .dot { color: #d4a017; font-size: 7px; }

    /* FLIP */
    .flip-container { width: 100%; max-width: 380px; z-index: 10; position: relative; perspective: 1000px; }
    .flip-inner {
      position: relative; width: 100%;
      transform-style: preserve-3d;
      transition: transform 0.7s cubic-bezier(0.4, 0.2, 0.2, 1);
    }
    .flip-inner.flipped { transform: rotateY(180deg); }

    .card-face {
      width: 100%;
      background: rgba(18,16,12,0.95);
      border: 1px solid #2a2416; border-radius: 16px;
      padding: 1.6rem 1.8rem 1.4rem;
      backface-visibility: hidden;
      -webkit-backface-visibility: hidden;
      box-shadow: 0 0 60px rgba(212,160,23,0.07);
    }
    .card-back {
      position: absolute; top: 0; left: 0;
      transform: rotateY(180deg);
    }

    .card-header { text-align: center; margin-bottom: 1.2rem; }
    .crown-badge {
      width: 46px; height: 46px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 0.6rem; font-size: 20px;
      background: linear-gradient(135deg, #b8860b, #d4a017, #f0c040);
    }
    .crown-badge.green { background: linear-gradient(135deg, #1a5c2a, #2d8a40, #3aab50); }
    .card-title { color: #fff; font-size: 18px; font-weight: 600; margin-bottom: 3px; }
    .card-sub { color: #6b6045; font-size: 12px; }

    .field-label { color: #8a7040; font-size: 9px; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 4px; display: block; }
    .input-wrap { position: relative; margin-bottom: 0.75rem; }
    .input-icon { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #5a4a28; font-size: 15px; }
    .input-wrap input {
      width: 100%; background: rgba(255,255,255,0.04);
      border: 1px solid #2a2416; border-radius: 8px;
      padding: 9px 11px 9px 34px; color: #e8d898;
      font-size: 13px; outline: none; transition: border-color 0.2s;
      font-family: 'Georgia', serif;
    }
    .input-wrap input::placeholder { color: #3a3020; }
    .input-wrap input:focus { border-color: #d4a017; background: rgba(212,160,23,0.05); }
    .eye-btn {
      position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
      background: none; border: none; cursor: pointer; color: #4a3c1e; font-size: 15px; padding: 0;
    }

    .extras { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.2rem; }
    .remember { display: flex; align-items: center; gap: 5px; cursor: pointer; }
    .remember input[type=checkbox], .terms input[type=checkbox] { accent-color: #d4a017; width: 13px; height: 13px; }
    .remember span { color: #6b6045; font-size: 12px; }
    .forgot { color: #d4a017; font-size: 12px; cursor: pointer; background: none; border: none; font-family: 'Georgia', serif; }
    .forgot:hover { text-decoration: underline; }

    .terms { display: flex; align-items: flex-start; gap: 6px; margin-bottom: 1rem; }
    .terms input[type=checkbox] { margin-top: 2px; flex-shrink: 0; }
    .terms span { color: #6b6045; font-size: 11px; line-height: 1.5; }
    .terms a { color: #d4a017; text-decoration: none; }
    .terms a:hover { text-decoration: underline; }

    .row-2 { display: flex; gap: 10px; }
    .row-2 > div { flex: 1; }

    .btn-gold, .btn-green {
      width: 100%; border: none; border-radius: 8px; padding: 12px;
      font-size: 13px; font-weight: 700; letter-spacing: 2px;
      text-transform: uppercase; cursor: pointer;
      transition: opacity 0.2s, transform 0.1s; font-family: 'Georgia', serif;
    }
    .btn-gold { background: linear-gradient(135deg, #b8860b, #d4a017, #e8b820); color: #1a0e00; }
    .btn-green { background: linear-gradient(135deg, #1a5c2a, #2d8a40, #3aab50); color: #e8f5e9; }
    .btn-gold:hover, .btn-green:hover { opacity: 0.9; }
    .btn-gold:active, .btn-green:active { transform: scale(0.98); }

    .switch-line { text-align: center; margin-top: 0.7rem; font-size: 12px; color: #4a3c1e; }
    .switch-line a { color: #d4a017; font-weight: 600; cursor: pointer; text-decoration: none; }
    .switch-line a:hover { text-decoration: underline; }

    /* TABS y PREMIOS dentro del card al fondo */
    .card-footer { margin-top: 1rem; border-top: 1px solid #1e1a10; padding-top: 0.8rem; }

    .nav-tabs {
      display: flex; align-items: center; gap: 6px;
      justify-content: center; margin-bottom: 0.5rem;
    }
    .nav-tab {
      color: #4a3c1e; font-size: 12px; cursor: pointer;
      padding: 4px 12px; border-radius: 20px; transition: all 0.2s;
      background: none; border: none; font-family: 'Georgia', serif;
    }
    .nav-tab.active { color: #d4a017; background: rgba(212,160,23,0.1); }
    .nav-sep { color: #2a2010; font-size: 15px; }

    .prize-bar {
      display: flex; gap: 5px; align-items: baseline;
      justify-content: center; flex-wrap: wrap; margin-bottom: 0.3rem;
    }
    .prize { font-size: 10px; color: #2a2010; font-family: monospace; }
    .prize.hl { color: #d4a017; font-weight: 700; font-size: 11px; }

    .footer-copy { text-align: center; color: #1e1a0e; font-size: 10px; }

    .error-msg { color: #e05050; font-size: 11px; margin-bottom: 0.5rem; display: none; text-align: center; }
    .error-msg.show { display: block; }
  </style>
</head>
<body>

  <div class="title-area">
    <div class="crown-row">
      <span class="crown-icon">♛</span>
      <span class="title-top">Quién Quiere Ser</span>
      <span class="crown-icon">♛</span>
    </div>
    <div class="title-main">Millonario</div>
    <div class="title-divider">
      <span class="line"></span><span class="dot">◆</span><span class="line"></span>
    </div>
  </div>

  <div class="flip-container">
    <div class="flip-inner" id="flipper">

      <!-- FRENTE: LOGIN -->
      <div class="card-face card-front">
        <div class="card-header">
          <div class="crown-badge">♛</div>
          <div class="card-title">Bienvenido de vuelta</div>
          <div class="card-sub">¿Listo para ganar el millón?</div>
        </div>
        <div class="error-msg" id="login-error"></div>
        <label class="field-label">Correo electrónico</label>
        <div class="input-wrap">
          <i class="ti ti-mail input-icon"></i>
          <input type="email" id="login-email" placeholder="tu@correo.com" />
        </div>
        <label class="field-label">Contraseña</label>
        <div class="input-wrap">
          <i class="ti ti-lock input-icon"></i>
          <input type="password" id="login-pwd" placeholder="••••••••" />
          <button class="eye-btn" onclick="togglePwd('login-pwd','eye-login')" type="button">
            <i class="ti ti-eye" id="eye-login"></i>
          </button>
        </div>
        <div class="extras">
          <label class="remember">
            <input type="checkbox" /><span>Recordarme</span>
          </label>
          <button class="forgot" type="button">¿Olvidaste tu contraseña?</button>
        </div>
        <button class="btn-gold" onclick="handleLogin()" type="button">Iniciar Sesión</button>
        <div class="switch-line">¿No tienes cuenta? <a onclick="flip(true)">Regístrate aquí</a></div>
        <div class="card-footer">
          <div class="nav-tabs">
            <button class="nav-tab active" onclick="flip(false)" type="button">Iniciar Sesión</button>
            <span class="nav-sep">⇄</span>
            <button class="nav-tab" onclick="flip(true)" type="button">Registrarse</button>
          </div>
          <div class="prize-bar">
            <span class="prize">$500</span><span class="prize">$1K</span><span class="prize">$5K</span>
            <span class="prize">$10K</span><span class="prize">$50K</span><span class="prize">$100K</span>
            <span class="prize">$500K</span><span class="prize hl">$1M</span>
          </div>
          <div class="footer-copy">© 2026 Quién Quiere Ser Millonario</div>
        </div>
      </div>

      <!-- REVERSO: REGISTRO -->
      <div class="card-face card-back">
        <div class="card-header">
          <div class="crown-badge green">♛</div>
          <div class="card-title">Únete al Juego</div>
          <div class="card-sub">Crea tu cuenta y compite por el millón</div>
        </div>
        <div class="error-msg" id="register-error"></div>
        <div class="row-2">
          <div>
            <label class="field-label">Nombres</label>
            <div class="input-wrap">
              <i class="ti ti-user input-icon"></i>
              <input type="text" id="reg-nombres" placeholder="Nombres" />
            </div>
          </div>
          <div>
            <label class="field-label">Apellidos</label>
            <div class="input-wrap">
              <i class="ti ti-user input-icon"></i>
              <input type="text" id="reg-apellidos" placeholder="Apellidos" />
            </div>
          </div>
        </div>
        <label class="field-label">Correo electrónico</label>
        <div class="input-wrap">
          <i class="ti ti-mail input-icon"></i>
          <input type="email" id="reg-email" placeholder="tu@correo.com" />
        </div>
        <label class="field-label">Contraseña</label>
        <div class="input-wrap">
          <i class="ti ti-lock input-icon"></i>
          <input type="password" id="reg-pwd" placeholder="Mínimo 6 caracteres" />
          <button class="eye-btn" onclick="togglePwd('reg-pwd','eye-reg')" type="button">
            <i class="ti ti-eye" id="eye-reg"></i>
          </button>
        </div>
        <label class="terms">
          <input type="checkbox" id="reg-terms" />
          <span>Acepto los <a href="#">Términos y Condiciones</a> y la <a href="#">Política de Privacidad</a></span>
        </label>
        <button class="btn-green" onclick="handleRegister()" type="button">Crear Cuenta</button>
        <div class="switch-line">¿Ya tienes cuenta? <a onclick="flip(false)">Inicia sesión aquí</a></div>
        <div class="card-footer">
          <div class="nav-tabs">
            <button class="nav-tab" onclick="flip(false)" type="button">Iniciar Sesión</button>
            <span class="nav-sep">⇄</span>
            <button class="nav-tab active" onclick="flip(true)" type="button">Registrarse</button>
          </div>
          <div class="prize-bar">
            <span class="prize">$500</span><span class="prize">$1K</span><span class="prize">$5K</span>
            <span class="prize">$10K</span><span class="prize">$50K</span><span class="prize">$100K</span>
            <span class="prize">$500K</span><span class="prize hl">$1M</span>
          </div>
          <div class="footer-copy">© 2026 Quién Quiere Ser Millonario</div>
        </div>
      </div>

    </div>
  </div>

  <script>
    function flip(toRegister) {
      document.getElementById('flipper').classList.toggle('flipped', toRegister);
    }

    function togglePwd(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon  = document.getElementById(iconId);
      input.type  = input.type === 'password' ? 'text' : 'password';
      icon.className = input.type === 'text' ? 'ti ti-eye-off' : 'ti ti-eye';
    }

    async function handleLogin() {
      const email = document.getElementById('login-email').value.trim();
      const password = document.getElementById('login-pwd').value;
      const err = document.getElementById('login-error');
      err.classList.remove('show');
      if (!email || !password) { err.textContent = 'Completa todos los campos.'; err.classList.add('show'); return; }
      try {
        const res = await fetch('/api/login', { method:'POST', headers:{'Content-Type':'application/json','Accept':'application/json'}, body: JSON.stringify({email, password}) });
        const data = await res.json();
        if (!res.ok) { err.textContent = data.message || 'Credenciales incorrectas.'; err.classList.add('show'); return; }
        localStorage.setItem('token', data.token);
        window.location.href = '/iniciar-juego';
      } catch { err.textContent = 'Error de conexión.'; err.classList.add('show'); }
    }

    async function handleRegister() {
      const nombres   = document.getElementById('reg-nombres').value.trim();
      const apellidos = document.getElementById('reg-apellidos').value.trim();
      const email     = document.getElementById('reg-email').value.trim();
      const password  = document.getElementById('reg-pwd').value;
      const terms     = document.getElementById('reg-terms').checked;
      const err = document.getElementById('register-error');
      err.classList.remove('show');
      if (!nombres || !apellidos || !email || !password) { err.textContent = 'Completa todos los campos.'; err.classList.add('show'); return; }
      if (password.length < 6) { err.textContent = 'La contraseña debe tener mínimo 6 caracteres.'; err.classList.add('show'); return; }
      if (!terms) { err.textContent = 'Acepta los términos y condiciones.'; err.classList.add('show'); return; }
      try {
        const res = await fetch('/api/register', { method:'POST', headers:{'Content-Type':'application/json','Accept':'application/json'}, body: JSON.stringify({nombres, apellidos, email, password}) });
        const data = await res.json();
        if (!res.ok) { err.textContent = data.message || 'Error al crear la cuenta.'; err.classList.add('show'); return; }
        localStorage.setItem('token', data.token);
        window.location.href = '/iniciar-juego';
      } catch { err.textContent = 'Error de conexión.'; err.classList.add('show'); }
    }

    [{left:'8%',delay:'0s',dur:'7s',r:'-15deg',dx:'20px'},
     {left:'18%',delay:'1.5s',dur:'9s',r:'10deg',dx:'-30px'},
     {left:'75%',delay:'0.5s',dur:'8s',r:'20deg',dx:'15px'},
     {left:'85%',delay:'2s',dur:'6.5s',r:'-25deg',dx:'-20px'},
     {left:'5%',delay:'3s',dur:'10s',r:'5deg',dx:'10px'},
     {left:'92%',delay:'1s',dur:'7.5s',r:'-10deg',dx:'-25px'},
     {left:'30%',delay:'4s',dur:'8.5s',r:'30deg',dx:'5px'},
     {left:'60%',delay:'2.5s',dur:'9.5s',r:'-20deg',dx:'30px'},
     {left:'45%',delay:'0.8s',dur:'11s',r:'15deg',dx:'-10px'},
     {left:'70%',delay:'3.5s',dur:'7s',r:'-5deg',dx:'20px'},
     {left:'22%',delay:'5s',dur:'9s',r:'25deg',dx:'-15px'},
     {left:'55%',delay:'1.2s',dur:'6s',r:'-30deg',dx:'8px'},
    ].forEach(b => {
      const el = document.createElement('div');
      el.className = 'bill';
      el.style.cssText = `left:${b.left};top:-40px;animation-delay:${b.delay};animation-duration:${b.dur};--r:${b.r};--dx:${b.dx};`;
      document.body.appendChild(el);
    });
  </script>
</body>
</html>