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
                radial-gradient(ellipse 70% 50% at 50% -10%, rgba(218,165,32,0.15) 0%, transparent 65%),
                radial-gradient(ellipse 50% 40% at 50% 110%, rgba(20,50,200,0.2) 0%, transparent 65%);
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
            animation: twinkle var(--d, 3s) var(--delay, 0s) infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.15; }
            50%       { opacity: 1; }
        }

        .card {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 3.5rem 3rem 3rem;
            max-width: 480px;
            width: 90%;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(218,165,32,0.18);
            border-radius: 16px;
            backdrop-filter: blur(8px);
        }

     
        .season {
            font-size: 12px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #daa520;
            margin-bottom: 1.1rem;
        }

        h1 {
            font-family: 'Cinzel Decorative', serif;
            font-size: clamp(20px, 5vw, 32px);
            color: #ffffff;
            line-height: 1.35;
            margin-bottom: 0.3rem;
            text-shadow: 0 0 40px rgba(218,165,32,0.35);
        }

        h1 span { color: gray; }

        .prize {
            font-size: 44px;
            font-weight: 600;
            color: #daa520;
            letter-spacing: 0.04em;
            margin: 0.2rem 0 2.2rem;
            animation: pulse-gold 2.2s ease-in-out infinite;
        }

        @keyframes pulse-gold {
            0%,100% { text-shadow: 0 0 16px rgba(218,165,32,0.35); }
            50%      { text-shadow: 0 0 40px rgba(218,165,32,0.9), 0 0 70px rgba(218,165,32,0.25); }
        }

        .rules {
            display: flex;
            gap: 12px;
            margin-bottom: 2.4rem;
            width: 100%;
            justify-content: center;
        }

        .rule {
            flex: 1;
            max-width: 110px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            background: rgba(218,165,32,0.06);
            border: 1px solid rgba(218,165,32,0.18);
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
            color: #fff;
            line-height: 1;
        }

        .rule-label {
            font-size: 11px;
            color: rgba(218,165,32,0.65);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

     
        .divider {
            width: 100px;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(218,165,32,0.45), transparent);
            margin-bottom: 2rem;
        }

   
        button {
            font-family: 'Rajdhani', sans-serif;
            font-size: 17px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #0a0a1a;
            background: linear-gradient(135deg, #c8920a 0%, #f5c842 50%, #c8920a 100%);
            border: none;
            padding: 15px 52px;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 24px rgba(218,165,32,0.3);
            transition: transform 0.15s, box-shadow 0.15s;
        }

        button:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 8px 36px rgba(218,165,32,0.55);
        }

        button:active { transform: scale(0.97); }

        button:disabled {
            opacity: 0.65;
            pointer-events: none;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .spinner {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 2px solid rgba(0,0,0,0.2);
            border-top-color: #0a0a1a;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            vertical-align: middle;
            margin-right: 7px;
        }

       
        .footer {
            font-size: 12px;
            color: rgba(255,255,255,0.18);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-top: 1.6rem;
        }
    </style>
</head>
<body>


<div id="stars"></div>

<div class="card">
    <div class="season">Temporada 2026</div>

    <h1>¿Quién quiere ser<br><span>millonario?</span></h1>
    <div class="prize">$1.000.000</div>

    <div class="rules">
        <div class="rule">
            <div class="rule-icon">&#10067;</div>
            <div class="rule-value">10</div>
            <div class="rule-label">Preguntas</div>
        </div>
        <div class="rule">
            <div class="rule-icon">&#9200;</div>
            <div class="rule-value">25s</div>
            <div class="rule-label">Por pregunta</div>
        </div>
        <div class="rule">
            <div class="rule-icon">&#128683;</div>
            <div class="rule-value">0</div>
            <div class="rule-label">Comodines</div>
        </div>
    </div>

    <div class="divider"></div>

    <button id="startBtn" onclick="startGame()">Iniciar Partida</button>

    <div class="footer">¿Tienes lo que se necesita?</div>
</div>

<script>
    
    const starsEl = document.getElementById('stars');
    for (let i = 0; i < 50; i++) {
        const s = document.createElement('div');
        s.className = 'star';
        const size = Math.random() > 0.75 ? '3px' : '2px';
        s.style.cssText = `
            left: ${Math.random() * 100}%;
            top: ${Math.random() * 100}%;
            width: ${size};
            height: ${size};
            --d: ${(2 + Math.random() * 3).toFixed(1)}s;
            --delay: ${(Math.random() * 3).toFixed(1)}s;
        `;
        starsEl.appendChild(s);
    }

    function startGame() {
        const btn = document.getElementById('startBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner"></span>Iniciando...';

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

            
            window.location.href = '/jugar';
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            btn.innerHTML = 'Iniciar Partida';
            alert(err.message);
        });
    }
</script>

</body>
</html>