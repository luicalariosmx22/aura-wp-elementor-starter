#!/usr/bin/env python3
"""
Generate Screenshot for WordPress Theme
Creates a 1200x900px screenshot for the theme

@author Aura Marketing
@link https://agenciaaura.mx
"""

import os
import sys
from pathlib import Path

try:
    from PIL import Image, ImageDraw, ImageFont
except ImportError:
    print("❌ Error: Pillow is required to generate screenshots.")
    print("   Install it with: pip install pillow")
    sys.exit(1)

def create_theme_screenshot():
    """
    Generate a professional screenshot for the WordPress theme
    """
    
    # Screenshot dimensions (WordPress standard)
    width, height = 1200, 900
    
    # Colors
    bg_color = '#f8f9fa'
    header_bg = '#ffffff'
    primary_color = '#0073aa'
    text_color = '#333333'
    border_color = '#e5e5e5'
    accent_color = '#005177'
    
    # Create main image
    img = Image.new('RGB', (width, height), bg_color)
    draw = ImageDraw.Draw(img)
    
    # Try to use system fonts, fallback to PIL default
    try:
        # Try common system fonts
        title_font = ImageFont.truetype("arial.ttf", 48) if os.name == 'nt' else ImageFont.truetype("/System/Library/Fonts/Arial.ttf", 48)
        subtitle_font = ImageFont.truetype("arial.ttf", 24) if os.name == 'nt' else ImageFont.truetype("/System/Library/Fonts/Arial.ttf", 24)
        small_font = ImageFont.truetype("arial.ttf", 16) if os.name == 'nt' else ImageFont.truetype("/System/Library/Fonts/Arial.ttf", 16)
    except (OSError, IOError):
        try:
            # Try alternative fonts
            title_font = ImageFont.truetype("calibri.ttf", 48) if os.name == 'nt' else ImageFont.load_default()
            subtitle_font = ImageFont.truetype("calibri.ttf", 24) if os.name == 'nt' else ImageFont.load_default() 
            small_font = ImageFont.truetype("calibri.ttf", 16) if os.name == 'nt' else ImageFont.load_default()
        except (OSError, IOError):
            # Fallback to default font
            title_font = ImageFont.load_default()
            subtitle_font = ImageFont.load_default()
            small_font = ImageFont.load_default()
    
    # Browser frame simulation
    frame_height = 40
    frame_y = 80
    
    # Browser frame background
    draw.rectangle([80, frame_y, width-80, frame_y + frame_height], fill=border_color)
    
    # Browser buttons (simple circles)
    button_y = frame_y + 12
    draw.ellipse([100, button_y, 116, button_y + 16], fill='#ff5f56')
    draw.ellipse([125, button_y, 141, button_y + 16], fill='#ffbd2e') 
    draw.ellipse([150, button_y, 166, button_y + 16], fill='#27ca3f')
    
    # URL bar simulation
    url_bar_x = 200
    url_bar_width = 400
    draw.rectangle([url_bar_x, button_y, url_bar_x + url_bar_width, button_y + 16], 
                  fill='#ffffff', outline=border_color)
    
    # Main content area
    content_y = frame_y + frame_height
    content_height = height - content_y - 100
    
    draw.rectangle([80, content_y, width-80, content_y + content_height], 
                  fill=header_bg, outline=border_color)
    
    # Header section
    header_height = 80
    draw.rectangle([80, content_y, width-80, content_y + header_height], 
                  fill=header_bg)
    
    # Logo placeholder
    logo_x, logo_y = 120, content_y + 20
    draw.rectangle([logo_x, logo_y, logo_x + 40, logo_y + 40], fill=primary_color)
    
    # Navigation simulation
    nav_x = 200
    nav_items = ["Home", "About", "Services", "Contact"]
    for i, item in enumerate(nav_items):
        item_x = nav_x + (i * 80)
        draw.text((item_x, content_y + 30), item, font=small_font, fill=text_color)
    
    # Main hero section
    hero_y = content_y + header_height + 60
    hero_center_x = width // 2
    
    # Business name (main title)
    business_name = "THEME_NAME_PLACEHOLDER"
    try:
        bbox = draw.textbbox((0, 0), business_name, font=title_font)
        text_width = bbox[2] - bbox[0]
    except AttributeError:
        # Fallback for older Pillow versions
        text_width = len(business_name) * 12  # Approximate width
    
    draw.text((hero_center_x - text_width//2, hero_y), business_name, 
             font=title_font, fill=primary_color)
    
    # Business tagline
    tagline = "TAGLINE_PLACEHOLDER"
    try:
        bbox = draw.textbbox((0, 0), tagline, font=subtitle_font)
        tagline_width = bbox[2] - bbox[0]
    except AttributeError:
        tagline_width = len(tagline) * 8  # Approximate width
    
    draw.text((hero_center_x - tagline_width//2, hero_y + 70), tagline, 
             font=subtitle_font, fill=text_color)
    
    # Feature boxes simulation
    box_y = hero_y + 140
    box_width = 200
    box_height = 120
    box_spacing = 40
    
    # Calculate starting position for 3 boxes
    total_width = 3 * box_width + 2 * box_spacing
    start_x = (width - total_width) // 2
    
    features = ["Responsive", "Elementor", "Fast Loading"]
    
    for i in range(3):
        box_x = start_x + i * (box_width + box_spacing)
        
        # Box background
        draw.rectangle([box_x, box_y, box_x + box_width, box_y + box_height], 
                      fill='#ffffff', outline=border_color, width=2)
        
        # Feature icon placeholder
        icon_size = 30
        icon_x = box_x + (box_width - icon_size) // 2
        icon_y = box_y + 20
        draw.rectangle([icon_x, icon_y, icon_x + icon_size, icon_y + icon_size], 
                      fill=accent_color)
        
        # Feature title
        feature_title = features[i]
        try:
            bbox = draw.textbbox((0, 0), feature_title, font=subtitle_font)
            feature_width = bbox[2] - bbox[0]
        except AttributeError:
            feature_width = len(feature_title) * 8  # Approximate width
        
        draw.text((box_x + (box_width - feature_width) // 2, icon_y + icon_size + 15), 
                 feature_title, font=subtitle_font, fill=text_color)
    
    # Footer section
    footer_y = height - 60
    footer_text = "Theme by Aura Marketing • agenciaaura.mx"
    
    try:
        bbox = draw.textbbox((0, 0), footer_text, font=small_font)
        footer_width = bbox[2] - bbox[0]
    except AttributeError:
        footer_width = len(footer_text) * 6  # Approximate width
    
    draw.text((hero_center_x - footer_width//2, footer_y), footer_text, 
             font=small_font, fill=text_color)
    
    # Save the screenshot
    output_path = Path(__file__).parent.parent / 'screenshot.png'
    img.save(output_path, 'PNG', quality=95, optimize=True)
    
    file_size = os.path.getsize(output_path)
    
    print(f"✅ Theme screenshot generated successfully!")
    print(f"   📁 Location: {output_path}")
    print(f"   📏 Dimensions: {width}x{height}px")
    print(f"   💾 File size: {file_size:,} bytes")
    print(f"   🎨 Ready for WordPress theme showcase")
    
    return output_path

if __name__ == "__main__":
    try:
        create_theme_screenshot()
    except Exception as e:
        print(f"❌ Error generating screenshot: {e}")
        print("\nTroubleshooting:")
        print("1. Make sure Pillow is installed: pip install pillow")
        print("2. Check file permissions in the theme directory")
        print("3. Ensure you're running this from the tools/ directory")
        sys.exit(1)