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

## 🎨 Personalización (Customizer)

El tema incluye un panel de personalización completo accesible desde **WordPress Admin → Apariencia → Personalizar**:

### 📱 **Configuración de Header**
- **Estilos de Header**: 3 diseños predefinidos (logo izquierda, centrado, etc.)
- **Tamaño de Logo**: Control independiente para desktop (80-320px) y mobile (60-240px)
- **Padding Vertical**: Ajuste del espaciado del header (6-40px)
- **Header Sticky**: Activar/desactivar header fijo al hacer scroll
- **Botón CTA**: Configurar texto y URL del botón de llamada a la acción
- **HTML Extra**: Agregar contenido personalizado (teléfono, promociones, etc.)

### 🌐 **Redes Sociales**
Configuración de URLs para mostrar íconos en el header:
- Facebook, Instagram, TikTok
- YouTube, WhatsApp, X (Twitter)

### 🎨 **Branding (Colores de Marca)**
Sistema completo de colores para mantener consistencia visual:

**Colores Principales:**
- **Color Primario**: Color principal de la marca (por defecto: #007cba)
- **Color Secundario**: Color de apoyo y acentos (por defecto: #005177)

**Colores de Fondo:**
- **Color de Fondo**: Fondo principal del sitio (por defecto: #ffffff)
- **Color de Superficie**: Fondos de tarjetas y elementos (por defecto: #f8f9fa)

**Colores de Texto:**
- **Color de Texto**: Texto principal (por defecto: #333333)
- **Color de Acento**: Para destacados y botones (por defecto: #28a745)

**Colores de Enlaces:**
- **Color de Enlaces**: Enlaces normales (por defecto: #007cba)
- **Color de Enlaces al Hover**: Enlaces al pasar el mouse (por defecto: #005177)

**Implementación:**
Los colores se aplican automáticamente mediante variables CSS (`--aura-brand-*`) y se reflejan en:
- Botones del header
- Enlaces del menú de navegación
- Enlaces del contenido
- Fondo del header y footer

### ⚙️ **Scripts Personalizados**
**Head Scripts**: Para código en `<head>` (Google Analytics, Facebook Pixel, etc.)
```html
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s) {
    // Tu código de Facebook Pixel aquí
  }
</script>
```

**Body Open Scripts**: Para código al inicio del `<body>` (noscript tags)
```html
<!-- Google Tag Manager (noscript) -->
<noscript>
  <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXX"></iframe>
</noscript>
```

### 🔒 **Nota de Seguridad**
- **Scripts solo para administradores**: Los campos de scripts requieren permisos de `unfiltered_html`
- **Recomendación**: Siempre prueba los scripts en un entorno de staging antes de aplicar en producción
- **Validación**: El tema sanitiza automáticamente el contenido según los permisos del usuario

---

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
    /* Header Layout Variables */
    --aura-logo-max-desktop: 180px;
    --aura-logo-max-mobile: 140px;
    --aura-header-pad-y: 16px;
    
    /* Brand Colors - Configurables desde el Customizer */
    --aura-brand-primary: #007cba;
    --aura-brand-secondary: #005177;
    --aura-brand-background: #ffffff;
    --aura-brand-surface: #f8f9fa;
    --aura-brand-text: #333333;
    --aura-brand-accent: #28a745;
    --aura-brand-link: #007cba;
    --aura-brand-link-hover: #005177;
}
```

**Uso en CSS personalizado:**
```css
/* Ejemplo: Botón personalizado con colores de marca */
.mi-boton {
    background: var(--aura-brand-primary);
    color: var(--aura-brand-background);
    border-radius: 4px;
    padding: 1rem 2rem;
}

.mi-boton:hover {
    background: var(--aura-brand-secondary);
}

/* Ejemplo: Card con colores de superficie */
.mi-card {
    background: var(--aura-brand-surface);
    color: var(--aura-brand-text);
    border: 1px solid var(--aura-brand-primary);
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