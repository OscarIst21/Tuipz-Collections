<?php
session_start();
require_once __DIR__ . '/../config.php';
admin_requerido();
$pdo = conectarDB();
$pdo->exec("CREATE TABLE IF NOT EXISTS categorias_admin (nombre VARCHAR(255) PRIMARY KEY, activo TINYINT DEFAULT 1)");
$enum = obtenerCategoriasEnum($pdo);
foreach ($enum as $k => $v) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO categorias_admin (nombre, activo) VALUES (?,1)");
    $stmt->execute([$v]);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = limpiarDatos($_POST['nombre'] ?? '');
    $accion = $_POST['accion'] ?? '';
    if ($accion === 'toggle' && $nombre) {
        $pdo->prepare("UPDATE categorias_admin SET activo = 1 - activo WHERE nombre = ?")->execute([$nombre]);
        header('Location: categorias.php');
        exit;
    }
    if ($accion === 'crear' && $nombre) {
        $current = array_values(obtenerCategoriasEnum($pdo));
        if (!in_array($nombre, $current, true)) {
            $nuevaLista = $current;
            $nuevaLista[] = $nombre;
            $quoted = array_map(function($v) { return "'" . str_replace("'", "\\'", $v) . "'"; }, $nuevaLista);
            $sqlAlter = "ALTER TABLE productos MODIFY COLUMN categoria ENUM(" . implode(',', $quoted) . ") NOT NULL";
            $pdo->exec($sqlAlter);
        }
        $pdo->prepare("INSERT IGNORE INTO categorias_admin (nombre, activo) VALUES (?,1)")->execute([$nombre]);
    }
    header('Location: categorias.php');
    exit;
}
$cats = $pdo->query("SELECT nombre, activo FROM categorias_admin ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Admin Tuipz</a>
            <div>
                <a class="btn btn-outline-light btn-sm" href="productos.php">Productos</a>
                <a class="btn btn-danger btn-sm" href="logout.php">Salir</a>
            </div>
        </div>
    </nav>
    <div class="container py-4">
        <h4 class="mb-3">Categorías</h4>
        <div class="card mb-4">
            <div class="card-body">
                <form class="row g-3" method="post">
                    <input type="hidden" name="accion" value="crear">
                    <div class="col-md-8">
                        <label class="form-label">Nueva categoría</label>
                        <input class="form-control" name="nombre" placeholder="Ej. Figuras de yeso">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary" type="submit">Agregar categoría</button>
                    </div>
                </form>
                <div class="form-text mt-2">Se agrega al ENUM de productos y se habilita para uso.</div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($cats as $c): ?>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div><?= htmlspecialchars($c['nombre']) ?></div>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="accion" value="toggle">
                            <input type="hidden" name="nombre" value="<?= htmlspecialchars($c['nombre']) ?>">
                            <button class="btn <?= $c['activo'] ? 'btn-success' : 'btn-secondary' ?>" type="submit">
                                <?= $c['activo'] ? 'Activo' : 'Inactivo' ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
