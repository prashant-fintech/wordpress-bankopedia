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
 * Inject a search toggle button into the GeneratePress navigation bar.
 * Renders after the primary nav items via the generate_inside_navigation hook.
 */
add_action( 'generate_inside_navigation', function () {
    ?>
    <div class="bp-nav-search" role="search">
        <button
            class="bp-nav-search__toggle"
            aria-label="Toggle search"
            aria-expanded="false"
            aria-controls="bp-nav-search-form"
            type="button"
        >
            <svg class="bp-nav-search__icon-open" width="18" height="18" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <svg class="bp-nav-search__icon-close" width="18" height="18" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        <form
            id="bp-nav-search-form"
            class="bp-nav-search__form"
            role="search"
            method="get"
            action="<?php echo esc_url( home_url( '/' ) ); ?>"
            hidden
        >
            <label for="bp-nav-search-input" class="screen-reader-text">Search</label>
            <input
                id="bp-nav-search-input"
                class="bp-nav-search__input"
                type="search"
                name="s"
                placeholder="Search articles, topics…"
                autocomplete="off"
                aria-label="Search"
            >
            <button type="submit" class="bp-nav-search__submit" aria-label="Submit search">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                </svg>
            </button>
        </form>
    </div>

    <script>
    (function () {
        document.addEventListener('DOMContentLoaded', function () {
            var btn   = document.querySelector('.bp-nav-search__toggle');
            var form  = document.getElementById('bp-nav-search-form');
            var input = document.getElementById('bp-nav-search-input');
            if (!btn || !form) return;

            btn.addEventListener('click', function () {
                var isOpen = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', String(!isOpen));
                form.hidden = isOpen;
                btn.classList.toggle('is-open', !isOpen);
                if (!isOpen && input) {
                    setTimeout(function () { input.focus(); }, 50);
                }
            });

            // Close on Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !form.hidden) {
                    form.hidden = true;
                    btn.setAttribute('aria-expanded', 'false');
                    btn.classList.remove('is-open');
                    btn.focus();
                }
            });
        });
    }());
    </script>
    <?php
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
