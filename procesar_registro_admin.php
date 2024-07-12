<?php
session_start();

// Verificar si la solicitud es mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establecer la conexión a la base de datos con las credenciales proporcionadas
    $servername = "sql204.infinityfree.com"; // Nombre del servidor MySQL
    $username = "if0_36879343"; // Nombre de usuario MySQL
    $password = "m4ph6uupmH"; // Contraseña MySQL
    $database = "if0_36879343_registro"; // Nombre de la base de datos MySQL

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Recibir los datos del formulario y asegurarse de que están definidos
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellido_paterno = isset($_POST['apellido_paterno']) ? $_POST['apellido_paterno'] : '';
    $apellido_materno = isset($_POST['apellido_materno']) ? $_POST['apellido_materno'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Verificar que todos los campos requeridos estén presentes
    if (empty($nombre) || empty($apellido_paterno) || empty($apellido_materno) || empty($email) || empty($telefono) || empty($password)) {
        die("Por favor, complete todos los campos del formulario.");
    }

    // Encriptar la contraseña (opcional pero altamente recomendado)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar el usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, email, telefono, password) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia SQL
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }
    
    // Asociar parámetros
    $stmt->bind_param("ssssss", $nombre, $apellido_paterno, $apellido_materno, $email, $telefono, $hashed_password);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $_SESSION['nombreUsuario'] = $nombre; // Guardar el nombre del usuario en la sesión
        echo "Usuario registrado exitosamente";
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    // Cerrar la sentencia
    $stmt->close();

    // Cerrar la conexión
    $conn->close();
} else {
    // Si la solicitud no es mediante el método POST, mostrar un mensaje de error
    die("Acceso no válido");
}
?>
