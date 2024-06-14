<?php
// Establecer la conexión a la base de datos (reemplaza con tus propias credenciales)
$servername = "localhost";
$username = "root";
$password = "escuadron99";
$database = "registro";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si los datos están siendo enviados correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario y asegurarse de que están definidos
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Verificar que el correo y la contraseña no estén vacíos
    if (empty($email) || empty($password)) {
        echo "Por favor, complete todos los campos del formulario.";
    } else {
        // Preparar la consulta SQL para buscar el usuario en la base de datos
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        
        // Preparar la sentencia SQL
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "Error al preparar la consulta: " . $conn->error;
        } else {
            // Asociar parámetros
            $stmt->bind_param("s", $email);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el resultado de la consulta
                $result = $stmt->get_result();

                // Verificar si se encontró algún usuario con el correo proporcionado
                if ($result->num_rows == 1) {
                    // Obtener la fila del resultado como un array asociativo
                    $row = $result->fetch_assoc();

                    // Verificar si la contraseña ingresada coincide con la almacenada en la base de datos
                    if (password_verify($password, $row['password'])) {
                        echo "success";
                    } else {
                        echo "La contraseña es incorrecta.";
                    }
                } else {
                    echo "El correo electrónico no está registrado. Por favor, contacte a su distribuidor.";
                }
            } else {
                echo "Error al ejecutar la consulta: " . $stmt->error;
            }

            // Cerrar la sentencia
            $stmt->close();
        }
    }
} else {
    echo "Acceso no válido";
}

// Cerrar la conexión
$conn->close();
?>
