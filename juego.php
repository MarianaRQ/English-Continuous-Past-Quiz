<?php
session_start();
include "db.php";

// Si es el primer acceso, reiniciamos el conteo de preguntas
if (!isset($_SESSION["contador"])) {
    $_SESSION["contador"] = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"])) {
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
if ($_SESSION["contador"] >= 10) {
    header("Location: ranking.php");
    exit();
}
if (!isset($_SESSION['preguntas_vistas'])) {
    $_SESSION['preguntas_vistas'] = [];
}

// Convertir a lista para SQL
$ids_vistas = implode(",", $_SESSION['preguntas_vistas']);
if ($ids_vistas == "") {
    $ids_vistas = "0"; // para que no dé error en la consulta
}

// Seleccionamos una pregunta aleatoria
$pregunta = $conn->query("SELECT * FROM preguntas WHERE id NOT IN ($ids_vistas)  ORDER BY RAND() LIMIT 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Preguntas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

</head>
<audio id="bgMusic" src="music/sonido1.mp3" autoplay loop></audio>

<body class="juego">
    <div class="container mt-5 preguntas">
        <h5 class="numero mt-4 mb-2">Pregunta <?php echo $_SESSION["contador"] + 1; ?> de 10</h5>

        <div class="imagen container contenter-center mt-4">
            <img src="img/caricatura.png" alt="" class=" img-fluid mb-4">
        </div>
        <h3><?php echo $pregunta['pregunta']; ?></h3>

        <form id="formPregunta" action="resultado.php" method="post">
            <input type="hidden" name="jugador_id" value="<?php echo $jugador_id; ?>">
            <input type="hidden" name="respuesta_correcta" value="<?php echo $pregunta['respuesta_correcta']; ?>">

            <div class="row">
                <div class="btn-group d-flex flex-wrap" role="group">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="respuesta" id="opcion<?php echo $i; ?>"
                                value="<?php echo $i; ?>" required>
                            <label class="btn btn-outline-primary m-2 flex-fill" for="opcion<?php echo $i; ?>">
                                <?php echo $pregunta['opcion' . $i]; ?>
                            </label>
                        </div>
                    <?php endfor; ?>
                </div>

            </div>

            <button type="submit" class="btn btn-info mt-3">Responder</button>
        </form>
        <p class="tiempo mt-4">
            ⏳ Tiempo restante:
            <span id="timer" class="circle-timer ms-3 mt-3">15</span>
        </p>
    </div>

    <script src="js/script.js"></script>
</body>

</html>