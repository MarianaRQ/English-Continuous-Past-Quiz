<?php
include "db.php";

$resultado = $conn->query("SELECT nombre, puntaje FROM participantes ORDER BY puntaje DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ranking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>🏆 Ranking</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Jugador</th>
                <th>Puntaje</th>
            </tr>
        </thead>
        <tbody>
            <?php while($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila["nombre"]; ?></td>
                    <td><?php echo $fila["puntaje"]; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
