#!/usr/bin/env python3
"""
Aura Starter Kit - Build Distribution ZIPs
Creates distributable ZIP files for WordPress theme and plugin

@author Aura Marketing
@link https://agenciaaura.mx

Usage:
python build_distribution.py [--theme-only] [--plugin-only] [--all]
"""

import os
import zipfile
import argparse
import sys
from pathlib import Path
import shutil
import datetime

class AuraDistributionBuilder:
    def __init__(self):
        self.project_root = Path(__file__).parent.parent
        self.build_dir = self.project_root / 'dist'
        self.timestamp = datetime.datetime.now().strftime('%Y%m%d_%H%M%S')
        
    def create_build_dir(self):
        """Create build directory"""
        if self.build_dir.exists():
            shutil.rmtree(self.build_dir)
        self.build_dir.mkdir(exist_ok=True)
        
    def get_theme_info(self):
        """Extract theme information from style.css"""
        theme_path = self.project_root / 'themes' / 'aura-wp-elementor-starter'
        style_css_path = theme_path / 'style.css'
        
        theme_info = {
            'name': 'aura-wp-elementor-starter',
            'version': '1.0.0',
            'path': theme_path
        }
        
        if style_css_path.exists():
            try:
                with open(style_css_path, 'r', encoding='utf-8') as f:
                    content = f.read()
                    
                # Extract theme name
                for line in content.split('\n'):
                    if line.strip().startswith('Theme Name:'):
                        name = line.split(':', 1)[1].strip()
                        if name and name != 'THEME_NAME_PLACEHOLDER':
                            theme_info['name'] = name.lower().replace(' ', '-')
                    elif line.strip().startswith('Version:'):
                        version = line.split(':', 1)[1].strip()
                        if version:
                            theme_info['version'] = version
            except Exception as e:
                print(f"Warning: Could not read theme info: {e}")
                
        return theme_info
        
    def get_plugin_info(self):
        """Extract plugin information from main file"""
        plugin_path = self.project_root / 'plugins' / 'aura-site-bootstrapper'
        main_file = plugin_path / 'aura-site-bootstrapper.php'
        
        plugin_info = {
            'name': 'aura-site-bootstrapper',
            'version': '1.0.0',
            'path': plugin_path
        }
        
        if main_file.exists():
            try:
                with open(main_file, 'r', encoding='utf-8') as f:
                    content = f.read()
                    
                # Extract plugin info
                for line in content.split('\n'):
                    if 'Plugin Name:' in line:
                        name = line.split(':', 1)[1].strip()
                        if name:
                            plugin_info['name'] = name.lower().replace(' ', '-')
                    elif 'Version:' in line:
                        version = line.split(':', 1)[1].strip()
                        if version:
                            plugin_info['version'] = version
            except Exception as e:
                print(f"Warning: Could not read plugin info: {e}")
                
        return plugin_info
    
    def should_exclude_file(self, file_path, exclude_patterns):
        """Check if file should be excluded"""
        file_str = str(file_path)
        for pattern in exclude_patterns:
            if pattern in file_str:
                return True
        return False
    
    def create_theme_zip(self):
        """Create theme ZIP package"""
        theme_info = self.get_theme_info()
        theme_path = theme_info['path']
        
        if not theme_path.exists():
            print("❌ Error: Theme directory not found!")
            return None
            
        # Exclude patterns for theme
        exclude_patterns = [
            '__pycache__',
            '.git',
            '.DS_Store',
            'node_modules',
            '.vscode',
            'tools',  # Exclude Python tools
            '*.pyc',
            '*.log'
        ]
        
        zip_name = f"{theme_info['name']}-v{theme_info['version']}-{self.timestamp}.zip"
        zip_path = self.build_dir / zip_name
        
        print(f"📦 Creating theme ZIP: {zip_name}")
        
        with zipfile.ZipFile(zip_path, 'w', zipfile.ZIP_DEFLATED) as zipf:
            for root, dirs, files in os.walk(theme_path):
                # Filter out excluded directories
                dirs[:] = [d for d in dirs if not any(pattern in d for pattern in exclude_patterns)]
                
                for file in files:
                    file_path = Path(root) / file
                    
                    if self.should_exclude_file(file_path, exclude_patterns):
                        continue
                    
                    # Calculate archive name (relative to theme root)
                    arcname = Path(theme_info['name']) / file_path.relative_to(theme_path)
                    zipf.write(file_path, arcname)
                    
        print(f"✅ Theme ZIP created: {zip_path}")
        return zip_path
    
    def create_plugin_zip(self):
        """Create plugin ZIP package"""
        plugin_info = self.get_plugin_info()
        plugin_path = plugin_info['path']
        
        if not plugin_path.exists():
            print("❌ Error: Plugin directory not found!")
            return None
            
        # Exclude patterns for plugin
        exclude_patterns = [
            '__pycache__',
            '.git',
            '.DS_Store',
            'node_modules',
            '.vscode',
            '*.pyc',
            '*.log',
            'test-elementor.php'  # Exclude test file
        ]
        
        zip_name = f"{plugin_info['name']}-v{plugin_info['version']}-{self.timestamp}.zip"
        zip_path = self.build_dir / zip_name
        
        print(f"📦 Creating plugin ZIP: {zip_name}")
        
        with zipfile.ZipFile(zip_path, 'w', zipfile.ZIP_DEFLATED) as zipf:
            for root, dirs, files in os.walk(plugin_path):
                # Filter out excluded directories
                dirs[:] = [d for d in dirs if not any(pattern in d for pattern in exclude_patterns)]
                
                for file in files:
                    file_path = Path(root) / file
                    
                    if self.should_exclude_file(file_path, exclude_patterns):
                        continue
                    
                    # Calculate archive name (relative to plugin root)
                    arcname = Path(plugin_info['name']) / file_path.relative_to(plugin_path)
                    zipf.write(file_path, arcname)
                    
        print(f"✅ Plugin ZIP created: {zip_path}")
        return zip_path
    
    def create_complete_bundle(self):
        """Create complete bundle with both theme and plugin"""
        bundle_name = f"aura-starter-kit-complete-{self.timestamp}.zip"
        bundle_path = self.build_dir / bundle_name
        
        print(f"📦 Creating complete bundle: {bundle_name}")
        
        # Create individual ZIPs first
        theme_zip = self.create_theme_zip()
        plugin_zip = self.create_plugin_zip()
        
        if not theme_zip or not plugin_zip:
            print("❌ Error: Could not create individual packages")
            return None
        
        # Create bundle with installation instructions
        with zipfile.ZipFile(bundle_path, 'w', zipfile.ZIP_DEFLATED) as zipf:
            # Add theme ZIP
            zipf.write(theme_zip, f"theme/{theme_zip.name}")
            
            # Add plugin ZIP
            zipf.write(plugin_zip, f"plugin/{plugin_zip.name}")
            
            # Add installation instructions
            instructions = self.create_installation_instructions()
            zipf.writestr("INSTALLATION.md", instructions)
            
            # Add project README
            readme_path = self.project_root / 'README.md'
            if readme_path.exists():
                zipf.write(readme_path, "README.md")
        
        print(f"✅ Complete bundle created: {bundle_path}")
        return bundle_path
    
    def create_installation_instructions(self):
        """Create installation instructions"""
        return """# 🚀 Aura Starter Kit - Installation Instructions

## 📦 What's Included

This bundle contains:
- **Theme**: Aura WP Elementor Starter Theme
- **Plugin**: Aura Site Bootstrapper Plugin

## 🔧 Installation Steps

### 1. Install Theme
1. Go to WordPress Admin → **Appearance → Themes**
2. Click **Add New → Upload Theme**
3. Upload the theme ZIP file from the `theme/` folder
4. **Activate** the theme

### 2. Install Plugin
1. Go to WordPress Admin → **Plugins → Add New**
2. Click **Upload Plugin**
3. Upload the plugin ZIP file from the `plugin/` folder
4. **Activate** the plugin

### 3. Configure
1. Go to **Aura Bootstrapper** in WordPress Admin
2. Click **Setup Site** to automatically create pages and menus
3. Configure your business information
4. Import Elementor templates

## 📋 Requirements

- WordPress 5.0+
- PHP 7.4+
- Elementor Plugin (auto-installed by plugin)

## 🆘 Support

- Documentation: README.md
- Contact: https://agenciaaura.mx

---
**Developed by Aura Marketing**
"""
    
    def print_summary(self, created_files):
        """Print build summary"""
        print("\n🎉 Build Complete!")
        print("=" * 50)
        
        for file_path in created_files:
            if file_path and file_path.exists():
                size_mb = file_path.stat().st_size / (1024 * 1024)
                print(f"📄 {file_path.name} ({size_mb:.2f} MB)")
        
        print(f"\n📁 Output directory: {self.build_dir}")
        print("\n📋 Next Steps:")
        print("1. Upload theme ZIP to WordPress → Appearance → Themes")
        print("2. Upload plugin ZIP to WordPress → Plugins")
        print("3. Activate both components")
        print("4. Run Aura Bootstrapper setup")

def main():
    parser = argparse.ArgumentParser(description='Build Aura Starter Kit distribution packages')
    parser.add_argument('--theme-only', action='store_true', help='Build only theme ZIP')
    parser.add_argument('--plugin-only', action='store_true', help='Build only plugin ZIP')
    parser.add_argument('--all', action='store_true', help='Build all packages including bundle')
    
    args = parser.parse_args()
    
    builder = AuraDistributionBuilder()
    builder.create_build_dir()
    
    created_files = []
    
    if args.theme_only:
        theme_zip = builder.create_theme_zip()
        created_files.append(theme_zip)
    elif args.plugin_only:
        plugin_zip = builder.create_plugin_zip()
        created_files.append(plugin_zip)
    elif args.all:
        theme_zip = builder.create_theme_zip()
        plugin_zip = builder.create_plugin_zip()
        bundle_zip = builder.create_complete_bundle()
        created_files.extend([theme_zip, plugin_zip, bundle_zip])
    else:
        # Default: create complete bundle
        bundle_zip = builder.create_complete_bundle()
        created_files.append(bundle_zip)
    
    builder.print_summary(created_files)

if __name__ == '__main__':
    main()