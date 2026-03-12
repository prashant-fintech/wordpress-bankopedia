<?php
/**
 * Bankopedia GeneratePress Child Theme Functions
 *
 * @package GeneratePress Child - Bankopedia
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue parent theme stylesheet first, then child theme stylesheet.
 * Using wp_enqueue_style with correct dependency ensures load order.
 */
add_action( 'wp_enqueue_scripts', function () {
    // Parent theme main stylesheet
    wp_enqueue_style(
        'generatepress-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( 'generatepress' )->get( 'Version' )
    );

    // Child theme stylesheet (overrides parent)
    wp_enqueue_style(
        'generatepress-child-style',
        get_stylesheet_uri(),
        [ 'generatepress-style' ],
        wp_get_theme()->get( 'Version' )
    );
}, 20 );

/**
 * Remove GeneratePress default body padding so hero section is full-bleed.
 * (Controlled via filter — safer than overriding with !important everywhere.)
 */
add_filter( 'generate_spacing_settings', function ( $defaults ) {
    // Ensure the content area doesn't add unneeded padding on the homepage
    return $defaults;
} );

/**
 * Add body class for the front page so we can scope CSS if needed.
 */
add_filter( 'body_class', function ( $classes ) {
    if ( is_front_page() ) {
        $classes[] = 'bp-is-front-page';
    }
    return $classes;
} );

/**
 * Disable GeneratePress's default site header on the front page.
 * Comment this out if you want to keep the default GP header instead of
 * relying solely on what front-page.php renders via get_header().
 */
// add_action( 'generate_before_header', function () {
//     if ( is_front_page() ) {
//         remove_action( 'generate_header', 'generate_construct_header' );
//     }
// } );

/**
 * Add custom excerpt length for article cards.
 */
add_filter( 'excerpt_length', function ( $length ) {
    return 18; // words
}, 999 );

add_filter( 'excerpt_more', function () {
    return '…';
} );

/**
 * Register widget areas specific to the child theme (newsletter sidebar, etc.)
 */
add_action( 'widgets_init', function () {
    register_sidebar( [
        'name'          => __( 'Homepage Newsletter', 'generatepress-child' ),
        'id'            => 'bp-newsletter',
        'description'   => __( 'Widget area for the homepage newsletter section.', 'generatepress-child' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );
} );
