<?php
session_start();
include "db.php";

// Si es el primer acceso, reiniciamos el conteo de preguntas
if(!isset($_SESSION["contador"])){
    $_SESSION["contador"] = 0;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"])){
    $nombre = $_POST["nombre"];
    $conn->query("INSERT INTO participantes (nombre) VALUES ('$nombre')");
    $jugador_id = $conn->insert_id;
    $_SESSION["jugador_id"] = $jugador_id;

    // 🔥 Reiniciamos el contador cuando empieza un nuevo jugador
    $_SESSION["contador"] = 0;
} else {
    $jugador_id = $_SESSION["jugador_id"];
}


// Verificamos si ya respondió 10 preguntas
if($_SESSION["contador"] >= 10){
    header("Location: ranking.php");
    exit();
}

// Seleccionamos una pregunta aleatoria
$pregunta = $conn->query("SELECT * FROM preguntas ORDER BY RAND() LIMIT 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Preguntas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<audio id="bgMusic" src="music/sonido1.mp3" autoplay loop></audio>

<body class="container mt-5">
    <h5>Pregunta <?php echo $_SESSION["contador"]+1; ?> de 10</h5>
    <h3><?php echo $pregunta['pregunta'];?></h3>
    
    <form  id="formPregunta" action="resultado.php" method="post">
        <input type="hidden" name="jugador_id" value="<?php echo $jugador_id;?>">
        <input type="hidden" name="respuesta_correcta" value="<?php echo $pregunta['respuesta_correcta'];?>">

        <?php for ($i = 1; $i <= 4; $i++): ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="respuesta" value="<?php echo $i; ?>" required>
                <label class="form-check-label"><?php echo $pregunta['opcion'.$i]; ?></label>
            </div>
        <?php endfor; ?>

        <button type="submit" class="btn btn-success mt-3">Responder</button>
    </form>
    <p>⏳ Tiempo restante: <span id="timer">15</span> segundos</p>

        <script src="js/script.js"></script>
</body>
</html>
