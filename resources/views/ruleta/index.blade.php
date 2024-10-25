<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruleta Innovafest</title>

    <link rel="stylesheet" href="{{ asset('css/ruleta.css') }}">
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Incluir Lodash desde un CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>
    <script src="https://backbonejs.org/backbone.js"></script>
    <script src="https://cdn.jsdelivr.net/velocity/1.2.1/velocity.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <nav class="border-gray-200">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-center mx-auto">
            <a href="https://bloque10.unimagdalena.edu.co/innovafest" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/Logo-innovafest-4-.png') }}" class="logo-innovafest" alt="Innovafest Logo" />
            </a>          
        </div>
    </nav>
    
    <div class="roulette">
        <div class="spinner"></div>
        <div class="shadow"></div>
        <div class="markers">
          <div class="triangle"></div>
        </div>
        <div class="button">
          <span>Girar</span>
        </div>
      </div>
      

    <!-- Modal contenedores para preguntas -->
    <div id="modal-container" style="display: none;">
        <div class="modal" id="modal-innovar">
            <p>Pregunta: ¿Qué fue lo más difícil de innovar?</p>
            <button onclick="closeModal()">Cerrar</button>
        </div>
        <div class="modal" id="modal-integrar">
            <p>Pregunta: ¿Cómo integras la IA en tu trabajo o estudio?</p>
            <button onclick="closeModal()">Cerrar</button>
        </div>
        <div class="modal" id="modal-etapas">
            <p>Pregunta: ¿Cuál fue tu etapa favorita en la innovación?</p>
            <button onclick="closeModal()">Cerrar</button>
        </div>
        <div class="modal" id="modal-transformar">
            <p>Pregunta: Espacios como InnovafestB10, ¿cómo transforman la educación?</p>
            <button onclick="closeModal()">Cerrar</button>
        </div>
        <div class="modal" id="modal-imagina">
            <p>Pregunta: ¿Cómo te imaginas el futuro de la IA en educación?
            </p>
            <button onclick="closeModal()">Cerrar</button>
        </div>
        <div class="modal" id="modal-reemplazar">
            <p>Pregunta: ¿Crees que la IA puede reemplazarte en el trabajo?
            </p>
            <button onclick="closeModal()">Cerrar</button>
        </div>
        <div class="modal" id="modal-innovafest">
            <p>Pregunta: ¿Qué es para ti Innovafest B10?
            </p>
            <button onclick="closeModal()">Cerrar</button>
        </div>
        <div class="modal" id="modal-bloque10">
            <p>Pregunta: ¿Cómo ha ayudado Bloque 10 en tu labor formativa?
            </p>
            <button onclick="closeModal()">Cerrar</button>
        </div>
        <div class="modal" id="modal-cetep">
            <p>Pregunta: ¿Cómo describes al equipo de CETEP?
            </p>
            <button onclick="closeModal()">Cerrar</button>
        </div>
        <div class="modal" id="modal-unimagdalena">
            <p>Pregunta: ¿Qué le propones a Unimagdalena para incentivar la innovación?
            </p>
            <button onclick="closeModal()">Cerrar</button>
        </div>
        <div class="modal" id="modal-futuro">
            <p>Pregunta: ¿Qué siga para tu innovación en el futuro?
            </p>
            <button onclick="closeModal()">Cerrar</button>
        </div>
    </div>

    <script src="{{ asset('js/ruleta.js') }}"></script>
</body>

</html>
