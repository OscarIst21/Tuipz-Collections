<?php
/**
 * Configuración de la Base de Datos
 * Catálogo Tuipz
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'catalogo_tuipz');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configuración de la aplicación
define('PRODUCTOS_POR_PAGINA', 30); // 5x6 productos por página
define('SITIO_NOMBRE', 'Catálogo Tuipz');
define('SITIO_URL', 'http://localhost/catalogo_Tuipz/');

// Configuración de imágenes
define('IMAGEN_PLACEHOLDER', 'https://via.placeholder.com/300x200?text=Sin+Imagen');

define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'tuipz2026');

// Función para conectar a la base de datos
function conectarDB() {
    try {
        $pdo = new PDO(
    "mysql:host=" . DB_HOST . ";port=3306;dbname=" . DB_NAME . ";charset=utf8",
    DB_USER,
    DB_PASS,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]
);

        return $pdo;
    } catch(PDOException $e) {
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }
}

// Función para limpiar datos de entrada
function limpiarDatos($datos) {
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

// Función para formatear precio
function formatearPrecio($precio) {
    return '$' . number_format($precio, 2);
}

function obtenerCategorias() {
    try {
        $pdo = conectarDB();
        $cats = $pdo->query("SHOW TABLES LIKE 'categorias_admin'")->fetchColumn();
        if ($cats) {
            $activos = $pdo->query("SELECT nombre FROM categorias_admin WHERE activo=1 ORDER BY nombre")->fetchAll(PDO::FETCH_COLUMN);
            if ($activos && count($activos) > 0) {
                return array_combine(array_map('strtolower', $activos), $activos);
            }
        }
        return obtenerCategoriasEnum($pdo);
    } catch (Throwable $e) {
        return [
            'pines' => 'Pines',
            'kit lienzos' => 'Kit Lienzos',
            'kit figuras yeso' => 'Kit Figuras Yeso'
        ];
    }
}

// Función para validar categoría
function validarCategoria($categoria) {
    $categorias = obtenerCategorias();
    return array_key_exists(strtolower($categoria), $categorias) || in_array($categoria, $categorias, true);
}

function normalizarCategoriaSeleccion($categoria) {
    $categorias = obtenerCategorias();
    $key = strtolower($categoria);
    if (array_key_exists($key, $categorias)) return $categorias[$key];
    if (in_array($categoria, $categorias, true)) return $categoria;
    return '';
}

function obtenerCategoriasActivas($pdo) {
    $ex = $pdo->query("SHOW TABLES LIKE 'categorias_admin'")->fetchColumn();
    if ($ex) {
        $activos = $pdo->query("SELECT nombre FROM categorias_admin WHERE activo=1 ORDER BY nombre")->fetchAll(PDO::FETCH_COLUMN);
        if ($activos) return $activos;
    }
    $map = obtenerCategoriasEnum($pdo);
    return array_values($map);
}

// Función para generar URL de paginación
function generarURLPaginacion($parametros = []) {
    $url = '?';
    $parametrosActuales = $_GET;
    
    // Combinar parámetros actuales con los nuevos
    $parametrosFinales = array_merge($parametrosActuales, $parametros);
    
    // Remover parámetros vacíos
    $parametrosFinales = array_filter($parametrosFinales, function($valor) {
        return $valor !== '' && $valor !== null;
    });
    
    return $url . http_build_query($parametrosFinales);
}

// Función para obtener estadísticas de productos
function obtenerEstadisticasProductos($pdo) {
    $sql = "SELECT 
                categoria,
                COUNT(*) as total,
                AVG(precio) as precio_promedio,
                MIN(precio) as precio_minimo,
                MAX(precio) as precio_maximo
            FROM productos 
            GROUP BY categoria";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Función para buscar productos
function buscarProductos($pdo, $busqueda = '', $categoria = '', $pagina = 1, $porPagina = PRODUCTOS_POR_PAGINA) {
    $sql = "SELECT * FROM productos WHERE 1=1";
    $params = [];
    
    // Agregar filtro de búsqueda
    if (!empty($busqueda)) {
        $sql .= " AND (nombre LIKE ? OR descripcion LIKE ?)";
        $params[] = "%$busqueda%";
        $params[] = "%$busqueda%";
    }
    
    if (!empty($categoria)) {
        $cat = normalizarCategoriaSeleccion($categoria);
        if ($cat !== '') {
            $sql .= " AND categoria = ?";
            $params[] = $cat;
        }
    }
    $actives = obtenerCategoriasActivas($pdo);
    if (!empty($actives)) {
        $placeholders = implode(',', array_fill(0, count($actives), '?'));
        $sql .= " AND categoria IN ($placeholders)";
        $params = array_merge($params, $actives);
    }
    
    // Contar total de productos
    $countSql = str_replace("SELECT *", "SELECT COUNT(*)", $sql);
    $stmt = $pdo->prepare($countSql);
    $stmt->execute($params);
    $totalProductos = $stmt->fetchColumn();
    
    // Calcular paginación
    $totalPaginas = ceil($totalProductos / $porPagina);
    $offset = ($pagina - 1) * $porPagina;
    
    // Obtener productos de la página actual
    $sql .= " ORDER BY nombre LIMIT $porPagina OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $productos = $stmt->fetchAll();
    
    return [
        'productos' => $productos,
        'total_productos' => $totalProductos,
        'total_paginas' => $totalPaginas,
        'pagina_actual' => $pagina
    ];
}

// Función para obtener un producto por ID
function obtenerProductoPorId($pdo, $id) {
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// Función para obtener productos relacionados
function obtenerProductosRelacionados($pdo, $categoria, $idExcluir, $limite = 4) {
    $sql = "SELECT * FROM productos 
            WHERE categoria = ? AND id != ? 
            ORDER BY RAND() 
            LIMIT ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$categoria, $idExcluir, $limite]);
    return $stmt->fetchAll();
}

function admin_login($usuario, $contrasena) {
    if ($usuario === ADMIN_USER && $contrasena === ADMIN_PASS) {
        $_SESSION['admin'] = true;
        return true;
    }
    return false;
}

function admin_logout() {
    unset($_SESSION['admin']);
}

function admin_requerido() {
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
        header('Location: login.php');
        exit;
    }
}

function obtenerCategoriasEnum($pdo) {
    $sql = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'productos' AND COLUMN_NAME = 'categoria'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([DB_NAME]);
    $row = $stmt->fetchColumn();
    if (!$row) return obtenerCategorias();
    $inicio = strpos($row, '(');
    $fin = strrpos($row, ')');
    $contenido = substr($row, $inicio + 1, $fin - $inicio - 1);
    $valores = array_map(function($v) { return trim(trim($v), "'"); }, explode(',', $contenido));
    return array_combine(array_map('strtolower', $valores), $valores);
}
?> 
