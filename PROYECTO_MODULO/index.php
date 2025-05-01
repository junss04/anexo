<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patrulla Espiritual - Camino a la Libertad</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="icon" href="img/icono.png" type="image/png">
    <link rel="stylesheet" href="styles.css">

    <style>
        /* Estilos generales */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #faf3e0;
            color: #704214;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3 {
            color: #B8860B;
        }

        .text-center {
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Estilos para las imágenes y diseño moderno */
        .main-content {
            padding: 20px;
            max-width: 1200px;
            margin: 100px auto 0;
        }

        .section {
            margin-bottom: 40px;
        }

        .welcome-section img, .addiction-info img {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid #DAA520;
        }

        .image-gallery {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .image-gallery img {
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
            border-radius: 10px;
            transition: transform 0.3s ease;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .image-gallery img:hover {
            transform: scale(1.2);
        }

        /* Estilos para el botón de video */
        .video-btn {
            background-color: #B8860B;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .video-btn:hover {
            background-color: #DAA520;
            transform: scale(1.1);
        }

        /* Estilos para el recuadro del video */
        .video-container {
            display: none;
            margin-top: 20px;
            padding: 15px;
            border: 4px solid #DAA520;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        iframe {
            width: 100%;
            max-width: 600px;
            height: 340px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Ajustes para dispositivos móviles */
        @media (max-width: 600px) {
            .navbar .nav-links {
                float: none;
                text-align: center;
            }

            .navbar .nav-links li {
                display: block;
                margin: 10px 0;
            }

            .image-gallery img {
                max-width: 100%;
            }

            iframe {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">
            <img src="img/logo_anexo.png" alt="Logo Circular" style="height: 40px;">
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="tomarfoto.php">Capturar fotografía</a></li>
            <li><a href="nuevapersona.php">Nueva Persona</a></li>
            <li><a href="barra.php">Buscar</a></li>
            <li><a href="persona.php">Actualizar Datos</a></li>
            <li><a href="comprobante.php">Comprobante</a></li>
            
        </ul>
    </nav>
</header>

    <main class="main-content">
        <section class="welcome-section section text-center">
            <h1>Bienvenido a Patrulla Espiritual</h1>
            <p>Camino a la Libertad es un centro de rehabilitación que se dedica a la recuperación integral de personas. Nuestro enfoque está en la sanación espiritual, física y emocional, brindando un ambiente de apoyo y compasión para aquellos que buscan una nueva vida.</p>
            <img src="img/logo_anexo.png" alt="Centro de rehabilitación">
        </section>

        <!-- Sección de galería de imágenes con diseño moderno -->
        <section class="section text-center">
            <h2>Nuestro Centro en Imágenes</h2>
            <div class="image-gallery">
                <img src="img/centro.jpg" alt="Imagen del centro 1">
                <img src="img/centro2.jpg" alt="Imagen del centro 2">
                <img src="img/doblea.gif" alt="Imagen del centro 3">
            </div>
        </section>

        <!-- Sección de información sobre adicciones -->
        <section class="addiction-info section">
            <h2>Adicciones a las Drogas y el Alcohol</h2>
            <p>Las adicciones a las drogas y al alcohol son problemas graves que afectan tanto al individuo como a su entorno familiar y social. El abuso de estas sustancias puede llevar a consecuencias devastadoras, como problemas de salud, aislamiento social y deterioro de la calidad de vida.</p>

            <div class="image-gallery">
                <img src="img/adiccion1.png" alt="Prevención 1">
                <img src="img/adiccion2.jpg" alt="Prevención 2">
            </div>

            <h3>Consecuencias de las Adicciones</h3>
            <ul>
                <li><strong>Problemas de salud:</strong> Las drogas y el alcohol pueden dañar gravemente el cuerpo, afectando órganos vitales como el hígado, el corazón y el cerebro.</li>
                <li><strong>Deterioro de relaciones:</strong> Las adicciones a menudo destruyen relaciones familiares y amistades debido a la falta de confianza y los conflictos causados por el abuso.</li>
                <li><strong>Problemas legales:</strong> El uso de drogas ilegales y comportamientos bajo la influencia del alcohol pueden llevar a situaciones legales graves, incluyendo arrestos y encarcelamiento.</li>
            </ul>

            <h3>Prevención de Adicciones</h3>
            <p>Prevenir una adicción es posible mediante la concienciación, el autocuidado y el apoyo de la comunidad. Aquí hay algunos consejos para evitar caer en el abuso de sustancias:</p>
            <ul>
                <li><strong>Educación:</strong> Conocer los efectos nocivos de las drogas y el alcohol desde una edad temprana puede ayudar a evitar el consumo irresponsable.</li>
                <li><strong>Mantener relaciones saludables:</strong> Tener una red de apoyo sólida con familiares y amigos ayuda a enfrentar el estrés sin recurrir a sustancias adictivas.</li>
                <li><strong>Estilo de vida activo:</strong> Participar en actividades deportivas, artísticas o comunitarias mantiene la mente ocupada y reduce la tentación de consumir drogas o alcohol.</li>
                <li><strong>Pedir ayuda:</strong> Si sientes que estás bajo presión para consumir o te cuesta controlar el consumo, busca ayuda profesional o habla con alguien de confianza antes de que se convierta en un problema mayor.</li>
            </ul>
        </section>

        <!-- Botón para ver el video -->
        <div class="text-center">
            <button class="video-btn" onclick="showVideo()">Ver Video</button>

            <!-- Contenedor del video oculto inicialmente -->
            <div id="video-container" class="video-container">
                <iframe src="https://www.youtube.com/embed/L9BDFFi36J4" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Patrulla Espiritual - Camino a la Libertad</p>
    </footer>

    <script>
        function showVideo() {
            var videoContainer = document.getElementById('video-container');
            if (videoContainer.style.display === 'none' || videoContainer.style.display === '') {
                videoContainer.style.display = 'block';
            } else {
                videoContainer.style.display = 'none';
            }
        }
    </script>
    
</body>
</html>
