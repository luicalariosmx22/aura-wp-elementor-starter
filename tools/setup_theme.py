#!/usr/bin/env python3
"""
WordPress Theme Setup Tool
Automates the setup process for Aura Elementor Starter theme
"""

import os
import json
import shutil
import subprocess
from pathlib import Path

class ThemeSetup:
    def __init__(self):
        self.theme_path = Path(__file__).parent.parent
        self.config_file = self.theme_path / 'tools' / 'theme.config.json'
        self.load_config()
    
    def load_config(self):
        """Load theme configuration"""
        try:
            with open(self.config_file, 'r', encoding='utf-8') as f:
                self.config = json.load(f)
        except FileNotFoundError:
            self.config = self.get_default_config()
            self.save_config()
    
    def get_default_config(self):
        """Default theme configuration"""
        return {
            "theme_name": "Aura WordPress Elementor Starter",
            "text_domain": "aura-elementor-starter",
            "version": "1.0.0",
            "author": "Your Name",
            "description": "A starter theme optimized for Elementor with modern WordPress features.",
            "tags": ["elementor", "responsive", "modern", "clean", "minimal"],
            "requires_wp": "5.0",
            "tested_wp": "6.4",
            "requires_php": "7.4",
            "license": "GPL v2 or later",
            "development": {
                "use_sass": False,
                "use_postcss": False,
                "use_webpack": False,
                "use_gulp": False
            },
            "features": {
                "custom_logo": True,
                "post_thumbnails": True,
                "menus": ["primary", "footer"],
                "widgets": ["sidebar-1", "footer-1"],
                "elementor_support": True,
                "woocommerce_support": False
            }
        }
    
    def save_config(self):
        """Save configuration to file"""
        with open(self.config_file, 'w', encoding='utf-8') as f:
            json.dump(self.config, f, indent=2)
    
    def update_theme_info(self):
        """Update theme information in style.css"""
        style_file = self.theme_path / 'style.css'
        
        header = f"""/*
Theme Name: {self.config['theme_name']}
Description: {self.config['description']}
Version: {self.config['version']}
Author: {self.config['author']}
Text Domain: {self.config['text_domain']}
Tags: {', '.join(self.config['tags'])}
Requires at least: {self.config['requires_wp']}
Tested up to: {self.config['tested_wp']}
Requires PHP: {self.config['requires_php']}
License: {self.config['license']}
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This theme, like WordPress, is licensed under the GPL.
Use it to make something cool, have fun, and share what you've learned with others.
*/"""

        # Read existing content after header
        with open(style_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Find end of header comment
        header_end = content.find('*/')
        if header_end != -1:
            remaining_content = content[header_end + 2:].strip()
            new_content = header + '\n\n' + remaining_content
        else:
            new_content = header + '\n\n' + content
        
        with open(style_file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        
        print(f"✓ Updated theme header in style.css")
    
    def setup_development_environment(self):
        """Setup development tools based on configuration"""
        dev_config = self.config.get('development', {})
        
        if dev_config.get('use_sass'):
            self.setup_sass()
        
        if dev_config.get('use_postcss'):
            self.setup_postcss()
        
        if dev_config.get('use_webpack'):
            self.setup_webpack()
        
        if dev_config.get('use_gulp'):
            self.setup_gulp()
    
    def setup_sass(self):
        """Setup Sass compilation"""
        scss_dir = self.theme_path / 'assets' / 'scss'
        scss_dir.mkdir(exist_ok=True)
        
        # Create main.scss
        main_scss = scss_dir / 'main.scss'
        with open(main_scss, 'w', encoding='utf-8') as f:
            f.write("""// Aura Elementor Starter - Main SCSS
// Import partials here
@import 'variables';
@import 'mixins';
@import 'base';
@import 'components';
@import 'layout';

// Responsive styles
@import 'responsive';
""")
        
        print("✓ Sass structure created")
    
    def create_child_theme_template(self):
        """Create a child theme template"""
        child_theme_dir = self.theme_path.parent / f"{self.config['text_domain']}-child"
        child_theme_dir.mkdir(exist_ok=True)
        
        # Child theme style.css
        child_style = child_theme_dir / 'style.css'
        with open(child_style, 'w', encoding='utf-8') as f:
            f.write(f"""/*
Theme Name: {self.config['theme_name']} Child
Description: Child theme of {self.config['theme_name']}
Template: {self.config['text_domain']}
Version: 1.0.0
*/

/* Add your custom styles here */
""")
        
        # Child theme functions.php
        child_functions = child_theme_dir / 'functions.php'
        with open(child_functions, 'w', encoding='utf-8') as f:
            f.write(f"""<?php
/**
 * Child theme functions
 */

// Enqueue parent theme styles
function child_enqueue_styles() {{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}}
add_action('wp_enqueue_scripts', 'child_enqueue_styles');
""")
        
        print(f"✓ Child theme template created at {child_theme_dir}")
    
    def validate_theme_files(self):
        """Validate required WordPress theme files"""
        required_files = [
            'style.css',
            'index.php',
            'functions.php'
        ]
        
        missing_files = []
        for file in required_files:
            if not (self.theme_path / file).exists():
                missing_files.append(file)
        
        if missing_files:
            print(f"⚠ Missing required files: {', '.join(missing_files)}")
            return False
        else:
            print("✓ All required theme files present")
            return True
    
    def setup_hooks_and_filters(self):
        """Add common WordPress hooks and filters to functions.php"""
        hooks_content = """
/**
 * Additional theme customizations
 */

// Add custom post type support
function aura_add_post_type_support() {
    add_post_type_support('page', 'excerpt');
}
add_action('init', 'aura_add_post_type_support');

// Custom excerpt more link
function aura_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'aura_excerpt_more');

// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Disable emoji scripts
function aura_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'aura_disable_emojis');

// Security headers
function aura_security_headers() {
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
}
add_action('send_headers', 'aura_security_headers');
"""
        
        functions_file = self.theme_path / 'functions.php'
        with open(functions_file, 'a', encoding='utf-8') as f:
            f.write(hooks_content)
        
        print("✓ Added additional hooks and filters")
    
    def run_setup(self):
        """Run complete theme setup"""
        print("🚀 Starting Aura Elementor Starter theme setup...")
        print()
        
        self.update_theme_info()
        self.validate_theme_files()
        self.setup_development_environment()
        self.setup_hooks_and_filters()
        
        print()
        print("✨ Theme setup completed successfully!")
        print()
        print("Next steps:")
        print("1. Upload the theme to your WordPress installation")
        print("2. Activate the theme in WordPress admin")
        print("3. Install and activate Elementor plugin")
        print("4. Customize your theme through WordPress Customizer")
        print("5. Create a child theme for custom modifications")

if __name__ == "__main__":
    setup = ThemeSetup()
    setup.run_setup()