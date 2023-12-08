
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "proyectoIntegrado";
// Create a connection to the MySQL database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the POST request
$data = json_decode(file_get_contents('php://input'), true);
if (empty($data)) {
    die(json_encode(["error" => "No data received"]));
}
$district = isset($data['place']['district']) ? $data['place']['district'] : '';
$city = isset($data['place']['city']) ? $data['place']['city'] : '';

// Assuming the table in your database is named 'users'
$sql = "INSERT INTO alumnos (Nombre, Apellido, DNI, Fecha_Nacimiento, Telefono, email, ComunidadAutonoma, Provincia, Municipio, calle, numero,CodigoPostal, Piso, Letra, Profesor)
        VALUES (
            '" . $data['firstName'] . "',
            '" . $data['surName'] . "',
            '" . $data['nif'] . "',
            '" . $data['birthDate'] . "',
            '" . $data['phone'] . "',
            '" . $data['email'] . "',
            '" . $data['place']['AC'] . "',
            '" . $data['place']['district'] . "',
            '" . $data['place']['city'] . "',
            '" . $data['address']['st'] . "',
            '" . $data['address']['number'] . "',
            '" . $data['address']['PC'] . "',
            '" . $data['address']['floor'] . "',
            '" . $data['address']['letter'] . "',
            '" . $data['teacher'] . "'
        )";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Form data saved successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
}

$conn->close();
?>