/**
 * Aura Elementor Starter - Main JavaScript
 * @package AuraElementorStarter
 */

(function($) {
    'use strict';

    /**
     * Mobile Navigation Toggle
     */
    function initMobileNavigation() {
        const menuToggle = $('.menu-toggle');
        const navigation = $('.main-navigation');
        
        menuToggle.on('click', function() {
            navigation.toggleClass('toggled');
            
            // Update aria-expanded attribute for accessibility
            const isExpanded = navigation.hasClass('toggled');
            $(this).attr('aria-expanded', isExpanded);
        });
        
        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .menu-toggle').length) {
                navigation.removeClass('toggled');
                menuToggle.attr('aria-expanded', 'false');
            }
        });
        
        // Close mobile menu on escape key
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27) { // Escape key
                navigation.removeClass('toggled');
                menuToggle.attr('aria-expanded', 'false');
            }
        });
    }

    /**
     * Smooth Scrolling for Anchor Links
     */
    function initSmoothScrolling() {
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                
                const target = $(this.hash);
                const targetElement = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (targetElement.length) {
                    $('html, body').animate({
                        scrollTop: targetElement.offset().top - 100
                    }, 800);
                    return false;
                }
            }
        });
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        // Create back to top button
        if (!$('#back-to-top').length) {
            $('body').append('<button id="back-to-top" aria-label="Back to top"><span>↑</span></button>');
        }
        
        const backToTopButton = $('#back-to-top');
        
        // Show/hide button based on scroll position
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                backToTopButton.addClass('visible');
            } else {
                backToTopButton.removeClass('visible');
            }
        });
        
        // Smooth scroll to top
        backToTopButton.on('click', function() {
            $('html, body').animate({
                scrollTop: 0
            }, 600);
        });
    }

    /**
     * Comments Form Enhancement
     */
    function initCommentsForm() {
        const commentForm = $('#commentform');
        
        if (commentForm.length) {
            // Add focus styles to form inputs
            commentForm.find('input, textarea').on('focus', function() {
                $(this).parent().addClass('focused');
            }).on('blur', function() {
                $(this).parent().removeClass('focused');
            });
            
            // Form validation feedback
            commentForm.on('submit', function(e) {
                const requiredFields = $(this).find('[required]');
                let isValid = true;
                
                requiredFields.each(function() {
                    if (!$(this).val().trim()) {
                        $(this).addClass('error');
                        isValid = false;
                    } else {
                        $(this).removeClass('error');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                }
            });
        }
    }

    /**
     * Search Form Enhancement
     */
    function initSearchForm() {
        const searchForm = $('.search-form');
        const searchInput = searchForm.find('input[type="search"]');
        
        if (searchInput.length) {
            // Add placeholder if not set
            if (!searchInput.attr('placeholder')) {
                searchInput.attr('placeholder', 'Search...');
            }
            
            // Clear button functionality
            searchInput.on('input', function() {
                const clearBtn = $(this).siblings('.search-clear');
                if ($(this).val()) {
                    if (!clearBtn.length) {
                        $(this).after('<button type="button" class="search-clear" aria-label="Clear search">×</button>');
                    }
                } else {
                    clearBtn.remove();
                }
            });
            
            // Handle clear button click
            searchForm.on('click', '.search-clear', function() {
                searchInput.val('').focus();
                $(this).remove();
            });
        }
    }

    /**
     * Lazy Loading for Images (if not natively supported)
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Accessibility Enhancements
     */
    function initAccessibility() {
        // Skip link functionality
        $('.skip-link').on('click', function(e) {
            const target = $($(this).attr('href'));
            if (target.length) {
                target.attr('tabindex', '-1').focus();
            }
        });
        
        // Keyboard navigation for mobile menu
        $('.main-navigation a').on('keydown', function(e) {
            if (e.keyCode === 13) { // Enter key
                $(this).click();
            }
        });
    }

    /**
     * Elementor Compatibility
     */
    function initElementorCompatibility() {
        // Re-initialize scripts when Elementor loads new content
        $(window).on('elementor/frontend/init', function() {
            initMobileNavigation();
            initSmoothScrolling();
        });
        
        // Handle Elementor popup triggers
        $(document).on('click', '[data-elementor-open-lightbox]', function(e) {
            // Custom lightbox handling if needed
        });
    }

    /**
     * Performance Optimizations
     */
    function initPerformanceOptimizations() {
        // Throttle resize events
        let resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                // Handle resize-specific tasks
                if (window.innerWidth > 768) {
                    $('.main-navigation').removeClass('toggled');
                }
            }, 250);
        });
        
        // Debounce scroll events
        let scrollTimer;
        $(window).on('scroll', function() {
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(function() {
                // Handle scroll-specific tasks
            }, 100);
        });
    }

    /**
     * Initialize all functions when document is ready
     */
    $(document).ready(function() {
        initMobileNavigation();
        initSmoothScrolling();
        initBackToTop();
        initCommentsForm();
        initSearchForm();
        initLazyLoading();
        initAccessibility();
        initElementorCompatibility();
        initPerformanceOptimizations();
        
        // Trigger custom event for other scripts
        $(document).trigger('auraThemeReady');
    });

})(jQuery);