
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

// Function to validate login
function validateLogin($username, $password) {
    global $conn;

    // Prevent SQL injection (you should use prepared statements)
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Query to check user credentials
    $query = "SELECT * FROM usuario WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // User credentials are valid
        return true;
    } else {
        // User credentials are invalid
        return false;
    }
}

// Handle login request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get username and password from the request
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate login
    if (validateLogin($username, $password)) {
        $token = bin2hex(random_bytes(16));

        // Set the cookie with the token
        setcookie("auth_token", $token, time() , "/"); // Set expiration time (1 hour in this case)
    
        // Login successful
        echo json_encode(["status" => "success", "message" => "Login successful", "token" => $token]);

    } else {
        // Login failed
        echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
    }
} else {
    // Handle invalid request method
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

// Close database connection
$conn->close();
?>