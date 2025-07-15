<?php
session_start();

// Incluir archivo de configuración
require_once 'config.php';

// Conectar a la base de datos
$pdo = conectarDB();

// Parámetros de búsqueda y filtros
$busqueda = isset($_GET['busqueda']) ? limpiarDatos($_GET['busqueda']) : '';
$categoria = isset($_GET['categoria']) ? limpiarDatos($_GET['categoria']) : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Buscar productos usando la función del archivo de configuración
$resultado = buscarProductos($pdo, $busqueda, $categoria, $pagina, PRODUCTOS_POR_PAGINA);

$productos = $resultado['productos'];
$totalProductos = $resultado['total_productos'];
$totalPaginas = $resultado['total_paginas'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo Tuipz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .producto-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            height: 100%;
        }
        
        .producto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .producto-imagen {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        
        .filtros-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .btn-filtro {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-filtro:hover, .btn-filtro.active {
            background: rgba(255,255,255,0.3);
            color: white;
            transform: scale(1.05);
        }
        
        .paginacion-container {
            background: #f8f9fa;
            padding: 2rem 0;
            margin-top: 2rem;
        }
        
        .modal-producto .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
        
        .producto-detalle-imagen {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        
        .precio {
            font-size: 1.25rem;
            font-weight: bold;
            color: #28a745;
        }
        
        .categoria-badge {
            font-size: 0.8rem;
        }
        
        .navbar-brand img {
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: scale(1.1);
        }
        
        @media (max-width: 768px) {
            .producto-imagen {
                height: 150px;
            }
            
            .navbar-brand img {
                height: 30px !important;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="img/tuipz_logo.png" alt="Tuipz Logo" height="40" class="me-2">
                Catálogo Tuipz
            </a>
        </div>
    </nav>

    <!-- Filtros y Búsqueda -->
    <div class="filtros-container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center mb-4">
                        <i class="fas fa-search me-2"></i>
                        Encuentra tu producto ideal
                    </h2>
                </div>
            </div>
            
            <!-- Búsqueda -->
            <div class="row mb-4">
                <div class="col-md-8 mx-auto">
                    <form method="GET" class="d-flex">
                        <input type="text" 
                               name="busqueda" 
                               value="<?= htmlspecialchars($busqueda) ?>" 
                               class="form-control form-control-lg me-2" 
                               placeholder="Buscar productos...">
                        <button type="submit" class="btn btn-light btn-lg">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Filtros por categoría -->
            <div class="row">
                <div class="col-12 text-center">
                    <div class="btn-group" role="group">
                        <a href="?<?= http_build_query(array_merge($_GET, ['categoria' => '', 'pagina' => 1])) ?>" 
                           class="btn btn-filtro <?= empty($categoria) ? 'active' : '' ?>">
                            <i class="fas fa-th-large me-1"></i>
                            Todos
                        </a>
                        <a href="?<?= http_build_query(array_merge($_GET, ['categoria' => 'pines', 'pagina' => 1])) ?>" 
                           class="btn btn-filtro <?= $categoria === 'pines' ? 'active' : '' ?>">
                            <i class="fas fa-thumbtack me-1"></i>
                            Pines
                        </a>
                        <a href="?<?= http_build_query(array_merge($_GET, ['categoria' => 'kit lienzos', 'pagina' => 1])) ?>" 
                           class="btn btn-filtro <?= $categoria === 'kit lienzos' ? 'active' : '' ?>">
                            <i class="fas fa-palette me-1"></i>
                            Kit Lienzos
                        </a>
                        <a href="?<?= http_build_query(array_merge($_GET, ['categoria' => 'kit figuras yeso', 'pagina' => 1])) ?>" 
                           class="btn btn-filtro <?= $categoria === 'kit figuras yeso' ? 'active' : '' ?>">
                            <i class="fas fa-sculpture me-1"></i>
                            Kit Figuras Yeso
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resultados -->
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <p class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Mostrando <?= count($productos) ?> de <?= $totalProductos ?> productos
                    <?= !empty($busqueda) ? " para '$busqueda'" : '' ?>
                    <?= !empty($categoria) ? " en '$categoria'" : '' ?>
                </p>
            </div>
        </div>

        <!-- Catálogo de Productos -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-4">
            <?php foreach ($productos as $producto): ?>
            <div class="col">
                <div class="card producto-card h-100" 
                     data-bs-toggle="modal" 
                     data-bs-target="#modalProducto" 
                     data-producto='<?= json_encode($producto) ?>'>
                    <img src="<?= htmlspecialchars($producto['imagen']) ?>" 
                         class="card-img-top producto-imagen" 
                         alt="<?= htmlspecialchars($producto['nombre']) ?>"
                         onerror="this.src='<?= IMAGEN_PLACEHOLDER ?>'">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h6>
                        <span class="badge bg-primary categoria-badge mb-2">
                            <?= htmlspecialchars($producto['categoria']) ?>
                        </span>
                        <p class="card-text text-muted small flex-grow-1">
                            <?= htmlspecialchars(substr($producto['descripcion'], 0, 80)) ?>...
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                                                         <span class="precio"><?= formatearPrecio($producto['precio']) ?></span>
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>
                                Ver
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginación -->
        <?php if ($totalPaginas > 1): ?>
        <div class="paginacion-container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Navegación de páginas">
                        <ul class="pagination justify-content-center">
                            <!-- Botón anterior -->
                            <?php if ($pagina > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina - 1])) ?>">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <?php endif; ?>

                            <!-- Números de página -->
                            <?php
                            $inicio = max(1, $pagina - 2);
                            $fin = min($totalPaginas, $pagina + 2);
                            
                            if ($inicio > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => 1])) ?>">1</a>
                            </li>
                            <?php if ($inicio > 2): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                            <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = $inicio; $i <= $fin; $i++): ?>
                            <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>

                            <?php if ($fin < $totalPaginas): ?>
                            <?php if ($fin < $totalPaginas - 1): ?>
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                            <?php endif; ?>
                            <li class="page-item">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $totalPaginas])) ?>"><?= $totalPaginas ?></a>
                            </li>
                            <?php endif; ?>

                            <!-- Botón siguiente -->
                            <?php if ($pagina < $totalPaginas): ?>
                            <li class="page-item">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina + 1])) ?>">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Modal del Producto -->
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="modalProductoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProductoLabel">Detalles del Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="modalImagen" src="" class="producto-detalle-imagen w-100" alt="">
                        </div>
                        <div class="col-md-6">
                            <h4 id="modalNombre"></h4>
                            <span id="modalCategoria" class="badge bg-primary mb-3"></span>
                            <p id="modalDescripcion" class="text-muted"></p>
                            <div class="mb-3">
                                <strong>Precio:</strong>
                                <span id="modalPrecio" class="precio ms-2"></span>
                            </div>
                            <div class="mb-3">
                                <strong>Stock:</strong>
                                <span id="modalStock" class="ms-2"></span>
                            </div>
                            <div class="mb-3">
                                <strong>Código:</strong>
                                <span id="modalCodigo" class="ms-2"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2024 Catálogo Tuipz. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Cargar datos del producto en el modal
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalProducto');
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const producto = JSON.parse(button.getAttribute('data-producto'));
                
                document.getElementById('modalImagen').src = producto.imagen;
                document.getElementById('modalImagen').alt = producto.nombre;
                document.getElementById('modalNombre').textContent = producto.nombre;
                document.getElementById('modalCategoria').textContent = producto.categoria;
                document.getElementById('modalDescripcion').textContent = producto.descripcion;
                document.getElementById('modalPrecio').textContent = '$' + parseFloat(producto.precio).toFixed(2);
                document.getElementById('modalStock').textContent = producto.stock;
                document.getElementById('modalCodigo').textContent = producto.codigo;
            });
        });
    </script>
</body>
</html> 