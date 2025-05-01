<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "centro_rehabilitacion";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el término de búsqueda si se envía el formulario
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Construir la consulta SQL para mostrar todos los registros o filtrar según el término de búsqueda
$sql = "SELECT p.*, f.foto FROM personas p 
        LEFT JOIN fotos_persona f ON p.id_persona = f.id_persona";

// Agregar filtro solo si se proporciona un término de búsqueda
if (!empty($buscar)) {
    $sql .= " WHERE p.curp LIKE '%$buscar%' 
              OR p.nombre LIKE '%$buscar%' 
              OR p.fecha_ingreso LIKE '%$buscar%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Persona - Patrulla Espiritual</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="img/icono.png" type="image/png">
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

        .search-section {
            text-align: center;
            margin: 20px 0;
        }

        .search-section input {
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-section button {
            padding: 10px 20px;
            background-color: #B8860B;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-section button:hover {
            background-color: #DAA520;
        }

        .result-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .result-item {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .result-item h3 {
            color: #B8860B;
            font-size: 1.3em;
            margin-bottom: 15px;
        }

        .result-item img {
            width: 150px;
            height: auto;
            border-radius: 8px;
            display: block;
            margin: 15px auto 0;
        }

        .result-item p {
            margin: 5px 0;
            font-size: 1em;
            text-align: justify;
        }

        .result-item .info {
            font-size: 0.95em;
        }

        .result-item .info strong {
            color: #B8860B;
        }

        @media (max-width: 768px) {
            .result-container {
                flex-direction: column;
                align-items: center;
            }

            .result-item {
                width: 80%;
            }
        }

        footer {
            background-color: #DAA520;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
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
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="tomarfoto.php">Capturar fotografía</a></li>
            <li><a href="nuevapersona.php">Nueva Persona</a></li>
            <li><a href="barra.php">Buscar</a></li>
            <li><a href="persona.php">Actualizar Datos</a></li>
            <li><a href="comprobante.php">Comprobante</a></li>
        </ul>
    </nav>
</header>
<br><br><br><br>

<section class="search-section">
    <h2>Buscar Persona</h2>
    <form method="GET" action="">
        <input type="text" name="buscar" placeholder="Buscar por CURP, nombre o fecha de ingreso" required>
        <button type="submit">Buscar</button>
    </form>
</section>

<section class="table-section">
    <h1>Resultados de la Búsqueda</h1>
    <div class="result-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $fecha_nacimiento = date("d-m-Y", strtotime($row["fecha_nacimiento"]));
                $fecha_ingreso = date("d-m-Y", strtotime($row["fecha_ingreso"]));

                // Calcular días restantes
                $fecha_ingreso_original = new DateTime($row["fecha_ingreso"]);
                $fecha_actual = new DateTime();
                $dias_transcurridos = $fecha_ingreso_original->diff($fecha_actual)->days;
                $dias_restantes = max(90 - $dias_transcurridos, 0);

                $foto = !empty($row["foto"]) ? base64_encode($row["foto"]) : 'img/default.png';

                echo "<div class='result-item'>
                    <h3>" . htmlspecialchars($row["nombre"]) . " " . htmlspecialchars($row["apellido_paterno"]) . " " . htmlspecialchars($row["apellido_materno"]) . "</h3>
                    <div class='info'>
                        <p><strong>ID:</strong> " . htmlspecialchars($row["id_persona"]) . "</p>
                        <p><strong>CURP:</strong> " . htmlspecialchars($row["curp"]) . "</p>
                        <p><strong>Fecha de Nacimiento:</strong> " . $fecha_nacimiento . "</p>
                        <p><strong>Fecha de Ingreso:</strong> " . $fecha_ingreso . "</p>
                        <p><strong>Días Restantes:</strong> " . $dias_restantes . " días</p>
                        <p><strong>Nombre Responsable:</strong> " . htmlspecialchars($row["nombre_responsable"]) . "</p>
                        <p><strong>Teléfono Responsable:</strong> " . htmlspecialchars($row["telefono_responsable"]) . "</p>
                    </div>
                    <img src='data:image/jpeg;base64," . $foto . "' alt='Foto'>
                </div>";
            }
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }
        ?>
    </div>
</section>
<br>
<footer>
    <p>&copy; 2024 Patrulla Espiritual - Camino a la Libertad</p>
</footer>

</body>
</html>
