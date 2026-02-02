#!/usr/bin/env python3
"""
Build Theme ZIP Package
Creates a distributable ZIP file of the WordPress theme

@author Aura Marketing
@link https://agenciaaura.mx

Usage:
python build_zip.py [--name custom-name] [--exclude-dev]
"""

import os
import zipfile
import argparse
import sys
from pathlib import Path
import shutil
import datetime

def get_theme_info():
    """
    Extract theme information from style.css
    """
    theme_root = Path(__file__).parent.parent
    style_css_path = theme_root / 'style.css'
    
    theme_info = {
        'name': 'aura-wp-elementor-starter',
        'version': '1.0.0'
    }
    
    try:
        with open(style_css_path, 'r', encoding='utf-8') as f:
            content = f.read()
            
        # Extract theme name
        if 'Theme Name:' in content:
            for line in content.split('\n'):
                if line.strip().startswith('Theme Name:'):
                    name = line.split(':', 1)[1].strip()
                    if name and name != 'Aura Elementor Starter':
                        # Convert to slug format
                        theme_info['name'] = name.lower().replace(' ', '-').replace('_', '-')
                        
        # Extract version
        if 'Version:' in content:
            for line in content.split('\n'):
                if line.strip().startswith('Version:'):
                    version = line.split(':', 1)[1].strip()
                    if version and version != '1.0.0':
                        theme_info['version'] = version
                        
    except (FileNotFoundError, UnicodeDecodeError):
        pass
    
    return theme_info

def should_exclude_file(file_path, theme_root, exclude_dev=False):
    """
    Determine if a file should be excluded from the ZIP
    """
    relative_path = file_path.relative_to(theme_root)
    path_str = str(relative_path).replace('\\', '/')
    
    # Always exclude these
    exclude_patterns = [
        '.git',
        '__pycache__',
        '.vscode',
        'logs',
        '.log',
        '.tmp',
        '.temp',
        '.cache',
        'node_modules',
        '.env',
        '.DS_Store',
        'thumbs.db',
        'desktop.ini'
    ]
    
    # Additional dev files to exclude when --exclude-dev is used
    if exclude_dev:
        exclude_patterns.extend([
            'tools/',
            'README.md',
            '.editorconfig',
            '.gitignore',
            'package.json',
            'package-lock.json',
            'composer.json',
            'composer.lock'
        ])
    
    # Check if file should be excluded
    for pattern in exclude_patterns:
        if pattern.endswith('/'):
            # Directory pattern
            if path_str.startswith(pattern) or f'/{pattern}' in path_str:
                return True
        else:
            # File pattern
            if pattern in path_str or path_str.endswith(pattern):
                return True
    
    return False

