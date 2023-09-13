<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$input = $_GET['input'];
$exclude = $_GET['exclude']; 

$query = "SELECT city_name FROM cities WHERE city_name LIKE '%$input%' AND city_name <> '$exclude' LIMIT 10";

$result = mysqli_query($connection, $query);

$cities = array();
while ($row = mysqli_fetch_assoc($result)) {
    $cities[] = $row['city_name'];
}

mysqli_close($connection);

header('Content-Type: application/json');
echo json_encode($cities);
?>
