/**
 * Afrisol Admin JavaScript
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Image upload
        $('.afrisol-upload-btn').on('click', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var targetInput = button.data('target');
            var preview = button.siblings('.afrisol-image-preview');
            
            var frame = wp.media({
                title: 'Select or Upload Image',
                button: { text: 'Use this image' },
                multiple: false
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('input[name="' + targetInput + '"]').val(attachment.url);
                preview.html('<img src="' + attachment.url + '" style="max-width: 200px;">');
            });
            
            frame.open();
        });
        
        // Settings form
        $('#afrisol-settings-form').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var btn = form.find('button[type="submit"]');
            var originalText = btn.html();
            
            btn.prop('disabled', true).html('Saving...');
            
            $.ajax({
                url: afrisol_admin_vars.ajax_url,
                type: 'POST',
                data: form.serialize() + '&action=afrisol_save_settings&nonce=' + afrisol_admin_vars.nonce,
                success: function(response) {
                    if (response.success) {
                        alert('Settings saved successfully!');
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                },
                error: function() {
                    alert('An error occurred');
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });
        
        // Order status update
        $('.afrisol-status-select').on('change', function() {
            var select = $(this);
            var orderId = select.data('order-id');
            var status = select.val();
            
            $.ajax({
                url: afrisol_admin_vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'afrisol_update_order_status',
                    nonce: afrisol_admin_vars.nonce,
                    order_id: orderId,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        select.closest('tr').find('.status-badge')
                            .removeClass()
                            .addClass('status-badge status-' + status)
                            .text(status.replace('_', ' '));
                    }
                }
            });
        });
        
        // Product meta boxes
        if ($('#afrisol-product-data').length) {
            // Gallery upload
            $('#afrisol-add-gallery-images').on('click', function(e) {
                e.preventDefault();
                
                var frame = wp.media({
                    title: 'Add Gallery Images',
                    button: { text: 'Add to gallery' },
                    multiple: true
                });
                
                frame.on('select', function() {
                    var attachments = frame.state().get('selection').toJSON();
                    var container = $('#afrisol-gallery-images');
                    
                    attachments.forEach(function(attachment) {
                        container.append(
                            '<div class="afrisol-gallery-item" data-id="' + attachment.id + '">' +
                                '<img src="' + attachment.url + '">' +
                                '<button type="button" class="afrisol-remove-gallery-image">&times;</button>' +
                                '<input type="hidden" name="afrisol_gallery[]" value="' + attachment.id + '">' +
                            '</div>'
                        );
                    });
                });
                
                frame.open();
            });
            
            $(document).on('click', '.afrisol-remove-gallery-image', function() {
                $(this).closest('.afrisol-gallery-item').remove();
            });
        }
        
        // Dashboard stats
        if ($('.afrisol-dashboard-stats').length) {
            $.ajax({
                url: afrisol_admin_vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'afrisol_get_dashboard_stats',
                    nonce: afrisol_admin_vars.nonce
                },
                success: function(response) {
                    if (response.success) {
                        var data = response.data;
                        $('#stat-orders').text(data.orders);
                        $('#stat-products').text(data.products);
                        $('#stat-quotes').text(data.quotes);
                        $('#stat-revenue').text('₦' + Number(data.revenue).toLocaleString());
                    }
                }
            });
        }
    });
    
})(jQuery);
