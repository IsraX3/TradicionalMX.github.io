<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>TradicionalMX</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .board {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
            padding: 10px;
        }
        .card {
            width: 120px;
            height: 150px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
            background-color: #fff;
        }
        .card-img-top {
    width: 100%;
    height: 100px;
    margin-top: 10px;
    object-fit: contain; /* Cambia de cover a contain */
}
        .card-body {
            padding: 5px;
        }
        .card-text {
            font-size: 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>

</head>
<body>
    <!-- Responsive navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5">
            <a class="navbar-brand" href="#!">TradicionalMX</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Tutoriales</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Page Content -->
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 align-items-center my-5">
            <div class="col-lg-5">
                <h1 class="font-weight-light">¡Exíto!</h1>
                <h3>Loteria Mexicana</h3>
                <br>
                <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
Opciones
  </button>
  <ul class="dropdown-menu">
    <li>
    <div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-primary">Revolver</button>
  <a href="loteria.php"><button type="button" class="btn btn-success">Loteria</button></a>
</div>
    </li>
    <br>
    <li>

    </li>
  </ul>
</div>

                <br>
                <form id="playerForm">
                    <div class="mb-3">
                        <label for="playerCount" class="form-label">Seleccionar Jugadores (máx. 2)</label>
                        <select id="playerCount" class="form-select" aria-label="Seleccionar cantidad de jugadores">
                            <option value="1">1 Jugador</option>
                            <option value="2">2 Jugadores</option>
                        </select>
                    </div>
                    <button type="button" id="generateButton" class="btn btn-primary">Generar Tableros</button>
                </form>
                <br>
                <div class="centered-content">
            <div class="input-group mb-3">
            <input type="number" id="rowInput" placeholder="Fila">
<input type="number" id="columnInput" placeholder="Columna">
<button id="showCardButton">Mostrar carta</button>

            </div>

            <!-- Contenedor para mostrar la carta seleccionada -->
            <div id="cardByCoordsContainer" class="large-card"></div>
        </div>
    </div>
                <div id="boardsContainer"></div>
            </div>
        </div>
        
        <!-- Content Row -->
        <!-- Más contenido aquí -->
    </div>

    <!-- Formulario para ingresar las coordenadas -->
    <script>
    const cartasDir = '../CartasLoteria/';
    const cartas = [
        '1(Gallo).jpg', '2(Diablo).jpg', '3(Dama).jpg',
        '4(catrin).jpg', '5(paraguas).jpg', '6(sirena).jpg',
        '7(escalera).jpg', '8(Botella).jpg', '9(Bariil).jpg',
        '10(Arbol).jpg', '11(Melon).jpg', '12(Valiente).jpg',
        '13(Gorrito).jpg', '14(Muerte).jpg', '15(Pera).jpg',
        '16(Bandera).jpg', '17(Bandolon).jpg', '18(Violoncello).jpg',
        '19(Garza).jpg', '20(Pajaro).jpg', '21(Mano).jpg',
        '22(Bota).jpg', '23(Luna).jpg', '24(Cotorro).jpg',
        '25(Borracho).jpg', '26(Negrito).jpg', '27(Corazon).jpg',
        '28(Sandia).jpg', '29(Tambor).jpg', '30(Camaron).jpg',
        '31(Jaras).jpg', '32(Musico).jpg', '33(Araña).jpg',
        '34(Soldado).jpg', '35(Estrella).jpg', '36(Cazo).jpg',
        '37(Mundo).jpg', '38(Apache).jpg', '39(Nopal).jpg',
        '40(Alacran).jpg', '41(Rosa).jpg', '42(Calavera).jpg',
        '43(Campana).jpg', '44(Cantarito).jpg', '45(Venado).jpg',
        '46(Sol).jpg', '47(Corona).jpg', '48(Chalupa).jpg',
        '49(Pino).jpg', '50(Pescado).jpg', '51(Palma).jpg',
        '52(Maceta).jpg', '53(Arpa).jpg', '54(Rana).jpg',
    ];

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    function generateBoards() {
        const playerCount = parseInt(document.getElementById('playerCount').value);
        const boardsContainer = document.getElementById('boardsContainer');
        boardsContainer.innerHTML = '';

        let cartasDisponibles = cartas.slice();
        cartasDisponibles = shuffleArray(cartasDisponibles);

        for (let i = 0; i < playerCount; i++) {
            const uniqueCartas = getUniqueCards(cartasDisponibles, 16);

            const board = document.createElement('div');
            board.className = 'col-6 col-md-4 col-lg-3 mb-4';
            board.innerHTML = '<div class="board"></div>';

            uniqueCartas.forEach((carta, index) => {
                const card = document.createElement('div');
                card.className = 'card';

                const cardName = carta.match(/\((.*?)\)/)[1];

                card.innerHTML = `
                    <img src="${cartasDir}${carta}" class="card-img-top" alt="${cardName}">
                    <div class="card-body text-center">
                        <p class="card-text">${cardName}</p>
                    </div>`;

                const row = Math.floor(index / 4);
                const col = index % 4;

                card.addEventListener('click', function() {
                    document.getElementById('rowInput').value = row;
                    document.getElementById('columnInput').value = col;
                    showCard(row, col, carta);
                });

                board.querySelector('.board').appendChild(card);
            });

            boardsContainer.appendChild(board);
        }
    }

    function getUniqueCards(cartasDisponibles, cantidad) {
        const uniqueCartas = [];
        while (uniqueCartas.length < cantidad && cartasDisponibles.length > 0) {
            const randomIndex = Math.floor(Math.random() * cartasDisponibles.length);
            const carta = cartasDisponibles.splice(randomIndex, 1)[0];
            uniqueCartas.push(carta);
        }
        return uniqueCartas;
    }

    function showCard(row, col, carta) {
        const cardName = carta.match(/\((.*?)\)/)[1];
        document.getElementById('cardByCoordsContainer').innerHTML = `
            <div class="card">
                <img src="${cartasDir}${carta}" class="card-img-top" alt="${cardName}">
                <div class="card-body text-center">
                    <p class="card-text">Fila: ${row}, Columna: ${col} - ${cardName}</p>
                </div>
            </div>`;
    }

    document.getElementById('generateButton').addEventListener('click', generateBoards);

    document.getElementById('showCardButton').addEventListener('click', function() {
        const row = parseInt(document.getElementById('rowInput').value);
        const col = parseInt(document.getElementById('columnInput').value);

        if (isNaN(row) || isNaN(col) || row < 0 || col < 0 || row > 3 || col > 3) {
            alert('Por favor, ingresa valores válidos para la fila y columna (0-3).');
            return;
        }

        const board = document.querySelector('.board');
        if (!board) {
            alert('No hay tableros generados.');
            return;
        }

        const cards = board.querySelectorAll('.card');
        const index = row * 4 + col;

        if (index >= cards.length) {
            alert('Posición fuera del rango.');
            return;
        }

        const selectedCard = cards[index];
        const cartaSrc = selectedCard.querySelector('img').src;
        const cardName = cartaSrc.match(/\((.*?)\)/)[1];

        document.getElementById('cardByCoordsContainer').innerHTML = `
            <div class="card">
                <img src="${cartaSrc}" class="card-img-top" alt="${cardName}">
                <div class="card-body text-center">
                    <p class="card-text">Fila: ${row}, Columna: ${col} - ${cardName}</p>
                </div>
            </div>`;
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('.btn-primary');
    const audioDir = '../mp3/';
    const audios = [
        '1gallo.mp3', '2diablo.mp3', '3dama.mp3',
        '4catrin.mp3', '5paraguas.mp3', '6sirena.mp3',
        '7escalera.mp3', '8botella.mp3', '9barril.mp3',
        '10arbol.mp3', '11melon.mp3', '12valiente.mp3',
        '13gorrito.mp3', '14muerte.mp3', '15pera.mp3',
        '16bandera.mp3', '17bandolon.mp3', '18violoncello.mp3',
        '19garza.mp3', '20pajaro.mp3', '21mano.mp3',
        '22bota.mp3', '23luna.mp3', '24cotorro.mp3',
        '25borracho.mp3', '26negrito.mp3', '27corazon.mp3',
        '28sandia.mp3', '29tambor.mp3', '30camaron.mp3',
        '31jaras.mp3', '32musico.mp3', '33araña.mp3',
        '34soldado.mp3', '35estrella.mp3', '36cazo.mp3',
        '37mundo.mp3', '38apache.mp3', '39nopal.mp3',
        '40alacran.mp3', '41rosa.mp3', '42calavera.mp3',
        '43campana.mp3', '44cantarito.mp3', '45venado.mp3',
        '46sol.mp3', '47corona.mp3', '48chalupa.mp3',
        '49pino.mp3', '50pescado.mp3', '51palma.mp3',
        '52maceta.mp3', '53arpa.mp3', '54rana.mp3',
    ];

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    button.addEventListener('click', function() {
        const shuffledAudios = shuffleArray(audios.slice());
        const audioPromises = shuffledAudios.map(audioFile => {
            return new Promise((resolve) => {
                const audio = new Audio(audioDir + audioFile);
                audio.onended = resolve;
                audio.play();
            });
        });

        audioPromises.reduce((promise, nextAudioPromise) => {
            return promise.then(() => nextAudioPromise);
        }, Promise.resolve());
    });
});
</script>
s
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('.btn-primary');
    const audioDir = '../mp3/';
    const audios = [
        '1gallo.mp3', '2diablo.mp3', '3dama.mp3',
        '4catrin.mp3', '5paraguas.mp3', '6sirena.mp3',
        '7escalera.mp3', '8botella.mp3', '9barril.mp3',
        '10arbol.mp3', '11melon.mp3', '12valiente.mp3',
        '13gorrito.mp3', '14muerte.mp3', '15pera.mp3',
        '16bandera.mp3', '17bandolon.mp3', '18violoncello.mp3',
        '19garza.mp3', '20pajaro.mp3', '21mano.mp3',
        '22bota.mp3', '23luna.mp3', '24cotorro.mp3',
        '25borracho.mp3', '26negrito.mp3', '27corazon.mp3',
        '28sandia.mp3', '29tambor.mp3', '30camaron.mp3',
        '31jaras.mp3', '32musico.mp3', '33araña.mp3',
        '34soldado.mp3', '35estrella.mp3', '36cazo.mp3',
        '37mundo.mp3', '38apache.mp3', '39nopal.mp3',
        '40alacran.mp3', '41rosa.mp3', '42calavera.mp3',
        '43campana.mp3', '44cantarito.mp3', '45venado.mp3',
        '46sol.mp3', '47corona.mp3', '48chalupa.mp3',
        '49pino.mp3', '50pescado.mp3', '51palma.mp3',
        '52maceta.mp3', '53arpa.mp3', '54rana.mp3',
    ];

    // Función para mezclar el array de audios
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    button.addEventListener('click', () => {
        // Mezclar los audios
        const shuffledAudios = shuffleArray(audios.slice());

        // Reproducir los audios en el orden aleatorio
        shuffledAudios.forEach((audioFile, index) => {
            setTimeout(() => {
                const audio = new Audio(audioDir + audioFile);
                audio.play().catch(error => console.error('Error al reproducir el audio:', error));
            }, index * 2000); // Ajusta el tiempo entre audios si es necesario
        });
    });

    // Evento para reproducir audio al hacer clic en las cartas
    document.addEventListener('click', function(e) {
        if (e.target && e.target.matches('.card-img-top')) {
            const imgSrc = e.target.src;
            const cardIndex = cartas.findIndex(carta => imgSrc.includes(carta));
            if (cardIndex !== -1) {
                const audioFile = audios[cardIndex];
                const audio = new Audio(audioDir + audioFile);
                audio.play().catch(error => console.error('Error al reproducir el audio:', error));
                document.getElementById('cardNumber').textContent = `Carta número: ${cardIndex + 1}`;
            }
        }
    });
});
</script>
  <script src="../assets/js/scrip.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>
