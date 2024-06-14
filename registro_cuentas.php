<?php
header('Content-Type: application/json'); // Asegurar que el contenido sea JSON

$servername = "localhost";
$username = "root";
$password = "escuadron99";
$dbname = "digital_accounts";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Conexión fallida: " . $conn->connect_error]);
    exit();
}

// Validar y capturar datos del formulario
$platform = isset($_POST['platform']) ? $_POST['platform'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$accountPassword = isset($_POST['password']) ? $_POST['password'] : null;
$accountCost = isset($_POST['accountCost']) ? $_POST['accountCost'] : null;
$profileNames = isset($_POST['profileName']) ? $_POST['profileName'] : [];
$profilePins = isset($_POST['profilePin']) ? $_POST['profilePin'] : [];
$profilePrices = isset($_POST['profilePrice']) ? $_POST['profilePrice'] : [];

// Ver valores recibidos
error_log("Platform: " . $platform);
error_log("Email: " . $email);
error_log("Account Password: " . $accountPassword);
error_log("Account Cost: " . $accountCost);
error_log("Profile Names: " . implode(", ", $profileNames));
error_log("Profile Pins: " . implode(", ", $profilePins));
error_log("Profile Prices: " . implode(", ", $profilePrices));

// Verificar que los datos requeridos no estén vacíos
if (is_null($platform) || is_null($email) || is_null($accountPassword) || is_null($accountCost) || empty($profileNames) || empty($profilePins) || empty($profilePrices)) {
    echo json_encode(["status" => "error", "message" => "Error: Faltan datos del formulario."]);
    exit();
}

// Validar que cada perfil tenga un precio válido
foreach ($profilePrices as $price) {
    if (!is_numeric($price) || $price <= 0) {
        echo json_encode(["status" => "error", "message" => "Error: Todos los perfiles deben tener un precio válido."]);
        exit();
    }
}

// Insertar cuenta principal
$sql = "INSERT INTO accounts (platform, email, password, account_cost) VALUES ('$platform', '$email', '$accountPassword', '$accountCost')";
if ($conn->query($sql) === TRUE) {
    $accountId = $conn->insert_id;
    // Insertar perfiles asociados
    for ($i = 0; $i < count($profileNames); $i++) {
        $profileName = $profileNames[$i];
        $profilePin = $profilePins[$i];
        $profilePrice = $profilePrices[$i];
        $sql = "INSERT INTO profiles (account_id, profile_name, profile_pin, profile_price) VALUES ('$accountId', '$profileName', '$profilePin', '$profilePrice')";
        if (!$conn->query($sql)) {
            echo json_encode(["status" => "error", "message" => "Error al insertar perfiles: " . $conn->error]);
            exit();
        }
    }
    echo json_encode(["status" => "success", "message" => "Los datos de la cuenta fueron guardados con éxito"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al insertar cuenta principal: " . $conn->error]);
}

$conn->close();
?>
