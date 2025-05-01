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

// Eliminar registro
if (isset($_POST['eliminar'])) {
    $id_eliminar = $_POST['id_eliminar'];

    // Verificar si el ID existe en la tabla personas
    $sql_check = "SELECT * FROM personas WHERE id_persona = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id_eliminar);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Eliminar primero de la tabla fotos_persona
        $sql_delete_foto = "DELETE FROM fotos_persona WHERE id_persona = ?";
        $stmt_foto = $conn->prepare($sql_delete_foto);
        $stmt_foto->bind_param("i", $id_eliminar);
        $stmt_foto->execute();

        // Luego eliminar de la tabla personas
        $sql_delete_persona = "DELETE FROM personas WHERE id_persona = ?";
        $stmt_persona = $conn->prepare($sql_delete_persona);
        $stmt_persona->bind_param("i", $id_eliminar);
        $stmt_persona->execute();

        echo "<script>alert('El registro con ID $id_eliminar ha sido eliminado correctamente.');</script>";
    } else {
        echo "<script>alert('El ID $id_eliminar no existe en la base de datos.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Personas - Patrulla Espiritual</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="icon" href="img/icono.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Asegurar espacio debajo de la barra de navegación */
        main.container {
            margin-top: 80px; /* Ajustar según la altura de la barra */
        }

        /* Formularios de acción */
        .action-forms {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-container {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 48%;
        }

        .form-container h2 {
            text-align: center;
            color: #B8860B;
        }

        .form-container .form-group {
            margin-bottom: 15px;
        }

        .form-container .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-container .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            background-color: #B8860B;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #DAA520;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #B8860B;
            color: white;
        }

        table img {
            max-width: 100px;
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

<main class="container">
    <div class="action-forms">
        <!-- Formulario de Modificar -->
        <div class="form-container">
            <h2>Modificar Registro</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="id_editar">ID del Registro:</label>
                    <input type="number" id="id_editar" name="id_editar" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido_paterno">Apellido Paterno:</label>
                    <input type="text" id="apellido_paterno" name="apellido_paterno" required>
                </div>
                <div class="form-group">
                    <label for="apellido_materno">Apellido Materno:</label>
                    <input type="text" id="apellido_materno" name="apellido_materno" required>
                </div>
                <div class="form-group">
                    <label for="fecha_ingreso">Fecha de Ingreso:</label>
                    <input type="date" id="fecha_ingreso" name="fecha_ingreso" required>
                </div>
                <div class="form-group">
                    <label for="foto">Selecciona una nueva foto (opcional):</label>
                    <input type="file" id="foto" name="foto" accept="image/*">
                </div>
                <button type="submit" name="editar" onclick='return confirm("¿Estás seguro de que deseas modificar este registro?");'>Modificar</button>
            </form>
        </div>

        <!-- Formulario de Eliminar -->
        <div class="form-container">
            <h2>Eliminar Registro</h2>
            <form method='POST' action=''>
                <div class="form-group">
                    <label for="id_eliminar">ID a Eliminar:</label>
                    <input type="number" id="id_eliminar" name="id_eliminar" required>
                </div>
                <button type='submit' name='eliminar' onclick='return confirm("¿Estás seguro de que deseas eliminar este registro?");'>Eliminar</button>
            </form>
        </div>
    </div>

    <section class="table-section">
        <h1 class="text-center">Lista de Personas Registradas</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CURP</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Fecha de Ingreso</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.*, f.foto FROM personas p LEFT JOIN fotos_persona f ON p.id_persona = f.id_persona";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $foto = !empty($row["foto"]) ? "data:image/jpeg;base64," . base64_encode($row["foto"]) : "img/default.png";
                        echo "<tr>
                                <td>{$row["id_persona"]}</td>
                                <td>{$row["curp"]}</td>
                                <td>{$row["nombre"]}</td>
                                <td>{$row["apellido_paterno"]}</td>
                                <td>{$row["apellido_materno"]}</td>
                                <td>{$row["fecha_ingreso"]}</td>
                                <td><img src='{$foto}' alt='Foto'></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay registros disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</main>

<footer>
    <p>&copy; 2024 Patrulla Espiritual. Todos los derechos reservados.</p>
</footer>
</body>
</html>
