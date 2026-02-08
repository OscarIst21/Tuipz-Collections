<?php
session_start();
require_once __DIR__ . '/../config.php';
admin_requerido();
$pdo = conectarDB();
$categoriasMap = obtenerCategoriasEnum($pdo);
$activos = $pdo->query("SELECT nombre FROM categorias_admin WHERE activo=1")->fetchAll(PDO::FETCH_COLUMN);
$todas = array_values($categoriasMap);
$categorias = $activos ? array_values(array_intersect($todas, $activos)) : $todas;
$uploadDir = __DIR__ . '/../img/uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
function guardarImagen($file, $uploadDir) {
    if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) return null;
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg','jpeg','png','webp'];
    if (!in_array($ext, $permitidas)) return null;
    $nombre = uniqid('prod_') . '.' . $ext;
    $destinoFs = $uploadDir . '/' . $nombre;
    if (!move_uploaded_file($file['tmp_name'], $destinoFs)) return null;
    return 'img/uploads/' . $nombre;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    if ($accion === 'crear') {
        $codigo = limpiarDatos($_POST['codigo'] ?? '');
        $nombre = limpiarDatos($_POST['nombre'] ?? '');
        $descripcion = limpiarDatos($_POST['descripcion'] ?? '');
        $precio = (float)($_POST['precio'] ?? 0);
        $categoriaSel = $_POST['categoria'] ?? '';
        $stock = (int)($_POST['stock'] ?? 0);
        if (!in_array($categoriaSel, $categorias)) $categoriaSel = $categorias[0] ?? '';
        $imagenPath = guardarImagen($_FILES['imagen'] ?? [], $uploadDir);
        $stmt = $pdo->prepare("INSERT INTO productos (codigo,nombre,descripcion,precio,categoria,stock,imagen) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([$codigo,$nombre,$descripcion,$precio,$categoriaSel,$stock,$imagenPath]);
        header('Location: productos.php');
        exit;
    }
    if ($accion === 'actualizar') {
        $id = (int)($_POST['id'] ?? 0);
        $codigo = limpiarDatos($_POST['codigo'] ?? '');
        $nombre = limpiarDatos($_POST['nombre'] ?? '');
        $descripcion = limpiarDatos($_POST['descripcion'] ?? '');
        $precio = (float)($_POST['precio'] ?? 0);
        $categoriaSel = $_POST['categoria'] ?? '';
        $stock = (int)($_POST['stock'] ?? 0);
        if (!in_array($categoriaSel, $categorias)) $categoriaSel = $categorias[0] ?? '';
        $imagenPath = guardarImagen($_FILES['imagen'] ?? [], $uploadDir);
        if ($imagenPath) {
            $stmt = $pdo->prepare("UPDATE productos SET codigo=?, nombre=?, descripcion=?, precio=?, categoria=?, stock=?, imagen=? WHERE id=?");
            $stmt->execute([$codigo,$nombre,$descripcion,$precio,$categoriaSel,$stock,$imagenPath,$id]);
        } else {
            $stmt = $pdo->prepare("UPDATE productos SET codigo=?, nombre=?, descripcion=?, precio=?, categoria=?, stock=? WHERE id=?");
            $stmt->execute([$codigo,$nombre,$descripcion,$precio,$categoriaSel,$stock,$id]);
        }
        header('Location: productos.php');
        exit;
    }
    if ($accion === 'eliminar') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id=?");
        $stmt->execute([$id]);
        header('Location: productos.php');
        exit;
    }
}
$busqueda = isset($_GET['q']) ? limpiarDatos($_GET['q']) : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$porPagina = 20;
$sql = "SELECT * FROM productos WHERE 1=1";
$params = [];
if ($busqueda) {
    $sql .= " AND (nombre LIKE ? OR codigo LIKE ?)";
    $params[] = "%$busqueda%";
    $params[] = "%$busqueda%";
}
$countSql = str_replace("SELECT *", "SELECT COUNT(*)", $sql);
$stmt = $pdo->prepare($countSql);
$stmt->execute($params);
$total = (int)$stmt->fetchColumn();
$offset = ($pagina - 1) * $porPagina;
$sql .= " ORDER BY id DESC LIMIT $porPagina OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll();
$totalPaginas = max(1, ceil($total / $porPagina));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Admin Tuipz</a>
            <div>
                <a class="btn btn-outline-light btn-sm" href="categorias.php">Categorías</a>
                <a class="btn btn-danger btn-sm" href="logout.php">Salir</a>
            </div>
        </div>
    </nav>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-3">Productos</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">Agregar</button>
        </div>
        <form class="row g-2 mb-3" method="get">
            <div class="col-auto">
                <input class="form-control" name="q" placeholder="Buscar" value="<?= htmlspecialchars($busqueda) ?>">
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-primary" type="submit">Buscar</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $it): ?>
                    <tr>
                        <td><?= (int)$it['id'] ?></td>
                        <td><?php if ($it['imagen']): ?><img src="../<?= htmlspecialchars($it['imagen']) ?>" style="height:48px"><?php endif; ?></td>
                        <td><?= htmlspecialchars($it['codigo']) ?></td>
                        <td><?= htmlspecialchars($it['nombre']) ?></td>
                        <td><?= htmlspecialchars($it['categoria']) ?></td>
                        <td><?= formatearPrecio($it['precio']) ?></td>
                        <td><?= (int)$it['stock'] ?></td>
                        <td>
                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modalEditar<?= (int)$it['id'] ?>">Editar</button>
                            <form method="post" class="d-inline" onsubmit="return confirm('Eliminar producto?')">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
                                <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <div class="modal fade" id="modalEditar<?= (int)$it['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar producto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <input type="hidden" name="accion" value="actualizar">
                                            <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
                                            <div class="col-md-4">
                                                <label class="form-label">Código</label>
                                                <input class="form-control" name="codigo" value="<?= htmlspecialchars($it['codigo']) ?>" required>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label">Nombre</label>
                                                <input class="form-control" name="nombre" value="<?= htmlspecialchars($it['nombre']) ?>" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Descripción</label>
                                                <textarea class="form-control" name="descripcion" rows="3"><?= htmlspecialchars($it['descripcion']) ?></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Precio</label>
                                                <input class="form-control" type="number" step="0.01" name="precio" value="<?= htmlspecialchars($it['precio']) ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Stock</label>
                                                <input class="form-control" type="number" name="stock" value="<?= (int)$it['stock'] ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Categoría</label>
                                                <select class="form-select" name="categoria">
                                                    <?php foreach ($categorias as $c): ?>
                                                    <option value="<?= htmlspecialchars($c) ?>" <?= $c === $it['categoria'] ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Imagen</label>
                                                <input class="form-control" type="file" name="imagen" accept=".jpg,.jpeg,.png,.webp">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                                        <button class="btn btn-primary" type="submit">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <nav>
            <ul class="pagination">
                <?php for ($i=1;$i<=$totalPaginas;$i++): ?>
                <li class="page-item <?= $i===$pagina?'active':'' ?>">
                    <a class="page-link" href="?<?= http_build_query(['q'=>$busqueda,'pagina'=>$i]) ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <div class="modal fade" id="modalCrear" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row g-3">
                            <input type="hidden" name="accion" value="crear">
                            <div class="col-md-4">
                                <label class="form-label">Código</label>
                                <input class="form-control" name="codigo" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nombre</label>
                                <input class="form-control" name="nombre" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="3"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Precio</label>
                                <input class="form-control" type="number" step="0.01" name="precio" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Stock</label>
                                <input class="form-control" type="number" name="stock" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Categoría</label>
                                <select class="form-select" name="categoria">
                                    <?php foreach ($categorias as $c): ?>
                                    <option value="<?= htmlspecialchars($c) ?>"><?= htmlspecialchars($c) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Imagen</label>
                                <input class="form-control" type="file" name="imagen" accept=".jpg,.jpeg,.png,.webp">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
