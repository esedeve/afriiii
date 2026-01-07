<?php
/**
 * Customer Portal Template
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
$currency_symbol = isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '₦';

if (!is_user_logged_in()) {
    wp_redirect(home_url('/afrisol-login/'));
    exit;
}

$user = wp_get_current_user();
$tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'dashboard';
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container">
            <div class="afrisol-portal-layout">
                <!-- Sidebar -->
                <aside class="afrisol-portal-sidebar afrisol-fade-in">
                    <div class="afrisol-card afrisol-text-center afrisol-mb-3">
                        <div class="afrisol-card-body">
                            <div class="afrisol-testimonial-avatar" style="width: 80px; height: 80px; font-size: 2rem; margin: 0 auto 15px;">
                                <?php echo esc_html(strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1))); ?>
                            </div>
                            <h4 style="margin-bottom: 5px;"><?php echo esc_html($user->display_name); ?></h4>
                            <p class="afrisol-text-muted" style="font-size: 0.875rem;"><?php echo esc_html($user->user_email); ?></p>
                        </div>
                    </div>
                    
                    <nav class="afrisol-portal-menu">
                        <a href="?tab=dashboard" <?php echo $tab === 'dashboard' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <a href="?tab=orders" <?php echo $tab === 'orders' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-shopping-bag"></i> My Orders
                        </a>
                        <a href="?tab=wishlist" <?php echo $tab === 'wishlist' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-heart"></i> Wishlist
                        </a>
                        <a href="?tab=warranties" <?php echo $tab === 'warranties' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-shield-alt"></i> Warranties
                        </a>
                        <a href="?tab=repairs" <?php echo $tab === 'repairs' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-tools"></i> Repair Tickets
                        </a>
                        <a href="?tab=quotes" <?php echo $tab === 'quotes' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-file-alt"></i> Quote Requests
                        </a>
                        <a href="?tab=loyalty" <?php echo $tab === 'loyalty' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-gift"></i> Loyalty Points
                        </a>
                        <a href="?tab=referrals" <?php echo $tab === 'referrals' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-users"></i> Referrals
                        </a>
                        <a href="?tab=profile" <?php echo $tab === 'profile' ? 'class="active"' : ''; ?>>
                            <i class="fas fa-user-edit"></i> Edit Profile
                        </a>
                        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </nav>
                </aside>
                
                <!-- Content -->
                <div class="afrisol-portal-content afrisol-fade-in">
                    <?php if ($tab === 'dashboard'): ?>
                        <div class="afrisol-portal-header">
                            <h1>Welcome back, <?php echo esc_html($user->first_name ?: $user->display_name); ?>!</h1>
                        </div>
                        
                        <div class="afrisol-dashboard-stats">
                            <div class="afrisol-stat-card">
                                <div class="afrisol-stat-icon"><i class="fas fa-shopping-bag"></i></div>
                                <div class="afrisol-stat-content">
                                    <h3>0</h3>
                                    <p>Total Orders</p>
                                </div>
                            </div>
                            <div class="afrisol-stat-card">
                                <div class="afrisol-stat-icon"><i class="fas fa-heart"></i></div>
                                <div class="afrisol-stat-content">
                                    <h3>0</h3>
                                    <p>Wishlist Items</p>
                                </div>
                            </div>
                            <div class="afrisol-stat-card">
                                <div class="afrisol-stat-icon"><i class="fas fa-star"></i></div>
                                <div class="afrisol-stat-content">
                                    <h3>0</h3>
                                    <p>Loyalty Points</p>
                                </div>
                            </div>
                            <div class="afrisol-stat-card">
                                <div class="afrisol-stat-icon"><i class="fas fa-users"></i></div>
                                <div class="afrisol-stat-content">
                                    <h3>0</h3>
                                    <p>Referrals</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="afrisol-grid afrisol-grid-2 afrisol-mt-4">
                            <div class="afrisol-card">
                                <div class="afrisol-card-header"><h4>Recent Orders</h4></div>
                                <div class="afrisol-card-body">
                                    <p class="afrisol-text-muted">No orders yet.</p>
                                    <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>" class="afrisol-btn afrisol-btn-primary afrisol-btn-sm">
                                        <i class="fas fa-shopping-cart"></i> Shop Now
                                    </a>
                                </div>
                            </div>
                            <div class="afrisol-card">
                                <div class="afrisol-card-header"><h4>Active Installations</h4></div>
                                <div class="afrisol-card-body">
                                    <p class="afrisol-text-muted">No scheduled installations.</p>
                                    <a href="<?php echo esc_url(home_url('/afrisol-quote/')); ?>" class="afrisol-btn afrisol-btn-primary afrisol-btn-sm">
                                        <i class="fas fa-calendar"></i> Schedule Installation
                                    </a>
                                </div>
                            </div>
                        </div>
                    
                    <?php elseif ($tab === 'orders'): ?>
                        <div class="afrisol-portal-header"><h1>My Orders</h1></div>
                        <div class="afrisol-card">
                            <div class="afrisol-card-body">
                                <div class="afrisol-empty-state">
                                    <i class="fas fa-shopping-bag"></i>
                                    <h3>No Orders Yet</h3>
                                    <p>Start shopping to see your orders here.</p>
                                    <a href="<?php echo esc_url(home_url('/afrisol-products/')); ?>" class="afrisol-btn afrisol-btn-primary">
                                        Browse Products
                                    </a>
                                </div>
                            </div>
                        </div>
                    
                    <?php elseif ($tab === 'wishlist'): ?>
                        <div class="afrisol-portal-header"><h1>My Wishlist</h1></div>
                        <div id="wishlist-container">
                            <p class="afrisol-text-muted">Loading wishlist...</p>
                        </div>
                    
                    <?php elseif ($tab === 'profile'): ?>
                        <div class="afrisol-portal-header"><h1>Edit Profile</h1></div>
                        <form class="afrisol-form" id="profile-form">
                            <div class="afrisol-form-row">
                                <div class="afrisol-form-group">
                                    <label for="profile-first-name"><i class="fas fa-user"></i> First Name</label>
                                    <input type="text" id="profile-first-name" name="first_name" value="<?php echo esc_attr($user->first_name); ?>">
                                </div>
                                <div class="afrisol-form-group">
                                    <label for="profile-last-name"><i class="fas fa-user"></i> Last Name</label>
                                    <input type="text" id="profile-last-name" name="last_name" value="<?php echo esc_attr($user->last_name); ?>">
                                </div>
                            </div>
                            <div class="afrisol-form-row">
                                <div class="afrisol-form-group">
                                    <label for="profile-email"><i class="fas fa-envelope"></i> Email</label>
                                    <input type="email" id="profile-email" name="email" value="<?php echo esc_attr($user->user_email); ?>">
                                </div>
                                <div class="afrisol-form-group">
                                    <label for="profile-phone"><i class="fas fa-phone"></i> Phone</label>
                                    <input type="tel" id="profile-phone" name="phone" value="<?php echo esc_attr(get_user_meta($user->ID, 'afrisol_phone', true)); ?>">
                                </div>
                            </div>
                            <div class="afrisol-form-group">
                                <label for="profile-address"><i class="fas fa-map-marker-alt"></i> Address</label>
                                <textarea id="profile-address" name="address" rows="2"><?php echo esc_textarea(get_user_meta($user->ID, 'afrisol_address', true)); ?></textarea>
                            </div>
                            <button type="submit" class="afrisol-btn afrisol-btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </form>
                    
                    <?php elseif ($tab === 'loyalty'): ?>
                        <div class="afrisol-portal-header"><h1>Loyalty Points</h1></div>
                        <div class="afrisol-card afrisol-mb-4">
                            <div class="afrisol-card-body afrisol-text-center">
                                <h2 style="font-size: 3rem; color: var(--afrisol-primary);">0</h2>
                                <p>Available Points</p>
                            </div>
                        </div>
                        <p class="afrisol-text-muted">Earn points on every purchase. 1 point = ₦1 discount on future orders.</p>
                    
                    <?php elseif ($tab === 'referrals'): ?>
                        <div class="afrisol-portal-header"><h1>Referral Program</h1></div>
                        <div class="afrisol-card afrisol-mb-4">
                            <div class="afrisol-card-body">
                                <h4>Your Referral Code</h4>
                                <div class="afrisol-flex afrisol-gap-md afrisol-mt-2">
                                    <input type="text" value="<?php echo esc_attr($user->user_login); ?>" readonly style="flex: 1;">
                                    <button class="afrisol-btn afrisol-btn-primary" onclick="navigator.clipboard.writeText('<?php echo esc_attr($user->user_login); ?>'); Afrisol.showToast('Copied!', 'success');">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                                <p class="afrisol-form-hint">Share this code with friends. Earn 500 points when they make their first purchase!</p>
                            </div>
                        </div>
                    
                    <?php else: ?>
                        <div class="afrisol-portal-header"><h1><?php echo esc_html(ucwords(str_replace('_', ' ', $tab))); ?></h1></div>
                        <div class="afrisol-card">
                            <div class="afrisol-card-body">
                                <p class="afrisol-text-muted">Coming soon...</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>
