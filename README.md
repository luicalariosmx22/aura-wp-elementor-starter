# 🌟 Aura Starter Kit - WordPress Monorepo

**🎨 Un ecosistema completo de desarrollo WordPress con tema avanzado y plugin de automatización**

Desarrollado por **[Aura Marketing](https://agenciaaura.mx)** para acelerar el desarrollo de sitios WordPress profesionales con integración completa de Elementor.

## 🚀 ¿Qué es Aura Starter Kit?

Un **monorepo completo** que incluye:

- **🎨 Tema WordPress avanzado** con 40+ opciones del Customizer
- **🔌 Plugin automatizador** para crear páginas y menús
- **🧩 Integración completa de Elementor** sin dependencias del Theme Builder
- **📱 Diseño responsive** con sistema de variables CSS
- **🛠️ Herramientas de desarrollo** en Python para automatización

## 📁 Estructura del Proyecto

```
aura-starter-kit/
├── themes/
│   └── aura-wp-elementor-starter/     # Tema WordPress completo
│       ├── functions.php              # 40+ Customizer controls
│       ├── style.css                  # Sistema de variables CSS
│       ├── assets/                    # CSS y JavaScript
│       └── tools/                     # Scripts Python
└── plugins/
    └── aura-site-bootstrapper/        # Plugin automatizador
        ├── aura-site-bootstrapper.php # Lógica principal
        ├── includes/                  # Funciones modulares
        └── templates/elementor/       # JSON templates
```

## ✨ Características Principales

### 🎨 Tema WordPress Avanzado

- **40+ Opciones del Customizer** organizadas en 6 secciones
- **Variables CSS dinámicas** para personalización en tiempo real
- **Header responsive** con menú mobile JavaScript
- **Footer customizable** con redes sociales
- **Compatibilidad completa** con Elementor

### 🔌 Plugin Site Bootstrapper

- **Creación automática** de páginas esenciales
- **Configuración de menús** WordPress
- **Importación de templates** JSON de Elementor
- **Sistema de placeholders** para branding dinámico
- **Detección inteligente** del estado de Elementor

### 🧩 Integración Elementor

- **4 Templates JSON** (Home, About, Services, Contact)
- **Sistema de placeholders** (`AURA_BUSINESS_NAME`, `AURA_BUSINESS_TAGLINE`)
- **Importación automática** sin Theme Builder
- **Reporte de debug** para transparencia

## 🚀 Instalación y Uso

### 1. Instalación en WordPress

```bash
# Descargar el monorepo
git clone https://github.com/luicalariosmx22/aura-wp-elementor-starter.git

# Copiar tema a wp-content/themes/
cp -r aura-starter-kit/themes/aura-wp-elementor-starter wp-content/themes/

# Copiar plugin a wp-content/plugins/
cp -r aura-starter-kit/plugins/aura-site-bootstrapper wp-content/plugins/
```

### 2. Activación

1. **Activar el tema**: WordPress Admin → Apariencia → Temas
2. **Activar el plugin**: WordPress Admin → Plugins → Aura Site Bootstrapper
3. **Configurar**: Admin → Aura Bootstrapper

### 3. Configuración Rápida

En el panel de administración del plugin:

1. **Detecta Elementor** automáticamente
2. **Instala/Activa Elementor** si es necesario
3. **Configura business info**: Nombre y tagline
4. **Ejecuta setup**: Crea páginas, menús y aplica templates

## 🛠️ Herramientas de Desarrollo

### Setup del Tema

```bash
cd themes/aura-wp-elementor-starter/tools/

# Personalizar tema para un negocio
python setup_theme.py --name "Mi Negocio" --tagline "Mi Eslogan" --slug "mi-negocio"
```

### Generar Screenshot

```bash
# Instalar dependencias
pip install pillow

# Generar screenshot.png
python generate_screenshot.py
```

### Build ZIP

```bash
# Crear archivo ZIP del tema
python build_zip.py
```

## ⚙️ Configuraciones del Customizer

### 📱 Header Settings
- Logo personalizable
- Menú responsive  
- Colores de header
- Tipografía de navegación

### 📱 Layout Settings
- Ancho del contenedor
- Espaciado de secciones
- Layout de sidebar

### 🎨 Branding Settings  
- Colores primarios y secundarios
- Tipografía de headings y body
- Configuraciones de botones

### 🔗 Social Media
- Enlaces a redes sociales
- Iconos personalizables

### 📝 Scripts Settings
- Google Analytics
- Facebook Pixel
- Scripts personalizados

### 🦶 Footer Settings
- Textos de copyright
- Información de contacto
- Configuración de widgets

## 🧩 Templates Elementor Incluidos

### 🏠 Home Template
- Hero section con CTA
- Sección de servicios
- Sobre nosotros
- Contacto

### ℹ️ About Template  
- Historia de la empresa
- Equipo de trabajo
- Valores corporativos

### 🛠️ Services Template
- Grid de servicios
- Descripciones detalladas
- Call-to-actions

### 📞 Contact Template
- Formulario de contacto
- Información de ubicación
- Mapa interactivo

## 🔄 Sistema de Placeholders

Reemplazo automático en templates:

- `AURA_BUSINESS_NAME` → Nombre del negocio
- `AURA_BUSINESS_TAGLINE` → Eslogan del negocio

## 🐛 Debug y Reporting

El plugin incluye un sistema de reportes que muestra:

- ✅ Estado de Elementor (instalado/activo)
- 📄 URLs de páginas creadas
- 📊 Datos Elementor importados
- 🎯 Status de templates JSON

## 📋 Requisitos del Sistema

- **WordPress**: 5.0+
- **PHP**: 7.4+
- **Elementor**: 3.0+ (instalación automática)
- **Python**: 3.6+ (para herramientas de desarrollo)

## 🤝 Contribución

1. Fork del proyecto
2. Crear rama de feature (`git checkout -b feature/nueva-caracteristica`)
3. Commit cambios (`git commit -am 'Añadir nueva característica'`)
4. Push a la rama (`git push origin feature/nueva-caracteristica`)
5. Crear Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia GPL v2 - ver el archivo [LICENSE](LICENSE) para detalles.

## 🆘 Soporte

- **Documentación**: [README.md](README.md)
- **Issues**: [GitHub Issues](https://github.com/luicalariosmx22/aura-wp-elementor-starter/issues)
- **Contacto**: [Aura Marketing](https://agenciaaura.mx)

---

**Desarrollado con ❤️ por [Aura Marketing](https://agenciaaura.mx)**

*Acelera tu desarrollo WordPress con herramientas profesionales y automatización inteligente.*