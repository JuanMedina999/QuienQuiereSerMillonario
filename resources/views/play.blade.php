<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Quién quiere ser millonario?</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<div class="game-container">

    <!-- Info superior -->
    <div class="game-info">
        <span class="info-pill">Puntos acumulados: <strong id="total-score">0</strong></span>
        <span class="info-pill">Pregunta: <strong id="question-number">1 / 10</strong></span>
        <span class="info-pill">Puntos de esta pregunta: <strong id="points" style="color:#FFD700">0</strong></span>
    </div>

    <!-- La pregunta -->
    <div id="question">Cargando pregunta...</div>

    <!-- Barra de tiempo -->
    <div id="timer-bar-container">
        <div id="timer-bar"></div>
    </div>
    <div class="timer-label">Tiempo restante: <span id="time">--</span>s</div>

    <!-- Feedback (correcto / incorrecto / timeout) -->
    <div id="feedback"></div>

    <!-- Opciones de respuesta -->
    <div id="answers"></div>

</div>

<script>
const gameId = localStorage.getItem('game_id');

if (!gameId) {
    alert('No hay juego activo');
    window.location.href = '/iniciar-juego';
}

const LETTERS = ['A', 'B', 'C', 'D'];

let countdownInterval = null;
let timeLimit  = 0;
let timeSpent  = 0;
let answered   = false;

// ── Carga la pregunta actual ──────────────────────────────
async function loadQuestion() {
    answered = false;
    clearTimer();
    hideFeedback();

    try {
        const res  = await fetch(`/api/games/${gameId}/current-question`);
        const data = await res.json();

        if (!res.ok) {
            handleGameEnd(data);
            return;
        }

        renderQuestion(data);
        startTimer(data.time_limit);

    } catch (error) {
        console.error(error);
        alert('Error cargando la pregunta');
    }
}

// ── Renderiza pregunta y opciones ─────────────────────────
function renderQuestion(data) {
    document.getElementById('question').innerText        = data.question;
    document.getElementById('points').innerText          = data.points;
    document.getElementById('question-number').innerText = `${data.question_number} / 10`;

    const container = document.getElementById('answers');
    container.innerHTML = '';

    data.answers.forEach((ans, index) => {
        const btn = document.createElement('button');
        btn.dataset.id     = ans.id;
        btn.dataset.letter = LETTERS[index] ?? (index + 1);
        btn.innerText      = ans.answer_text;
        btn.onclick        = () => sendAnswer(ans.id);
        container.appendChild(btn);
    });
}

// ── Timer ─────────────────────────────────────────────────
function startTimer(seconds) {
    timeLimit = seconds;
    timeSpent = 0;
    updateTimerUI(seconds);

    countdownInterval = setInterval(() => {
        timeSpent++;
        const remaining = timeLimit - timeSpent;
        updateTimerUI(remaining);

        if (remaining <= 0) {
            clearTimer();
            handleTimeout();
        }
    }, 1000);
}

function updateTimerUI(remaining) {
    document.getElementById('time').innerText = Math.max(remaining, 0);

    const pct = Math.max((remaining / timeLimit) * 100, 0);
    const bar  = document.getElementById('timer-bar');
    bar.style.width = `${pct}%`;

    if (pct > 50)      bar.style.background = '#4CAF50';
    else if (pct > 25) bar.style.background = '#f39c12';
    else               bar.style.background = '#f44336';
}

function clearTimer() {
    if (countdownInterval) {
        clearInterval(countdownInterval);
        countdownInterval = null;
    }
}

// ── Timeout automático ────────────────────────────────────
async function handleTimeout() {
    if (answered) return;
    answered = true;

    disableAnswerButtons();
    showFeedback('⏰ ¡Tiempo agotado!', 'timeout');

    try {
        const res  = await fetch(`/api/games/${gameId}/timeout`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        });
        const data = await res.json();

        document.getElementById('total-score').innerText = data.total_score ?? 0;

        if (data.game_status === 'finished') {
            setTimeout(() => window.location.href = '/resultado', 2000);
        } else {
            setTimeout(() => loadQuestion(), 2000);
        }

    } catch (error) {
        console.error(error);
    }
}

// ── Envía respuesta ───────────────────────────────────────
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

        if (!res.ok) {
            alert(data.message || 'Error al responder');
            return;
        }

        document.getElementById('total-score').innerText = data.total_score ?? 0;

        if (data.result === 'correct') {
            showFeedback(`✅ ¡Correcto! +${data.earned_points} puntos`, 'correct');
            highlightButton(answerId, 'correct');
        } else if (data.result === 'timeout') {
            showFeedback('⏰ Respondiste fuera de tiempo', 'timeout');
        } else {
            showFeedback('❌ Respuesta incorrecta', 'incorrect');
        }

        if (data.game_status === 'finished') {
            setTimeout(() => window.location.href = '/resultado', 2000);
        } else {
            setTimeout(() => loadQuestion(), 2000);
        }

    } catch (error) {
        console.error(error);
        alert('Error enviando respuesta');
    }
}

// ── Helpers UI ────────────────────────────────────────────
function disableAnswerButtons() {
    document.querySelectorAll('#answers button').forEach(btn => btn.disabled = true);
}

function highlightButton(answerId, type) {
    document.querySelectorAll('#answers button').forEach(btn => {
        if (parseInt(btn.dataset.id) === answerId) {
            btn.classList.add(`btn-${type}`);
        }
    });
}

function showFeedback(message, type) {
    const fb = document.getElementById('feedback');
    fb.innerText   = message;
    fb.className   = `feedback-${type}`;
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