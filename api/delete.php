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
$tableName = "alumnos";
// Database connection parameters
$data = json_decode(file_get_contents("php://input"), true);

// Check if 'itemIds' key exists in $data
if (isset($data['itemIds'])) {
    $itemIds = $data['itemIds'];

    // Delete items from the database
    foreach ($itemIds as $itemId) {
        // Escape and sanitize the input to prevent SQL injection
        $itemId = mysqli_real_escape_string($conn, $itemId);

        // Use SQL LIKE to delete values that start with the given characters
        $sql = "DELETE FROM $tableName WHERE DNI LIKE '$itemId%'";

        if ($conn->query($sql) === TRUE) {
            // Item deleted successfully
        } else {
            echo "Error deleting items: " . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();

    // Respond to the Angular application (you can customize the response accordingly)
    header('Content-Type: application/json');
    echo json_encode(["message" => "Items deleted successfully"]);
} else {
    // Respond with an error message if 'itemIds' key is not present
    header('Content-Type: application/json');
    echo json_encode(["error" => "Invalid request format"]);
}
?>