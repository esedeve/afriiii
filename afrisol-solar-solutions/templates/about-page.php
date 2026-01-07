<?php
/**
 * About Us Page Template
 */
if (!defined('ABSPATH')) exit;
$settings = get_option('afrisol_settings', array());
?>
<div class="afrisol-wrapper">
    <?php echo do_shortcode('[afrisol_header]'); ?>
    
    <main class="afrisol-section" style="padding-top: 120px;">
        <div class="afrisol-container">
            <!-- Hero -->
            <div class="afrisol-about-hero afrisol-fade-in">
                <span class="afrisol-badge"><i class="fas fa-sun"></i> About Afrisol</span>
                <h1>Solar Solutions for a Sustainable Africa</h1>
                <p class="afrisol-text-muted">Empowering communities with clean, affordable, and reliable energy solutions since 2015.</p>
            </div>
            
            <!-- Mission -->
            <div class="afrisol-about-content afrisol-fade-in">
                <div class="afrisol-about-image">
                    <div class="afrisol-about-image-wrapper">
                        <div class="afrisol-image-placeholder" style="height: 100%;">
                            <i class="fas fa-image" style="font-size: 4rem;"></i>
                            <span>Company Image</span>
                            <small>(Admin uploads via frontend)</small>
                        </div>
                    </div>
                </div>
                <div class="afrisol-about-text">
                    <h2>Our Mission</h2>
                    <p>At Afrisol, we believe that access to clean, reliable energy is a fundamental right. Our mission is to accelerate Africa's transition to sustainable energy by providing high-quality solar solutions that are affordable, accessible, and tailored to the unique needs of our communities.</p>
                    <p>We are committed to reducing Africa's dependence on fossil fuels while creating economic opportunities and improving quality of life for millions of people across the continent.</p>
                </div>
            </div>
            
            <!-- Vision -->
            <div class="afrisol-about-content reverse afrisol-fade-in">
                <div class="afrisol-about-image">
                    <div class="afrisol-about-image-wrapper">
                        <div class="afrisol-image-placeholder" style="height: 100%;">
                            <i class="fas fa-lightbulb" style="font-size: 4rem;"></i>
                            <span>Vision Image</span>
                        </div>
                    </div>
                </div>
                <div class="afrisol-about-text">
                    <h2>Our Vision</h2>
                    <p>We envision an Africa where every home, business, and community has access to clean, reliable, and affordable energy. An Africa where solar power drives economic growth, creates jobs, and protects our environment for future generations.</p>
                    <p>By 2030, we aim to have powered over 1 million homes and businesses across the continent, making a significant contribution to Africa's sustainable development goals.</p>
                </div>
            </div>
            
            <!-- Values -->
            <div class="afrisol-section afrisol-fade-in">
                <div class="afrisol-section-header">
                    <h2>Our Values</h2>
                </div>
                <div class="afrisol-grid afrisol-grid-4">
                    <?php
                    $values = array(
                        array('icon' => 'fas fa-star', 'title' => 'Excellence', 'desc' => 'We deliver only the highest quality products and services'),
                        array('icon' => 'fas fa-handshake', 'title' => 'Integrity', 'desc' => 'Honesty and transparency in all our dealings'),
                        array('icon' => 'fas fa-leaf', 'title' => 'Sustainability', 'desc' => 'Committed to environmental responsibility'),
                        array('icon' => 'fas fa-users', 'title' => 'Community', 'desc' => 'Empowering local communities and creating jobs'),
                    );
                    foreach ($values as $value): ?>
                        <div class="afrisol-card afrisol-text-center">
                            <div class="afrisol-service-icon" style="margin: 0 auto 15px;">
                                <i class="<?php echo esc_attr($value['icon']); ?>"></i>
                            </div>
                            <h4><?php echo esc_html($value['title']); ?></h4>
                            <p><?php echo esc_html($value['desc']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Team -->
            <div class="afrisol-section afrisol-fade-in">
                <div class="afrisol-section-header">
                    <h2>Our Leadership Team</h2>
                    <p>Experienced professionals driving our mission forward</p>
                </div>
                <div class="afrisol-team-grid">
                    <?php
                    $team = array(
                        array('name' => 'Team Member 1', 'role' => 'CEO & Founder'),
                        array('name' => 'Team Member 2', 'role' => 'Chief Operations Officer'),
                        array('name' => 'Team Member 3', 'role' => 'Head of Engineering'),
                        array('name' => 'Team Member 4', 'role' => 'Sales Director'),
                    );
                    foreach ($team as $member): ?>
                        <div class="afrisol-team-card">
                            <div class="afrisol-team-image">
                                <i class="fas fa-user" style="font-size: 2rem;"></i>
                            </div>
                            <h4 class="afrisol-team-name"><?php echo esc_html($member['name']); ?></h4>
                            <p class="afrisol-team-role"><?php echo esc_html($member['role']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Impact Stats -->
            <div class="afrisol-section afrisol-fade-in">
                <div class="afrisol-section-header">
                    <h2>Our Impact</h2>
                    <p>Making a difference across Africa</p>
                </div>
                <div class="afrisol-impact-stats">
                    <div class="afrisol-impact-stat">
                        <div class="afrisol-impact-number">5000+</div>
                        <div class="afrisol-impact-label">Installations Completed</div>
                    </div>
                    <div class="afrisol-impact-stat">
                        <div class="afrisol-impact-number">25MW</div>
                        <div class="afrisol-impact-label">Solar Capacity Installed</div>
                    </div>
                    <div class="afrisol-impact-stat">
                        <div class="afrisol-impact-number">10K+</div>
                        <div class="afrisol-impact-label">Tons CO2 Saved</div>
                    </div>
                    <div class="afrisol-impact-stat">
                        <div class="afrisol-impact-number">200+</div>
                        <div class="afrisol-impact-label">Jobs Created</div>
                    </div>
                </div>
            </div>
            
            <!-- Certifications -->
            <div class="afrisol-card afrisol-mt-5 afrisol-fade-in">
                <div class="afrisol-card-body afrisol-text-center">
                    <h3>Certifications & Partnerships</h3>
                    <p class="afrisol-text-muted">We work with industry-leading partners and maintain the highest standards</p>
                    <div class="afrisol-flex-center afrisol-gap-xl afrisol-mt-4" style="flex-wrap: wrap;">
                        <span class="afrisol-badge"><i class="fas fa-certificate"></i> ISO 9001 Certified</span>
                        <span class="afrisol-badge"><i class="fas fa-award"></i> SON Approved</span>
                        <span class="afrisol-badge"><i class="fas fa-handshake"></i> NERC Licensed</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php echo do_shortcode('[afrisol_footer]'); ?>
    <?php echo do_shortcode('[afrisol_scroll_top]'); ?>
    <?php echo do_shortcode('[afrisol_whatsapp]'); ?>
</div>
