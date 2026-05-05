let gameId = 1; // ⚠️ aquí pones el ID del juego creado

function mostrarPregunta(data) {
    document.getElementById("question").innerText = data.question;

    let answersDiv = document.getElementById("answers");
    answersDiv.innerHTML = "";

    data.answers.forEach(answer => {
        let btn = document.createElement("button");
        btn.innerText = answer.answer_text;

        btn.onclick = () => responder(answer.id);

        answersDiv.appendChild(btn);
    });
}

function responder(answerId) {
    fetch(`/api/games/${gameId}/answer`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            answer_id: answerId,
            time_spent: 5
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);

        // actualizar puntaje
        document.getElementById("score").innerText = data.total_score;

        // si hay siguiente pregunta
        if (data.next_question) {
            mostrarPregunta(data.next_question);
        } else {
            alert("Juego terminado. Puntaje: " + data.total_score);
        }
    });
}

// 🔥 Cargar primera pregunta
function iniciarJuego() {
    fetch(`/api/games/${gameId}/current-question`)
        .then(res => res.json())
        .then(data => {
            mostrarPregunta(data);
        });
}

// iniciar automáticamente
iniciarJuego();