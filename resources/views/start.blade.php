<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Quién quiere ser millonario?</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">

    <style>

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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
                radial-gradient(
                    ellipse 70% 50% at 50% -10%,
                    rgba(218,165,32,0.15) 0%,
                    transparent 65%
                ),

                radial-gradient(
                    ellipse 50% 40% at 50% 110%,
                    rgba(20,50,200,0.2) 0%,
                    transparent 65%
                );

            pointer-events: none;
        }

        #stars {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .star {
            position: absolute;
            background: rgba(218,165,32,0.6);
            border-radius: 50%;
            animation: twinkle var(--d,3s) var(--delay,0s) infinite;
        }

        @keyframes twinkle {
            0%,100% { opacity: .15; }
            50% { opacity: 1; }
        }

        .card {
            position: relative;
            z-index: 1;

            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;

            padding: 3.5rem 3rem 3rem;

            max-width: 500px;
            width: 90%;

            background: rgba(255,255,255,0.03);

            border: 1px solid rgba(218,165,32,0.18);

            border-radius: 16px;

            backdrop-filter: blur(8px);
        }

        .season {
            font-size: 12px;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: #daa520;
            margin-bottom: 1.1rem;
        }

        h1 {
            font-family: 'Cinzel Decorative', serif;
            font-size: clamp(20px, 5vw, 32px);
            color: white;
            line-height: 1.35;
            margin-bottom: .3rem;
            text-shadow: 0 0 40px rgba(218,165,32,.35);
        }

        h1 span {
            color: orange;
        }

        .prize {
            font-size: 44px;
            font-weight: 600;
            color: #daa520;
            letter-spacing: .04em;
            margin: .2rem 0 2.2rem;
        }

        .rules {
            display: flex;
            gap: 12px;
            width: 100%;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .rule {
            flex: 1;
            max-width: 110px;

            display: flex;
            flex-direction: column;
            align-items: center;

            gap: 6px;

            background: rgba(218,165,32,.06);

            border: 1px solid rgba(218,165,32,.18);

            border-radius: 10px;

            padding: 14px 10px;
        }

        .rule-icon {
            font-size: 22px;
            color: #daa520;
        }

        .rule-value {
            font-size: 22px;
            font-weight: 600;
            color: white;
        }

        .rule-label {
            font-size: 11px;
            color: rgba(218,165,32,.65);
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        .category-wrapper {
            width: 100%;
            margin-bottom: 25px;
        }

        .category-label {
            display: block;
            text-align: left;

            color: #daa520;

            margin-bottom: 10px;

            font-size: 14px;

            letter-spacing: .1em;

            text-transform: uppercase;
        }

        .category-select {

            width: 100%;

            padding: 14px;

            border-radius: 8px;

            border: 1px solid rgba(218,165,32,.3);

            background: #111;

            color: white;

            font-size: 16px;
        }

        .divider {

            width: 100px;

            height: 1px;

            background: linear-gradient(
                to right,
                transparent,
                rgba(218,165,32,.45),
                transparent
            );

            margin-bottom: 2rem;
        }

        button {

            font-family: 'Rajdhani', sans-serif;

            font-size: 17px;

            font-weight: 600;

            letter-spacing: .14em;

            text-transform: uppercase;

            color: #0a0a1a;

            background: linear-gradient(
                135deg,
                #c8920a 0%,
                #f5c842 50%,
                #c8920a 100%
            );

            border: none;

            padding: 15px 52px;

            border-radius: 5px;

            cursor: pointer;

            box-shadow: 0 4px 24px rgba(218,165,32,.3);

            transition: .2s;
        }

        button:hover {
            transform: translateY(-2px);
        }

        button:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        .spinner {

            display: inline-block;

            width: 15px;

            height: 15px;

            border: 2px solid rgba(0,0,0,.2);

            border-top-color: #0a0a1a;

            border-radius: 50%;

            animation: spin .7s linear infinite;

            margin-right: 8px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .footer {
            margin-top: 1.6rem;
            font-size: 12px;
            color: rgba(255,255,255,.18);
            text-transform: uppercase;
        }

    </style>
</head>
<body>

<div id="stars"></div>

<div class="card">

    <div class="season">
        Temporada 2026
    </div>

    <h1>
        ¿Quién quiere ser<br>
        <span>millonario?</span>
    </h1>

    <div class="prize">
        $1.000.000
    </div>

    <div class="rules">

        <div class="rule">
            <div class="rule-icon">❓</div>
            <div class="rule-value">10</div>
            <div class="rule-label">Preguntas</div>
        </div>

        <div class="rule">
            <div class="rule-icon">⏰</div>
            <div class="rule-value">25s</div>
            <div class="rule-label">Por pregunta</div>
        </div>

        <div class="rule">
            <div class="rule-icon">🚫</div>
            <div class="rule-value">0</div>
            <div class="rule-label">Comodines</div>
        </div>

    </div>

    <div class="category-wrapper">

        <label class="category-label">
            Categoría
        </label>

        <select id="categorySelect" class="category-select">
            <option value="">
                Cargando categorías...
            </option>
        </select>

    </div>

    <div class="divider"></div>

    <button id="startBtn" onclick="startGame()">
        Iniciar Partida
    </button>

    <div class="footer">
        ¿Tienes lo que se necesita?
    </div>

</div>

<script>

    const starsEl = document.getElementById('stars');

    for(let i = 0; i < 50; i++) {

        const s = document.createElement('div');

        s.className = 'star';

        const size = Math.random() > .75 ? '3px' : '2px';

        s.style.cssText = `
            left:${Math.random()*100}%;
            top:${Math.random()*100}%;
            width:${size};
            height:${size};
            --d:${(2+Math.random()*3).toFixed(1)}s;
            --delay:${(Math.random()*3).toFixed(1)}s;
        `;

        starsEl.appendChild(s);
    }

    async function loadCategories() {

        try {

            const response =
                await fetch('/api/categories');

            if(!response.ok) {
                throw new Error();
            }

            const categories =
                await response.json();

            const select =
                document.getElementById('categorySelect');

            select.innerHTML =
                '<option value="">Seleccione una categoría</option>';

            categories.forEach(category => {

                select.innerHTML += `
                    <option value="${category.id}">
                        ${category.name}
                    </option>
                `;

            });

        } catch(error) {

            console.error(error);

            document.getElementById('categorySelect').innerHTML =
                '<option value="">Error cargando categorías</option>';
        }
    }

    async function startGame() {

        const btn =
            document.getElementById('startBtn');

        const categoryId =
            document.getElementById('categorySelect').value;

        if(!categoryId) {
            alert('Selecciona una categoría');
            return;
        }

        btn.disabled = true;

        btn.innerHTML =
            '<span class="spinner"></span>Iniciando...';

        try {

            const response =
                await fetch('/api/games/start', {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json'
                    },

                    body: JSON.stringify({
                        category_id: parseInt(categoryId)
                    })

                });

            const data =
                await response.json();

            if(!response.ok) {

                throw new Error(
                    data.error ||
                    data.message ||
                    'Error al iniciar juego'
                );
            }

            localStorage.setItem(
                'game_id',
                data.game_id
            );

            localStorage.setItem(
                'category_id',
                categoryId
            );

            window.location.href = '/jugar';

        } catch(error) {

            console.error(error);

            btn.disabled = false;

            btn.innerHTML = 'Iniciar Partida';

            alert(error.message);
        }
    }

    loadCategories();

</script>

</body>
</html>