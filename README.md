# Aura WordPress Elementor Starter

Un theme starter moderno y optimizado para WordPress con soporte completo para Elementor.

## 🚀 Características

- ✅ **Elementor Ready**: Optimizado para trabajar perfectamente con Elementor
- ✅ **Responsive Design**: Diseño completamente responsivo y mobile-first
- ✅ **Clean Code**: Código limpio y bien documentado
- ✅ **WordPress Standards**: Sigue las mejores prácticas de WordPress
- ✅ **SEO Friendly**: Optimizado para motores de búsqueda
- ✅ **Accessible**: Cumple con estándares de accesibilidad web
- ✅ **Fast Loading**: Optimizado para velocidad de carga
- ✅ **Modern CSS**: Utiliza CSS moderno con custom properties

## 📋 Requisitos

- WordPress 5.0 o superior
- PHP 7.4 o superior
- Elementor Plugin (recomendado)

## 🛠 Instalación

1. **Descarga el theme**
   ```bash
   git clone https://github.com/your-username/aura-wp-elementor-starter.git
   ```

2. **Sube a WordPress**
   - Comprime la carpeta del theme en un archivo .zip
   - Ve a WordPress Admin → Apariencia → Temas
   - Haz clic en "Añadir nuevo" → "Subir tema"
   - Selecciona el archivo .zip y súbelo

3. **Activa el theme**
   - Una vez subido, haz clic en "Activar"

4. **Instala Elementor** (opcional pero recomendado)
   - Ve a Plugins → Añadir nuevo
   - Busca "Elementor" e instálalo

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