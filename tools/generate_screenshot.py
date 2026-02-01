#!/usr/bin/env python3
"""
Generate Screenshot for WordPress Theme
Creates a 1200x900px screenshot for the theme
"""

from PIL import Image, ImageDraw, ImageFont
import os
from pathlib import Path

def create_theme_screenshot():
    """Generate a professional screenshot for the theme"""
    
    # Screenshot dimensions (WordPress standard)
    width, height = 1200, 900
    
    # Colors
    bg_color = '#f8f9fa'
    primary_color = '#0073aa'
    secondary_color = '#005177'
    text_color = '#333333'
    white = '#ffffff'
    
    # Create image
    img = Image.new('RGB', (width, height), bg_color)
    draw = ImageDraw.Draw(img)
    
    # Header section
    header_height = 100
    draw.rectangle([0, 0, width, header_height], fill=white)
    
    # Header border
    draw.rectangle([0, header_height-2, width, header_height], fill='#e5e5e5')
    
    # Logo/Brand area
    draw.rectangle([50, 25, 300, 75], fill=primary_color)
    
    try:
        # Try to load a font (fallback to default if not available)
        try:
            title_font = ImageFont.truetype("arial.ttf", 36)
            subtitle_font = ImageFont.truetype("arial.ttf", 18)
            header_font = ImageFont.truetype("arial.ttf", 24)
        except:
            title_font = ImageFont.load_default()
            subtitle_font = ImageFont.load_default()
            header_font = ImageFont.load_default()
    except:
        title_font = ImageFont.load_default()
        subtitle_font = ImageFont.load_default()
        header_font = ImageFont.load_default()
    
    # Header text (simulate logo)
    draw.text((320, 35), "Aura Theme", font=header_font, fill=primary_color)
    
    # Navigation simulation
    nav_items = ["Home", "About", "Services", "Blog", "Contact"]
    nav_x = 600
    for item in nav_items:
        draw.text((nav_x, 40), item, font=subtitle_font, fill=text_color)
        nav_x += 100
    
    # Hero section
    hero_y = header_height + 50
    hero_height = 300
    
    # Hero background with gradient effect
    for i in range(hero_height):
        alpha = int(255 * (1 - i / hero_height))
        color = f"#{primary_color[1:3]}{primary_color[3:5]}{primary_color[5:7]}"
        draw.rectangle([0, hero_y + i, width, hero_y + i + 1], 
                      fill=primary_color)
    
    # Hero content
    hero_title = "Beautiful WordPress Themes"
    hero_subtitle = "Elementor-Ready & Responsive Design"
    
    # Calculate text position for centering
    title_bbox = draw.textbbox((0, 0), hero_title, font=title_font)
    title_width = title_bbox[2] - title_bbox[0]
    title_x = (width - title_width) // 2
    
    subtitle_bbox = draw.textbbox((0, 0), hero_subtitle, font=subtitle_font)
    subtitle_width = subtitle_bbox[2] - subtitle_bbox[0]
    subtitle_x = (width - subtitle_width) // 2
    
    draw.text((title_x, hero_y + 80), hero_title, font=title_font, fill=white)
    draw.text((subtitle_x, hero_y + 140), hero_subtitle, font=subtitle_font, fill=white)
    
    # Button simulation
    button_width, button_height = 200, 50
    button_x = (width - button_width) // 2
    button_y = hero_y + 200
    
    draw.rectangle([button_x, button_y, button_x + button_width, button_y + button_height], 
                  fill=white, outline=primary_color, width=2)
    
    button_text = "Get Started"
    button_bbox = draw.textbbox((0, 0), button_text, font=subtitle_font)
    button_text_width = button_bbox[2] - button_bbox[0]
    button_text_height = button_bbox[3] - button_bbox[1]
    
    button_text_x = button_x + (button_width - button_text_width) // 2
    button_text_y = button_y + (button_height - button_text_height) // 2
    
    draw.text((button_text_x, button_text_y), button_text, font=subtitle_font, fill=primary_color)
    
    # Content section with cards
    content_y = hero_y + hero_height + 50
    card_width = 300
    card_height = 200
    card_spacing = 50
    
    # Calculate positions for 3 cards
    total_cards_width = 3 * card_width + 2 * card_spacing
    start_x = (width - total_cards_width) // 2
    
    for i in range(3):
        card_x = start_x + i * (card_width + card_spacing)
        
        # Card background
        draw.rectangle([card_x, content_y, card_x + card_width, content_y + card_height], 
                      fill=white, outline='#e5e5e5', width=1)
        
        # Card header
        draw.rectangle([card_x, content_y, card_x + card_width, content_y + 60], 
                      fill='#f8f9fa')
        
        # Card title
        card_titles = ["Responsive", "Elementor Ready", "Clean Code"]
        draw.text((card_x + 20, content_y + 20), card_titles[i], font=subtitle_font, fill=text_color)
        
        # Card content simulation
        for j in range(3):
            line_y = content_y + 80 + j * 25
            line_width = card_width - 40
            if j == 2:
                line_width = int(line_width * 0.7)  # Shorter last line
            
            draw.rectangle([card_x + 20, line_y, card_x + 20 + line_width, line_y + 15], 
                          fill='#e5e5e5')
    
    # Footer
    footer_y = height - 80
    draw.rectangle([0, footer_y, width, height], fill=text_color)
    
    footer_text = "© 2026 Aura Elementor Starter Theme"
    footer_bbox = draw.textbbox((0, 0), footer_text, font=subtitle_font)
    footer_text_width = footer_bbox[2] - footer_bbox[0]
    footer_x = (width - footer_text_width) // 2
    
    draw.text((footer_x, footer_y + 25), footer_text, font=subtitle_font, fill=white)
    
    # Save the image
    output_path = Path(__file__).parent.parent / 'screenshot.png'
    img.save(output_path, 'PNG', quality=90, optimize=True)
    
    print(f"✓ Theme screenshot generated: {output_path}")
    print(f"   Dimensions: {width}x{height}px")
    print(f"   File size: {os.path.getsize(output_path)} bytes")

if __name__ == "__main__":
    try:
        create_theme_screenshot()
    except ImportError:
        print("❌ PIL (Pillow) is required to generate screenshots.")
        print("   Install it with: pip install Pillow")
    except Exception as e:
        print(f"❌ Error generating screenshot: {e}")