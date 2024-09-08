<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Generador de Tableros</title>
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <style>
        .board {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
            border: 2px solid #333; /* Añadido para verificar el contenedor */
            padding: 10px;
        }
        .card {
            width: 100px;
            height: 100px;
            overflow: hidden;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
            background-color: #fff; /* Añadido para visibilidad */
        }
        .card-img-top {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <button id="generateButton" class="btn btn-primary">Generar Tableros</button>
    <div id="boardsContainer"></div>

    <script>
        const cartasDir = 'CartasLoteria/'; // Directorio donde están las cartas
        const cartas = [
            '1(Gallo).jpg', '2(Diablo).jpg', '3(Dama).jpg', // Agrega los nombres de las cartas aquí
            '4(El catrin).jpg', '5(El paraguas).jpg', '6(La sirena).jpg',
            '7(La escalera).jpg', '8(Botella).jpg', '9(Bariil).jpg',
            // Agrega más cartas según sea necesario
        ];

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        function generateBoards() {
            const boardsContainer = document.getElementById('boardsContainer');
            boardsContainer.innerHTML = ''; // Limpiar contenido previo

            // Clonar y mezclar las cartas para evitar repetición en los tableros
            let cartasDisponibles = cartas.slice();
            cartasDisponibles = shuffleArray(cartasDisponibles);

            for (let i = 0; i < 8; i++) {
                const uniqueCartas = getUniqueCards(cartasDisponibles, 16);

                const board = document.createElement('div');
                board.className = 'board';
                uniqueCartas.forEach(carta => {
                    const card = document.createElement('div');
                    card.className = 'card';
                    card.innerHTML = `
                        <img src="${cartasDir}${carta}" class="card-img-top" alt="${carta}">
                    `;
                    board.appendChild(card);
                });

                boardsContainer.appendChild(board);

                // Eliminar las cartas usadas para el próximo tablero
                cartasDisponibles = cartasDisponibles.filter(carta => !uniqueCartas.includes(carta));
                if (cartasDisponibles.length < 16) {
                    cartasDisponibles = shuffleArray(cartas.slice());
                }
            }
        }

        function getUniqueCards(cartas, num) {
            const unique = [];
            for (const carta of cartas) {
                if (unique.length < num) {
                    unique.push(carta);
                } else {
                    break;
                }
            }
            return unique;
        }

        document.getElementById('generateButton').addEventListener('click', generateBoards);
    </script>
</body>
</html>
