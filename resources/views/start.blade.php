<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Juego</title>
</head>
<link rel="stylesheet" href="styles.css">

<body>

<h1>¿Quién quiere ser millonario?</h1>

<button onclick="startGame()">Iniciar Partida</button>

<script>
function startGame() {
    fetch('/api/games/start', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(async res => {
        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.error || 'Error al iniciar juego');
        }

        return data;
    })
    .then(data => {
        console.log("Juego creado:", data);

        // Guardar ID del juego
        localStorage.setItem('game_id', data.game_id);

        // Ir a jugar
        window.location.href = '/jugar';
    })
    .catch(err => {
        console.error(err);
        alert(err.message);
    });
}

</script>

</body>
</html>