<?php
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="inicio d-flex justify-content-center align-items-center vh-100">

    <div class="container text-center pregunta">
        <!-- Logo -->
        <div class="mb-4">
            <img src="img/logo.png" alt="logo" class="logo img-fluid">
        </div>

        <!-- Registro -->
        <div class="registro mx-auto p-5 border rounded shadow col-md-6 col-lg-4">
            <h2 class="mb-3">Ingresar al juego</h2>
            <form action="juego.php" method="post">
                <input type="text" name="nombre" class="form-control mb-3" placeholder="Tu nombre" required>
                <button onclick="startGame()" type="submit" class="btn btn-primary w-100 mb-5">Iniciar Juego</button>
            </form>
        </div>
    </div>

    <!-- Audios -->
   <audio id="effectSound" src="music/sonido2.mp3" autoplay muted loop></audio>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const effectSound = document.getElementById("effectSound");

    // Desmutear en el primer clic para que ya suene
    document.body.addEventListener("click", () => {
        effectSound.muted = false;
        effectSound.play();
    }, { once: true });
});
</script>



</body>

</html>
