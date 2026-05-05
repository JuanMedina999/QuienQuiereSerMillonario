<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Final - ¿Quién quiere ser millonario?</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<div class="result-container">
    <h1>🏆 RESULTADO FINAL 🏆</h1>

    <div class="stats-card">
        <div class="stat-item">
            <div class="stat-label">PUNTAJE TOTAL</div>
            <div class="stat-value" id="score">0</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">ESTADO</div>
            <div class="stat-value" id="status">-</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">RESPUESTAS CORRECTAS</div>
            <div class="stat-value correct" id="correctCount">0</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">INCORRECTAS / TIMEOUT</div>
            <div class="stat-value incorrect" id="incorrectCount">0</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">TIEMPO AGOTADO</div>
            <div class="stat-value timeout" id="timeoutCount">0</div>
        </div>
    </div>

    <h2>📋 Resumen de preguntas</h2>
    <div id="questions" class="questions-list"></div>

    <div class="action-buttons">
        <button class="btn btn-secondary" onclick="volverAlMenu()">
            🏠 Volver al menú principal
        </button>
        <button class="btn btn-primary" onclick="jugarDeNuevo()">
            🎮 Jugar de nuevo
        </button>
    </div>
</div>

<script>
const gameId = localStorage.getItem('game_id');

if (!gameId) {
    alert('No hay un juego finalizado para mostrar');
    window.location.href = '/iniciar-juego';
}

async function loadResult() {
    try {
        const res  = await fetch(`/api/games/${gameId}/result`);
        const data = await res.json();

        if (!res.ok) {
            alert('Error cargando los resultados');
            window.location.href = '/iniciar-juego';
            return;
        }

        // ── Estadísticas principales ──────────────────────────
        document.getElementById('score').innerText = data.score || 0;

        const statusMap = { 'finished': 'FINALIZADO', 'playing': 'EN CURSO' };
        document.getElementById('status').innerText =
            statusMap[data.status] || (data.status?.toUpperCase() ?? 'TERMINADO');

        // ── Conteo por estado ─────────────────────────────────
        let correctCount   = 0;
        let incorrectCount = 0;
        let timeoutCount   = 0;

        (data.questions || []).forEach(q => {
            if (q.status === 'correct')   correctCount++;
            if (q.status === 'incorrect') incorrectCount++;
            if (q.status === 'timeout')   timeoutCount++;
        });

        document.getElementById('correctCount').innerText   = correctCount;
        document.getElementById('incorrectCount').innerText = incorrectCount;
        document.getElementById('timeoutCount').innerText   = timeoutCount;

        // ── Lista de preguntas ────────────────────────────────
        const container = document.getElementById('questions');
        container.innerHTML = '';

        if (!data.questions || data.questions.length === 0) {
            container.innerHTML = '<div class="empty-message">No hay preguntas para mostrar</div>';
            return;
        }

        const letters = ['A', 'B', 'C', 'D'];

        data.questions.forEach((q, index) => {
            const statusConfig = {
                correct:   { cls: 'status-correct',   text: '✓ Correcta'      },
                incorrect: { cls: 'status-incorrect',  text: '✗ Incorrecta'    },
                timeout:   { cls: 'status-timeout',    text: '⏰ Tiempo agotado'},
                pending:   { cls: 'status-pending',    text: '⏳ Pendiente'    },
            };
            const cfg = statusConfig[q.status] || statusConfig.pending;

            // Respuesta correcta
            const correctAnswer = q.question?.answers?.find(a => a.is_correct);
            const correctText   = correctAnswer ? escapeHtml(correctAnswer.answer_text) : 'No disponible';

            // Opciones de respuesta con letras
            const answersHtml = (q.question?.answers || []).map((ans, i) => {
                const isCorrect = ans.is_correct;
                const cls = isCorrect ? 'answer-option correct-option' : 'answer-option';
                return `<div class="${cls}">
                    <span class="answer-letter">${letters[i] || i + 1}</span>
                    <span>${escapeHtml(ans.answer_text)}</span>
                    ${isCorrect ? '<span class="answer-badge">✓ Correcta</span>' : ''}
                </div>`;
            }).join('');

            const div = document.createElement('div');
            div.className = 'question-item';
            div.innerHTML = `
                <div class="question-header" onclick="toggleQuestion(this)">
                    <div class="question-number">Pregunta ${q.question_order ?? index + 1}</div>
                    <div class="question-text">${escapeHtml(q.question?.question || 'Sin texto')}</div>
                    <div class="question-status ${cfg.cls}">${cfg.text}</div>
                    <div class="question-points">🏆 ${q.earned_points || 0} pts</div>
                    <div class="expand-icon">▼</div>
                </div>
                <div class="question-details">
                    <div class="detail-content">
                        <div class="detail-row">
                            <div class="detail-label">⏱️ Tiempo límite:</div>
                            <div class="detail-value">${q.question?.time_limit ?? 0}s</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">⭐ Puntos posibles:</div>
                            <div class="detail-value">${q.question?.points ?? 0} pts</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">📋 Opciones:</div>
                        </div>
                        <div class="answers-grid">${answersHtml}</div>
                    </div>
                </div>
            `;

            container.appendChild(div);
        });

    } catch (error) {
        console.error('Error cargando resultados:', error);
        alert('Error al cargar los resultados. Por favor, intenta de nuevo.');
    }
}

function toggleQuestion(headerElement) {
    headerElement.closest('.question-item').classList.toggle('expanded');
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function volverAlMenu() {
    window.location.href = '/iniciar-juego';
}

function jugarDeNuevo() {
    localStorage.removeItem('game_id');
    window.location.href = '/iniciar-juego';
}

loadResult();
</script>
</body>
</html>