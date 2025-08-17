<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "quiz_game";


$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
//echo "✅ Conexión exitosa a la base de datos";

?>