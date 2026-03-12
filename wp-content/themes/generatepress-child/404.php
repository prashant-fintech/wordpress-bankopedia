<?php
/**
 * 404 Page Template — Bankopedia
 *
 * @package GeneratePress Child - Bankopedia
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="site-content" class="bp-404-page" role="main">
    <div class="bp-404__inner">

        <div class="bp-404__number" aria-hidden="true">404</div>

        <h1 class="bp-404__title">Page Not Found</h1>
        <p class="bp-404__subtitle">
            The page you're looking for has moved, been removed, or never existed.
            Let's get you back on track.
        </p>

        <!-- Search -->
        <form class="bp-404__search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <label for="bp-404-search" class="screen-reader-text">Search Bankopedia</label>
            <div class="bp-404__search-row">
                <input
                    id="bp-404-search"
                    type="search"
                    name="s"
                    placeholder="Search for a topic, e.g. &quot;home loan&quot;…"
                    autocomplete="off"
                    aria-label="Search Bankopedia"
                >
                <button type="submit" aria-label="Search">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </button>
            </div>
        </form>

        <!-- Quick links -->
        <div class="bp-404__links">
            <p class="bp-404__links-label">Or go directly to:</p>
            <div class="bp-404__links-grid">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="bp-404__link">
                    <span class="bp-404__link-icon" aria-hidden="true">🏠</span>
                    <span>Home</span>
                </a>
                <a href="<?php echo esc_url( home_url( '/loan-calculator/' ) ); ?>" class="bp-404__link">
                    <span class="bp-404__link-icon" aria-hidden="true">🧮</span>
                    <span>EMI Calculator</span>
                </a>
                <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="bp-404__link">
                    <span class="bp-404__link-icon" aria-hidden="true">📰</span>
                    <span>All Articles</span>
                </a>
                <a href="<?php echo esc_url( home_url( '/?s=banking' ) ); ?>" class="bp-404__link">
                    <span class="bp-404__link-icon" aria-hidden="true">🏦</span>
                    <span>Banking Basics</span>
                </a>
            </div>
        </div>

    </div>
</main>

<?php get_footer(); ?>
