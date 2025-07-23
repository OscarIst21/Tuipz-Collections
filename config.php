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

// Función para conectar a la base de datos
function conectarDB() {
    try {
        $pdo = new PDO(
    "mysql:host=" . DB_HOST . ";port=3309;dbname=" . DB_NAME . ";charset=utf8",
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

// Función para obtener categorías disponibles
function obtenerCategorias() {
    return [
        'pines' => 'Pines',
        'kit lienzos' => 'Kit Lienzos',
        'kit figuras yeso' => 'Kit Figuras Yeso'
    ];
}

// Función para validar categoría
function validarCategoria($categoria) {
    $categorias = obtenerCategorias();
    return array_key_exists($categoria, $categorias);
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
    
    // Agregar filtro de categoría
    if (!empty($categoria) && validarCategoria($categoria)) {
        $sql .= " AND categoria = ?";
        $params[] = $categoria;
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
?> 