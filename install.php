<?php
/**
 * Script de Instalación Automática
 * Catálogo Tuipz
 */

// Configuración de la base de datos
$host = 'localhost';
$username = 'root';
$password = '';

$dbname = 'catalogo_tuipz';

// Función para mostrar mensajes
function mostrarMensaje($mensaje, $tipo = 'info') {
    $clase = $tipo === 'error' ? 'alert-danger' : ($tipo === 'success' ? 'alert-success' : 'alert-info');
    echo "<div class='alert $clase' role='alert'>$mensaje</div>";
}

// Función para verificar requisitos
function verificarRequisitos() {
    $errores = [];
    
    // Verificar PHP
    if (version_compare(PHP_VERSION, '7.4.0', '<')) {
        $errores[] = "Se requiere PHP 7.4 o superior. Versión actual: " . PHP_VERSION;
    }
    
    // Verificar extensiones
    if (!extension_loaded('pdo')) {
        $errores[] = "La extensión PDO no está habilitada";
    }
    
    if (!extension_loaded('pdo_mysql')) {
        $errores[] = "La extensión PDO MySQL no está habilitada";
    }
    
    return $errores;
}

// Función para conectar a MySQL
function conectarMySQL($host, $username, $password) {
    try {
        $pdo = new PDO("mysql:host=$host", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        return false;
    }
}

// Función para crear la base de datos
function crearBaseDatos($pdo, $dbname) {
    try {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        return true;
    } catch(PDOException $e) {
        return false;
    }
}

// Función para ejecutar el script SQL
function ejecutarScriptSQL($pdo, $dbname, $archivoSQL) {
    try {
        $pdo->exec("USE `$dbname`");
        $sql = file_get_contents($archivoSQL);
        
        // Dividir el script en consultas individuales
        $consultas = array_filter(array_map('trim', explode(';', $sql)));
        
        foreach ($consultas as $consulta) {
            if (!empty($consulta)) {
                $pdo->exec($consulta);
            }
        }
        
        return true;
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

// Función para verificar archivos necesarios
function verificarArchivos() {
    $archivos = ['config.php', 'database.sql'];
    $faltantes = [];
    
    foreach ($archivos as $archivo) {
        if (!file_exists($archivo)) {
            $faltantes[] = $archivo;
        }
    }
    
    return $faltantes;
}

// Procesar la instalación
$paso = isset($_GET['paso']) ? (int)$_GET['paso'] : 1;
$errores = [];
$mensajes = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['instalar'])) {
    // Paso 1: Verificar requisitos
    $errores = verificarRequisitos();
    
    if (empty($errores)) {
        // Paso 2: Verificar archivos
        $archivosFaltantes = verificarArchivos();
        
        if (empty($archivosFaltantes)) {
            // Paso 3: Conectar a MySQL
            $pdo = conectarMySQL($host, $username, $password);
            
            if ($pdo) {
                // Paso 4: Crear base de datos
                if (crearBaseDatos($pdo, $dbname)) {
                    // Paso 5: Ejecutar script SQL
                    $resultado = ejecutarScriptSQL($pdo, $dbname, 'database.sql');
                    
                    if ($resultado === true) {
                        $mensajes[] = "¡Instalación completada exitosamente!";
                        $paso = 3; // Mostrar página de éxito
                    } else {
                        $errores[] = "Error al ejecutar el script SQL: $resultado";
                    }
                } else {
                    $errores[] = "No se pudo crear la base de datos '$dbname'";
                }
            } else {
                $errores[] = "No se pudo conectar a MySQL. Verifica que el servicio esté ejecutándose.";
            }
        } else {
            $errores[] = "Faltan los siguientes archivos: " . implode(', ', $archivosFaltantes);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación - Catálogo Tuipz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .install-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .step-indicator {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .step {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #dee2e6;
            color: #6c757d;
            text-align: center;
            line-height: 40px;
            margin: 0 10px;
            font-weight: bold;
        }
        .step.active {
            background: #007bff;
            color: white;
        }
        .step.completed {
            background: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="install-container p-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h1 class="display-4 text-primary">
                            <img src="img/tuipz_logo.png" alt="Tuipz Logo" height="60" class="me-3">
                            Catálogo Tuipz
                        </h1>
                        <p class="lead text-muted">Instalación del Sistema</p>
                    </div>

                    <!-- Indicador de pasos -->
                    <div class="step-indicator text-center">
                        <div class="step <?= $paso >= 1 ? 'completed' : 'active' ?>">1</div>
                        <div class="step <?= $paso >= 2 ? 'completed' : ($paso == 1 ? 'active' : '') ?>">2</div>
                        <div class="step <?= $paso >= 3 ? 'completed' : ($paso == 2 ? 'active' : '') ?>">3</div>
                    </div>

                    <!-- Mensajes de error -->
                    <?php foreach ($errores as $error): ?>
                        <?php mostrarMensaje($error, 'error'); ?>
                    <?php endforeach; ?>

                    <!-- Mensajes de éxito -->
                    <?php foreach ($mensajes as $mensaje): ?>
                        <?php mostrarMensaje($mensaje, 'success'); ?>
                    <?php endforeach; ?>

                    <?php if ($paso == 1): ?>
                        <!-- Paso 1: Verificación de requisitos -->
                        <div class="text-center">
                            <h3 class="mb-4">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                Verificación de Requisitos
                            </h3>
                            
                            <div class="row text-start">
                                <div class="col-md-6">
                                    <h5>Requisitos del Sistema</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-<?= version_compare(PHP_VERSION, '7.4.0', '>=') ? 'check text-success' : 'times text-danger' ?> me-2"></i>PHP 7.4+ (<?= PHP_VERSION ?>)</li>
                                        <li><i class="fas fa-<?= extension_loaded('pdo') ? 'check text-success' : 'times text-danger' ?> me-2"></i>Extensión PDO</li>
                                        <li><i class="fas fa-<?= extension_loaded('pdo_mysql') ? 'check text-success' : 'times text-danger' ?> me-2"></i>Extensión PDO MySQL</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5>Archivos Requeridos</h5>
                                    <ul class="list-unstyled">
                                        <?php 
                                        $archivos = ['config.php', 'database.sql'];
                                        foreach ($archivos as $archivo): 
                                            $existe = file_exists($archivo);
                                        ?>
                                        <li><i class="fas fa-<?= $existe ? 'check text-success' : 'times text-danger' ?> me-2"></i><?= $archivo ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                            <form method="POST" class="mt-4">
                                <button type="submit" name="instalar" class="btn btn-primary btn-lg">
                                    <i class="fas fa-rocket me-2"></i>
                                    Iniciar Instalación
                                </button>
                            </form>
                        </div>

                    <?php elseif ($paso == 2): ?>
                        <!-- Paso 2: Instalación en progreso -->
                        <div class="text-center">
                            <h3 class="mb-4">
                                <i class="fas fa-cog fa-spin text-primary me-2"></i>
                                Instalando...
                            </h3>
                            <p>Por favor espera mientras se configura la base de datos.</p>
                        </div>

                    <?php elseif ($paso == 3): ?>
                        <!-- Paso 3: Instalación completada -->
                        <div class="text-center">
                            <h3 class="mb-4">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                ¡Instalación Completada!
                            </h3>
                            
                            <div class="alert alert-success">
                                <h5>El catálogo ha sido instalado exitosamente.</h5>
                                <p class="mb-0">La base de datos y todos los archivos han sido configurados correctamente.</p>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-database fa-3x text-primary mb-3"></i>
                                            <h5>Base de Datos</h5>
                                            <p class="text-muted">30 productos de ejemplo han sido agregados</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-palette fa-3x text-success mb-3"></i>
                                            <h5>Categorías</h5>
                                            <p class="text-muted">Pines, Kit Lienzos, Kit Figuras Yeso</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="index.php" class="btn btn-success btn-lg">
                                    <i class="fas fa-external-link-alt me-2"></i>
                                    Ir al Catálogo
                                </a>
                            </div>

                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Para mayor seguridad, elimina este archivo (install.php) después de la instalación.
                                </small>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 