#!/usr/bin/env python3
"""
Setup Theme Configuration
Converts the starter theme into a business-specific theme

@author Aura Marketing
@link https://agenciaaura.mx

Usage:
python setup_theme.py --name "Nombre Negocio" --tagline "Tagline" --slug "slug-del-negocio"
"""

import os
import re
import argparse
import sys
from pathlib import Path

# Common articles to ignore when creating PHP prefix
IGNORE_WORDS = {'el', 'la', 'los', 'las', 'de', 'del', 'y', 'en', 'con', 'para', 'por', 'un', 'una', 'al'}

def generate_php_prefix(business_name):
    """
    Generate PHP prefix from business name
    Takes initials from main words (ignoring common articles)
    Format: aura_[initials]_
    
    Example: "La Carreta Verde" -> "aura_lcv_"
    """
    # Clean and split words
    words = re.sub(r'[^\w\s]', '', business_name.lower()).split()
    
    # Filter out common articles and get initials
    initials = []
    for word in words:
        if word not in IGNORE_WORDS and len(word) > 0:
            initials.append(word[0])
    
    # Fallback if no valid words found
    if not initials:
        initials = [word[0] for word in words if len(word) > 0]
    
    # Limit to reasonable length (max 5 initials)
    if len(initials) > 5:
        initials = initials[:5]
    
    prefix = f"aura_{''.join(initials)}_"
    return prefix

def find_text_files(theme_root):
    """
    Find all text files that should be processed
    Excludes binary files and hidden files
    """
    text_extensions = {'.php', '.css', '.js', '.json', '.md', '.txt', '.xml', '.yml', '.yaml'}
    binary_extensions = {'.png', '.jpg', '.jpeg', '.gif', '.ico', '.svg', '.woff', '.woff2', '.ttf', '.eot'}
    
    text_files = []
    
    for root, dirs, files in os.walk(theme_root):
        # Skip hidden directories, git, and cache
        dirs[:] = [d for d in dirs if not d.startswith('.') and d not in {'__pycache__', 'node_modules'}]
        
        for file in files:
            file_path = Path(root) / file
            
            # Skip hidden files
            if file.startswith('.'):
                continue
            
            # Check extension
            ext = file_path.suffix.lower()
            
            # Include text files, exclude binaries
            if ext in text_extensions or (ext not in binary_extensions and file_path.suffix):
                text_files.append(file_path)
    
    return text_files

def replace_placeholders_in_file(file_path, replacements):
    """
    Replace placeholders in a single file
    Returns True if file was modified, False otherwise
    """
    try:
        # Read file content
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Store original content to check if changes were made
        original_content = content
        
        # Apply replacements
        for placeholder, replacement in replacements.items():
            content = content.replace(placeholder, replacement)
        
        # Write back if changed
        if content != original_content:
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(content)
            return True
        
        return False
        
    except (UnicodeDecodeError, PermissionError, IOError) as e:
        print(f"⚠️  Error processing {file_path}: {e}")
        return False

def validate_no_placeholders(theme_root, allow_remaining=False):
    """
    Validate that no placeholders remain in text files
    """
    placeholders_found = []
    
    # Common placeholder patterns
    placeholder_patterns = [
        r'THEME_NAME_PLACEHOLDER',
        r'TAGLINE_PLACEHOLDER', 
        r'aura-business-slug',
        r'aura_abc_',
        r'PREFIX_PHP_PLACEHOLDER',
        r'TEXT_DOMAIN_PLACEHOLDER',
        r'BUSINESS_NAME_PLACEHOLDER',
        r'AURA BUSINESS NAME',
        r'AURA BUSINESS TAGLINE'
    ]
    
    text_files = find_text_files(theme_root)
    
    for file_path in text_files:
        try:
            with open(file_path, 'r', encoding='utf-8') as f:
                content = f.read()
            
            # Check for each placeholder pattern
            for pattern in placeholder_patterns:
                if re.search(pattern, content, re.IGNORECASE):
                    placeholders_found.append({
                        'file': file_path.relative_to(theme_root),
                        'pattern': pattern
                    })
                    
        except (UnicodeDecodeError, PermissionError, IOError):
            continue  # Skip files we can't read
    
    if placeholders_found and not allow_remaining:
        print("\n❌ Validation Failed: Placeholders still found!")
        for item in placeholders_found:
            print(f"   📄 {item['file']}: {item['pattern']}")
        return False
    elif placeholders_found and allow_remaining:
        print(f"\n⚠️  {len(placeholders_found)} placeholders remain (allowed)")
    else:
        print("\n✅ Validation Passed: No placeholders found!")
    
    return True

