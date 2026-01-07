/**
 * Afrisol Pages JavaScript
 */

(function($) {
    'use strict';
    
    /**
     * Quote Form Multi-step
     */
    Afrisol.initQuoteForm = function() {
        var currentStep = 1;
        var totalSteps = 5;
        
        // Option selection
        $(document).on('click', '.afrisol-quote-option', function() {
            var container = $(this).closest('.afrisol-quote-options');
            container.find('.afrisol-quote-option').removeClass('selected');
            $(this).addClass('selected');
            
            var value = $(this).data('value');
            var input = $(this).closest('.afrisol-quote-step-content').find('input[type="hidden"]');
            input.val(value);
        });
        
        // Next button
        $('#quote-next').on('click', function() {
            if (currentStep < totalSteps) {
                // Validate current step
                if (!Afrisol.validateQuoteStep(currentStep)) {
                    return;
                }
                
                currentStep++;
                Afrisol.showQuoteStep(currentStep);
            }
        });
        
        // Previous button
        $('#quote-prev').on('click', function() {
            if (currentStep > 1) {
                currentStep--;
                Afrisol.showQuoteStep(currentStep);
            }
        });
        
        // Submit
        $('#quote-form').on('submit', function(e) {
            e.preventDefault();
            Afrisol.submitQuoteForm($(this));
        });
    };
    
    Afrisol.validateQuoteStep = function(step) {
        var stepContent = $('[data-step="' + step + '"].afrisol-quote-step-content');
        
        if (step === 1) {
            if (!$('#service_type').val()) {
                Afrisol.showToast('Please select a service type', 'warning');
                return false;
            }
        }
        
        if (step === 2) {
            if (!$('#category').val()) {
                Afrisol.showToast('Please select a category', 'warning');
                return false;
            }
        }
        
        return true;
    };
    
    Afrisol.showQuoteStep = function(step) {
        // Update step indicators
        $('.afrisol-step').each(function() {
            var stepNum = $(this).data('step');
            $(this).removeClass('active completed');
            if (stepNum < step) {
                $(this).addClass('completed');
            } else if (stepNum === step) {
                $(this).addClass('active');
            }
        });
        
        // Show step content
        $('.afrisol-quote-step-content').removeClass('active');
        $('[data-step="' + step + '"].afrisol-quote-step-content').addClass('active');
        
        // Update buttons
        if (step === 1) {
            $('#quote-prev').hide();
            $('#quote-next').show();
            $('#quote-submit').hide();
        } else if (step === 5) {
            $('#quote-prev').show();
            $('#quote-next').hide();
            $('#quote-submit').show();
            Afrisol.updateQuoteSummary();
        } else {
            $('#quote-prev').show();
            $('#quote-next').show();
            $('#quote-submit').hide();
        }
        
        // Scroll to top of form
        $('html, body').animate({
            scrollTop: $('#quote-form').offset().top - 100
        }, 300);
    };
    
    Afrisol.updateQuoteSummary = function() {
        var summary = '<div class="afrisol-mb-3">';
        summary += '<strong>Service Type:</strong> ' + ($('#service_type').val() || 'Not selected').replace(/_/g, ' ') + '<br>';
        summary += '<strong>Category:</strong> ' + ($('#category').val() || 'Not selected').replace(/_/g, ' ') + '<br>';
        summary += '<strong>Location:</strong> ' + ($('#quote-location').val() || 'Not specified') + '<br>';
        summary += '<strong>Property Type:</strong> ' + ($('#quote-property').val() || 'Not specified') + '<br>';
        summary += '<strong>Budget:</strong> ' + ($('#quote-budget').val() || 'Not specified').replace(/_/g, ' ') + '<br>';
        summary += '</div>';
        
        summary += '<div>';
        summary += '<strong>Contact:</strong><br>';
        summary += 'Name: ' + $('#quote-name').val() + '<br>';
        summary += 'Email: ' + $('#quote-email').val() + '<br>';
        summary += 'Phone: ' + $('#quote-phone').val() + '<br>';
        summary += '</div>';
        
        $('#quote-summary').html(summary);
    };
    
    Afrisol.submitQuoteForm = function(form) {
        var btn = form.find('#quote-submit');
        var originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
        
        var formData = new FormData(form[0]);
        formData.append('action', 'afrisol_submit_quote');
        formData.append('nonce', afrisol_vars.nonce);
        
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Afrisol.showToast(response.data.message, 'success');
                    if (response.data.redirect) {
                        window.location.href = response.data.redirect;
                    }
                } else {
                    Afrisol.showToast(response.data.message, 'error');
                    btn.prop('disabled', false).html(originalText);
                }
            },
            error: function() {
                Afrisol.showToast('An error occurred. Please try again.', 'error');
                btn.prop('disabled', false).html(originalText);
            }
        });
    };
    
    /**
     * Solar Calculator
     */
    Afrisol.initCalculator = function() {
        // Add appliance row
        $('#add-appliance').on('click', function() {
            var row = '<div class="afrisol-appliance-row">' +
                '<select name="appliance[]">' +
                    '<option value="">Select appliance</option>' +
                    '<option value="ac_1hp" data-watts="1000">AC (1 HP)</option>' +
                    '<option value="ac_2hp" data-watts="2000">AC (2 HP)</option>' +
                    '<option value="fridge" data-watts="150">Refrigerator</option>' +
                    '<option value="freezer" data-watts="200">Freezer</option>' +
                    '<option value="tv" data-watts="100">TV</option>' +
                    '<option value="fan" data-watts="75">Fan</option>' +
                    '<option value="lights" data-watts="50">Lights (5 bulbs)</option>' +
                    '<option value="pump" data-watts="750">Water Pump</option>' +
                    '<option value="washer" data-watts="500">Washing Machine</option>' +
                '</select>' +
                '<input type="number" name="quantity[]" placeholder="Qty" min="1" value="1" style="width: 80px;">' +
                '<input type="number" name="hours[]" placeholder="Hrs/day" min="1" max="24" value="4" style="width: 100px;">' +
                '<button type="button" class="afrisol-remove-appliance"><i class="fas fa-times"></i></button>' +
            '</div>';
            
            $('#appliances-list').append(row);
        });
        
        // Remove appliance row
        $(document).on('click', '.afrisol-remove-appliance', function() {
            $(this).closest('.afrisol-appliance-row').remove();
        });
        
        // Calculate
        $('#solar-calculator-form').on('submit', function(e) {
            e.preventDefault();
            Afrisol.calculateSolar($(this));
        });
    };
    
    Afrisol.calculateSolar = function(form) {
        var btn = form.find('button[type="submit"]');
        var originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Calculating...');
        
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: form.serialize() + '&action=afrisol_calculate_solar&nonce=' + afrisol_vars.nonce,
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    
                    $('#result-system').html(data.system_size + ' <small>kVA</small>');
                    $('#result-cost').html(Afrisol.formatCurrency(data.estimated_cost));
                    $('#result-savings').html(Afrisol.formatCurrency(data.monthly_savings) + ' <small>/month</small>');
                    $('#result-roi').html(data.roi_months + ' <small>months</small>');
                    $('#result-co2').html(data.co2_saved + ' <small>kg</small>');
                    
                    $('#get-proposal-btn').show();
                    
                    Afrisol.showToast('Calculation complete!', 'success');
                } else {
                    Afrisol.showToast(response.data.message || 'Calculation failed', 'error');
                }
            },
            error: function() {
                Afrisol.showToast('An error occurred', 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    };
    
    /**
     * Repair Form
     */
    Afrisol.initRepairForm = function() {
        $('#repair-form').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var btn = form.find('button[type="submit"]');
            var originalText = btn.html();
            
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
            
            var formData = new FormData(form[0]);
            formData.append('action', 'afrisol_submit_repair');
            formData.append('nonce', afrisol_vars.nonce);
            
            $.ajax({
                url: afrisol_vars.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Afrisol.showToast('Repair request submitted! Ticket: ' + response.data.ticket, 'success');
                        form[0].reset();
                    } else {
                        Afrisol.showToast(response.data.message, 'error');
                    }
                },
                error: function() {
                    Afrisol.showToast('An error occurred', 'error');
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });
    };
    
    /**
     * Checkout
     */
    Afrisol.initCheckout = function() {
        // Toggle installation date
        $('input[name="installation"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('#installation-date-section').slideDown();
            } else {
                $('#installation-date-section').slideUp();
            }
        });
        
        // Toggle delivery address
        $('input[name="delivery_method"]').on('change', function() {
            if ($(this).val() === 'pickup') {
                $('#delivery-address-section').slideUp();
            } else {
                $('#delivery-address-section').slideDown();
            }
        });
        
        // Checkout form submission
        $('#checkout-form').on('submit', function(e) {
            e.preventDefault();
            Afrisol.processCheckout($(this));
        });
    };
    
    Afrisol.processCheckout = function(form) {
        var btn = form.find('#pay-btn');
        var originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: form.serialize() + '&action=afrisol_process_checkout&nonce=' + afrisol_vars.nonce,
            success: function(response) {
                if (response.success) {
                    // Initialize Paystack
                    var handler = PaystackPop.setup({
                        key: response.data.paystack_key || afrisol_vars.paystack_public_key,
                        email: response.data.email,
                        amount: response.data.total * 100,
                        currency: 'NGN',
                        ref: response.data.order_number,
                        onClose: function() {
                            btn.prop('disabled', false).html(originalText);
                            Afrisol.showToast('Payment cancelled', 'warning');
                        },
                        callback: function(paymentResponse) {
                            Afrisol.verifyPayment(paymentResponse.reference, response.data.order_id);
                        }
                    });
                    
                    handler.openIframe();
                } else {
                    Afrisol.showToast(response.data.message, 'error');
                    btn.prop('disabled', false).html(originalText);
                }
            },
            error: function() {
                Afrisol.showToast('An error occurred', 'error');
                btn.prop('disabled', false).html(originalText);
            }
        });
    };
    
    Afrisol.verifyPayment = function(reference, orderId) {
        $.ajax({
            url: afrisol_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'afrisol_verify_payment',
                nonce: afrisol_vars.nonce,
                reference: reference,
                order_id: orderId
            },
            success: function(response) {
                if (response.success) {
                    Afrisol.showToast('Payment successful!', 'success');
                    window.location.href = afrisol_vars.portal_url + '?tab=orders';
                } else {
                    Afrisol.showToast(response.data.message, 'error');
                }
            }
        });
    };
    
    /**
     * File Upload Zones
     */
    Afrisol.initFileUploads = function() {
        $(document).on('click', '.afrisol-image-upload-zone', function() {
            $(this).find('input[type="file"]').click();
        });
        
        $(document).on('change', '.afrisol-image-upload-zone input[type="file"]', function() {
            var files = this.files;
            var preview = $(this).closest('.afrisol-form-group, .afrisol-admin-card').find('.afrisol-image-preview');
            
            preview.empty();
            
            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.append('<img src="' + e.target.result + '" style="max-width: 150px; margin: 5px; border-radius: 8px;">');
                };
                reader.readAsDataURL(files[i]);
            }
        });
    };
    
    /**
     * Admin Settings Form
     */
    Afrisol.initAdminSettings = function() {
        $('#admin-settings-form').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var btn = form.find('button[type="submit"]');
            var originalText = btn.html();
            
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
            
            var formData = new FormData(form[0]);
            formData.append('action', 'afrisol_save_settings');
            formData.append('nonce', afrisol_admin_vars ? afrisol_admin_vars.nonce : afrisol_vars.nonce);
            
            $.ajax({
                url: afrisol_vars.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Afrisol.showToast(response.data.message, 'success');
                    } else {
                        Afrisol.showToast(response.data.message, 'error');
                    }
                },
                error: function() {
                    Afrisol.showToast('An error occurred', 'error');
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });
    };
    
    // Initialize on document ready
    $(document).ready(function() {
        if ($('#quote-form').length) {
            Afrisol.initQuoteForm();
        }
        
        if ($('#solar-calculator-form').length) {
            Afrisol.initCalculator();
        }
        
        if ($('#repair-form').length) {
            Afrisol.initRepairForm();
        }
        
        if ($('#checkout-form').length) {
            Afrisol.initCheckout();
        }
        
        if ($('#admin-settings-form').length) {
            Afrisol.initAdminSettings();
        }
        
        Afrisol.initFileUploads();
    });
    
})(jQuery);
