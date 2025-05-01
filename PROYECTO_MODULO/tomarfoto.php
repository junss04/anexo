<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toma de Fotografía</title>
    <link rel="icon" href="img/icono.png" type="image/png">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos generales */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #faf3e0; /* Fondo más claro */
            color: #704214;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #B8860B;
            text-align: center;
            margin-top: 100px; /* Ajustado por el header fijo */
        }

        .main-content {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .section {
            margin-bottom: 40px;
        }

        .camera-container {
            text-align: center;
        }

        #video {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid #DAA520;
        }

        #captureButton {
            background-color: #B8860B;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        #captureButton:hover {
            background-color: #DAA520;
            transform: scale(1.05);
        }

        #canvas {
            display: none;
        }

        #preview {
            display: none;
            margin-top: 20px;
            border: 2px solid #B8860B;
            width: 100%;
            max-width: 300px;
            height: 300px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        #preview img {
            width: 100%;
            height: auto;
        }

        #imageName {
            margin-top: 20px;
            padding: 10px;
            width: 100%;
            max-width: 400px;
            border: 1px solid #B8860B;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff8dc;
            display: block;
            margin: 20px auto;
        }

        #downloadLink {
            display: none;
            background-color: #DAA520;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 50px;
            margin-top: 10px;
            display: inline-block;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        #downloadLink:hover {
            background-color: #FFD700;
            transform: scale(1.05);
        }

        @media (max-width: 600px) {
            #video, #preview, #imageName, #downloadLink {
                max-width: 100%;
            }
            .navbar .nav-links {
                float: none;
                text-align: center;
            }
            .navbar .nav-links li {
                display: block;
                margin: 10px 0;
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

<h1>Toma de Fotografía</h1>

<div class="main-content">
    <!-- Sección de cámara -->
    <div class="camera-container section">
        <video id="video" autoplay></video>
        <button id="captureButton">Tomar foto</button>
        <canvas id="canvas"></canvas>
        <div id="preview">
            <img id="previewImg" src="" alt="Vista previa de la imagen">
        </div>
    </div>
    
    <!-- Campo para ingresar el nombre de la imagen -->
    <div class="section">
        <label for="imageName" class="text-center">Nombre de la Foto:</label>
        <input type="text" id="imageName" placeholder="Ingresa un nombre para la foto" />
    </div>

    <!-- Enlace para descargar la imagen -->
    <div class="section text-center">
        <a id="downloadLink">Descargar Foto</a>
    </div>
</div>

<script>
    let videoStream;

    // Iniciar la cámara
    function startCamera() {
        const video = document.getElementById('video');
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                videoStream = stream;
                video.srcObject = stream;
            })
            .catch(err => {
                console.error("Error al acceder a la cámara: ", err);
            });
    }

    startCamera();

    document.getElementById('captureButton').addEventListener('click', function() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        
        // Obtener el nombre de la imagen antes de capturar
        const imageName = document.getElementById('imageName').value.trim(); 
        
        if (!imageName) {
            alert("Por favor ingrese un nombre para la foto");
            return;  // No procedemos sin un nombre
        }
        
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        const imgData = canvas.toDataURL('image/png');
        document.getElementById('previewImg').src = imgData;
        document.getElementById('preview').style.display = 'block'; // Mostrar la vista previa
        document.getElementById('downloadLink').style.display = 'block'; // Mostrar enlace de descarga

        // Establecer el nombre de archivo y enlace de descarga
        document.getElementById('downloadLink').href = imgData;
        document.getElementById('downloadLink').download = imageName + '.png';

        // Detener la cámara
        if (videoStream) {
            const tracks = videoStream.getTracks();
            tracks.forEach(track => track.stop());
            video.srcObject = null;
        }
    });
</script>
</body>
</html>
