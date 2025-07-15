-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS catalogo_tuipz CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE catalogo_tuipz;

-- Crear tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) UNIQUE NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    categoria ENUM('pines', 'kit lienzos', 'kit figuras yeso') NOT NULL,
    stock INT DEFAULT 0,
    imagen VARCHAR(500),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar productos de ejemplo - PINES
INSERT INTO productos (codigo, nombre, descripcion, precio, categoria, stock, imagen) VALUES
('PIN001', 'Pin Decorativo Mariposa', 'Hermoso pin decorativo con forma de mariposa, perfecto para personalizar mochilas, chaquetas y accesorios. Material de alta calidad con acabado brillante.', 15.99, 'pines', 50, 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=400&h=300&fit=crop'),
('PIN002', 'Pin Vintage Estrella', 'Pin retro con diseño de estrella, ideal para coleccionistas y amantes del estilo vintage. Incluye cierre de seguridad.', 12.50, 'pines', 35, 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=300&fit=crop'),
('PIN003', 'Pin Personalizado Nombre', 'Pin personalizable con tu nombre o frase favorita. Disponible en múltiples colores y fuentes elegantes.', 18.75, 'pines', 25, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=300&fit=crop'),
('PIN004', 'Pin Colección Flores', 'Set de 3 pines con diseños florales únicos. Perfectos para regalo o uso personal. Cada pin tiene un diseño diferente.', 22.00, 'pines', 40, 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=400&h=300&fit=crop'),
('PIN005', 'Pin Metálico Corazón', 'Pin elegante con forma de corazón en metal plateado. Ideal para ocasiones especiales y regalos románticos.', 16.25, 'pines', 30, 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=300&fit=crop'),
('PIN006', 'Pin Anime Popular', 'Pin coleccionable de personajes populares de anime. Material resistente y colores vibrantes.', 14.99, 'pines', 45, 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop'),
('PIN007', 'Pin Minimalista Círculo', 'Pin con diseño minimalista en forma de círculo. Perfecto para un look elegante y sobrio.', 11.75, 'pines', 55, 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=300&fit=crop'),
('PIN008', 'Pin Glow in the Dark', 'Pin que brilla en la oscuridad con diseño de luna y estrellas. Ideal para eventos nocturnos.', 19.50, 'pines', 20, 'https://images.unsplash.com/photo-1534447677768-be436bb09401?w=400&h=300&fit=crop'),
('PIN009', 'Pin Colección Animales', 'Set de 4 pines con diferentes animales. Diseños tiernos y coloridos para todas las edades.', 25.00, 'pines', 35, 'https://images.unsplash.com/photo-1456926631375-92c8ce872def?w=400&h=300&fit=crop'),
('PIN010', 'Pin Premium Cristal', 'Pin de lujo con incrustaciones de cristal. Perfecto para ocasiones especiales y regalos elegantes.', 28.75, 'pines', 15, 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=300&fit=crop');

-- Insertar productos de ejemplo - KIT LIENZOS
INSERT INTO productos (codigo, nombre, descripcion, precio, categoria, stock, imagen) VALUES
('LIEN001', 'Kit Lienzo Básico 3 Piezas', 'Kit completo para principiantes con 3 lienzos de 30x40cm, pinceles básicos y pinturas acrílicas de colores primarios. Incluye paleta de mezcla.', 45.99, 'kit lienzos', 25, 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=400&h=300&fit=crop'),
('LIEN002', 'Kit Lienzo Avanzado 5 Piezas', 'Kit profesional con 5 lienzos de diferentes tamaños (20x30cm, 30x40cm, 40x60cm), pinceles profesionales y paleta completa de colores acrílicos.', 89.50, 'kit lienzos', 15, 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=300&fit=crop'),
('LIEN003', 'Kit Lienzo Acuarela', 'Kit especializado para acuarela con 3 lienzos de papel especial, pinceles de pelo natural y 12 colores de acuarela profesionales.', 65.25, 'kit lienzos', 20, 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop'),
('LIEN004', 'Kit Lienzo Óleo', 'Kit completo para pintura al óleo con 2 lienzos de lino, pinceles especializados, óleos de calidad y diluyente. Incluye caballete plegable.', 120.00, 'kit lienzos', 10, 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=400&h=300&fit=crop'),
('LIEN005', 'Kit Lienzo Infantil', 'Kit diseñado para niños con 4 lienzos pequeños, pinceles suaves y pinturas no tóxicas. Incluye delantal y guía de dibujo.', 35.75, 'kit lienzos', 30, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=300&fit=crop'),
('LIEN006', 'Kit Lienzo Paisaje', 'Kit especializado para pintar paisajes con 3 lienzos panorámicos, pinceles planos y paleta de colores naturales.', 75.50, 'kit lienzos', 18, 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=300&fit=crop'),
('LIEN007', 'Kit Lienzo Retrato', 'Kit profesional para retratos con 2 lienzos de alta calidad, pinceles finos y colores especializados para piel y detalles.', 95.25, 'kit lienzos', 12, 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop'),
('LIEN008', 'Kit Lienzo Abstracto', 'Kit para arte abstracto con 4 lienzos de diferentes formas, pinceles expresivos y colores vibrantes. Incluye espátulas.', 68.99, 'kit lienzos', 22, 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=400&h=300&fit=crop'),
('LIEN009', 'Kit Lienzo Minimalista', 'Kit con 3 lienzos blancos, pinceles de precisión y paleta monocromática. Perfecto para arte minimalista y moderno.', 55.00, 'kit lienzos', 28, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=300&fit=crop'),
('LIEN010', 'Kit Lienzo Premium', 'Kit de lujo con lienzos de lino premium, pinceles de pelo de marta y pinturas de artista. Incluye maleta organizadora.', 150.75, 'kit lienzos', 8, 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=300&fit=crop');

-- Insertar productos de ejemplo - KIT FIGURAS YESO
INSERT INTO productos (codigo, nombre, descripcion, precio, categoria, stock, imagen) VALUES
('YESO001', 'Kit Figuras Yeso Animales', 'Kit completo con 6 moldes de animales, yeso de secado rápido, pinturas acrílicas y pinceles. Incluye guía paso a paso.', 42.99, 'kit figuras yeso', 20, 'https://images.unsplash.com/photo-1456926631375-92c8ce872def?w=400&h=300&fit=crop'),
('YESO002', 'Kit Figuras Yeso Flores', 'Kit especializado con moldes de flores y plantas, yeso blanco, pinturas brillantes y herramientas de detalle.', 38.50, 'kit figuras yeso', 25, 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=400&h=300&fit=crop'),
('YESO003', 'Kit Figuras Yeso Personajes', 'Kit con moldes de personajes populares, yeso de alta calidad, pinturas metálicas y accesorios decorativos.', 52.75, 'kit figuras yeso', 15, 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop'),
('YESO004', 'Kit Figuras Yeso Navidad', 'Kit temático navideño con moldes de árboles, estrellas y figuras festivas. Incluye pinturas con brillo y decoraciones.', 45.00, 'kit figuras yeso', 30, 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=400&h=300&fit=crop'),
('YESO005', 'Kit Figuras Yeso Infantil', 'Kit seguro para niños con moldes grandes, yeso no tóxico, pinturas lavables y herramientas de plástico.', 35.25, 'kit figuras yeso', 35, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=300&fit=crop'),
('YESO006', 'Kit Figuras Yeso Hogar', 'Kit decorativo con moldes de elementos del hogar, yeso resistente y pinturas para interiores.', 48.99, 'kit figuras yeso', 18, 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=300&fit=crop'),
('YESO007', 'Kit Figuras Yeso Jardín', 'Kit para exteriores con moldes de elementos de jardín, yeso impermeable y pinturas resistentes al clima.', 62.50, 'kit figuras yeso', 12, 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=400&h=300&fit=crop'),
('YESO008', 'Kit Figuras Yeso Colección', 'Kit coleccionable con moldes únicos y limitados, yeso premium y pinturas especiales con efectos.', 75.25, 'kit figuras yeso', 10, 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop'),
('YESO009', 'Kit Figuras Yeso Básico', 'Kit para principiantes con 4 moldes simples, yeso económico y pinturas básicas. Ideal para aprender.', 28.99, 'kit figuras yeso', 40, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=300&fit=crop'),
('YESO010', 'Kit Figuras Yeso Premium', 'Kit profesional con moldes de alta definición, yeso de artista y pinturas de calidad profesional.', 85.00, 'kit figuras yeso', 8, 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400&h=300&fit=crop');

-- Crear índices para mejorar el rendimiento
CREATE INDEX idx_categoria ON productos(categoria);
CREATE INDEX idx_precio ON productos(precio);
CREATE INDEX idx_nombre ON productos(nombre);
CREATE INDEX idx_codigo ON productos(codigo);

-- Mostrar estadísticas de la base de datos
SELECT 
    categoria,
    COUNT(*) as total_productos,
    AVG(precio) as precio_promedio,
    MIN(precio) as precio_minimo,
    MAX(precio) as precio_maximo
FROM productos 
GROUP BY categoria; 