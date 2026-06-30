<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Quién quiere ser millonario?</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            background: #06060f;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Rajdhani', sans-serif;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 50% at 50% -10%, rgba(218,165,32,0.15) 0%, transparent 65%),
                radial-gradient(ellipse 50% 40% at 50% 110%, rgba(20,50,200,0.2) 0%, transparent 65%);
            pointer-events: none;
        }

        #stars { position: fixed; inset: 0; pointer-events: none; z-index: 0; }
        .star {
            position: absolute;
            background: rgba(218,165,32,0.6);
            border-radius: 50%;
            animation: twinkle var(--d,3s) var(--delay,0s) infinite;
        }
        @keyframes twinkle { 0%,100% { opacity:.15; } 50% { opacity:1; } }

        .game-container {
            position: relative;
            z-index: 1;
            width: 90%;
            max-width: 740px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(218,165,32,0.18);
            border-radius: 16px;
            backdrop-filter: blur(8px);
            padding: 2rem 2rem 2.5rem;
        }

        .game-info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 1.4rem;
        }
        .info-pill {
            background: rgba(218,165,32,0.08);
            border: 1px solid rgba(218,165,32,0.2);
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 13px;
            color: rgba(255,255,255,0.75);
            letter-spacing: .05em;
        }
        .info-pill strong { color: #fff; }

        #question {
            background: rgba(10,20,80,0.55);
            border: 1px solid rgba(218,165,32,0.25);
            border-radius: 10px;
            padding: 1.2rem 1.4rem;
            font-size: 18px;
            color: #fff;
            text-align: center;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        #timer-bar-container {
            height: 8px;
            background: rgba(255,255,255,0.1);
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 6px;
        }
        #timer-bar {
            height: 100%;
            width: 100%;
            background: #4CAF50;
            transition: width .9s linear, background .9s linear;
            border-radius: 4px;
        }
        .timer-label {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
            margin-bottom: 1rem;
        }
        .timer-label span { color: #FFD700; font-weight: 600; }

        /* COMODINES */
        .comodines-bar {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        .btn-comodin {
            display: flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #1a1400, #2a2000);
            border: 1px solid rgba(218,165,32,0.35);
            border-radius: 20px;
            padding: 7px 16px;
            color: #daa520;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            letter-spacing: .05em;
        }
        .btn-comodin:hover:not(:disabled) {
            background: linear-gradient(135deg, #2a2000, #3a3000);
            border-color: #daa520;
            box-shadow: 0 0 12px rgba(218,165,32,0.2);
        }
        .btn-comodin:disabled {
            opacity: 0.35;
            cursor: not-allowed;
            filter: grayscale(1);
        }
        .btn-comodin .comodin-icon { font-size: 16px; }

        /* FEEDBACK */
        #feedback {
            display: none;
            text-align: center;
            font-size: 15px;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 1rem;
            letter-spacing: .05em;
        }
        .feedback-correct   { background: rgba(76,175,80,0.15);  color: #4CAF50; border: 1px solid rgba(76,175,80,0.3);  }
        .feedback-incorrect { background: rgba(244,67,54,0.15);  color: #f44336; border: 1px solid rgba(244,67,54,0.3); }
        .feedback-timeout   { background: rgba(255,152,0,0.15);  color: #ff9800; border: 1px solid rgba(255,152,0,0.3);  }

        /* RESPUESTAS */
        #answers { display: flex; flex-direction: column; gap: 10px; }
        #answers button {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(10,20,80,0.4);
            border: 1px solid rgba(218,165,32,0.2);
            border-radius: 8px;
            padding: 14px 18px;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
            transition: all .2s;
            text-align: left;
            font-family: inherit;
        }
        #answers button:hover:not(:disabled) {
            background: rgba(218,165,32,0.12);
            border-color: rgba(218,165,32,0.5);
        }
        #answers button:disabled { cursor: not-allowed; }
        #answers button .letter {
            width: 30px; height: 30px;
            border-radius: 50%;
            border: 2px solid #daa520;
            color: #daa520;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; flex-shrink: 0;
        }
        .btn-correct   { background: rgba(76,175,80,0.2)  !important; border-color: #4CAF50 !important; }
        .btn-incorrect { background: rgba(244,67,54,0.2)  !important; border-color: #f44336 !important; }
        .btn-eliminated { opacity: 0.2 !important; pointer-events: none !important; }

        /* MODALES */
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.8);
            align-items: center; justify-content: center;
            z-index: 100;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background: #0e0c08;
            border: 1px solid #daa520;
            border-radius: 14px;
            padding: 2rem 2rem 1.5rem;
            max-width: 420px; width: 90%;
            text-align: center;
            box-shadow: 0 0 40px rgba(218,165,32,0.15);
        }
        .modal-icon  { font-size: 36px; margin-bottom: 0.8rem; }
        .modal-title { color: #daa520; font-size: 14px; letter-spacing: .15em; text-transform: uppercase; margin-bottom: 1rem; }
        .modal-body  {
            color: #e8d898; font-size: 16px; line-height: 1.7;
            background: rgba(218,165,32,0.05);
            border: 1px solid rgba(218,165,32,0.15);
            border-radius: 8px; padding: 1rem; margin-bottom: 1.2rem;
        }
        .modal-box button {
            background: linear-gradient(135deg, #b8860b, #daa520);
            color: #0a0a1a; border: none;
            padding: 10px 28px; border-radius: 8px;
            cursor: pointer; font-weight: 700;
            font-size: 13px; letter-spacing: .1em;
            text-transform: uppercase; transition: opacity .2s;
        }
        .modal-box button:hover { opacity: 0.85; }
    </style>
</head>
<body>

<div id="stars"></div>

<div class="game-container">

    <div class="game-info">
        <span class="info-pill">Puntos acumulados: <strong id="total-score">0</strong></span>
        <span class="info-pill">Pregunta: <strong id="question-number">1 / 10</strong></span>
        <span class="info-pill">Puntos de esta pregunta: <strong id="points" style="color:#FFD700">0</strong></span>
    </div>

    <div id="question">Cargando pregunta...</div>

    <div id="timer-bar-container"><div id="timer-bar"></div></div>
    <div class="timer-label">Tiempo restante: <span id="time">--</span>s</div>

    <!-- Comodines -->
    <div class="comodines-bar">
        <button class="btn-comodin" id="btn-pista" onclick="usarPista()">
            <span class="comodin-icon">💡</span> Pista
        </button>
        <button class="btn-comodin" id="btn-cambio" onclick="cambiarPregunta()">
            <span class="comodin-icon">🔄</span> Cambiar Pregunta
        </button>
        <button class="btn-comodin" id="btn-5050" onclick="usarCincuentaCincuenta()">
            <span class="comodin-icon">🎯</span> 50/50
        </button>
    </div>

    <div id="feedback"></div>
    <div id="answers"></div>

</div>

<!-- Modal Pista -->
<div class="modal-overlay" id="modal-pista">
    <div class="modal-box">
        <div class="modal-icon">💡</div>
        <div class="modal-title">Comodín — Pista</div>
        <div class="modal-body" id="modal-pista-texto"></div>
        <button onclick="cerrarModal('modal-pista')">Entendido</button>
    </div>
</div>

<!-- Modal Cambiar Pregunta -->
<div class="modal-overlay" id="modal-cambio">
    <div class="modal-box">
        <div class="modal-icon">🔄</div>
        <div class="modal-title">Comodín — Cambiar Pregunta</div>
        <div class="modal-body">¿Estás seguro de que quieres cambiar esta pregunta? <br><strong style="color:#daa520">Solo puedes hacerlo una vez.</strong></div>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button onclick="confirmarCambio()">Sí, cambiar</button>
            <button onclick="cerrarModal('modal-cambio')" style="background:rgba(255,255,255,0.1);color:#fff;">Cancelar</button>
        </div>
    </div>
</div>

<script>
    // Estrellas
    const starsEl = document.getElementById('stars');
    for (let i = 0; i < 50; i++) {
        const s = document.createElement('div');
        s.className = 'star';
        const size = Math.random() > .75 ? '3px' : '2px';
        s.style.cssText = `left:${Math.random()*100}%;top:${Math.random()*100}%;width:${size};height:${size};--d:${(2+Math.random()*3).toFixed(1)}s;--delay:${(Math.random()*3).toFixed(1)}s;`;
        starsEl.appendChild(s);
    }

    const gameId = localStorage.getItem('game_id');
    if (!gameId) { alert('No hay juego activo'); window.location.href = '/iniciar-juego'; }

    const LETTERS = ['A', 'B', 'C', 'D'];
    let countdownInterval = null;
    let timeLimit   = 0;
    let timeSpent   = 0;
    let answered    = false;
    let questionId  = null;
    let pistaUsada  = false;
    let cambioUsado = false;
    let cincuentaUsado = false;

    // ── Carga pregunta ────────────────────────────────────
    async function loadQuestion() {
        answered   = false;
        pistaUsada = false;
        clearTimer();
        hideFeedback();

        // Reactivar pista en cada pregunta (pero no cambio ni 50/50)
        if (!pistaUsada) document.getElementById('btn-pista').disabled = false;
        if (cambioUsado) document.getElementById('btn-cambio').disabled = true;
        if (cincuentaUsado) document.getElementById('btn-5050').disabled = true;

        try {
            const res  = await fetch(`/api/games/${gameId}/current-question`);
            const data = await res.json();
            if (!res.ok) { handleGameEnd(data); return; }
            renderQuestion(data);
            startTimer(data.time_limit);
        } catch (e) {
            console.error(e);
            alert('Error cargando la pregunta');
        }
    }

    // ── Renderiza pregunta ────────────────────────────────
    function renderQuestion(data) {
        questionId = data.question_id ?? data.id;

        document.getElementById('question').innerText        = data.question;
        document.getElementById('points').innerText          = data.points;
        document.getElementById('question-number').innerText = `${data.question_number} / 10`;

        const container = document.getElementById('answers');
        container.innerHTML = '';

        data.answers.forEach((ans, index) => {
            const btn = document.createElement('button');
            btn.dataset.id = ans.id;
            btn.innerHTML  = `<span class="letter">${LETTERS[index] ?? index+1}</span>${ans.answer_text}`;
            btn.onclick    = () => sendAnswer(ans.id);
            container.appendChild(btn);
        });
    }

    // ── Timer ─────────────────────────────────────────────
    function startTimer(seconds) {
        timeLimit = seconds;
        timeSpent = 0;
        updateTimerUI(seconds);
        countdownInterval = setInterval(() => {
            timeSpent++;
            const remaining = timeLimit - timeSpent;
            updateTimerUI(remaining);
            if (remaining <= 0) { clearTimer(); handleTimeout(); }
        }, 1000);
    }

    function updateTimerUI(remaining) {
        document.getElementById('time').innerText = Math.max(remaining, 0);
        const pct = Math.max((remaining / timeLimit) * 100, 0);
        const bar = document.getElementById('timer-bar');
        bar.style.width = `${pct}%`;
        if (pct > 50)      bar.style.background = '#4CAF50';
        else if (pct > 25) bar.style.background = '#f39c12';
        else               bar.style.background = '#f44336';
    }

    function clearTimer() {
        if (countdownInterval) { clearInterval(countdownInterval); countdownInterval = null; }
    }

    // ── Timeout ───────────────────────────────────────────
    async function handleTimeout() {
        if (answered) return;
        answered = true;
        disableAnswerButtons();
        showFeedback('⏰ ¡Tiempo agotado!', 'timeout');
        try {
            const res  = await fetch(`/api/games/${gameId}/timeout`, { method: 'POST', headers: { 'Content-Type': 'application/json' } });
            const data = await res.json();
            document.getElementById('total-score').innerText = data.total_score ?? 0;
            if (data.game_status === 'finished') setTimeout(() => window.location.href = '/resultado', 2000);
            else setTimeout(() => loadQuestion(), 2000);
        } catch (e) { console.error(e); }
    }

    // ── Envía respuesta ───────────────────────────────────
    async function sendAnswer(answerId) {
        if (answered) return;
        answered = true;
        clearTimer();
        disableAnswerButtons();
        try {
            const res  = await fetch(`/api/games/${gameId}/answer`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ answer_id: answerId, time_spent: timeSpent })
            });
            const data = await res.json();
            if (!res.ok) { alert(data.message || 'Error al responder'); return; }
            document.getElementById('total-score').innerText = data.total_score ?? 0;
            if (data.result === 'correct') {
                showFeedback(`✅ ¡Correcto! +${data.earned_points} puntos`, 'correct');
                highlightButton(answerId, 'correct');
            } else if (data.result === 'timeout') {
                showFeedback('⏰ Respondiste fuera de tiempo', 'timeout');
            } else {
                showFeedback('❌ Respuesta incorrecta', 'incorrect');
                highlightButton(answerId, 'incorrect');
            }
            if (data.game_status === 'finished') setTimeout(() => window.location.href = '/resultado', 2000);
            else setTimeout(() => loadQuestion(), 2000);
        } catch (e) { console.error(e); alert('Error enviando respuesta'); }
    }

    // ── Comodín Pista ─────────────────────────────────────
    async function usarPista() {
        if (pistaUsada || !questionId) return;
        try {
            const res  = await fetch(`/api/pistas/${questionId}?game_id=${gameId}`);
            const data = await res.json();
            if (!res.ok) { alert(data.message || 'Esta pregunta no tiene pista disponible'); return; }
            pistaUsada = true;
            document.getElementById('btn-pista').disabled = true;
            document.getElementById('modal-pista-texto').innerText = data.data.pista;
            document.getElementById('modal-pista').classList.add('show');
        } catch (e) { console.error(e); alert('Error al obtener la pista'); }
    }

    // ── Comodín Cambiar Pregunta ──────────────────────────
    function cambiarPregunta() {
        if (cambioUsado || answered) return;
        document.getElementById('modal-cambio').classList.add('show');
    }

    async function confirmarCambio() {
        cerrarModal('modal-cambio');
        try {
            const res  = await fetch(`/api/games/${gameId}/cambiar-pregunta`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }
            });
            const data = await res.json();
            if (!res.ok) { alert(data.message || 'No puedes usar este comodín'); return; }
            cambioUsado = true;
            document.getElementById('btn-cambio').disabled = true;
            clearTimer();
            hideFeedback();
            answered = false;
            renderQuestion(data);
            startTimer(data.time_limit);
        } catch (e) { console.error(e); alert('Error al cambiar la pregunta'); }
    }

    // ── Comodín 50/50 ─────────────────────────────────────
    async function usarCincuentaCincuenta() {
        if (cincuentaUsado || answered || !questionId) return;
        try {
            const res  = await fetch(`/api/games/${gameId}/fifty-fifty`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ question_id: questionId })
            });
            const data = await res.json();
            if (!res.ok) { alert(data.message || 'No puedes usar este comodín'); return; }
            cincuentaUsado = true;
            document.getElementById('btn-5050').disabled = true;
            const remainingIds = data.remaining_options.map(a => a.id);
            document.querySelectorAll('#answers button').forEach(btn => {
                if (!remainingIds.includes(parseInt(btn.dataset.id))) {
                    btn.classList.add('btn-eliminated');
                    btn.disabled = true;
                }
            });
        } catch (e) { console.error(e); alert('Error usando 50/50'); }
    }

    // ── Helpers UI ────────────────────────────────────────
    function cerrarModal(id) { document.getElementById(id).classList.remove('show'); }

    function disableAnswerButtons() {
        document.querySelectorAll('#answers button').forEach(btn => btn.disabled = true);
    }

    function highlightButton(answerId, type) {
        document.querySelectorAll('#answers button').forEach(btn => {
            if (parseInt(btn.dataset.id) === answerId) btn.classList.add(`btn-${type}`);
        });
    }

    function showFeedback(message, type) {
        const fb = document.getElementById('feedback');
        fb.innerText = message;
        fb.className = `feedback-${type}`;
        fb.style.display = 'block';
    }

    function hideFeedback() {
        const fb = document.getElementById('feedback');
        fb.style.display = 'none';
        fb.className = '';
    }

    function handleGameEnd(data) {
        alert(data.message || 'Juego terminado');
        window.location.href = '/resultado';
    }

    loadQuestion();
</script>
</body>
</html>