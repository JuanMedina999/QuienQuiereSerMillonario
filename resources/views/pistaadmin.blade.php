<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Crear Pista — Quién Quiere Ser Millonario</title>
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

    .title-area { text-align: center; margin-bottom: 1rem; z-index: 10; position: relative; }
    .crown-row { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 2px; }
    .crown-icon { color: #d4a017; font-size: 20px; }
    .title-top { color: #d4a017; font-size: 11px; letter-spacing: 4px; text-transform: uppercase; }
    .title-main { color: #fff; font-size: 26px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; }
    .title-divider { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 4px; }
    .title-divider .line { width: 36px; height: 1px; background: #d4a017; opacity: 0.5; }
    .title-divider .dot { color: #d4a017; font-size: 7px; }

    .card {
      width: 100%; max-width: 460px;
      background: rgba(18,16,12,0.95);
      border: 1px solid #2a2416; border-radius: 16px;
      padding: 1.8rem 2rem;
      box-shadow: 0 0 60px rgba(212,160,23,0.07);
      z-index: 10; position: relative;
    }

    .card-header { text-align: center; margin-bottom: 1.4rem; }
    .crown-badge {
      width: 46px; height: 46px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 0.6rem; font-size: 22px;
      background: linear-gradient(135deg, #b8860b, #d4a017, #f0c040);
    }
    .card-title { color: #fff; font-size: 18px; font-weight: 600; margin-bottom: 3px; }
    .card-sub { color: #6b6045; font-size: 12px; }

    .field-label { color: #8a7040; font-size: 9px; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 4px; display: block; }

    .input-wrap { position: relative; margin-bottom: 1rem; }
    .input-icon { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #5a4a28; font-size: 15px; z-index: 1; }
    .input-wrap select {
      width: 100%; background: rgba(255,255,255,0.04);
      border: 1px solid #2a2416; border-radius: 8px;
      padding: 9px 11px 9px 34px; color: #e8d898;
      font-size: 13px; outline: none; transition: border-color 0.2s;
      font-family: 'Georgia', serif; appearance: none; cursor: pointer;
    }
    .input-wrap select:focus { border-color: #d4a017; background: rgba(212,160,23,0.05); }
    .input-wrap select option { background: #1a1200; color: #e8d898; }
    .input-wrap select:disabled { opacity: 0.4; cursor: not-allowed; }

    /* Flecha del select */
    .input-wrap::after {
      content: '▾'; position: absolute; right: 12px; top: 50%;
      transform: translateY(-50%); color: #5a4a28; pointer-events: none; font-size: 13px;
    }

    /* Preview pregunta */
    .preview-box {
      background: rgba(212,160,23,0.05);
      border: 1px solid #2a2416; border-radius: 8px;
      padding: 10px 14px; margin-bottom: 1rem;
      display: none;
    }
    .preview-box.show { display: block; }
    .preview-label { color: #6b6045; font-size: 10px; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 4px; }
    .preview-text { color: #e8d898; font-size: 13px; line-height: 1.5; }

    /* Spinner */
    .spinner { display: none; text-align: center; color: #6b6045; font-size: 12px; margin-bottom: 0.8rem; }
    .spinner.show { display: block; }

    .textarea-wrap { position: relative; margin-bottom: 0.3rem; }
    .textarea-icon { position: absolute; left: 11px; top: 12px; color: #5a4a28; font-size: 15px; }
    .textarea-wrap textarea {
      width: 100%; background: rgba(255,255,255,0.04);
      border: 1px solid #2a2416; border-radius: 8px;
      padding: 9px 11px 9px 34px; color: #e8d898;
      font-size: 13px; outline: none; transition: border-color 0.2s;
      font-family: 'Georgia', serif; resize: vertical; min-height: 80px;
    }
    .textarea-wrap textarea::placeholder { color: #3a3020; }
    .textarea-wrap textarea:focus { border-color: #d4a017; background: rgba(212,160,23,0.05); }

    .char-counter { text-align: right; font-size: 10px; color: #4a3c1e; margin-bottom: 1rem; }
    .char-counter.warn { color: #e05050; }

    .btn-gold {
      width: 100%; border: none; border-radius: 8px; padding: 12px;
      font-size: 13px; font-weight: 700; letter-spacing: 2px;
      text-transform: uppercase; cursor: pointer;
      background: linear-gradient(135deg, #b8860b, #d4a017, #e8b820);
      color: #1a0e00; font-family: 'Georgia', serif;
      transition: opacity 0.2s, transform 0.1s;
    }
    .btn-gold:hover { opacity: 0.9; }
    .btn-gold:active { transform: scale(0.98); }
    .btn-gold:disabled { opacity: 0.4; cursor: not-allowed; }

    .btn-back {
      width: 100%; border: 1px solid #2a2416; border-radius: 8px; padding: 10px;
      font-size: 12px; font-weight: 600; letter-spacing: 1px;
      text-transform: uppercase; cursor: pointer;
      background: transparent; color: #6b6045;
      font-family: 'Georgia', serif; margin-top: 0.6rem;
      transition: border-color 0.2s, color 0.2s;
    }
    .btn-back:hover { border-color: #d4a017; color: #d4a017; }

    .error-msg { color: #e05050; font-size: 11px; margin-bottom: 0.6rem; display: none; text-align: center; }
    .error-msg.show { display: block; }
    .success-msg { color: #3aab50; font-size: 11px; margin-bottom: 0.6rem; display: none; text-align: center; }
    .success-msg.show { display: block; }

    /* Separador de pasos */
    .steps { display: flex; align-items: center; justify-content: center; gap: 6px; margin-bottom: 1.2rem; }
    .step { display: flex; align-items: center; gap: 4px; font-size: 11px; color: #4a3c1e; }
    .step.active { color: #d4a017; }
    .step.done { color: #3aab50; }
    .step-num { width: 20px; height: 20px; border-radius: 50%; border: 1px solid currentColor; display: flex; align-items: center; justify-content: center; font-size: 10px; }
    .step-sep { color: #2a2010; }
  </style>
</head>
<body>

  <div class="title-area">
    <div class="crown-row">
      <span class="crown-icon">♛</span>
      <span class="title-top">Comodín</span>
      <span class="crown-icon">♛</span>
    </div>
    <div class="title-main">Crear Pista</div>
    <div class="title-divider">
      <span class="line"></span><span class="dot">◆</span><span class="line"></span>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <div class="crown-badge">💡</div>
      <div class="card-title">Nueva Pista</div>
      <div class="card-sub">Selecciona categoría → pregunta → escribe la pista</div>
    </div>

    <!-- Indicador de pasos -->
    <div class="steps">
      <div class="step active" id="step1">
        <span class="step-num">1</span> Categoría
      </div>
      <span class="step-sep">──</span>
      <div class="step" id="step2">
        <span class="step-num">2</span> Pregunta
      </div>
      <span class="step-sep">──</span>
      <div class="step" id="step3">
        <span class="step-num">3</span> Pista
      </div>
    </div>

    <div class="error-msg" id="error-msg"></div>
    <div class="success-msg" id="success-msg"></div>

    <!-- PASO 1: Categoría -->
    <label class="field-label">Categoría</label>
    <div class="input-wrap">
      <i class="ti ti-category input-icon"></i>
      <select id="select-categoria" onchange="cargarPreguntas()">
        <option value="">Selecciona una categoría...</option>
      </select>
    </div>

    <!-- PASO 2: Pregunta -->
    <label class="field-label">Pregunta</label>
    <div class="input-wrap">
      <i class="ti ti-help-circle input-icon"></i>
      <select id="select-pregunta" onchange="mostrarPregunta()" disabled>
        <option value="">Primero selecciona una categoría...</option>
      </select>
    </div>

    <div class="spinner" id="spinner">⏳ Cargando preguntas...</div>

    <!-- Preview -->
    <div class="preview-box" id="preview-box">
      <div class="preview-label">Pregunta seleccionada</div>
      <div class="preview-text" id="preview-text"></div>
    </div>

    <!-- PASO 3: Pista -->
    <label class="field-label">Pista</label>
    <div class="textarea-wrap">
      <i class="ti ti-bulb textarea-icon"></i>
      <textarea id="input-pista" placeholder="Escribe aquí la pista para esta pregunta..." maxlength="255" oninput="contarCaracteres()"></textarea>
    </div>
    <div class="char-counter" id="char-counter">0 / 255</div>

    <button class="btn-gold" id="btn-guardar" onclick="guardarPista()" type="button">💾 Guardar Pista</button>
    <button class="btn-back" onclick="history.back()" type="button">← Volver</button>
  </div>

  <script>
    const token = localStorage.getItem('token');

    // Cargar categorías al iniciar
    async function cargarCategorias() {
      try {
        const res = await fetch('/api/categories', {
          headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
        });
        const data = await res.json();
        const select = document.getElementById('select-categoria');
        const categorias = data.data || data;
        categorias.forEach(c => {
          const opt = document.createElement('option');
          opt.value = c.id;
          opt.textContent = c.name;
          select.appendChild(opt);
        });
      } catch (e) {
        console.error('Error cargando categorías:', e);
      }
    }

    // Cargar preguntas por categoría
    async function cargarPreguntas() {
      const categoriaId = document.getElementById('select-categoria').value;
      const selectPregunta = document.getElementById('select-pregunta');
      const spinner = document.getElementById('spinner');
      const preview = document.getElementById('preview-box');

      // Reset
      selectPregunta.innerHTML = '<option value="">Cargando preguntas...</option>';
      selectPregunta.disabled = true;
      preview.classList.remove('show');
      actualizarPasos(1);

      if (!categoriaId) {
        selectPregunta.innerHTML = '<option value="">Primero selecciona una categoría...</option>';
        return;
      }

      spinner.classList.add('show');

      try {
        const res = await fetch(`/api/questions/categoria/${categoriaId}`, {
          headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
        });
        const data = await res.json();
        const preguntas = data.data || data;

        selectPregunta.innerHTML = '<option value="">Selecciona una pregunta...</option>';

        if (!preguntas.length) {
          selectPregunta.innerHTML = '<option value="">No hay preguntas en esta categoría</option>';
        } else {
          preguntas.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = p.question.length > 55 ? p.question.substring(0, 55) + '...' : p.question;
            opt.dataset.full = p.question;
            selectPregunta.appendChild(opt);
          });
          selectPregunta.disabled = false;
          actualizarPasos(2);
        }
      } catch (e) {
        selectPregunta.innerHTML = '<option value="">Error cargando preguntas</option>';
        console.error(e);
      }

      spinner.classList.remove('show');
    }

    function mostrarPregunta() {
      const select = document.getElementById('select-pregunta');
      const preview = document.getElementById('preview-box');
      const text = document.getElementById('preview-text');
      if (select.value) {
        text.textContent = select.options[select.selectedIndex].dataset.full;
        preview.classList.add('show');
        actualizarPasos(3);
      } else {
        preview.classList.remove('show');
        actualizarPasos(2);
      }
    }

    function actualizarPasos(paso) {
      for (let i = 1; i <= 3; i++) {
        const el = document.getElementById('step' + i);
        el.classList.remove('active', 'done');
        if (i < paso) el.classList.add('done');
        else if (i === paso) el.classList.add('active');
      }
    }

    function contarCaracteres() {
      const pista = document.getElementById('input-pista').value;
      const counter = document.getElementById('char-counter');
      counter.textContent = pista.length + ' / 255';
      counter.classList.toggle('warn', pista.length > 220);
    }

    async function guardarPista() {
      const idPregunta = document.getElementById('select-pregunta').value;
      const pista = document.getElementById('input-pista').value.trim();
      const errEl = document.getElementById('error-msg');
      const sucEl = document.getElementById('success-msg');
      errEl.classList.remove('show');
      sucEl.classList.remove('show');

      if (!document.getElementById('select-categoria').value) { errEl.textContent = 'Selecciona una categoría.'; errEl.classList.add('show'); return; }
      if (!idPregunta) { errEl.textContent = 'Selecciona una pregunta.'; errEl.classList.add('show'); return; }
      if (!pista) { errEl.textContent = 'Escribe la pista.'; errEl.classList.add('show'); return; }

      const btn = document.getElementById('btn-guardar');
      btn.disabled = true;
      btn.textContent = 'Guardando...';

      try {
        const res = await fetch('/api/pistas', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + token
          },
          body: JSON.stringify({ idPregunta, pista })
        });
        const data = await res.json();
        if (!res.ok) {
          errEl.textContent = data.message || 'Error al guardar la pista.';
          errEl.classList.add('show');
        } else {
          sucEl.textContent = '✓ Pista guardada correctamente.';
          sucEl.classList.add('show');
          // Reset formulario
          document.getElementById('select-categoria').value = '';
          document.getElementById('select-pregunta').innerHTML = '<option value="">Primero selecciona una categoría...</option>';
          document.getElementById('select-pregunta').disabled = true;
          document.getElementById('input-pista').value = '';
          document.getElementById('preview-box').classList.remove('show');
          document.getElementById('char-counter').textContent = '0 / 255';
          actualizarPasos(1);
        }
      } catch {
        errEl.textContent = 'Error de conexión.';
        errEl.classList.add('show');
      }

      btn.disabled = false;
      btn.textContent = '💾 Guardar Pista';
    }

    // Billetes
    [{left:'8%',delay:'0s',dur:'7s',r:'-15deg',dx:'20px'},
     {left:'18%',delay:'1.5s',dur:'9s',r:'10deg',dx:'-30px'},
     {left:'75%',delay:'0.5s',dur:'8s',r:'20deg',dx:'15px'},
     {left:'85%',delay:'2s',dur:'6.5s',r:'-25deg',dx:'-20px'},
     {left:'5%',delay:'3s',dur:'10s',r:'5deg',dx:'10px'},
     {left:'92%',delay:'1s',dur:'7.5s',r:'-10deg',dx:'-25px'},
     {left:'55%',delay:'1.2s',dur:'6s',r:'-30deg',dx:'8px'},
    ].forEach(b => {
      const el = document.createElement('div');
      el.className = 'bill';
      el.style.cssText = `left:${b.left};top:-40px;animation-delay:${b.delay};animation-duration:${b.dur};--r:${b.r};--dx:${b.dx};`;
      document.body.appendChild(el);
    });

    cargarCategorias();
  </script>
</body>
</html>