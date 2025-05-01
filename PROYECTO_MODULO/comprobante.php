<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante - Patrulla Espiritual</title>
    <link rel="icon" href="img/icono.png" type="image/png">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos generales para el cuerpo de la página */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Sección del formulario */
        .form-section {
            background-color: #FFF8E1; /* Fondo dorado suave */
            padding: 40px 20px;
            margin-top: 80px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 70%;
            margin-left: auto;
            margin-right: auto;
        }

        /* Título principal del formulario */
        .form-section h1 {
            text-align: center;
            color: #DAA520; /* Dorado */
            margin-bottom: 30px;
            font-size: 28px;
        }

        /* Estilos para los grupos del formulario */
        .form-group {
            margin-bottom: 20px;
        }

        /* Etiquetas de los campos del formulario */
        .form-group label {
            font-weight: bold;
            color: #DAA520; /* Dorado */
            margin-bottom: 5px;
            font-size: 16px;
        }

        /* Campos de entrada */
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #DAA520; /* Borde dorado */
            border-radius: 5px;
            font-size: 16px;
            background-color: #EEE2B5; /* Fondo suave dorado */
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #DAA520;
            outline: none;
        }

        /* Estilo para el botón de generar comprobante */
        .submit-button {
            background-color: #DAA520; /* Dorado */
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 20px;
        }

        .submit-button:hover {
            background-color: #C88B12; /* Dorado oscuro */
        }

        /* Estilos para el pie de página */
        footer {
            background-color: #DAA520;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Estilo del div con el comprobante de compra */
        .ticket {
            background-color: #fff;
            width: 300px;
            padding: 20px;
            border: 2px solid #DAA520;
            margin: 30px auto;
            border-radius: 10px;
            text-align: center;
            font-size: 14px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .ticket img {
            max-width: 100px;
            margin-bottom: 10px;
        }

        .ticket .field {
            margin-bottom: 10px;
            font-weight: bold;
            color: #DAA520;
        }

        .ticket .value {
            font-size: 16px;
            color: #333;
        }
    </style>
    <style>
    /* Estilos para la impresión */
    @media print {
        body * {
            visibility: hidden;
        }
        
        .ticket, .ticket * {
            visibility: visible;
        }
        
        .ticket {
            position: absolute;
            left: 0;
            top: 0;
        }
        
        button {
            display: none; /* Ocultar el botón de impresión */
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

<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "centro_rehabilitacion";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Variables por defecto
$nombre = $apellidoPaterno = $apellidoMaterno = $fechaNacimiento = $nombreResponsable = $telefonoResponsable = $fechaIngreso = $fechaSalida = "";

// Verificar si se ha enviado el formulario con el ID
if (isset($_POST['buscar'])) {
    $id = $_POST['id'];

    // Preparar la consulta SQL para obtener los datos a partir del ID
    $sql = "SELECT * FROM personas WHERE id_persona = '$id'";
    $resultado = $conn->query($sql);

    // Verificar si se encontraron resultados
    if ($resultado->num_rows > 0) {
        // Obtener los datos de la persona
        $row = $resultado->fetch_assoc();
        $nombre = $row['nombre'];
        $apellidoPaterno = $row['apellido_paterno'];
        $apellidoMaterno = $row['apellido_materno'];
        // Formatear las fechas
        $fechaNacimiento = date("d-m-Y", strtotime($row['fecha_nacimiento']));
        $nombreResponsable = $row['nombre_responsable'];
        $telefonoResponsable = $row['telefono_responsable'];
        $fechaIngreso = date("d-m-Y", strtotime($row['fecha_ingreso'])); // Formato para fecha de ingreso
        $fechaSalida = date("d-m-Y", strtotime($row['fecha_salida'])); // Formato para fecha de salida
    } else {
        echo "No se encontraron resultados.";
    }
}

$conn->close();
?>

<div class="form-section">
    <h1>Generar Comprobante de Ingreso</h1>
    <form method="post" action="comprobante.php">
        <div class="form-group">
            <label for="id">ID Persona:</label>
            <input type="text" id="id" name="id" required>
            <button type="submit" name="buscar" class="submit-button">Buscar</button>
        </div>
    </form>

    <?php if (isset($_POST['buscar']) && !empty($nombre)): ?>
        <!-- Mostrar el ticket -->
        <div class="ticket">
            <img src="img/logo_anexo.png" alt="Logo">
            <div class="field">Nombre:</div>
            <div class="value"><?php echo $nombre; ?></div>

            <div class="field">Apellido Paterno:</div>
            <div class="value"><?php echo $apellidoPaterno; ?></div>

            <div class="field">Apellido Materno:</div>
            <div class="value"><?php echo $apellidoMaterno; ?></div>

            <div class="field">Fecha de Nacimiento:</div>
            <div class="value"><?php echo $fechaNacimiento; ?></div>

            <div class="field">Nombre del Responsable:</div>
            <div class="value"><?php echo $nombreResponsable; ?></div>

            <div class="field">Teléfono Responsable:</div>
            <div class="value"><?php echo $telefonoResponsable; ?></div>

            <div class="field">Fecha de Ingreso:</div>
            <div class="value"><?php echo $fechaIngreso; ?></div>

            <div class="field">Fecha de Salida:</div>
            <div class="value"><?php echo $fechaSalida; ?></div>
        </div>

        <button class="submit-button" onclick="window.print()">Imprimir Comprobante</button>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; 2024 Patrulla Espiritual. Todos los derechos reservados.</p>
</footer>

</body>
</html>
