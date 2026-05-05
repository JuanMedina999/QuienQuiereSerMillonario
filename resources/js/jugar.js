data.answers.forEach((ans, index) => {
    const btn = document.createElement('button');
    btn.innerText = ans.answer_text;
    btn.setAttribute('data-letter', String.fromCharCode(65 + index)); // ← AÑADE ESTA LÍNEA
    btn.onclick = () => sendAnswer(ans.id);
    container.appendChild(btn);
});