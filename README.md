# Catálogo Tuipz - Sistema de Catálogo Responsivo

Un catálogo web responsivo desarrollado en PHP con funcionalidades de búsqueda, filtros y paginación.

## 🚀 Características

- **Diseño Responsivo**: Se adapta a todos los dispositivos (móvil, tablet, desktop)
- **Buscador Inteligente**: Búsqueda por nombre y descripción de productos
- **Filtros por Categoría**: 
  - Pines
  - Kit Lienzos  
  - Kit Figuras Yeso
- **Paginación**: 30 productos por página (5x6 en pantallas grandes)
- **Modal de Detalles**: Información completa del producto al hacer clic
- **Interfaz Moderna**: Diseño atractivo con Bootstrap 5 y Font Awesome

## 📋 Requisitos Previos

- **XAMPP** (Apache + MySQL + PHP)
- **PHP 7.4** o superior
- **MySQL 5.7** o superior
- **Navegador web moderno**

## 🛠️ Instalación

### 1. Configurar XAMPP

1. Descarga e instala XAMPP desde [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Inicia Apache y MySQL desde el panel de control de XAMPP

### 2. Clonar/Descargar el Proyecto

1. Coloca todos los archivos en la carpeta: `C:\xampp\htdocs\catalogo_Tuipz\`
2. Crea la carpeta `img` y coloca tu logo como `tuipz_logo.png` (formato PNG con fondo transparente)
3. Asegúrate de que la estructura sea:
   ```
       catalogo_Tuipz/
    ├── index.php
    ├── config.php
    ├── database.sql
    ├── install.php
    ├── img/
    │   └── tuipz_logo.png
    └── README.md
   ```

### 3. Configurar la Base de Datos (Método Automático - Recomendado)

1. Abre tu navegador y ve a: `http://localhost/catalogo_Tuipz/install.php`
2. El instalador verificará automáticamente los requisitos del sistema
3. Haz clic en "Iniciar Instalación"
4. El sistema creará la base de datos y agregará 30 productos de ejemplo
5. ¡Listo! Tu catálogo estará funcionando

### 3. Configurar la Base de Datos (Método Manual)

Si prefieres hacerlo manualmente:

1. Abre tu navegador y ve a: `http://localhost/phpmyadmin`
2. Crea una nueva base de datos llamada `catalogo_tuipz`
3. Ve a la pestaña "Importar"
4. Selecciona el archivo `database.sql`
5. Haz clic en "Continuar" para ejecutar el script

### 4. Verificar Configuración

1. Abre el archivo `index.php` y verifica que las credenciales de la base de datos sean correctas:
   ```php
   $host = 'localhost';
   $dbname = 'catalogo_tuipz';
   $username = 'root';
   $password = '';
   ```

### 5. Acceder al Catálogo

1. Abre tu navegador
2. Ve a: `http://localhost/catalogo_Tuipz/`
3. ¡El catálogo debería estar funcionando!

## 🎨 Personalización

### Cambiar Colores y Estilos

Los estilos están definidos en la sección `<style>` del archivo `index.php`. Puedes modificar:

- **Colores del gradiente**: Cambia los valores en `.filtros-container`
- **Colores de botones**: Modifica las clases `.btn-filtro`
- **Tamaños de imágenes**: Ajusta `.producto-imagen`

### Agregar Nuevos Productos

1. Ve a phpMyAdmin
2. Selecciona la base de datos `catalogo_tuipz`
3. Ve a la tabla `productos`
4. Haz clic en "Insertar" para agregar nuevos productos

### Estructura de la Base de Datos

```sql
CREATE TABLE productos (
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
```

## 🔧 Funcionalidades

### Búsqueda
- Busca por nombre o descripción del producto
- Búsqueda en tiempo real con filtros aplicados

### Filtros
- **Todos**: Muestra todos los productos
- **Pines**: Solo productos de la categoría pines
- **Kit Lienzos**: Solo kits de lienzos
- **Kit Figuras Yeso**: Solo kits de figuras de yeso

### Paginación
- 30 productos por página
- Navegación intuitiva con números de página
- Botones de anterior/siguiente

### Modal de Producto
- Información completa del producto
- Imagen en alta resolución
- Precio, stock y código
- Botón para agregar al carrito (funcionalidad futura)

## 📱 Responsividad

El catálogo se adapta automáticamente:

- **Móvil**: 1 producto por fila
- **Tablet**: 2-3 productos por fila  
- **Desktop**: 4-5 productos por fila
- **Pantallas grandes**: 5 productos por fila

## 🐛 Solución de Problemas

### Error de Conexión a la Base de Datos
- Verifica que MySQL esté ejecutándose en XAMPP
- Confirma que las credenciales en `index.php` sean correctas
- Asegúrate de que la base de datos `catalogo_tuipz` exista

### Imágenes No Se Muestran
- Las imágenes usan URLs de Unsplash
- Si no cargan, se muestra una imagen placeholder
- Puedes cambiar las URLs por imágenes locales

### Página No Carga
- Verifica que Apache esté ejecutándose
- Confirma que los archivos estén en la carpeta correcta
- Revisa los logs de error de Apache

## 📞 Soporte

Si tienes problemas o preguntas:

1. Verifica que todos los requisitos estén instalados
2. Revisa la configuración de XAMPP
3. Confirma que la base de datos esté creada correctamente

## 🔄 Actualizaciones Futuras

Funcionalidades planeadas:
- Sistema de carrito de compras
- Panel de administración
- Gestión de usuarios
- Sistema de reseñas
- Filtros por precio
- Ordenamiento personalizado

---

**Desarrollado con ❤️ para Catálogo Tuipz** 