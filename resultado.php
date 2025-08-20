<?php
session_start();
include "db.php";

$jugador_id = $_POST['jugador_id'];
$respuesta = $_POST['respuesta'];
$respuesta_correcta = $_POST['respuesta_correcta'];

// Inicializamos el contador si no existe
if(!isset($_SESSION["contador"])){
    $_SESSION["contador"] = 0;
}

$respuesta = isset($_POST['respuesta']) ? $_POST['respuesta'] : 0;

// Evaluar respuesta
if($respuesta == $respuesta_correcta) {
    $conn->query("UPDATE participantes SET puntaje = puntaje + 10 WHERE id = $jugador_id");
    $mensaje = "¡Correcto! Sumaste 10 puntos 🎉";
    $tipo = "success";
} else {
    $mensaje = "Incorrecto 😢";
    $tipo = "danger";
}

// Aumentamos el contador
$_SESSION["contador"]++;

// Si ya respondió 10 preguntas → ir a ranking
if($_SESSION["contador"] >= 10){
    header("Refresh: 2; url=ranking.php"); // espera 2 segundos y va al ranking
    $finalizado = true;
} else {
    $finalizado = false;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0d1b2a; /* Azul oscuro */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }
        .resultado-box {
            background: #1b263b;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }
        .resultado-box h3 {
            margin-bottom: 20px;
        }
        .btn {
            margin: 5px;
            border-radius: 10px;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <div class="resultado-box">
        <h3 class="text-<?php echo $tipo; ?>">
            <?php echo $mensaje; ?>
        </h3>

        <?php if(!$finalizado): ?>
            <a href="juego.php?jugador_id=<?php echo $jugador_id; ?>" class="btn btn-primary">Siguiente Pregunta</a>
            <a href="ranking.php" class="btn btn-secondary">Ver Ranking</a>
        <?php else: ?>
            <div class="alert alert-success mt-3">
                ¡Has respondido las 10 preguntas! 🎯 Serás enviado al ranking...
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
