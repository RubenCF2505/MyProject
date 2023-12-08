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

// Fetch data from the "alumnos" table
$sql = "SELECT * FROM alumnos";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch the data and encode it as JSON
    $alumnos = [];
    while ($row = $result->fetch_assoc()) {
        $alumnos[] = $row;
    }
    echo json_encode($alumnos);
} else {
    // No results found
    echo "No data found";
}

// Close the database connection
$conn->close();

?>