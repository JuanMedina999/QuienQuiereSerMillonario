<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Pregunta - ¿Quién quiere ser millonario?</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<div class="game-container">

    <div style="display:flex; align-items:center; gap:15px; margin-bottom:30px;">
        <a href="/preguntas" class="btn btn-secondary" style="text-decoration:none; padding:10px 20px; font-size:0.9rem;">
            ← Volver
        </a>
        <h1 style="margin:0; font-size:2rem;">➕ Crear Nueva Pregunta</h1>
    </div>

    <!-- Mensaje de feedback -->
    <div id="feedback" style="display:none; margin-bottom:20px;"></div>

    <form id="questionForm">

        <!-- Pregunta -->
        <div class="form-group">
            <label class="form-label">📝 Pregunta</label>
            <input
                type="text"
                name="question"
                placeholder="Escribe aquí la pregunta..."
                class="form-input"
                required
            >
        </div>

        <!-- Puntos y Tiempo -->
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">⭐ Puntos</label>
                <input
                    type="number"
                    name="points"
                    value="100"
                    min="10"
                    class="form-input"
                    required
                >
            </div>
            <div class="form-group">
                <label class="form-label">⏱️ Tiempo límite (segundos)</label>
                <input
                    type="number"
                    name="time_limit"
                    value="30"
                    min="5"
                    max="120"
                    class="form-input"
                    required
                >
            </div>
        </div>

        <!-- Respuestas -->
        <div class="form-group" style="margin-top:10px;">
            <label class="form-label">🎯 Respuestas <span style="color:#aaa; font-size:0.85rem; font-weight:normal;">(selecciona cuál es la correcta)</span></label>

            <div id="answers" style="display:flex; flex-direction:column; gap:12px; margin-top:10px;">

                <div class="answer-row" data-index="0">
                    <label class="answer-radio-label">
                        <input type="radio" name="correct" value="0">
                        <span class="radio-custom"></span>
                    </label>
                    <span class="answer-letter-badge">A</span>
                    <input type="text" name="answers[]" placeholder="Respuesta A" class="form-input answer-input" required>
                </div>

                <div class="answer-row" data-index="1">
                    <label class="answer-radio-label">
                        <input type="radio" name="correct" value="1">
                        <span class="radio-custom"></span>
                    </label>
                    <span class="answer-letter-badge">B</span>
                    <input type="text" name="answers[]" placeholder="Respuesta B" class="form-input answer-input" required>
                </div>

                <div class="answer-row" data-index="2">
                    <label class="answer-radio-label">
                        <input type="radio" name="correct" value="2">
                        <span class="radio-custom"></span>
                    </label>
                    <span class="answer-letter-badge">C</span>
                    <input type="text" name="answers[]" placeholder="Respuesta C" class="form-input answer-input" required>
                </div>

                <div class="answer-row" data-index="3">
                    <label class="answer-radio-label">
                        <input type="radio" name="correct" value="3">
                        <span class="radio-custom"></span>
                    </label>
                    <span class="answer-letter-badge">D</span>
                    <input type="text" name="answers[]" placeholder="Respuesta D" class="form-input answer-input" required>
                </div>

            </div>
        </div>

        <!-- Botones -->
        <div style="display:flex; gap:15px; margin-top:30px; flex-wrap:wrap;">
            <button type="submit" class="btn btn-primary" style="flex:1; min-width:180px; justify-content:center;">
                💾 Guardar Pregunta
            </button>
            <button type="button" class="btn btn-secondary" onclick="resetForm()" style="flex:1; min-width:180px; justify-content:center;">
                🔄 Limpiar formulario
            </button>
        </div>

    </form>
</div>

<script>
const LETTERS = ['A', 'B', 'C', 'D'];

// Resalta la fila de respuesta al seleccionar el radio
document.querySelectorAll('input[name="correct"]').forEach(radio => {
    radio.addEventListener('change', () => {
        document.querySelectorAll('.answer-row').forEach(row => row.classList.remove('answer-row--selected'));
        const selectedRow = document.querySelector(`.answer-row[data-index="${radio.value}"]`);
        if (selectedRow) selectedRow.classList.add('answer-row--selected');
    });
});

function showFeedback(message, type) {
    const fb = document.getElementById('feedback');
    fb.innerText     = message;
    fb.className     = `feedback-${type}`;
    fb.style.display = 'block';
    fb.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    setTimeout(() => { fb.style.display = 'none'; }, 4000);
}

function resetForm() {
    document.getElementById('questionForm').reset();
    document.querySelectorAll('.answer-row').forEach(r => r.classList.remove('answer-row--selected'));
    document.getElementById('feedback').style.display = 'none';
}

document.getElementById('questionForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;

    const answers      = Array.from(form.querySelectorAll('input[name="answers[]"]')).map(i => ({ text: i.value }));
    const correctInput = form.querySelector('input[name="correct"]:checked');

    if (!correctInput) {
        showFeedback('⚠️ Debes seleccionar cuál es la respuesta correcta', 'timeout');
        return;
    }

    const data = {
        question:      form.question.value.trim(),
        points:        parseInt(form.points.value),
        time_limit:    parseInt(form.time_limit.value),
        answers:       answers,
        correct_index: parseInt(correctInput.value)
    };

    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled   = true;
    submitBtn.innerText  = '⏳ Guardando...';

    try {
        const response = await fetch('/api/questions', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(data)
        });

        const result = await response.json();

        if (!response.ok) {
            showFeedback('❌ Error al guardar la pregunta. Verifica los datos.', 'incorrect');
            return;
        }

        showFeedback('✅ ¡Pregunta creada correctamente!', 'correct');
        resetForm();

    } catch (error) {
        console.error(error);
        showFeedback('❌ Error de conexión. Intenta de nuevo.', 'incorrect');
    } finally {
        submitBtn.disabled  = false;
        submitBtn.innerText = '💾 Guardar Pregunta';
    }
});
</script>

</body>
</html>