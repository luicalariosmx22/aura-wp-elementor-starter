/**
 * Aura Theme - Main JavaScript
 * 
 * @author Aura Marketing
 * @link https://agenciaaura.mx
 * @package AuraTheme
 */

(function() {
    'use strict';

    // Mobile menu functionality
    function initMobileMenu() {
        const menuToggle = document.querySelector('.aura-header__toggle');
        const navContainer = document.querySelector('.aura-header__nav-container');
        
        if (!menuToggle || !navContainer) {
            return; // Elements not found
        }

        // Toggle menu function
        function toggleMenu() {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            
            // Toggle aria-expanded
            menuToggle.setAttribute('aria-expanded', !isExpanded);
            
            // Toggle menu visibility
            if (isExpanded) {
                navContainer.classList.remove('is-open');
            } else {
                navContainer.classList.add('is-open');
            }
        }

        // Close menu function
        function closeMenu() {
            menuToggle.setAttribute('aria-expanded', 'false');
            navContainer.classList.remove('is-open');
        }

        // Menu toggle click handler
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMenu();
        });

        // Close menu on resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeMenu();
            }
        });

        // Close menu when clicking outside (optional)
        document.addEventListener('click', function(e) {
            const isMenuOpen = navContainer.classList.contains('is-open');
            const isClickInsideMenu = navContainer.contains(e.target);
            const isClickOnToggle = menuToggle.contains(e.target);
            
            if (isMenuOpen && !isClickInsideMenu && !isClickOnToggle) {
                closeMenu();
            }
        });

        // Close menu when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navContainer.classList.contains('is-open')) {
                closeMenu();
                menuToggle.focus(); // Return focus to toggle button
            }
        });
    }

    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize mobile menu
        initMobileMenu();
        
        // Theme utilities available globally
        window.AuraTheme = {
            version: '1.0.0',
            
            // Mobile menu methods
            openMenu: function() {
                const menuToggle = document.querySelector('.aura-header__toggle');
                const navContainer = document.querySelector('.aura-header__nav-container');
                
                if (menuToggle && navContainer) {
                    menuToggle.setAttribute('aria-expanded', 'true');
                    navContainer.classList.add('is-open');
                }
            },
            
            closeMenu: function() {
                const menuToggle = document.querySelector('.aura-header__toggle');
                const navContainer = document.querySelector('.aura-header__nav-container');
                
                if (menuToggle && navContainer) {
                    menuToggle.setAttribute('aria-expanded', 'false');
                    navContainer.classList.remove('is-open');
                }
            },
            
            // Initialize theme
            init: function() {
                console.log('AuraTheme v' + this.version + ' initialized');
            }
        };
        
        // Initialize theme
        window.AuraTheme.init();
    });

})();