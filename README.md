# Aura WordPress Starter Theme

Un starter theme personalizable para WordPress optimizado para Elementor. Diseñado para crear rápidamente temas únicos para negocios locales y empresas.

**Desarrollado por [Aura Marketing](https://agenciaaura.mx)**

## 🎯 ¿Qué es este starter theme?

Este es un tema base que permite generar rápidamente temas de WordPress personalizados para diferentes negocios. Incluye:

- ✅ **Elementor Ready**: Optimizado para Elementor
- ✅ **Responsive**: Diseño adaptable a todos los dispositivos
- ✅ **Personalizable**: Sistema de placeholders para branding
- ✅ **Optimizado**: SEO y velocidad de carga
- ✅ **Herramientas**: Scripts Python para automatización

## 🚀 Uso Rápido

### 1. Personalizar para un negocio

```bash
python tools/setup_theme.py --name "La Carreta Verde" --tagline "Comida fresca y local" --slug "la-carreta-verde"
```

Esto creará un tema personalizado con:
- Nombre: "La Carreta Verde"
- Descripción: "Comida fresca y local"
- Slug: "la-carreta-verde"
- Prefijos PHP únicos

### 2. Generar screenshot

```bash
python tools/generate_screenshot.py
```

### 3. Instalar en WordPress

1. Comprime la carpeta del tema
2. Sube a WordPress Admin → Apariencia → Temas
3. Activa el tema
4. Instala Elementor (recomendado)

## 📋 Requisitos

- WordPress 5.0+
- PHP 7.4+
- Python 3.6+ (para herramientas de desarrollo)
- Elementor Plugin (recomendado)

## 🔧 Herramientas Incluidas

### setup_theme.py
Personaliza el tema con información del negocio:

**Parámetros:**
- `--name`: Nombre del negocio
- `--tagline`: Eslogan o descripción
- `--slug`: Identificador único (se genera automáticamente si no se especifica)

**Ejemplos:**
```bash
# Restaurante
python tools/setup_theme.py --name "La Carreta Verde" --tagline "Comida fresca y local" --slug "la-carreta-verde"

# Consultorio médico  
python tools/setup_theme.py --name "Dr. García Medicina" --tagline "Cuidando tu salud"

# Tienda
python tools/setup_theme.py --name "Boutique Luna" --tagline "Moda única para ti"
```

### generate_screenshot.py
Genera un screenshot profesional del tema automáticamente.

**Requisitos:**
```bash
pip install pillow
```

**Uso:**
```bash
python tools/generate_screenshot.py
```

## 🖼️ Cómo Generar screenshot.png

El tema incluye un script para generar automáticamente el archivo `screenshot.png` requerido por WordPress:

### Instalación de Dependencias
```bash
# Instalar Pillow (requerido)
pip install pillow
```

### Generar Screenshot
```bash
# Desde la raíz del tema
python tools/generate_screenshot.py
```

Esto creará un archivo `screenshot.png` de 1200x900px en la raíz del tema con:
- Nombre del negocio (placeholder)
- Tagline del negocio (placeholder) 
- Diseño responsive simulado
- Créditos de Aura Marketing

**Tip:** Ejecuta este comando después de personalizar el tema con `setup_theme.py` para que use el nombre real del negocio.

---

## 📦 Generar ZIP para Distribución

El tema incluye un script para crear un archivo ZIP listo para instalar en WordPress:

### Uso Básico
```bash
# Generar ZIP con configuración automática
python tools/build_zip.py

# ZIP con nombre personalizado
python tools/build_zip.py --name mi-tema-personalizado

# Excluir archivos de desarrollo (sin tools/, README.md, etc.)
python tools/build_zip.py --exclude-dev

# Combinando opciones
python tools/build_zip.py --name tema-produccion --exclude-dev
```

### Características del ZIP
- **Estructura limpia**: Carpeta con nombre del tema
- **Auto-exclusión**: Elimina `.git`, `__pycache__`, `.vscode`, etc.
- **Validación**: Verifica archivos esenciales (style.css, functions.php, index.php)
- **Compresión optimizada**: Archivo pequeño para uploads rápidos
- **Información detallada**: Muestra tamaño, archivos incluidos y próximos pasos

### Subir a WordPress
1. Ejecutar `python tools/build_zip.py`
2. Ir a WordPress Admin → Apariencia → Temas → Añadir nuevo
3. Hacer clic en "Subir tema"
4. Seleccionar el archivo ZIP generado
5. Instalar y activar

---

## 📄 Plantillas Incluidas

El tema incluye plantillas especiales optimizadas para diferentes casos de uso:

### **Full Width**
- **Cuándo usar**: Para páginas que necesitan más espacio horizontal
- **Características**: Mantiene header y footer del tema, sin sidebar
- **Ideal para**: Páginas de servicios, landing pages con Elementor
- **Seleccionar**: En el editor de páginas → Atributos → Plantilla → "Full Width"

### **Blank (No Header/Footer)**
- **Cuándo usar**: Para páginas completamente personalizadas con Elementor
- **Características**: Sin header ni footer, HTML mínimo
- **Ideal para**: Landing pages, páginas de ventas, diseños 100% Elementor
- **Seleccionar**: En el editor de páginas → Atributos → Plantilla → "Blank (No Header/Footer)"

**Tip**: Usa "Blank" cuando quieras control total del diseño y "Full Width" cuando necesites mantener la navegación del sitio.

## 📁 Estructura del Tema

```
aura-wp-elementor-starter/
├── style.css              # Header del tema y estilos base
├── functions.php          # Funciones principales
├── index.php             # Template principal  
├── page.php              # Template para páginas
├── single.php            # Template para posts
├── assets/               # CSS y JavaScript
├── templates/            # Page templates especiales
├── template-parts/       # Partes reutilizables
└── tools/               # Herramientas de desarrollo
```

## 🤝 Créditos

**Desarrollado por [Aura Marketing](https://agenciaaura.mx)**  
Agencia de marketing digital especializada en soluciones web para negocios locales.

## 📄 Licencia

GPL v2 o posterior. Úsalo libremente para tus proyectos comerciales.

## 📁 Estructura del Theme

```
aura-wp-elementor-starter/
├── style.css                 # Hoja de estilos principal y header del theme
├── functions.php             # Funciones principales del theme
├── index.php                 # Template principal
├── header.php                # Header del sitio
├── footer.php                # Footer del sitio
├── page.php                  # Template para páginas
├── single.php                # Template para posts individuales
├── archive.php               # Template para archivos
├── search.php                # Template para resultados de búsqueda
├── 404.php                   # Template para página de error 404
├── comments.php              # Template para comentarios
├── sidebar.php               # Sidebar del sitio
├── screenshot.png            # Captura de pantalla del theme
├── template-parts/           # Partes de templates reutilizables
│   └── content-archive.php
├── templates/                # Page templates especiales
│   ├── template-fullwidth.php
│   └── template-blank.php
├── assets/                   # Archivos de recursos
│   ├── css/
│   │   └── main.css         # Estilos adicionales
│   └── js/
│       └── main.js          # JavaScript del theme
├── tools/                    # Herramientas de desarrollo
│   ├── setup_theme.py       # Script de configuración
│   ├── generate_screenshot.py
│   └── theme.config.json    # Configuración del theme
├── README.md                 # Documentación
└── .gitignore               # Archivos a ignorar por Git
```

## 🎨 Templates Incluidos

### Page Templates
- **Full Width**: Template sin sidebar para páginas completas
- **Blank**: Template en blanco, ideal para Elementor

### Template Parts
- **Content Archive**: Para mostrar posts en archivos y búsquedas

## ⚙️ Configuración

### Menús
El theme soporta dos ubicaciones de menús:
- **Primary Menu**: Menú principal en el header
- **Footer Menu**: Menú en el footer

### Widgets
Áreas de widgets disponibles:
- **Sidebar**: Barra lateral principal
- **Footer 1**: Área de widgets en el footer

### Funcionalidades de WordPress
- ✅ Custom Logo
- ✅ Post Thumbnails
- ✅ Responsive Embeds
- ✅ WordPress Block Styles
- ✅ Wide Alignment
- ✅ HTML5 Support
- ✅ Title Tag

## 🔧 Herramientas de Desarrollo

### Setup Theme (Python)
```bash
cd tools/
python setup_theme.py
```

Este script automatiza:
- Actualización de información del theme
- Validación de archivos requeridos
- Configuración del entorno de desarrollo
- Adición de hooks y filtros adicionales

### Generate Screenshot
```bash
cd tools/
python generate_screenshot.py
```

Genera automáticamente una captura de pantalla profesional del theme.

## 🎯 Compatibilidad con Elementor

Este theme está optimizado para Elementor:

- **Header & Footer Support**: Usa `add_theme_support('elementor-header-footer')`
- **Template Blank**: Template especial sin elementos del theme
- **Clean CSS**: Estilos que no interfieren con Elementor
- **Hook Integration**: Hooks compatibles con Elementor

## 🚀 Optimizaciones de Rendimiento

- **Lazy Loading**: Para imágenes (cuando esté soportado)
- **Minified CSS**: CSS optimizado y minificado
- **Efficient JavaScript**: JavaScript optimizado
- **Modern CSS**: Uso de CSS custom properties

## 🔒 Seguridad

- Eliminación de la versión de WordPress
- Headers de seguridad
- Validación de datos
- Escape de salidas

## ♿ Accesibilidad

- Enlaces de salto al contenido
- Navegación por teclado
- Texto para lectores de pantalla
- Manejo adecuado del foco

## 🎨 Personalización

### CSS Custom Properties
El theme utiliza CSS custom properties para fácil personalización:

```css
:root {
    --primary-color: #0073aa;
    --secondary-color: #005177;
    --text-color: #333333;
    /* ... más variables */
}
```

### Child Theme
Se recomienda crear un child theme para personalizaciones:

```php
// functions.php del child theme
function child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'child_enqueue_styles');
```

## 📝 Desarrollo

### Hooks Disponibles
- `aura_before_header`
- `aura_after_header`
- `aura_before_content`
- `aura_after_content`
- `aura_before_footer`
- `aura_after_footer`

### Filtros Disponibles
- `aura_excerpt_length`
- `aura_excerpt_more`
- `aura_nav_menu_args`

## 🤝 Contribuir

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/nueva-caracteristica`)
3. Commit tus cambios (`git commit -am 'Añadir nueva característica'`)
4. Push a la rama (`git push origin feature/nueva-caracteristica`)
5. Abre un Pull Request

## 📄 Licencia

Este theme está licenciado bajo GPL v2 o posterior. Ver [LICENSE](LICENSE) para más detalles.

## 🆘 Soporte

- [Documentación de WordPress](https://developer.wordpress.org/themes/)
- [Documentación de Elementor](https://developers.elementor.com/)
- [Issues en GitHub](https://github.com/your-username/aura-wp-elementor-starter/issues)

## 📈 Changelog

### v1.0.0
- Lanzamiento inicial
- Soporte completo para Elementor
- Templates responsive
- Herramientas de desarrollo incluidas

---

**Desarrollado con ❤️ para la comunidad de WordPress**