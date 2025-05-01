<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Ingreso - Patrulla Espiritual</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="icon" href="img/icono.png">
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

        /* Estilos para el contenido principal */
        .main-content {
            padding: 20px;
            max-width: 1200px;
            margin: 100px auto 0;
        }

        .form-section {
            margin-top: 20px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-section h1 {
            text-align: center;
            color: #333;
        }

        .modern-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #3f51b5;
            outline: none;
        }

        .submit-button {
            padding: 10px;
            border: none;
            background-color: #B8860B;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-button:hover {
            background-color: #DAA520;
        }

        footer {
            text-align: center;
            padding: 20px 0;
            background-color: #282c34;
            color: #ffffff;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Convertir a mayúsculas automáticamente */
        input[type="text"], input[type="tel"], input[type="date"], input[type="email"] {
            text-transform: uppercase;
        }
    </style>
    <script>
        function calcularSalida() {
            const ingreso = new Date(document.getElementById("fecha_ingreso").value);
            const hoy = new Date();
            
            if (ingreso > hoy) {
                alert("La fecha de ingreso no puede ser futura.");
                document.getElementById("fecha_ingreso").value = "";  // Resetea el campo
                return;
            }

            const salida = new Date(ingreso);
            salida.setDate(salida.getDate() + 90);  // Agrega 90 días al día de ingreso

            const diaSalida = salida.toISOString().split('T')[0];  // Formato YYYY-MM-DD
            document.getElementById("fecha_salida").value = diaSalida;
        }
    </script>
</head>
<body>

<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // Conectar a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "centro_rehabilitacion";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Recoger datos del formulario
        $nombre = htmlspecialchars($_POST['nombre']);
        $apellidoPaterno = htmlspecialchars($_POST['apellido_paterno']);
        $apellidoMaterno = htmlspecialchars($_POST['apellido_materno']);
        $fechaNacimiento = htmlspecialchars($_POST['fecha_nacimiento']);
        $nombreResponsable = htmlspecialchars($_POST['nombre_responsable']);
        $telefonoResponsable = htmlspecialchars($_POST['telefono_responsable']);
        $fechaIngreso = htmlspecialchars($_POST['fecha_ingreso']);
        $fechaSalida = htmlspecialchars($_POST['fecha_salida']);
        $curp = htmlspecialchars($_POST['curp']);

        // Insertar los datos de la persona
        $sqlPersona = "INSERT INTO personas (nombre, apellido_paterno, apellido_materno, fecha_nacimiento, nombre_responsable, telefono_responsable, fecha_ingreso, fecha_salida, curp)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtPersona = $conn->prepare($sqlPersona);
        $stmtPersona->bind_param("sssssssss", $nombre, $apellidoPaterno, $apellidoMaterno, $fechaNacimiento, $nombreResponsable, $telefonoResponsable, $fechaIngreso, $fechaSalida, $curp);

        if ($stmtPersona->execute()) {
            $idPersona = $stmtPersona->insert_id; // Obtener el ID de la persona insertada

            // Manejar la subida de la foto
            if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $foto = $_FILES['foto']['tmp_name'];
                $tipoFoto = mime_content_type($foto);
                $tamañoFoto = $_FILES['foto']['size'];
                
                // Verificar que el archivo sea una imagen y su tamaño
                if (($tipoFoto === 'image/jpeg' || $tipoFoto === 'image/png') && $tamañoFoto <= 2097152) {
                    $fotoContenido = file_get_contents($foto); // Leer el contenido del archivo de imagen

                    // Insertar la foto en la tabla "fotos_persona"
                    $sqlFoto = "INSERT INTO fotos_persona (id_persona, foto) VALUES (?, ?)";
                    $stmtFoto = $conn->prepare($sqlFoto);
                    $stmtFoto->bind_param("is", $idPersona, $fotoContenido);

                    // Ejecutar la consulta de la foto y verificar si fue exitosa
                    if ($stmtFoto->execute()) {
                        echo "Registro y foto agregados correctamente.";
                    } else {
                        echo "Error al guardar la foto: " . $stmtFoto->error;
                    }

                    $stmtFoto->close();
                } else {
                    echo "Error: La imagen debe ser JPEG o PNG y no mayor a 2MB.";
                }
            } else {
                echo "Error al cargar la imagen. Asegúrate de que has seleccionado un archivo válido.";
            }
        } else {
            echo "Error al guardar los datos de la persona: " . $stmtPersona->error;
        }


        $stmtPersona->close();
        $conn->close();
    } else {
        die("CSRF token no es válido");
    }
}
?>

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
    <section class="form-section">
        <h1>Formulario de Ingreso</h1>
        <form method="POST" action="" class="modern-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" pattern="[A-Za-z\s]+" required oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label for="apellido_paterno">Apellido Paterno:</label>
                <input type="text" id="apellido_paterno" name="apellido_paterno" pattern="[A-Za-z\s]+" required oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label for="apellido_materno">Apellido Materno:</label>
                <input type="text" id="apellido_materno" name="apellido_materno" pattern="[A-Za-z\s]+" required oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="nombre_responsable">Nombre del Responsable:</label>
                <input type="text" id="nombre_responsable" name="nombre_responsable" pattern="[A-Za-z\s]+" required oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label for="telefono_responsable">Teléfono del Responsable:</label>
                <input type="tel" id="telefono_responsable" name="telefono_responsable" required>
            </div>
            <div class="form-group">
                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                <input type="date" id="fecha_ingreso" name="fecha_ingreso" required onchange="calcularSalida();">
            </div>
            <div class="form-group">
                <label for="fecha_salida">Fecha de Salida:</label>
                <input type="date" id="fecha_salida" name="fecha_salida" readonly>
            </div>
            <div class="form-group">
                <label for="curp">CURP:</label>
                <input type="text" id="curp" name="curp" pattern="[A-Z]{4}[0-9]{6}[A-Z]{6}[0-9]{2}" maxlength="18" required oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="form-group">
                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
            </div>
            <button type="submit" class="submit-button">Guardar</button>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        </form>
    </section>
</main>

<footer>
    <p>&copy; 2024 Patrulla Espiritual | Todos los derechos reservados</p>
</footer>

</body>
</html>
