<?php
/**
 * Products functionality
 */
class Afrisol_Products {
    
    /**
     * Get product data
     */
    public static function get_product_data($product_id) {
        $product = get_post($product_id);
        
        if (!$product || $product->post_type !== 'afrisol_product') {
            return null;
        }
        
        // Get categories
        $categories = wp_get_post_terms($product_id, 'afrisol_product_cat');
        $category_names = array();
        $category_slugs = array();
        foreach ($categories as $cat) {
            $category_names[] = $cat->name;
            $category_slugs[] = $cat->slug;
        }
        
        // Get gallery images
        $gallery_ids = get_post_meta($product_id, '_afrisol_gallery', true);
        $gallery = array();
        if ($gallery_ids && is_array($gallery_ids)) {
            foreach ($gallery_ids as $id) {
                $gallery[] = array(
                    'id' => $id,
                    'url' => wp_get_attachment_url($id),
                    'thumb' => wp_get_attachment_image_url($id, 'thumbnail'),
                    'medium' => wp_get_attachment_image_url($id, 'medium'),
                    'large' => wp_get_attachment_image_url($id, 'large'),
                );
            }
        }
        
        // Add featured image to gallery
        if (has_post_thumbnail($product_id)) {
            $thumb_id = get_post_thumbnail_id($product_id);
            array_unshift($gallery, array(
                'id' => $thumb_id,
                'url' => wp_get_attachment_url($thumb_id),
                'thumb' => wp_get_attachment_image_url($thumb_id, 'thumbnail'),
                'medium' => wp_get_attachment_image_url($thumb_id, 'medium'),
                'large' => wp_get_attachment_image_url($thumb_id, 'large'),
            ));
        }
        
        // Get average rating
        global $wpdb;
        $reviews_table = $wpdb->prefix . 'afrisol_reviews';
        $avg_rating = $wpdb->get_var($wpdb->prepare(
            "SELECT AVG(rating) FROM $reviews_table WHERE product_id = %d AND status = 'approved'",
            $product_id
        ));
        $review_count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $reviews_table WHERE product_id = %d AND status = 'approved'",
            $product_id
        ));
        
        // Get specifications
        $specs = get_post_meta($product_id, '_afrisol_specifications', true);
        if (!is_array($specs)) {
            $specs = array();
        }
        
        return array(
            'id' => $product_id,
            'title' => $product->post_title,
            'slug' => $product->post_name,
            'content' => $product->post_content,
            'excerpt' => $product->post_excerpt ?: wp_trim_words($product->post_content, 30),
            'price' => floatval(get_post_meta($product_id, '_afrisol_price', true)),
            'sale_price' => floatval(get_post_meta($product_id, '_afrisol_sale_price', true)),
            'brand' => get_post_meta($product_id, '_afrisol_brand', true),
            'power' => get_post_meta($product_id, '_afrisol_power', true),
            'warranty' => get_post_meta($product_id, '_afrisol_warranty', true),
            'stock_status' => get_post_meta($product_id, '_afrisol_stock_status', true) ?: 'in_stock',
            'featured' => get_post_meta($product_id, '_afrisol_featured', true) === 'yes',
            'categories' => $category_names,
            'category_slugs' => $category_slugs,
            'image' => get_the_post_thumbnail_url($product_id, 'large'),
            'thumbnail' => get_the_post_thumbnail_url($product_id, 'thumbnail'),
            'gallery' => $gallery,
            'rating' => floatval($avg_rating) ?: 0,
            'review_count' => intval($review_count),
            'specifications' => $specs,
            'url' => home_url('/afrisol-product/?id=' . $product_id),
            'date' => $product->post_date,
        );
    }
    
    /**
     * Get featured products
     */
    public static function get_featured($count = 4) {
        $products = get_posts(array(
            'post_type' => 'afrisol_product',
            'posts_per_page' => $count,
            'meta_query' => array(
                array(
                    'key' => '_afrisol_featured',
                    'value' => 'yes',
                ),
            ),
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        
        $result = array();
        foreach ($products as $product) {
            $result[] = self::get_product_data($product->ID);
        }
        
        return $result;
    }
    
    /**
     * Get related products
     */
    public static function get_related($product_id, $count = 4) {
        $categories = wp_get_post_terms($product_id, 'afrisol_product_cat', array('fields' => 'ids'));
        
        if (empty($categories)) {
            return array();
        }
        
        $products = get_posts(array(
            'post_type' => 'afrisol_product',
            'posts_per_page' => $count,
            'post__not_in' => array($product_id),
            'tax_query' => array(
                array(
                    'taxonomy' => 'afrisol_product_cat',
                    'field' => 'term_id',
                    'terms' => $categories,
                ),
            ),
        ));
        
        $result = array();
        foreach ($products as $product) {
            $result[] = self::get_product_data($product->ID);
        }
        
        return $result;
    }
    
    /**
     * Get all brands
     */
    public static function get_brands() {
        global $wpdb;
        
        $brands = $wpdb->get_col(
            "SELECT DISTINCT meta_value FROM {$wpdb->postmeta} 
             WHERE meta_key = '_afrisol_brand' AND meta_value != '' 
             ORDER BY meta_value ASC"
        );
        
        return $brands;
    }
    
    /**
     * Get price range
     */
    public static function get_price_range() {
        global $wpdb;
        
        $min = $wpdb->get_var(
            "SELECT MIN(CAST(meta_value AS DECIMAL)) FROM {$wpdb->postmeta} 
             WHERE meta_key = '_afrisol_price'"
        );
        
        $max = $wpdb->get_var(
            "SELECT MAX(CAST(meta_value AS DECIMAL)) FROM {$wpdb->postmeta} 
             WHERE meta_key = '_afrisol_price'"
        );
        
        return array(
            'min' => floatval($min),
            'max' => floatval($max),
        );
    }
    
    /**
     * Get product categories
     */
    public static function get_categories() {
        $categories = get_terms(array(
            'taxonomy' => 'afrisol_product_cat',
            'hide_empty' => false,
        ));
        
        $result = array();
        foreach ($categories as $cat) {
            $result[] = array(
                'id' => $cat->term_id,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'description' => $cat->description,
                'count' => $cat->count,
            );
        }
        
        return $result;
    }
}