def create_theme_zip(output_name=None, exclude_dev=False):
    """
    Create ZIP file of the theme
    """
    theme_root = Path(__file__).parent.parent
    
    # Get theme info for naming
    theme_info = get_theme_info()
    
    if not output_name:
        output_name = f"{theme_info['name']}-v{theme_info['version']}"
    
    # Clean output name (remove invalid characters)
    output_name = "".join(c for c in output_name if c.isalnum() or c in ('-', '_', '.')).strip('-_.')
    
    # Output path
    zip_path = theme_root.parent / f"{output_name}.zip"
    
    print("📦 Building Theme ZIP Package")
    print("=" * 50)
    print(f"   📁 Theme: {theme_info['name']}")
    print(f"   🔢 Version: {theme_info['version']}")
    print(f"   🎯 Output: {zip_path.name}")
    print(f"   🚫 Exclude dev files: {'Yes' if exclude_dev else 'No'}")
    print()
    
    # Count files for progress
    all_files = []
    excluded_files = []
    
    for root, dirs, files in os.walk(theme_root):
        # Remove excluded directories from dirs to avoid walking them
        dirs_to_remove = []
        for d in dirs:
            dir_path = Path(root) / d
            if should_exclude_file(dir_path, theme_root, exclude_dev):
                dirs_to_remove.append(d)
        
        for d in dirs_to_remove:
            dirs.remove(d)
        
        for file in files:
            file_path = Path(root) / file
            if should_exclude_file(file_path, theme_root, exclude_dev):
                excluded_files.append(file_path.relative_to(theme_root))
            else:
                all_files.append(file_path)
    
    print(f"🔍 Found {len(all_files)} files to include")
    
    if excluded_files:
        print(f"⏭️  Excluding {len(excluded_files)} files")
        # Show first few excluded files
        for i, excluded in enumerate(excluded_files[:5]):
            print(f"   • {excluded}")
        if len(excluded_files) > 5:
            print(f"   ... and {len(excluded_files) - 5} more")
    
    print(f"\n📦 Creating ZIP archive...")
    
    # Create ZIP file
    try:
        with zipfile.ZipFile(zip_path, 'w', zipfile.ZIP_DEFLATED, compresslevel=6) as zipf:
            folder_name = output_name
            
            for file_path in all_files:
                # Calculate relative path within theme
                rel_path = file_path.relative_to(theme_root)
                # Add to ZIP with folder name prefix
                zip_info_path = f"{folder_name}/{rel_path}"
                
                zipf.write(file_path, zip_info_path)
        
        # Get file size
        file_size = zip_path.stat().st_size
        
        print(f"\n✅ ZIP Package Created Successfully!")
        print(f"   📍 Location: {zip_path}")
        print(f"   📊 Files included: {len(all_files)}")
        print(f"   💾 File size: {file_size:,} bytes ({file_size / 1024 / 1024:.1f} MB)")
        print(f"   📂 Folder structure: {folder_name}/")
        
        # Basic validation
        with zipfile.ZipFile(zip_path, 'r') as zipf:
            zip_contents = zipf.namelist()
            
        # Check for essential files
        essential_files = ['style.css', 'functions.php', 'index.php']
        missing_files = []
        
        for essential in essential_files:
            expected_path = f"{folder_name}/{essential}"
            if expected_path not in zip_contents:
                missing_files.append(essential)
        
        if missing_files:
            print(f"\n⚠️  Warning: Missing essential files: {', '.join(missing_files)}")
        else:
            print(f"\n🎉 Theme package is ready for WordPress installation!")
            print(f"   💡 Upload {zip_path.name} to WordPress Admin → Themes → Add New → Upload Theme")
        
        return zip_path
        
    except Exception as e:
        print(f"\n❌ Error creating ZIP: {e}")
        if zip_path.exists():
            zip_path.unlink()  # Clean up partial file
        return None

def main():
    """
    Main entry point
    """
    parser = argparse.ArgumentParser(
        description='Build distributable ZIP package of WordPress theme',
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Examples:
  python build_zip.py
  python build_zip.py --name my-custom-theme
  python build_zip.py --exclude-dev
  python build_zip.py --name production-theme --exclude-dev

Output:
  Creates a ZIP file in the parent directory ready for WordPress installation.
        """
    )
    
    parser.add_argument('--name',
                       help='Custom name for the ZIP file (default: auto-generated from theme info)')
    
    parser.add_argument('--exclude-dev',
                       action='store_true',
                       help='Exclude development files (tools/, README.md, etc.)')
    
    args = parser.parse_args()
    
    print("🚀 Aura Theme ZIP Builder")
    print("=" * 60)
    
    try:
        zip_path = create_theme_zip(args.name, args.exclude_dev)
        
        if zip_path:
            print(f"\n📋 Next Steps:")
            print(f"   1. Test the ZIP by extracting it")
            print(f"   2. Upload to WordPress: Themes → Add New → Upload Theme")
            print(f"   3. Activate and configure your theme")
        
    except KeyboardInterrupt:
        print(f"\n⚠️  Build cancelled by user")
        sys.exit(1)
    except Exception as e:
        print(f"\n❌ Unexpected error: {e}")
        sys.exit(1)

if __name__ == "__main__":
    main()