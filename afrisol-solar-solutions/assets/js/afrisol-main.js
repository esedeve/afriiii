/**
 * Afrisol Main JavaScript
 */

(function($) {
    'use strict';
    
    // Global Afrisol object
    window.Afrisol = window.Afrisol || {};
    
    /**
     * Initialize Afrisol
     */
    Afrisol.init = function() {
        Afrisol.initHeader();
        Afrisol.initMobileNav();
        Afrisol.initScrollTop();
        Afrisol.initFadeIn();
        Afrisol.initToasts();
        Afrisol.initPasswordToggle();
        Afrisol.initForms();
        Afrisol.initLazyLoad();
    };
    
    /**
     * Header functionality
     */
    Afrisol.initHeader = function() {
        var header = $('.afrisol-header');
        var lastScroll = 0;
        
        $(window).on('scroll', function() {
            var currentScroll = $(this).scrollTop();
            
            // Add scrolled class
            if (currentScroll > 50) {
                header.addClass('scrolled');
            } else {
                header.removeClass('scrolled');
            }
            
            lastScroll = currentScroll;
        });
    };
    
    /**
     * Mobile navigation
     */
    Afrisol.initMobileNav = function() {
        var mobileToggle = $('.afrisol-mobile-toggle');
        var mobileNav = $('.afrisol-mobile-nav');
        var overlay = $('.afrisol-overlay');
        var mobileClose = $('.afrisol-mobile-close');
        
        function openNav() {
            mobileNav.addClass('active');
            overlay.addClass('active');
            $('body').css('overflow', 'hidden');
        }
        
        function closeNav() {
            mobileNav.removeClass('active');
            overlay.removeClass('active');
            $('body').css('overflow', '');
        }
        
        mobileToggle.on('click', openNav);
        mobileClose.on('click', closeNav);
        overlay.on('click', closeNav);
        
        // Close on link click
        mobileNav.find('a').on('click', closeNav);
        
        // Close on escape
        $(document).on('keyup', function(e) {
            if (e.key === 'Escape') {
                closeNav();
            }
        });
    };
    
    /**
     * Scroll to top with progress
     */
    Afrisol.initScrollTop = function() {
        var scrollTop = $('#afrisol-scroll-top');
        var progressBar = scrollTop.find('.afrisol-scroll-progress-bar');
        
        $(window).on('scroll', function() {
            var scrollPercent = ($(this).scrollTop() / ($(document).height() - $(window).height())) * 100;
            var dashOffset = 289 - (289 * scrollPercent / 100);
            
            progressBar.css('stroke-dashoffset', dashOffset);
            
            if ($(this).scrollTop() > 300) {
                scrollTop.addClass('visible');
            } else {
                scrollTop.removeClass('visible');
            }
        });
        
        scrollTop.on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 500);
        });
    };
    
    /**
     * Fade in on scroll
     */
    Afrisol.initFadeIn = function() {
        var elements = $('.afrisol-fade-in');
        
        function checkFade() {
            var windowBottom = $(window).scrollTop() + $(window).height();
            
            elements.each(function() {
                var elementTop = $(this).offset().top;
                
                if (windowBottom > elementTop + 50) {
                    $(this).addClass('visible');
                }
            });
        }
        
        $(window).on('scroll', checkFade);
        checkFade();
    };
    
    /**
     * Toast notifications
     */
    Afrisol.initToasts = function() {
        // Create toast container if it doesn't exist
        if (!$('.afrisol-toast-container').length) {
            $('body').append('<div class="afrisol-toast-container"></div>');
        }
    };
    
    Afrisol.showToast = function(message, type) {
        type = type || 'info';
        
        var icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };
        
        var toast = $('<div class="afrisol-toast ' + type + '">' +
            '<i class="afrisol-toast-icon ' + icons[type] + '"></i>' +
            '<span class="afrisol-toast-message">' + message + '</span>' +
            '<button class="afrisol-toast-close"><i class="fas fa-times"></i></button>' +
            '</div>');
        
        $('.afrisol-toast-container').append(toast);
        
        toast.find('.afrisol-toast-close').on('click', function() {
            toast.fadeOut(300, function() { $(this).remove(); });
        });
        
        // Auto remove after 5 seconds
        setTimeout(function() {
            toast.fadeOut(300, function() { $(this).remove(); });
        }, 5000);
    };
    
    /**
     * Password visibility toggle
     */
    Afrisol.initPasswordToggle = function() {
        $(document).on('click', '.afrisol-password-toggle', function() {
            var input = $(this).siblings('input');
            var icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    };
    
    /**
     * Form handling
     */
    Afrisol.initForms = function() {
        // Contact form
        $(document).on('submit', '.afrisol-contact-form', function(e) {
            e.preventDefault();
            Afrisol.submitContactForm($(this));
        });
        
        // Login form
        $(document).on('submit', '.afrisol-login-form', function(e) {
            e.preventDefault();
            Afrisol.submitLoginForm($(this));
        });
        
        // Register form
        $(document).on('submit', '.afrisol-register-form', function(e) {
            e.preventDefault();
            Afrisol.submitRegisterForm($(this));
        });
    };
    
    Afrisol.submitContactForm = function(form) {
        var btn = form.find('button[type="submit"]');
        var originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
        
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'afrisol_submit_contact',
                nonce: afrisol_vars.nonce,
                name: form.find('[name="name"]').val(),
                email: form.find('[name="email"]').val(),
                phone: form.find('[name="phone"]').val(),
                subject: form.find('[name="subject"]').val(),
                message: form.find('[name="message"]').val(),
                type: form.find('[name="type"]').val() || 'contact'
            },
            success: function(response) {
                if (response.success) {
                    Afrisol.showToast(response.data.message, 'success');
                    form[0].reset();
                } else {
                    Afrisol.showToast(response.data.message, 'error');
                }
            },
            error: function() {
                Afrisol.showToast(afrisol_vars.strings.error, 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    };
    
    Afrisol.submitLoginForm = function(form) {
        var btn = form.find('button[type="submit"]');
        var originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Logging in...');
        
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'afrisol_login',
                nonce: afrisol_vars.nonce,
                username: form.find('[name="username"]').val(),
                password: form.find('[name="password"]').val(),
                remember: form.find('[name="remember"]').is(':checked') ? 'true' : 'false'
            },
            success: function(response) {
                if (response.success) {
                    Afrisol.showToast(response.data.message, 'success');
                    window.location.href = response.data.redirect;
                } else {
                    Afrisol.showToast(response.data.message, 'error');
                    btn.prop('disabled', false).html(originalText);
                }
            },
            error: function() {
                Afrisol.showToast(afrisol_vars.strings.error, 'error');
                btn.prop('disabled', false).html(originalText);
            }
        });
    };
    
    Afrisol.submitRegisterForm = function(form) {
        var btn = form.find('button[type="submit"]');
        var originalText = btn.html();
        
        // Validate password match
        var password = form.find('[name="password"]').val();
        var confirmPassword = form.find('[name="password_confirm"]').val();
        
        if (password !== confirmPassword) {
            Afrisol.showToast('Passwords do not match', 'error');
            return;
        }
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Creating account...');
        
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'afrisol_register',
                nonce: afrisol_vars.nonce,
                first_name: form.find('[name="first_name"]').val(),
                last_name: form.find('[name="last_name"]').val(),
                username: form.find('[name="username"]').val(),
                email: form.find('[name="email"]').val(),
                phone: form.find('[name="phone"]').val(),
                password: password,
                referral: form.find('[name="referral"]').val()
            },
            success: function(response) {
                if (response.success) {
                    Afrisol.showToast(response.data.message, 'success');
                    window.location.href = response.data.redirect;
                } else {
                    Afrisol.showToast(response.data.message, 'error');
                    btn.prop('disabled', false).html(originalText);
                }
            },
            error: function() {
                Afrisol.showToast(afrisol_vars.strings.error, 'error');
                btn.prop('disabled', false).html(originalText);
            }
        });
    };
    
    /**
     * Lazy loading images
     */
    Afrisol.initLazyLoad = function() {
        if ('IntersectionObserver' in window) {
            var lazyImages = document.querySelectorAll('img[data-src]');
            
            var imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var image = entry.target;
                        image.src = image.dataset.src;
                        image.removeAttribute('data-src');
                        imageObserver.unobserve(image);
                    }
                });
            });
            
            lazyImages.forEach(function(image) {
                imageObserver.observe(image);
            });
        }
    };
    
    /**
     * Format currency
     */
    Afrisol.formatCurrency = function(amount) {
        return afrisol_vars.currency_symbol + Number(amount).toLocaleString();
    };
    
    /**
     * AJAX helper
     */
    Afrisol.ajax = function(action, data, callback) {
        data = data || {};
        data.action = action;
        data.nonce = afrisol_vars.nonce;
        
        return $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: data,
            success: callback
        });
    };
    
    // Initialize on document ready
    $(document).ready(function() {
        Afrisol.init();
    });
    
})(jQuery);
