<?php
session_start();
require_once __DIR__ . '/../config.php';
admin_requerido();
$pdo = conectarDB();
$stats = obtenerEstadisticasProductos($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Tuipz</a>
            <div>
                <a class="btn btn-outline-light btn-sm" href="categorias.php">Categorías</a>
                <a class="btn btn-outline-light btn-sm" href="productos.php">Productos</a>
                <a class="btn btn-danger btn-sm" href="logout.php">Salir</a>
            </div>
        </div>
    </nav>
    <div class="container py-4">
        <h4 class="mb-3">Resumen</h4>
        <div class="row">
            <?php foreach ($stats as $s): ?>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="fw-bold"><?= htmlspecialchars($s['categoria']) ?></div>
                        <div>Total: <?= (int)$s['total'] ?></div>
                        <div>Promedio: <?= formatearPrecio($s['precio_promedio']) ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