def setup_theme(business_name, tagline, slug):
    """
    Main theme setup function
    """
    theme_root = Path(__file__).parent.parent
    
    # Generate derived values
    php_prefix = generate_php_prefix(business_name)
    text_domain = slug
    
    # Define all replacements
    replacements = {
        # Main placeholders
        'THEME_NAME_PLACEHOLDER': business_name,
        'TAGLINE_PLACEHOLDER': tagline,
        'aura-business-slug': slug,
        'aura_abc_': php_prefix,
        
        # Additional placeholders for compatibility
        'PREFIX_PHP_PLACEHOLDER': php_prefix,
        'TEXT_DOMAIN_PLACEHOLDER': text_domain,
        'BUSINESS_NAME_PLACEHOLDER': business_name,
        'AURA BUSINESS NAME': business_name,
        'AURA BUSINESS TAGLINE': tagline,
        
        # Theme metadata
        'VERSION_PLACEHOLDER': '1.0.0',
        'DESCRIPTION_PLACEHOLDER': f'Professional WordPress theme for {business_name}',
        'AUTHOR_PLACEHOLDER': 'Aura Marketing',
        'AUTHOR_URI_PLACEHOLDER': 'https://agenciaaura.mx'
    }
    
    print("🎯 Theme Setup Configuration")
    print("=" * 50)
    print(f"   🏢 Business Name: {business_name}")
    print(f"   💬 Tagline: {tagline}")
    print(f"   🔗 Slug: {slug}")
    print(f"   🔧 PHP Prefix: {php_prefix}")
    print(f"   📦 Text Domain: {text_domain}")
    print()
    
    # Find and process text files
    text_files = find_text_files(theme_root)
    
    print(f"🔍 Found {len(text_files)} text files to process...")
    
    files_changed = 0
    processed_files = []
    
    # Process each file
    for file_path in text_files:
        was_modified = replace_placeholders_in_file(file_path, replacements)
        
        if was_modified:
            files_changed += 1
            processed_files.append(file_path.relative_to(theme_root))
    
    # Print summary
    print(f"\n📝 Processing Complete!")
    print(f"   ✅ {files_changed} files modified")
    print(f"   📁 {len(text_files) - files_changed} files unchanged")
    
    if processed_files:
        print(f"\n📄 Files Modified:")
        for file_path in sorted(processed_files):
            print(f"   • {file_path}")
    
    return files_changed > 0

def main():
    """
    Main entry point
    """
    parser = argparse.ArgumentParser(
        description='Setup WordPress theme for a specific business',
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Examples:
  python setup_theme.py --name "La Carreta Verde" --tagline "Comida Saludable" --slug "carreta-verde"
  python setup_theme.py --name "Tech Solutions Inc" --tagline "Innovation Matters" --slug "tech-solutions"

Notes:
  • PHP prefix is auto-generated from business name initials
  • Text domain equals slug
  • All text files will be processed (excludes binaries like images)
        """
    )
    
    parser.add_argument('--name', 
                       required=True,
                       help='Business name (e.g., "La Carreta Verde")')
    
    parser.add_argument('--tagline',
                       required=True, 
                       help='Business tagline (e.g., "Comida Saludable")')
    
    parser.add_argument('--slug',
                       required=True,
                       help='Theme slug (e.g., "carreta-verde")')
    
    parser.add_argument('--allow-remaining-placeholders',
                       action='store_true',
                       help='Skip validation of remaining placeholders')
    
    args = parser.parse_args()
    
    # Validate inputs
    if not args.name.strip():
        print("❌ Error: Business name cannot be empty")
        sys.exit(1)
    
    if not args.tagline.strip():
        print("❌ Error: Tagline cannot be empty") 
        sys.exit(1)
    
    if not args.slug.strip() or not re.match(r'^[a-z0-9-]+$', args.slug):
        print("❌ Error: Slug must contain only lowercase letters, numbers, and hyphens")
        sys.exit(1)
    
    print("🚀 Aura Theme Business Setup")
    print("=" * 60)
    
    # Setup the theme
    try:
        success = setup_theme(args.name, args.tagline, args.slug)
        
        if success:
            # Validate results
            theme_root = Path(__file__).parent.parent
            validate_no_placeholders(theme_root, args.allow_remaining_placeholders)
            
            print(f"\n🎉 Setup Complete!")
            print(f"   💡 Theme is ready for WordPress installation")
            print(f"   📁 Consider renaming folder to: {args.slug}")
            print(f"   🖼️  Run 'python tools/generate_screenshot.py' to update screenshot")
        else:
            print("\n⚠️  No changes were made - placeholders may have been replaced already")
    
    except KeyboardInterrupt:
        print("\n⚠️  Setup cancelled by user")
        sys.exit(1)
    except Exception as e:
        print(f"\n❌ Error during setup: {e}")
        sys.exit(1)

if __name__ == "__main__":
    main()